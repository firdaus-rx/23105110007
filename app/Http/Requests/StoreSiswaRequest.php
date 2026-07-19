<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $siswaId = $this->route('siswa') ? $this->route('siswa')->getKey() : null;
        $user = $this->route('siswa') ? $this->route('siswa')->user : null;
        $isCreate = !$this->route('siswa');

        $rules = [
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'nullable|string|unique:siswas,nis,' . ($siswaId ?? 'NULL'),
            'nisn' => 'nullable|string|unique:siswas,nisn,' . ($siswaId ?? 'NULL'),
            'kelas_id' => 'nullable|exists:kelas,id',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'telepon_orang_tua' => 'nullable|string|max:20',
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
            'nama_siswa.required' => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'nis.unique' => 'NIS sudah digunakan.',
            'nisn.unique' => 'NISN sudah digunakan.',
            'user_name.required' => 'Nama pengguna wajib diisi jika mengisi email.',
            'user_email.required' => 'Email pengguna wajib diisi.',
            'user_email.email' => 'Format email tidak valid.',
            'user_email.unique' => 'Email sudah digunakan.',
            'user_password.required' => 'Password wajib diisi.',
            'user_password.min' => 'Password minimal 6 karakter.',
        ];
    }
}