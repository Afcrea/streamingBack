<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {

    }
    // 회원 가입
    public function regist(Request $request) {
        try {
            // Validation
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
            ]);

            
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            return response()->json(['message' => 'User registered successfully'], 201);
        }
        catch(\Exception $e) {
            return response()->json(['message' => 'Bad request'], 401);
        }
    }
    
    public function getUser() {
        return response()->json(['user' => auth()->user()], 200);
    }
}
