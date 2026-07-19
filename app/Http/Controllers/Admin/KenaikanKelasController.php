<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KenaikanKelasController extends Controller
{
    public function index()
    {
        $tahunPelajarans = TahunPelajaran::latest()->get();
        $semesters = Semester::latest()->get();
        $kelasList = Kelas::withCount('siswas')->orderBy('tingkat')->orderBy('nama_kelas')->get();

        // If preview params exist
        $dataKelas = null;
        $tahunAsal = null;
        $semesterAsal = null;

        if (request()->filled('tahun_pelajaran_asal') && request()->filled('semester_asal')) {
            $tahunAsal = TahunPelajaran::find(request('tahun_pelajaran_asal'));
            $semesterAsal = Semester::find(request('semester_asal'));

            if ($tahunAsal && $semesterAsal) {
                $kelasWithSiswa = Kelas::with('siswas')->orderBy('tingkat')->orderBy('nama_kelas')->get();
                $dataKelas = [];

                foreach ($kelasWithSiswa as $kelas) {
                    if ($kelas->siswas->count() == 0) continue;

                    $nextKelas = Kelas::where('tingkat', $kelas->tingkat + 1)
                        ->where('nama_kelas', 'like', '%' . substr($kelas->nama_kelas, -1))
                        ->first();

                    $dataKelas[] = (object)[
                        'kelas' => $kelas,
                        'siswas' => $kelas->siswas,
                        'nextKelas' => $nextKelas,
                        'bisaNaik' => $nextKelas !== null && $kelas->tingkat < 6,
                    ];
                }
            }
        }

        return view('admin.kenaikan-kelas.index', compact(
            'tahunPelajarans', 'semesters', 'kelasList',
            'dataKelas', 'tahunAsal', 'semesterAsal'
        ));
    }

    public function preview(Request $request)
    {
        return redirect()->route('admin.kenaikan-kelas', [
            'tahun_pelajaran_asal' => $request->tahun_pelajaran_asal,
            'semester_asal' => $request->semester_asal,
        ]);
    }

    public function promote(Request $request)
    {
        $request->validate([
            'tahun_pelajaran_asal' => 'required|exists:tahun_pelajarans,id',
            'semester_asal' => 'required|exists:semesters,id',
            'siswa_ids' => 'required',
        ]);

        $siswaIds = json_decode($request->siswa_ids);
        if (!is_array($siswaIds) || empty($siswaIds)) {
            return back()->with('error', 'Pilih minimal satu siswa untuk dinaikkan.');
        }

        $validIds = \App\Models\Siswa::whereIn('id', $siswaIds)->pluck('id')->toArray();
        $naik = 0;
        $lulus = 0;

        DB::transaction(function () use ($validIds, &$naik, &$lulus) {
            foreach ($validIds as $siswaId) {
                $siswa = Siswa::with('kelas')->findOrFail($siswaId);
                $kelas = $siswa->kelas;

                if (!$kelas || $kelas->tingkat >= 6) {
                    $lulus++;
                    continue;
                }

                $nextKelas = Kelas::where('tingkat', $kelas->tingkat + 1)
                    ->where('nama_kelas', 'like', '%' . substr($kelas->nama_kelas, -1))
                    ->first();

                if ($nextKelas) {
                    $siswa->update(['kelas_id' => $nextKelas->id]);
                    $naik++;
                } else {
                    $lulus++;
                }
            }
        });

        return redirect()->route('admin.kenaikan-kelas')
            ->with('success', "Kenaikan kelas selesai: {$naik} siswa naik kelas, {$lulus} siswa lulus.");
    }
}