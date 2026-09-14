<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $ok = $data['email'] === config('shop.admin_email')
            && $data['password'] === config('shop.admin_password');

        if (!$ok) {
            return back()->with('error', 'Hibás e-mail vagy jelszó.')->withInput();
        }

        $request->session()->put('admin_logged_in', true);
        $request->session()->put('admin_email', $data['email']);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_logged_in', 'admin_email']);

        return redirect()->route('admin.login');
    }
}
