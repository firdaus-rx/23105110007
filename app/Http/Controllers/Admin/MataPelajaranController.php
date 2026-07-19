<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapelRequest;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mataPelajarans = MataPelajaran::latest()->get();
        return view('admin.mata-pelajaran.index', compact('mataPelajarans'));
    }

    public function create()
    {
        return view('admin.mata-pelajaran.create');
    }

    public function store(StoreMapelRequest $request)
    {
        MataPelajaran::create($request->validated());
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function show(MataPelajaran $mataPelajaran)
    {
        return view('admin.mata-pelajaran.show', compact('mataPelajaran'));
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('admin.mata-pelajaran.edit', compact('mataPelajaran'));
    }

    public function update(StoreMapelRequest $request, MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->update($request->validated());
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
