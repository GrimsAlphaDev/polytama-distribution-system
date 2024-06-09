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
                return redirect('/marketing');
                break;
            case 'transporter':
                dd('transporter');
                break;
            case 'driver':
                dd('driver');
                break;
            case 'logistik':
                dd('logistik');
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
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->withErrors([
            'Error' => 'Terjadi Kesalahan'
        ]);
    }
}
