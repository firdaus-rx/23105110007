@extends('layouts.app')

@section('title', 'Kenaikan Kelas')
@section('page-title', 'Kenaikan Kelas')

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
            <i class="ph ph-arrow-fat-up text-2xl text-indigo-600"></i>
        </div>
        <div>
            <h3 class="font-semibold text-gray-800">Kenaikan Kelas Siswa</h3>
            <p class="text-sm text-gray-500">Naikkan siswa ke kelas berikutnya setelah tahun pelajaran selesai.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.kenaikan-kelas') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Pelajaran Asal <span class="text-red-500">*</span></label>
            <select name="tahun_pelajaran_asal" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                <option value="">Pilih...</option>
                @foreach($tahunPelajarans as $t)
                    <option value="{{ $t->id }}" @selected(request('tahun_pelajaran_asal') == $t->id)>{{ $t->nama_tahun }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Semester Asal <span class="text-red-500">*</span></label>
            <select name="semester_asal" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                <option value="">Pilih...</option>
                @foreach($semesters as $s)
                    <option value="{{ $s->id }}" @selected(request('semester_asal') == $s->id)>{{ $s->nama_semester }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                <i class="ph ph-eye"></i> Lihat Data
            </button>
            @if(request('tahun_pelajaran_asal'))
            <a href="{{ route('admin.kenaikan-kelas') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                <i class="ph ph-arrows-counter-clockwise"></i>
            </a>
            @endif
        </div>
    </form>
</div>

@if($dataKelas)
<div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
    <p class="text-sm text-blue-700">
        <strong>Kenaikan Kelas</strong> — {{ $tahunAsal->nama_tahun }} Semester {{ $semesterAsal->nama_semester }}
    </p>
    <form method="POST" action="{{ route('admin.kenaikan-kelas.promote') }}" id="formPromote">
        @csrf
        <input type="hidden" name="tahun_pelajaran_asal" value="{{ $tahunAsal->id }}">
        <input type="hidden" name="semester_asal" value="{{ $semesterAsal->id }}">
        <input type="hidden" name="siswa_ids" id="siswa_ids_input" value="">
        <button type="submit" id="btnPromote" disabled class="px-6 py-2.5 bg-green-600 hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white text-sm font-medium rounded-lg transition">
            <i class="ph ph-arrow-fat-up"></i> Naikkan Kelas Terpilih
        </button>
    </form>
</div>

@forelse($dataKelas as $item)
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-indigo-50 to-indigo-100 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-indigo-200 flex items-center justify-center">
                    <i class="ph ph-buildings text-xl text-indigo-700"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-indigo-800">Kelas {{ $item->kelas->nama_kelas }}</h3>
                    <p class="text-xs text-indigo-600">{{ $item->siswas->count() }} siswa</p>
                </div>
            </div>
            <div class="text-right">
                @if($item->bisaNaik)
                    <p class="text-xs text-green-600">Naik ke <strong>{{ $item->nextKelas->nama_kelas }}</strong></p>
                    <label class="flex items-center gap-1 text-xs text-indigo-600 mt-1 cursor-pointer justify-end">
                        <input type="checkbox" class="kelas-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-kelas="{{ $item->kelas->id }}">
                        Pilih semua
                    </label>
                @else
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $item->kelas->tingkat >= 6 ? 'bg-gray-100 text-gray-600' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $item->kelas->tingkat >= 6 ? 'LULUS' : 'Tidak ada kelas tujuan' }}
                    </span>
                @endif
            </div>
        </div>
    </div>
    @if($item->bisaNaik)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-10 px-4 py-3"></th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">NIS</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Siswa</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Kelas Tujuan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($item->siswas as $s)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-center">
                        <input type="checkbox" value="{{ $s->id }}" class="siswa-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-kelas="{{ $item->kelas->id }}">
                    </td>
                    <td class="px-4 sm:px-6 py-3 text-sm text-gray-600">{{ $s->nis ?? '-' }}</td>
                    <td class="px-4 sm:px-6 py-3 text-sm text-gray-800">{{ $s->nama_siswa }}</td>
                    <td class="px-4 sm:px-6 py-3 text-sm text-green-700 font-medium">{{ $item->nextKelas->nama_kelas }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-6 text-center text-sm text-gray-400">
        @if($item->kelas->tingkat >= 6)
            Siswa kelas {{ $item->kelas->nama_kelas }} telah menyelesaikan pendidikan.
        @else
            Belum ada kelas {{ $item->kelas->tingkat + 1 }} yang tersedia.
        @endif
    </div>
    @endif
</div>
@empty
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <i class="ph ph-users text-4xl text-gray-300 block mb-3"></i>
    <p class="text-gray-400">Tidak ada data siswa ditemukan.</p>
</div>
@endforelse
@else
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Kelas</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Tingkat</th>
                    <th class="text-center px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Jumlah Siswa</th>
                    <th class="text-left px-4 sm:px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Kelas Tujuan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($kelasList as $k)
                @php
                    $nextKelas = \App\Models\Kelas::where('tingkat', $k->tingkat + 1)
                        ->where('nama_kelas', 'like', '%' . substr($k->nama_kelas, -1))
                        ->first();
                @endphp
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-800 font-medium">{{ $k->nama_kelas }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center">{{ $k->tingkat }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-center">{{ $k->siswas_count }}</td>
                    <td class="px-4 sm:px-6 py-4 text-sm">
                        @if($k->tingkat >= 6)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">LULUS</span>
                        @elseif($nextKelas)
                            {{ $nextKelas->nama_kelas }}
                        @else
                            <span class="text-gray-400 italic">Belum ada kelas tujuan</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@push('scripts')
<script>
document.querySelectorAll('.kelas-checkbox').forEach(function(cb) {
    cb.addEventListener('change', function() {
        const kelasId = this.dataset.kelas;
        document.querySelectorAll(`.siswa-checkbox[data-kelas="${kelasId}"]`).forEach(function(s) {
            s.checked = cb.checked;
        });
        updateButton();
    });
});

document.querySelectorAll('.siswa-checkbox').forEach(function(cb) {
    cb.addEventListener('change', function() {
        updateButton();
        const kelasId = this.dataset.kelas;
        const allCbs = document.querySelectorAll(`.siswa-checkbox[data-kelas="${kelasId}"]`);
        const checkedCbs = document.querySelectorAll(`.siswa-checkbox[data-kelas="${kelasId}"]:checked`);
        const kelasCb = document.querySelector(`.kelas-checkbox[data-kelas="${kelasId}"]`);
        if (kelasCb) {
            kelasCb.checked = allCbs.length === checkedCbs.length && allCbs.length > 0;
        }
    });
});

function updateButton() {
    const checked = document.querySelectorAll('.siswa-checkbox:checked');
    const btn = document.getElementById('btnPromote');
    const input = document.getElementById('siswa_ids_input');
    if (checked.length > 0) {
        btn.disabled = false;
        input.value = JSON.stringify(Array.from(checked).map(c => parseInt(c.value)));
    } else {
        btn.disabled = true;
        input.value = '';
    }
}

document.getElementById('formPromote')?.addEventListener('submit', function(e) {
    const checked = document.querySelectorAll('.siswa-checkbox:checked');
    if (checked.length === 0) {
        e.preventDefault();
        Swal.fire({
            title: 'Peringatan',
            text: 'Pilih minimal satu siswa untuk dinaikkan.',
            icon: 'warning',
            confirmButtonColor: '#2563eb',
        });
        return;
    }
    e.preventDefault();
    Swal.fire({
        title: 'Konfirmasi',
        text: `Naikkan ${checked.length} siswa ke kelas berikutnya?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, naikkan!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>
@endpush
@endsection