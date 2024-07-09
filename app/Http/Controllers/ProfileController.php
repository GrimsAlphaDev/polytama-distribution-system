<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            return view('marketing.profile.setting');
        } else if (auth()->user()->role_id == 2) {
            return view('transporter.profile.setting');
        } else if (auth()->user()->role_id == 3) {
            return view('driver.profile.setting');
        } else if (auth()->user()->role_id == 4) {
            return view('logistik.profile.setting');
        }
    }

    public function updateDetail($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
        ]);

        $user = User::find($id);

        // Perbarui data pengguna
        $user->name = $request->name;
        $user->email = $request->email;

        // Simpan perubahan ke database
        $user->update();

        return redirect()->back()->with('success', 'Sukses')->with('description', 'Data Profile berhasil diubah');
    }

    public function chagePass($id, Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find($id);

        // Perbarui password pengguna
        $user->password = bcrypt($request->password);

        // Simpan perubahan ke database
        $user->update();

        return redirect()->back()->with('success', 'Sukses')->with('description', 'Password berhasil diubah');
    }
}
