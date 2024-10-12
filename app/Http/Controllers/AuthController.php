<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\UserActivityEvent;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // Sesuaikan dengan view login
    }

    // Method untuk menangani proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // Tentukan guard berdasarkan role yang akan login
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.',
            ]);
        }

        $guard = strtolower($user->role);

        // Cek akun
        if (Auth::guard($guard)->attempt($credentials, $request->has('remember-me'))) {
            $user->last_login = now();
            $user->save();

            // Cek status akun
            if ($user->status_akun !== 'Aktif') {
                Auth::guard($guard)->logout();
                return redirect()->route('login')->with('error', 'Status akun anda Non-Aktif. Silahkan laporkan masalah.');
            }

            // Redirect ke dashboard yang sesuai dengan guard
            return redirect()->route($guard . '.dashboard')->with('success', 'Login berhasil!');
        }

        // Jika login gagal pada semua guard
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }
    public function logout(Request $request)
    {
        // Tentukan guard berdasarkan role yang sedang login
        $roleGuards = [
            'Admin' => 'admin',
            'Operator' => 'operator',
            'Pegawai' => 'pegawai',
        ];

        // Logout dari guard yang aktif
        foreach ($roleGuards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();

                // Invalidate session
                $request->session()->invalidate();

                // Regenerate CSRF token
                $request->session()->regenerateToken();

                // Hapus remember_me dari session
                $request->session()->forget('remember_me');

                // Redirect ke halaman login atau halaman lain setelah logout
                return redirect('/login')->with('success', 'Anda telah berhasil logout.');
            }
        }

        // Redirect to login if no user was logged in (fallback)
        return redirect('/login')->with('error', 'Tidak ada pengguna yang login.');
    }


    // Menampilkan form permintaan reset password
    public function create_forgot_password()
    {
        return view('auth.forgot-password');
    }

    // Mengirim email reset password
    public function store_forgot_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Kirim link reset password
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Menampilkan form reset password
    public function create_reset_password($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Menyimpan password baru
    public function store_reset_password(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Reset password menggunakan token
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                // Trigger event reset password
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }


}
