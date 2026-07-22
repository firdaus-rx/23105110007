<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiswaRequest;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::all();
        $query = Siswa::with('kelas', 'user');

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $siswas = $query->latest()->get();
        $selectedKelas = $request->kelas_id;

        return view('admin.siswa.index', compact('siswas', 'kelasList', 'selectedKelas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(StoreSiswaRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->safe()->except(['user_name', 'user_email', 'user_password']);

            if ($request->filled('user_name') && $request->filled('user_email')) {
                $user = User::create([
                    'name' => $request->user_name,
                    'email' => $request->user_email,
                    'password' => Hash::make($request->user_password ?? 'siswa123'),
                    'role' => 'siswa',
                ]);
                $data['user_id'] = $user->id;
            }

            Siswa::create($data);
        });

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load('kelas', 'user');
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $siswa->load('user');
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(StoreSiswaRequest $request, Siswa $siswa)
    {
        DB::transaction(function () use ($request, $siswa) {
            $data = $request->safe()->except(['user_name', 'user_email', 'user_password']);

            if ($request->filled('user_name') && $request->filled('user_email')) {
                if ($siswa->user) {
                    $siswa->user->update([
                        'name' => $request->user_name,
                        'email' => $request->user_email,
                    ]);
                    if ($request->filled('user_password')) {
                        $siswa->user->update(['password' => Hash::make($request->user_password)]);
                    }
                } else {
                    $user = User::create([
                        'name' => $request->user_name,
                        'email' => $request->user_email,
                        'password' => Hash::make($request->user_password ?? 'siswa123'),
                        'role' => 'siswa',
                    ]);
                    $data['user_id'] = $user->id;
                }
            } elseif (!$request->filled('user_name') && !$request->filled('user_email') && $siswa->user) {
                $data['user_id'] = null;
            }

            $siswa->update($data);
        });

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
