<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = null;

        if ($user->role === 'guru') {
            $profile = Guru::with('user')->where('user_id', $user->id)->first();
        } elseif ($user->role === 'siswa' || $user->role === 'orang_tua') {
            $profile = Siswa::with('user', 'kelas')->where('user_id', $user->id)->first();
        }

        return view('profile.index', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if ($user->role === 'guru') {
            $guru = Guru::where('user_id', $user->id)->first();
            if ($guru && $request->filled('telepon')) {
                $guru->update(['telepon' => $request->telepon]);
            }
        } elseif (in_array($user->role, ['siswa', 'orang_tua'])) {
            $siswa = Siswa::where('user_id', $user->id)->first();
            if ($siswa) {
                $data = [];
                if ($request->filled('telepon_orang_tua')) $data['telepon_orang_tua'] = $request->telepon_orang_tua;
                if ($request->filled('alamat')) $data['alamat'] = $request->alamat;
                if (!empty($data)) $siswa->update($data);
            }
        }

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
