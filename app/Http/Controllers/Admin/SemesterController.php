<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::latest()->get();
        return view('admin.semester.index', compact('semesters'));
    }

    public function create()
    {
        return view('admin.semester.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_semester' => 'required|in:Ganjil,Genap',
            'status_aktif' => 'nullable|boolean',
        ]);

        if ($request->boolean('status_aktif')) {
            Semester::where('status_aktif', true)->update(['status_aktif' => false]);
        }

        Semester::create($validated);
        return redirect()->route('semester.index')->with('success', 'Semester berhasil ditambahkan.');
    }

    public function edit(Semester $semester)
    {
        return view('admin.semester.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $validated = $request->validate([
            'nama_semester' => 'required|in:Ganjil,Genap',
            'status_aktif' => 'nullable|boolean',
        ]);

        if ($request->boolean('status_aktif')) {
            Semester::where('id', '!=', $semester->id)
                ->where('status_aktif', true)
                ->update(['status_aktif' => false]);
        }

        $semester->update($validated);
        return redirect()->route('semester.index')->with('success', 'Semester berhasil diperbarui.');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect()->route('semester.index')->with('success', 'Semester berhasil dihapus.');
    }
}
