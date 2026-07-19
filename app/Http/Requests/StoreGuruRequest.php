<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $guruId = $this->route('guru') ? $this->route('guru')->getKey() : null;
        $user = $this->route('guru') ? $this->route('guru')->user : null;
        $isCreate = !$this->route('guru');

        $rules = [
            'nama_guru' => 'required|string|max:255',
            'nip' => 'nullable|string|unique:gurus,nip,' . ($guruId ?? 'NULL'),
            'jenis_kelamin' => 'required|in:L,P',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ];

        if ($this->filled('user_name') || $this->filled('user_email')) {
            $rules['user_name'] = 'required|string|max:255';
            $rules['user_email'] = 'required|email|unique:users,email,' . ($user?->id ?? 'NULL');
            if ($isCreate) {
                $rules['user_password'] = 'required|string|min:6';
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'nip.unique' => 'NIP sudah digunakan.',
            'user_name.required' => 'Nama pengguna wajib diisi jika mengisi email.',
            'user_email.required' => 'Email pengguna wajib diisi.',
            'user_email.email' => 'Format email tidak valid.',
            'user_email.unique' => 'Email sudah digunakan.',
            'user_password.required' => 'Password wajib diisi.',
            'user_password.min' => 'Password minimal 6 karakter.',
        ];
    }
}