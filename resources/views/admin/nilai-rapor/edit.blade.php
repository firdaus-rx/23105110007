@extends('layouts.app')

@section('title', 'Edit Nilai Rapor')
@section('page-title', 'Edit Nilai Rapor')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('nilai-rapor.update', $nilaiRapor) }}">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                    <select name="kelas_id" id="kelas_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        <option value="">Pilih Kelas...</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" @selected(old('kelas_id', $nilaiRapor->kelas_id)==$k->id)>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Guru <span class="text-red-500">*</span></label>
                    <select name="guru_id" id="guru_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        <option value="">Pilih Kelas Terlebih Dahulu</option>
                    </select>
                    @error('guru_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran <span class="text-red-500">*</span></label>
                    <select name="mata_pelajaran_id" id="mata_pelajaran_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        <option value="">Pilih Guru Terlebih Dahulu</option>
                    </select>
                    @error('mata_pelajaran_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Pelajaran <span class="text-red-500">*</span></label>
                    <select name="tahun_pelajaran_id" id="tahun_pelajaran_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($tahunPelajarans as $t)
                            <option value="{{ $t->id }}" @selected(old('tahun_pelajaran_id', $nilaiRapor->tahun_pelajaran_id)==$t->id)>{{ $t->nama_tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester <span class="text-red-500">*</span></label>
                    <select name="semester_id" id="semester_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        @foreach($semesters as $s)
                            <option value="{{ $s->id }}" @selected(old('semester_id', $nilaiRapor->semester_id)==$s->id)>{{ $s->nama_semester }}</option>
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
                        <i class="ph ph-check"></i> Perbarui Nilai
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
const currentSiswaId = {{ $nilaiRapor->siswa_id }};
const currentPengetahuan = {{ $nilaiRapor->nilai_pengetahuan ?? 'null' }};
const currentKeterampilan = {{ $nilaiRapor->nilai_keterampilan ?? 'null' }};
const currentSikap = @json($nilaiRapor->nilai_sikap ?? '');
const currentGuruId = {{ $nilaiRapor->guru_id }};
const currentMapelId = {{ $nilaiRapor->mata_pelajaran_id }};

const kelasSelect = document.getElementById('kelas_id');
const guruSelect = document.getElementById('guru_id');
const mapelSelect = document.getElementById('mata_pelajaran_id');
const container = document.getElementById('siswaContainer');
const tbody = document.getElementById('siswaTableBody');
const loading = document.getElementById('loadingSiswa');
const emptyKelas = document.getElementById('emptyKelas');
const submitBtn = document.getElementById('submitContainer');

function loadGuru(kelasId, callback) {
    guruSelect.innerHTML = '<option value="">Memuat...</option>';
    guruSelect.disabled = true;
    mapelSelect.innerHTML = '<option value="">Pilih Guru Terlebih Dahulu</option>';
    mapelSelect.disabled = true;

    if (!kelasId) {
        guruSelect.innerHTML = '<option value="">Pilih Kelas Terlebih Dahulu</option>';
        guruSelect.disabled = false;
        if (callback) callback();
        return;
    }

    fetch('/admin/nilai-rapor/get-guru/' + kelasId)
        .then(res => res.json())
        .then(gurus => {
            guruSelect.innerHTML = '<option value="">Pilih Guru...</option>';
            gurus.forEach(g => {
                const selected = g.id === currentGuruId ? 'selected' : '';
                guruSelect.innerHTML += `<option value="${g.id}" ${selected}>${g.nama_guru}${g.nip ? ' (' + g.nip + ')' : ''}</option>`;
            });
            guruSelect.disabled = false;
            if (callback) callback();
        })
        .catch(() => {
            guruSelect.innerHTML = '<option value="">Gagal memuat data</option>';
            guruSelect.disabled = false;
            if (callback) callback();
        });
}

function loadMapel(kelasId, guruId, callback) {
    mapelSelect.innerHTML = '<option value="">Memuat...</option>';
    mapelSelect.disabled = true;

    if (!kelasId || !guruId) {
        mapelSelect.innerHTML = '<option value="">Pilih Guru Terlebih Dahulu</option>';
        mapelSelect.disabled = false;
        if (callback) callback();
        return;
    }

    fetch('/admin/nilai-rapor/get-mapel/' + kelasId + '/' + guruId)
        .then(res => res.json())
        .then(mapels => {
            mapelSelect.innerHTML = '<option value="">Pilih Mata Pelajaran...</option>';
            mapels.forEach(m => {
                const selected = m.id === currentMapelId ? 'selected' : '';
                mapelSelect.innerHTML += `<option value="${m.id}" ${selected}>${m.nama_mapel} (KKM ${m.kkm})</option>`;
            });
            mapelSelect.disabled = false;
            if (callback) callback();
        })
        .catch(() => {
            mapelSelect.innerHTML = '<option value="">Gagal memuat data</option>';
            mapelSelect.disabled = false;
            if (callback) callback();
        });
}

function loadSiswa(kelasId) {
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
                const isCurrent = s.id === currentSiswaId;
                html += `
                    <tr class="hover:bg-gray-50 transition ${isCurrent ? 'bg-blue-50' : ''}">
                        <td class="px-4 sm:px-6 py-3 text-sm text-gray-500 text-center">${i + 1}</td>
                        <td class="px-4 sm:px-6 py-3 text-sm text-gray-800">${s.nama_siswa} <span class="text-gray-400 text-xs">(${s.nis || '-'})</span></td>
                        <td class="px-4 sm:px-6 py-3 text-center">
                            <input type="number" name="nilai[${s.id}][nilai_pengetahuan]" value="${isCurrent ? currentPengetahuan : ''}" min="0" max="100" class="w-24 text-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none mx-auto block" placeholder="-">
                        </td>
                        <td class="px-4 sm:px-6 py-3 text-center">
                            <input type="number" name="nilai[${s.id}][nilai_keterampilan]" value="${isCurrent ? currentKeterampilan : ''}" min="0" max="100" class="w-24 text-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none mx-auto block" placeholder="-">
                        </td>
                        <td class="px-4 sm:px-6 py-3 text-center">
                            <input type="text" name="nilai[${s.id}][nilai_sikap]" value="${isCurrent ? currentSikap : ''}" class="w-28 text-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none mx-auto block" placeholder="Baik">
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
}

kelasSelect.addEventListener('change', function() {
    loadGuru(this.value, function() {
        if (guruSelect.value) {
            guruSelect.dispatchEvent(new Event('change'));
        }
    });
    loadSiswa(this.value);
});

guruSelect.addEventListener('change', function() {
    loadMapel(kelasSelect.value, this.value);
});

// Auto-load on page ready
document.addEventListener('DOMContentLoaded', function() {
    const kelasId = kelasSelect.value;
    if (kelasId) {
        loadGuru(kelasId, function() {
            guruSelect.value = currentGuruId;
            loadMapel(kelasId, currentGuruId, function() {
                mapelSelect.value = currentMapelId;
            });
        });
        loadSiswa(kelasId);
    }
});
</script>
@endpush
@endsection