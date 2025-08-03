<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login_id' => ['required'],
            'password' => ['required'],
        ]);

        // login_id로 사용자 찾기
        $user = User::where('login_id', $credentials['login_id'])->first();

        if ($user && Auth::attempt(['login_id' => $user->login_id, 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            // 권한에 따른 분기 처리
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home');
            }
        }

        return back()->withErrors([
            'login_id' => '아이디 또는 비밀번호가 올바르지 않습니다.',
        ])->onlyInput('login_id');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
