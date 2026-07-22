<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuruRequest;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $gurus = Guru::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $gurus->where(function ($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        $gurus = $gurus->latest()->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(StoreGuruRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->safe()->except(['user_name', 'user_email', 'user_password']);

            if ($request->filled('user_name') && $request->filled('user_email')) {
                $user = User::create([
                    'name' => $request->user_name,
                    'email' => $request->user_email,
                    'password' => Hash::make($request->user_password ?? 'guru123'),
                    'role' => 'guru',
                ]);
                $data['user_id'] = $user->id;
            }

            Guru::create($data);
        });

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        $guru->load('user');
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        $guru->load('user');
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(StoreGuruRequest $request, Guru $guru)
    {
        DB::transaction(function () use ($request, $guru) {
            $data = $request->safe()->except(['user_name', 'user_email', 'user_password']);

            if ($request->filled('user_name') && $request->filled('user_email')) {
                if ($guru->user) {
                    $guru->user->update([
                        'name' => $request->user_name,
                        'email' => $request->user_email,
                    ]);
                    if ($request->filled('user_password')) {
                        $guru->user->update(['password' => Hash::make($request->user_password)]);
                    }
                } else {
                    $user = User::create([
                        'name' => $request->user_name,
                        'email' => $request->user_email,
                        'password' => Hash::make($request->user_password ?? 'guru123'),
                        'role' => 'guru',
                    ]);
                    $data['user_id'] = $user->id;
                }
            } elseif (!$request->filled('user_name') && !$request->filled('user_email') && $guru->user) {
                $data['user_id'] = null;
            }

            $guru->update($data);
        });

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
