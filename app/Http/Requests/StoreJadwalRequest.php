<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJadwalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guru_id' => 'required|exists:gurus,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tahun_pelajaran_id' => 'required|exists:tahun_pelajarans,id',
            'semester_id' => 'required|exists:semesters,id',
        ];
    }

    public function messages(): array
    {
        return [
            'guru_id.required' => 'Guru wajib dipilih.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'tahun_pelajaran_id.required' => 'Tahun pelajaran wajib dipilih.',
            'semester_id.required' => 'Semester wajib dipilih.',
        ];
    }
}
