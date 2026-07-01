<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot-password');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'nama_lengkap' => 'required',
            'role' => 'required',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
        ]);

        $admin = User::where('username', $request->username)
            ->where('nama_lengkap', $request->nama_lengkap)
            ->where('role', $request->role)
            ->first();

        if (!$admin) {
            return back()
                ->withErrors([
                    'username' => 'Data yang dimasukkan tidak sesuai.'
                ])
                ->withInput();
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()
            ->route('login')
            ->with('success', 'Password berhasil diperbarui. Silakan login kembali.');
    }
}