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
}