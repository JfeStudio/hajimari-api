<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function login(LoginRequest $request){
        // check user yg login siapa? menggunakan only()
        $creadentials = $request->only('email', 'password');
        // check menggunakan auth attemp punya laravel, dia akan mengembalikan true/false
        if (Auth::attempt($creadentials)) {
            // lalu kita cari user
            $user = User::where('email', $request->email)->first();
            // dan generate token
            $token = $user->createToken('token')->plainTextToken;
            // kita return datanya menggunakan resource
                return new LoginResource([
                    'message' => 'success',
                    'user' => $user,
                    'token' => $token,
                ]);
        }
        // klw pass gagal, maka dia akan return di bawah ini
        return response()->json(['message' => 'Bad Credentials']);
    }

    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|min:3',
            'password' => 'required|min:8'
        ]);
        if ($validated) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'message' => 'success',
                'user' => $user,
                'token' => $token,
            ]);
        }
        return response()->json([
            'message' => 'data bad credentials',
        ]);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => 'success',
        ]);
    }
}