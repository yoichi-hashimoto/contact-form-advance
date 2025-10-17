<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class UserController extends Controller
{
    public function showRegistrationForm(){return view('register');
    }
    public function showLoginForm(){return view('login');
    }

    public function register(RegisterRequest $request){
        $validated = $request->validated();
            
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        return redirect()->intended('admin')->with('success', '登録に成功しました！');
    }

    public function login(LoginRequest $request){
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin')->with('success', 'ログインしました。');
        }
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが違います。',
        ])->onlyInput('email');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'ログアウトしました。');
    }
}