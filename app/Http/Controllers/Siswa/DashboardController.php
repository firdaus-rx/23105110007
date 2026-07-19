<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\NilaiRapor;
use App\Models\Rapor;
use App\Models\Semester;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Services\NilaiService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $nilaiService;

    public function __construct(NilaiService $nilaiService)
    {
        $this->nilaiService = $nilaiService;
    }

    public function index()
    {
        $siswa = Siswa::where('user_id', auth()->id())->first();

        if (!$siswa) {
            return view('siswa.dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $tahunAktif = TahunPelajaran::where('status_aktif', true)->first();
        $semesterAktif = Semester::where('status_aktif', true)->first();

        $nilais = collect();
        $rataRata = 0;
        $absensi = null;

        if ($tahunAktif && $semesterAktif) {
            $nilais = NilaiRapor::with('mataPelajaran')
                ->where('siswa_id', $siswa->id)
                ->where('tahun_pelajaran_id', $tahunAktif->id)
                ->where('semester_id', $semesterAktif->id)
                ->get();

            $rataRata = $this->nilaiService->hitungRataRataRapor(
                $siswa->id, $siswa->kelas_id,
                $tahunAktif->id, $semesterAktif->id
            );

            $absensi = Absensi::where('siswa_id', $siswa->id)
                ->where('tahun_pelajaran_id', $tahunAktif->id)
                ->where('semester_id', $semesterAktif->id)
                ->first();
        }

        $chartLabels = $nilais->pluck('mataPelajaran.nama_mapel')->toArray();
        $chartNilaiPengetahuan = $nilais->pluck('nilai_pengetahuan')->map(fn($v) => (int)$v)->toArray();
        $chartNilaiKeterampilan = $nilais->pluck('nilai_keterampilan')->map(fn($v) => (int)$v)->toArray();
        $totalMapel = $nilais->count();
        $predikatA = $nilais->where('predikat', 'A')->count();
        $totalAbsensi = ($absensi->sakit ?? 0) + ($absensi->izin ?? 0) + ($absensi->alfa ?? 0);

        return view('siswa.dashboard', compact(
            'siswa', 'nilais', 'rataRata', 'absensi', 'tahunAktif', 'semesterAktif',
            'chartLabels', 'chartNilaiPengetahuan', 'chartNilaiKeterampilan',
            'totalMapel', 'predikatA', 'totalAbsensi'
        ));
    }

    public function nilai()
    {
        $siswa = Siswa::where('user_id', auth()->id())->firstOrFail();

        $nilaiRaw = NilaiRapor::with(['mataPelajaran', 'tahunPelajaran', 'semester'])
            ->where('siswa_id', $siswa->id)
            ->get()
            ->groupBy(['tahunPelajaran.nama_tahun', 'semester.nama_semester']);

        $nilaiPerTahun = [];
        foreach ($nilaiRaw as $tahun => $semesters) {
            foreach ($semesters as $semester => $nilais) {
                $rata = round($nilais->avg(function ($n) {
                    return ((int)$n->nilai_pengetahuan + (int)$n->nilai_keterampilan) / 2;
                }), 2);
                $nilaiPerTahun[] = (object)[
                    'tahun' => $tahun,
                    'semester' => $semester,
                    'nilais' => $nilais,
                    'rata_rata' => $rata,
                ];
            }
        }

        usort($nilaiPerTahun, fn($a, $b) => $b->tahun <=> $a->tahun ?: $b->semester <=> $a->semester);

        return view('siswa.nilai', compact('siswa', 'nilaiPerTahun'));
    }

    public function rapor()
    {
        $siswa = Siswa::where('user_id', auth()->id())->firstOrFail();
        $rapors = Rapor::with(['kelas', 'tahunPelajaran', 'semester'])
            ->where('siswa_id', $siswa->id)
            ->where('status_rapor', 'final')
            ->latest()
            ->get();

        return view('siswa.rapor', compact('siswa', 'rapors'));
    }

    public function cetakRapor(Rapor $rapor)
    {
        $siswa = Siswa::where('user_id', auth()->id())->firstOrFail();

        if ($rapor->siswa_id !== $siswa->id || $rapor->status_rapor !== 'final') {
            abort(403);
        }

        $rapor->load(['siswa', 'kelas', 'tahunPelajaran', 'semester']);
        $nilais = NilaiRapor::with('mataPelajaran')
            ->where('siswa_id', $rapor->siswa_id)
            ->where('kelas_id', $rapor->kelas_id)
            ->where('tahun_pelajaran_id', $rapor->tahun_pelajaran_id)
            ->where('semester_id', $rapor->semester_id)
            ->get();

        $absensi = Absensi::where('siswa_id', $rapor->siswa_id)
            ->where('tahun_pelajaran_id', $rapor->tahun_pelajaran_id)
            ->where('semester_id', $rapor->semester_id)
            ->first();

        return view('rapor.cetak', compact('rapor', 'nilais', 'absensi'));
    }
}
