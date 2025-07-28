<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileUpdateRequest; // Pastikan ini diimport
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // Pastikan ini diimport
use Illuminate\Support\Facades\Hash; // Diperlukan jika ada perubahan password

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information and photo.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();

        // Update email verification status if email changes
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // --- Logika Penanganan Foto Profil ---
        // Tangani penghapusan foto lama jika checkbox 'remove_photo' dicentang
        if ($request->boolean('remove_photo') && $user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->profile_photo_path = null; // Set path ke null di database
        }

        // Tangani upload foto baru
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada (dan tidak dihapus via checkbox) sebelum upload baru
            if ($user->profile_photo_path && !$request->boolean('remove_photo')) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Simpan foto baru ke storage/app/public/profile-photos
            $user->profile_photo_path = $request->file('profile_photo')->store('profile-photos', 'public');
        }
        // Pastikan path foto yang diperbarui/dihapus disimpan ke objek $user
        $user->profile_photo_path = $user->profile_photo_path;
        // --- Akhir Logika Penanganan Foto Profil ---


        // Update user data (nama_lengkap dan email)
        $user->fill($request->validated()); // Mengisi kolom 'nama_lengkap' dan 'email'

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Hapus foto profil fisik dari storage saat user dihapus
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
