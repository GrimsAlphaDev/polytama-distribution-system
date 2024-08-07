<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthentificationController extends Controller
{
    public function login()
    {
        return view('portal.login');
    }

    public function signIn(Request $request)
    {
        $credentials = $request->only('nik', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/checkRoles');
        }

        return back()->withErrors([
            'nik' => 'NIK atau Password Salah',
        ]);
    }

    public function checkRoles(Request $request)
    {
        switch (Auth::user()->role->name) {
            case 'marketing':
                return redirect('/marketing')->with('success', 'Berhasil Login')->with('description', 'Selamat Datang di Dashboard Marketing');
                break;
            case 'transporter':
                return redirect('/transporter')->with('success', 'Berhasil Login')->with('description', 'Selamat Datang di Dashboard Transporter');
                break;
            case 'driver':
                return redirect('/driver')->with('success', 'Berhasil Login')->with('description', 'Selamat Datang di Dashboard Driver');
                break;
                
            case 'logistik':
                return redirect('/logistik')->with('success', 'Berhasil Login')->with('description', 'Selamat Datang di Dashboard Logistik');
                break;

            default:
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/')->withErrors([
                    'Error' => 'Terjadi Kesalahan'
                ]);
        }
    }

    public function logout(Request $request)
    {

        // check if user is not logged in
        if (!Auth::check()) {
            return redirect('/login')->withErrors([
                'Error' => 'Anda belum login'
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sukses')->with('description', 'Berhasil Logout');
    }
}
