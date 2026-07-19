<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMapelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mapelId = $this->route('mata_pelajaran')?->getKey();
        return [
            'nama_mapel' => 'required|string|max:255',
            'kode_mapel' => 'nullable|string|unique:mata_pelajarans,kode_mapel,' . ($mapelId ?? 'NULL'),
            'kkm' => 'required|integer|min:0|max:100',
            'kelompok' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_mapel.required' => 'Nama mata pelajaran wajib diisi.',
            'kkm.required' => 'KKM wajib diisi.',
            'kkm.integer' => 'KKM harus berupa angka.',
        ];
    }
}
