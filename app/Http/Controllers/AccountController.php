<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $gNum = "05";
        return view('account.index', compact('user', 'gNum'));
    }

    public function edit()
    {
        $user = Auth::user();
        $gNum = "05";
        return view('account.edit', compact('user', 'gNum'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // 유효성 검사
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->idx . ',idx',
            'phone' => 'required|string|max:20',
        ]);

        // 사용자 정보 업데이트
        $user->update($validated);

        return redirect()->route('account.index')
                        ->with('success', '프로필이 성공적으로 업데이트되었습니다.');
    }

    public function information()
    {
        $user = Auth::user();
        $gNum = "05";
        return view('account.information', compact('user', 'gNum'));
    }
}
