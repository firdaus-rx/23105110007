@extends('layouts.app')

@section('title', 'Tambah Rapor')
@section('page-title', 'Tambah Rapor')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('rapor.store') }}" id="formRapor">
            @csrf
            <input type="hidden" name="kelas_id" id="kelas_id_hidden">
            <input type="hidden" name="siswa_id" id="siswa_id_hidden">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                    <select name="kelas_id_select" id="kelas_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        <option value="">Pilih Kelas...</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" @selected(old('kelas_id')==$k->id)>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Pelajaran <span class="text-red-500">*</span></label>
                    <select name="tahun_pelajaran_id" id="tahun_pelajaran_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($tahunPelajarans as $t)
                            <option value="{{ $t->id }}" @selected(old('tahun_pelajaran_id', $tahunAktif?->id)==$t->id)>{{ $t->nama_tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester <span class="text-red-500">*</span></label>
                    <select name="semester_id" id="semester_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($semesters as $s)
                            <option value="{{ $s->id }}" @selected(old('semester_id', $semesterAktif?->id)==$s->id)>{{ $s->nama_semester }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="siswaContainer" class="hidden">
                <div class="overflow-x-auto border border-gray-200 rounded-lg mb-4">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">No</th>
                                <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Siswa</th>
                                <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Total Nilai</th>
                                <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Rata-rata</th>
                                <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Pilih</th>
                            </tr>
                        </thead>
                        <tbody id="siswaTableBody" class="divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
                <div id="loadingSiswa" class="text-center py-8 text-gray-400 hidden">
                    <i class="ph ph-spinner-gap text-2xl animate-spin inline-block"></i>
                    <p class="mt-2">Memuat data siswa...</p>
                </div>

                <div id="formDetail" class="hidden">
                    <div class="grid grid-cols-1 gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Wali Kelas</label>
                            <textarea name="catatan_wali_kelas" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">{{ old('catatan_wali_kelas') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Rapor</label>
                            <input type="date" name="tanggal_rapor" value="{{ old('tanggal_rapor', date('Y-m-d')) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        </div>
                        <div>
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                                <i class="ph ph-check"></i> Buat Rapor
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="emptyKelas" class="text-center py-8 text-gray-400">
                <i class="ph ph-users text-4xl text-gray-300 block mb-3"></i>
                <p>Pilih kelas untuk menampilkan daftar siswa.</p>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('kelas_id').addEventListener('change', function() {
    const kelasId = this.value;
    const container = document.getElementById('siswaContainer');
    const tbody = document.getElementById('siswaTableBody');
    const loading = document.getElementById('loadingSiswa');
    const emptyKelas = document.getElementById('emptyKelas');
    const formDetail = document.getElementById('formDetail');
    const hiddenKelas = document.getElementById('kelas_id_hidden');

    hiddenKelas.value = kelasId;
    formDetail.classList.add('hidden');

    if (!kelasId) {
        container.classList.add('hidden');
        emptyKelas.classList.remove('hidden');
        return;
    }

    container.classList.remove('hidden');
    emptyKelas.classList.add('hidden');
    loading.classList.remove('hidden');
    tbody.innerHTML = '';

    const tahunId = document.getElementById('tahun_pelajaran_id').value;
    const semesterId = document.getElementById('semester_id').value;
    fetch('/admin/rapor/get-siswa/' + kelasId + '?tahun_pelajaran_id=' + tahunId + '&semester_id=' + semesterId)
        .then(res => res.json())
        .then(siswas => {
            loading.classList.add('hidden');
            if (siswas.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Tidak ada siswa di kelas ini.</td></tr>';
                return;
            }
            let html = '';
            siswas.forEach((s, i) => {
                html += `
                    <tr class="hover:bg-gray-50 transition siswa-row" data-siswa='${JSON.stringify(s)}'>
                        <td class="px-4 sm:px-6 py-3 text-sm text-gray-500 text-center">${i + 1}</td>
                        <td class="px-4 sm:px-6 py-3 text-sm text-gray-800">${s.nama_siswa} <span class="text-gray-400 text-xs">(${s.nis || '-'})</span></td>
                        <td class="px-4 sm:px-6 py-3 text-sm text-center text-gray-500">-</td>
                        <td class="px-4 sm:px-6 py-3 text-sm text-center text-gray-500">-</td>
                        <td class="px-4 sm:px-6 py-3 text-sm text-center text-gray-500">-</td>
                        <td class="px-4 sm:px-6 py-3 text-center">
                            <button type="button" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition pilih-siswa" data-id="${s.id}">Pilih</button>
                        </td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        })
        .catch(() => {
            loading.classList.add('hidden');
            tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-red-500">Gagal memuat data siswa.</td></tr>';
        });
});

document.addEventListener('click', function(e) {
    const btn = e.target.closest('.pilih-siswa');
    if (!btn) return;

    const siswaId = btn.dataset.id;
    const tahunId = document.getElementById('tahun_pelajaran_id').value;
    const semesterId = document.getElementById('semester_id').value;
    const formDetail = document.getElementById('formDetail');

    document.getElementById('siswa_id_hidden').value = siswaId;

    // Highlight selected row
    document.querySelectorAll('.siswa-row').forEach(r => r.classList.remove('bg-blue-50'));
    btn.closest('tr').classList.add('bg-blue-50');

    formDetail.classList.remove('hidden');

    // Fetch calculated data
    fetch(`/admin/rapor/get-data/${siswaId}?tahun_pelajaran_id=${tahunId}&semester_id=${semesterId}`)
        .then(res => res.json())
        .then(data => {
            const row = btn.closest('tr');
            row.children[2].innerHTML = `<span class="font-medium">${data.total_nilai}</span>`;
            row.children[3].innerHTML = `<span class="font-medium">${data.rata_rata}</span>`;
            row.children[4].innerHTML = data.exists
                ? `<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Sudah ada</span>`
                : `<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Baru</span>`;
        });
});

document.getElementById('tahun_pelajaran_id').addEventListener('change', function() {
    const kelasId = document.getElementById('kelas_id').value;
    if (kelasId) document.getElementById('kelas_id').dispatchEvent(new Event('change'));
});
document.getElementById('semester_id').addEventListener('change', function() {
    const kelasId = document.getElementById('kelas_id').value;
    if (kelasId) document.getElementById('kelas_id').dispatchEvent(new Event('change'));
});

@if(old('siswa_id'))
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('kelas_id').dispatchEvent(new Event('change'));
});
@endif
</script>
@endpush
@endsection