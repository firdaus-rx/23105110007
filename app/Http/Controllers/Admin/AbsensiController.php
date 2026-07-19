<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tahunPelajarans = TahunPelajaran::latest()->get();
        $semesters = Semester::latest()->get();
        $kelasList = Kelas::all();
        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();

        $query = Absensi::with(['siswa', 'kelas', 'tahunPelajaran', 'semester']);

        if ($request->filled('tahun_pelajaran_id')) {
            $query->where('tahun_pelajaran_id', $request->tahun_pelajaran_id);
        } elseif ($tahunAktif) {
            $query->where('tahun_pelajaran_id', $tahunAktif->id);
        }
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        } elseif ($semesterAktif) {
            $query->where('semester_id', $semesterAktif->id);
        }
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $absensis = $query->latest()->get()->groupBy(function ($a) {
            return $a->tahunPelajaran->nama_tahun . '|' . $a->semester->nama_semester . '|' . $a->kelas->nama_kelas;
        });

        return view('admin.absensi.index', compact(
            'absensis', 'tahunPelajarans', 'semesters', 'kelasList',
            'tahunAktif', 'semesterAktif'
        ));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();
        return view('admin.absensi.create', compact('kelas', 'tahunPelajarans', 'semesters'));
    }

    public function getSiswaByKelas(Kelas $kelas)
    {
        $siswas = Siswa::where('kelas_id', $kelas->id)->get(['id', 'nama_siswa', 'nis']);
        return response()->json($siswas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_pelajaran_id' => 'required|exists:tahun_pelajarans,id',
            'semester_id' => 'required|exists:semesters,id',
            'absensi' => 'required|array',
            'absensi.*.sakit' => 'nullable|integer|min:0',
            'absensi.*.izin' => 'nullable|integer|min:0',
            'absensi.*.alfa' => 'nullable|integer|min:0',
        ]);

        foreach ($request->absensi as $siswaId => $data) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'kelas_id' => $request->kelas_id,
                    'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
                    'semester_id' => $request->semester_id,
                ],
                [
                    'sakit' => $data['sakit'] ?? 0,
                    'izin' => $data['izin'] ?? 0,
                    'alfa' => $data['alfa'] ?? 0,
                ]
            );
        }

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil disimpan.');
    }

    public function edit(Absensi $absensi)
    {
        $siswas = Siswa::all();
        $kelas = Kelas::all();
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();
        return view('admin.absensi.edit', compact('absensi', 'siswas', 'kelas', 'tahunPelajarans', 'semesters'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'sakit' => 'nullable|integer|min:0',
            'izin' => 'nullable|integer|min:0',
            'alfa' => 'nullable|integer|min:0',
        ]);

        $absensi->update($validated);
        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dihapus.');
    }
}
