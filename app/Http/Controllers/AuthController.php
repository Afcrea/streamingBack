<?php

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// 로그인 할때 마다 토큰 발급해서 업데이트 토큰은 로그아웃할때 전부 삭제

class AuthController extends Controller
{
    // echo "123";exit;
    
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        // 사용자가 존재하고, 입력된 비밀번호가 일치하면 토큰 업데이트
        if ($user && Hash::check($request->input('password'), $user->password)) {
            $token = $user->createToken('token-name')->plainTextToken;
            $user->update([
                'remember_token' => $token
            ]);

            return response()->json(['message' => 'Secess Authorization', 'token' => $token], 200);
        }

        // 사용자 인증 실패
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout() {
        // 현재 인증된 사용자의 토큰을 모두 삭제
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}

