<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthController extends Controller
{
    // Existing methods tetap sama...
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showBankLogin()
    {
        return view('auth.bank-login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::with('role')->find(Auth::id());

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isBank()) {
                return redirect()->route('bank.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return redirect()->back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Default user role
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    // NEW METHODS untuk Google OAuth
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada berdasarkan Google ID
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // User sudah ada, langsung login
                Auth::login($user);
                return $this->redirectBasedOnRole($user);
            }

            // Cek apakah email sudah terdaftar
            $existingUser = User::where('email', $googleUser->email)->first();

            if ($existingUser) {
                // Email sudah ada, update dengan Google ID
                $existingUser->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                ]);

                Auth::login($existingUser);
                return $this->redirectBasedOnRole($existingUser);
            }

            // User baru, buat akun baru
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'role_id' => 2, // Default user role
            ]);

            Auth::login($newUser);
            return $this->redirectBasedOnRole($newUser);
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors([
                'google' => 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.'
            ]);
        }
    }

    private function redirectBasedOnRole($user)
    {
        $user = User::with('role')->find($user->id);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isBank()) {
            return redirect()->route('bank.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
}
