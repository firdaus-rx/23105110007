<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nilai_pengetahuan' => 'nullable|integer|min:0|max:100',
            'nilai_keterampilan' => 'nullable|integer|min:0|max:100',
            'nilai_sikap' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'nilai_pengetahuan.min' => 'Nilai pengetahuan minimal 0.',
            'nilai_pengetahuan.max' => 'Nilai pengetahuan maksimal 100.',
            'nilai_keterampilan.min' => 'Nilai keterampilan minimal 0.',
            'nilai_keterampilan.max' => 'Nilai keterampilan maksimal 100.',
        ];
    }
}
