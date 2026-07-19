<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbsensiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'absensi' => 'required|array',
            'absensi.*.sakit' => 'nullable|integer|min:0',
            'absensi.*.izin' => 'nullable|integer|min:0',
            'absensi.*.alfa' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'absensi.required' => 'Data absensi wajib diisi.',
        ];
    }
}
