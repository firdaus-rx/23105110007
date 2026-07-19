<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|integer|min:1|max:6',
            'wali_kelas_id' => 'nullable|exists:gurus,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'tingkat.required' => 'Tingkat wajib diisi.',
        ];
    }
}
