<?php

namespace App\Http\Requests\Profile; // Pastikan namespace ini benar

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class  ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = auth()->id();
        return [
            'nama_lengkap' => ['required', 'string', 'max:255'], // Menggunakan nama_lengkap
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($userId),
            ],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // Tambahkan validasi untuk foto (maks 2MB)
            'remove_photo' => ['nullable', 'boolean'], // Tambahkan validasi untuk checkbox hapus foto
        ];
    }
}
