<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJadwalRequest;
use App\Models\Guru;
use App\Models\JadwalMengajar;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Semester;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class JadwalMengajarController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::all();
        $mataPelajarans = MataPelajaran::all();
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();

        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();

        $query = JadwalMengajar::with(['guru', 'kelas', 'mataPelajaran', 'tahunPelajaran', 'semester']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }
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

        $jadwals = $query->latest()->get()->groupBy(function ($j) {
            return $j->kelas->nama_kelas;
        });

        return view('admin.jadwal-mengajar.index', compact(
            'jadwals', 'kelasList', 'mataPelajarans', 'tahunPelajarans', 'semesters',
            'tahunAktif', 'semesterAktif'
        ));
    }

    public function create()
    {
        $gurus = Guru::all();
        $kelas = Kelas::all();
        $mataPelajarans = MataPelajaran::where('status', 'aktif')->get();
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();
        return view('admin.jadwal-mengajar.create', compact('gurus', 'kelas', 'mataPelajarans', 'tahunPelajarans', 'semesters'));
    }

    public function store(StoreJadwalRequest $request)
    {
        $exists = JadwalMengajar::where([
            'guru_id' => $request->guru_id,
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
            'semester_id' => $request->semester_id,
        ])->exists();

        if ($exists) {
            return back()->withErrors(['duplicate' => 'Jadwal mengajar sudah ada.'])->withInput();
        }

        JadwalMengajar::create($request->validated());
        return redirect()->route('jadwal-mengajar.index')->with('success', 'Jadwal mengajar berhasil ditambahkan.');
    }

    public function edit(JadwalMengajar $jadwalMengajar)
    {
        $gurus = Guru::all();
        $kelas = Kelas::all();
        $mataPelajarans = MataPelajaran::where('status', 'aktif')->get();
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();
        return view('admin.jadwal-mengajar.edit', compact('jadwalMengajar', 'gurus', 'kelas', 'mataPelajarans', 'tahunPelajarans', 'semesters'));
    }

    public function update(StoreJadwalRequest $request, JadwalMengajar $jadwalMengajar)
    {
        $exists = JadwalMengajar::where([
            'guru_id' => $request->guru_id,
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
            'semester_id' => $request->semester_id,
        ])->where('id', '!=', $jadwalMengajar->id)->exists();

        if ($exists) {
            return back()->withErrors(['duplicate' => 'Jadwal mengajar sudah ada.'])->withInput();
        }

        $jadwalMengajar->update($request->validated());
        return redirect()->route('jadwal-mengajar.index')->with('success', 'Jadwal mengajar berhasil diperbarui.');
    }

    public function destroy(JadwalMengajar $jadwalMengajar)
    {
        $jadwalMengajar->delete();
        return redirect()->route('jadwal-mengajar.index')->with('success', 'Jadwal mengajar berhasil dihapus.');
    }
}
