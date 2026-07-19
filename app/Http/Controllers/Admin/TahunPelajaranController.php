<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class TahunPelajaranController extends Controller
{
    public function index()
    {
        $tahunPelajarans = TahunPelajaran::latest()->get();
        return view('admin.tahun-pelajaran.index', compact('tahunPelajarans'));
    }

    public function create()
    {
        return view('admin.tahun-pelajaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tahun' => 'required|string|unique:tahun_pelajarans,nama_tahun',
            'status_aktif' => 'nullable|boolean',
        ]);

        if ($request->boolean('status_aktif')) {
            TahunPelajaran::where('status_aktif', true)->update(['status_aktif' => false]);
        }

        TahunPelajaran::create($validated);
        return redirect()->route('tahun-pelajaran.index')->with('success', 'Tahun pelajaran berhasil ditambahkan.');
    }

    public function edit(TahunPelajaran $tahunPelajaran)
    {
        return view('admin.tahun-pelajaran.edit', compact('tahunPelajaran'));
    }

    public function update(Request $request, TahunPelajaran $tahunPelajaran)
    {
        $validated = $request->validate([
            'nama_tahun' => 'required|string|unique:tahun_pelajarans,nama_tahun,' . $tahunPelajaran->id,
            'status_aktif' => 'nullable|boolean',
        ]);

        if ($request->boolean('status_aktif')) {
            TahunPelajaran::where('id', '!=', $tahunPelajaran->id)
                ->where('status_aktif', true)
                ->update(['status_aktif' => false]);
        }

        $tahunPelajaran->update($validated);
        return redirect()->route('tahun-pelajaran.index')->with('success', 'Tahun pelajaran berhasil diperbarui.');
    }

    public function destroy(TahunPelajaran $tahunPelajaran)
    {
        $tahunPelajaran->delete();
        return redirect()->route('tahun-pelajaran.index')->with('success', 'Tahun pelajaran berhasil dihapus.');
    }
}
