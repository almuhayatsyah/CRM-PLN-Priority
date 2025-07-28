<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace-nya App\Http\Controllers\Admin

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect; // Pastikan ini diimport
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage; // Pastikan ini diimport
use Illuminate\Support\Facades\Auth; // Mungkin diperlukan untuk logika menghapus akun sendiri

class UserController extends Controller
{
  public function __construct()
  {
    // Hanya Admin yang bisa mengakses controller ini
    $this->middleware(['auth', 'role:admin']);
  }

  /**
   * Tampilkan daftar user.
   */
  public function index(Request $request) // TAMBAHKAN Request $request
  {
    $query = User::with('roles');

    // Filter berdasarkan nama atau email
    if ($request->filled('nama_cari')) {
      $query->where('nama_lengkap', 'like', '%' . $request->nama_cari . '%')
        ->orWhere('email', 'like', '%' . $request->nama_cari . '%');
    }

    // Filter berdasarkan role
    if ($request->filled('role_filter')) {
      $query->whereHas('roles', function ($q) use ($request) {
        $q->where('name', $request->role_filter);
      });
    }

    // Ambil semua user dengan filter, dan paginasi
    $allUsers = $query->orderBy('nama_lengkap')->paginate(10); // Gunakan $allUsers dan orderBy

    // Ambil semua role untuk dropdown filter
    $allRoles = Role::all(); // TAMBAHKAN INI

    // Perbarui view path ke 'admin.users.index' (plural)
    return view('admin.users.index', compact('allUsers', 'allRoles')); // TAMBAHKAN allRoles
  }
  /**
   * Form tambah user.
   */
  public function create()
  {
    $roles = Role::all();
    // Perbarui view path ke 'admin.users.create' (plural)
    return view('admin.users.create', compact('roles'));
  }

  /**
   * Simpan user baru.
   */
  public function store(Request $request)
  {
    $request->validate([
      'nama_lengkap' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      // Validasi password: required, minimal 8 karakter, konfirmasi
      'password' => ['required', 'string', Rules\Password::defaults(), 'confirmed'],
      'role' => 'required|exists:roles,name', // Validasi peran
      'profile_photo' => 'nullable|image|max:2048', // Validasi file gambar (maks 2MB)
    ]);

    // Tangani upload foto profil
    $profilePhotoPath = null;
    if ($request->hasFile('profile_photo')) {
      // Simpan file di storage/app/public/profile-photos
      $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
    }

    $user = User::create([
      'nama_lengkap' => $request->nama_lengkap,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'profile_photo_path' => $profilePhotoPath, // Simpan path foto
    ]);

    // Tugaskan peran ke user baru
    $user->assignRole($request->role);

    // Perbarui redirect route ke 'admin.users.index' (plural)
    return Redirect::route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
  }

  /**
   * Form edit user.
   */
  public function edit($id)
  {
    $user = User::findOrFail($id);
    $roles = Role::all();
    // Perbarui view path ke 'admin.users.edit' (plural)
    return view('admin.users.edit', compact('user', 'roles'));
  }

  /**
   * Update user.
   */
  public function update(Request $request, $id)
  {
    $user = User::findOrFail($id);

    $request->validate([
      'nama_lengkap' => 'required|string|max:255',
      // Pastikan email unik kecuali untuk user yang sedang diedit
      'email' => 'required|email|unique:users,email,' . $user->id,
      // Password bisa null jika tidak diubah, tapi jika diisi harus dikonfirmasi
      'password' => ['nullable', 'string', Rules\Password::defaults(), 'confirmed'],
      'role' => 'required|exists:roles,name',
      'profile_photo' => 'nullable|image|max:2048', // Validasi file gambar
    ]);

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
      // Simpan foto baru
      $user->profile_photo_path = $request->file('profile_photo')->store('profile-photos', 'public');
    }

    // Update data user (kecuali password jika tidak diisi)
    $user->nama_lengkap = $request->nama_lengkap;
    $user->email = $request->email;
    if ($request->filled('password')) { // Hanya update password jika field diisi
      $user->password = Hash::make($request->password);
    }
    // Pastikan profile_photo_path di-set setelah semua logika foto
    $user->profile_photo_path = $user->profile_photo_path;

    $user->save(); // Simpan perubahan user

    // Sinkronkan peran user (mengganti peran yang ada)
    $user->syncRoles([$request->role]);

    // Perbarui redirect route ke 'admin.users.index' (plural)
    return Redirect::route('admin.users.index')->with('success', 'User berhasil diupdate.');
  }

  /**
   * Hapus user.
   */
  public function destroy($id)
  {
    $user = User::findOrFail($id);

    // Pencegahan: Admin tidak dapat menghapus akunnya sendiri
    if (Auth::check() && Auth::user()->id == $user->id) {
      // Perbarui redirect route ke 'admin.users.index' (plural)
      return Redirect::route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
    }

    // Hapus foto profil fisik dari storage saat user dihapus
    if ($user->profile_photo_path) {
      Storage::disk('public')->delete($user->profile_photo_path);
    }

    $user->delete(); // Hapus user dari database

    // Perbarui redirect route ke 'admin.users.index' (plural)
    return Redirect::route('admin.users.index')->with('success', 'User berhasil dihapus.');
  }
}
