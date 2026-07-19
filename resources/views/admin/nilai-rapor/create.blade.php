@extends('layouts.app')

@section('title', 'Tambah Nilai Rapor')
@section('page-title', 'Tambah Nilai Rapor')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('nilai-rapor.store') }}" id="formNilai">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                    <select name="kelas_id" id="kelas_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        <option value="">Pilih Kelas...</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" @selected(old('kelas_id')==$k->id)>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Guru <span class="text-red-500">*</span></label>
                    <select name="guru_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        <option value="">Pilih...</option>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id }}" @selected(old('guru_id')==$g->id)>{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                    @error('guru_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran <span class="text-red-500">*</span></label>
                    <select name="mata_pelajaran_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        <option value="">Pilih...</option>
                        @foreach($mataPelajarans as $m)
                            <option value="{{ $m->id }}" @selected(old('mata_pelajaran_id')==$m->id)>{{ $m->nama_mapel }} (KKM {{ $m->kkm }})</option>
                        @endforeach
                    </select>
                    @error('mata_pelajaran_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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

            <div id="siswaContainer" class="{{ old('nilai') ? '' : 'hidden' }}">
                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">No</th>
                                <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Siswa</th>
                                <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Pengetahuan (0-100)</th>
                                <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Keterampilan (0-100)</th>
                                <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Sikap</th>
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

                <div class="flex items-center gap-3 mt-6" id="submitContainer" style="display:none">
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                        <i class="ph ph-check"></i> Simpan Semua Nilai
                    </button>
                    <a href="{{ route('nilai-rapor.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">Batal</a>
                </div>
            </div>

            <div id="emptyKelas" class="text-center py-8 text-gray-400 {{ old('nilai') ? 'hidden' : '' }}">
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
    const submitBtn = document.getElementById('submitContainer');

    if (!kelasId) {
        container.classList.add('hidden');
        emptyKelas.classList.remove('hidden');
        submitBtn.style.display = 'none';
        return;
    }

    container.classList.remove('hidden');
    emptyKelas.classList.add('hidden');
    loading.classList.remove('hidden');
    tbody.innerHTML = '';
    submitBtn.style.display = 'none';

    fetch('/admin/nilai-rapor/get-siswa/' + kelasId)
        .then(res => res.json())
        .then(siswas => {
            loading.classList.add('hidden');
            if (siswas.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada siswa di kelas ini.</td></tr>';
                return;
            }
            let html = '';
            siswas.forEach((s, i) => {
                html += `
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-3 text-sm text-gray-500 text-center">${i + 1}</td>
                        <td class="px-4 sm:px-6 py-3 text-sm text-gray-800">${s.nama_siswa} <span class="text-gray-400 text-xs">(${s.nis || '-'})</span></td>
                        <td class="px-4 sm:px-6 py-3 text-center">
                            <input type="number" name="nilai[${s.id}][nilai_pengetahuan]" min="0" max="100" class="w-24 text-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none mx-auto block" placeholder="-">
                        </td>
                        <td class="px-4 sm:px-6 py-3 text-center">
                            <input type="number" name="nilai[${s.id}][nilai_keterampilan]" min="0" max="100" class="w-24 text-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none mx-auto block" placeholder="-">
                        </td>
                        <td class="px-4 sm:px-6 py-3 text-center">
                            <input type="text" name="nilai[${s.id}][nilai_sikap]" class="w-28 text-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none mx-auto block" placeholder="Baik">
                        </td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
            submitBtn.style.display = 'flex';
        })
        .catch(() => {
            loading.classList.add('hidden');
            tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-red-500">Gagal memuat data siswa.</td></tr>';
        });
});

@if(old('kelas_id'))
document.getElementById('kelas_id').dispatchEvent(new Event('change'));
@endif
</script>
@endpush
@endsection