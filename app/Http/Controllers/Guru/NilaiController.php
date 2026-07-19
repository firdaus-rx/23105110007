<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JadwalMengajar;
use App\Models\MataPelajaran;
use App\Models\NilaiRapor;
use App\Models\Siswa;
use App\Services\NilaiService;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    protected $nilaiService;

    public function __construct(NilaiService $nilaiService)
    {
        $this->nilaiService = $nilaiService;
    }

    public function index(JadwalMengajar $jadwal)
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();

        if ($jadwal->guru_id !== $guru->id) {
            abort(403, 'Anda tidak memiliki akses ke jadwal ini.');
        }

        $siswas = Siswa::where('kelas_id', $jadwal->kelas_id)->get();
        $nilais = NilaiRapor::where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('tahun_pelajaran_id', $jadwal->tahun_pelajaran_id)
            ->where('semester_id', $jadwal->semester_id)
            ->get()
            ->keyBy('siswa_id');

        return view('guru.nilai.index', compact('jadwal', 'siswas', 'nilais'));
    }

    public function store(Request $request, JadwalMengajar $jadwal)
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();

        if ($jadwal->guru_id !== $guru->id) {
            abort(403);
        }

        $validated = $request->validate([
            'nilai' => 'required|array',
            'nilai.*.nilai_pengetahuan' => 'nullable|integer|min:0|max:100',
            'nilai.*.nilai_keterampilan' => 'nullable|integer|min:0|max:100',
            'nilai.*.nilai_sikap' => 'nullable|string|max:50',
        ]);

        foreach ($request->nilai as $siswaId => $data) {
            $nilaiPengetahuan = $data['nilai_pengetahuan'] ?? null;
            $nilaiKeterampilan = $data['nilai_keterampilan'] ?? null;

            if ($nilaiPengetahuan !== null || $nilaiKeterampilan !== null) {
                $nilaiAkhir = $this->nilaiService->hitungNilaiAkhir(
                    $nilaiPengetahuan ?? 0,
                    $nilaiKeterampilan ?? 0
                );

                $mapel = MataPelajaran::find($jadwal->mata_pelajaran_id);

                NilaiRapor::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'guru_id' => $guru->id,
                        'kelas_id' => $jadwal->kelas_id,
                        'mata_pelajaran_id' => $jadwal->mata_pelajaran_id,
                        'tahun_pelajaran_id' => $jadwal->tahun_pelajaran_id,
                        'semester_id' => $jadwal->semester_id,
                    ],
                    [
                        'nilai_pengetahuan' => $nilaiPengetahuan,
                        'nilai_keterampilan' => $nilaiKeterampilan,
                        'nilai_sikap' => $data['nilai_sikap'] ?? null,
                        'predikat' => $this->nilaiService->hitungPredikat($nilaiAkhir),
                        'deskripsi' => $this->nilaiService->hitungDeskripsi($nilaiAkhir, $mapel->kkm, $mapel->nama_mapel),
                    ]
                );

                $this->nilaiService->updateRaporSiswa(
                    $siswaId, $jadwal->kelas_id,
                    $jadwal->tahun_pelajaran_id, $jadwal->semester_id
                );
            }
        }

        return redirect()->route('guru.nilai.index', $jadwal)->with('success', 'Nilai berhasil disimpan.');
    }

    public function rekap()
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $jadwals = JadwalMengajar::with(['kelas', 'mataPelajaran', 'tahunPelajaran', 'semester'])
            ->where('guru_id', $guru->id)->get();

        $rekapGroup = [];
        foreach ($jadwals as $j) {
            $rata = NilaiRapor::where('mata_pelajaran_id', $j->mata_pelajaran_id)
                ->where('kelas_id', $j->kelas_id)
                ->where('tahun_pelajaran_id', $j->tahun_pelajaran_id)
                ->where('semester_id', $j->semester_id)
                ->avg(\DB::raw('(COALESCE(nilai_pengetahuan,0) + COALESCE(nilai_keterampilan,0)) / 2'));
            $rekapGroup[$j->kelas->nama_kelas][] = [
                'jadwal' => $j,
                'rata_rata' => round($rata ?: 0, 2),
            ];
        }

        return view('guru.nilai.rekap', compact('rekapGroup'));
    }
}
