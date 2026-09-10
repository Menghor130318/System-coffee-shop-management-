<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(array $data)
    {
        if (!Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ])) {
            abort(401, 'Email hoặc mật khẩu không đúng.');
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
    public function register(array $data)
    {
        $user = User::create([

            'role_id' => 2,

            'full_name' => $data['full_name'],

            'email' => $data['email'],

            'password' => Hash::make($data['password']),

            'phone' => $data['phone'] ?? null,

            'address' => null,

            'avatar' => null,

            'status' => 1,

        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [

            'user' => $user,

            'token' => $token,

        ];
    }
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return true;
    }
}
