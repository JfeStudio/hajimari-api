<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function login(LoginRequest $request){
        // check user yg login siapa?
        $user = User::where('email', $request->email)->first();
        // lalu check klw bukan user dengan pass yg tidak sama dengan di inputkannya dgn pass yg di db maka.
        if (!$user || !Hash::check($request->password, $user->password)) {
            // kita return 401
            return response()->json([
                'message' => 'Bad Credentials',
            ], 401);
        }
        // return $user->createToken('token')->plainTextToken;
        // klw success kita generate token
        $token = $user->createToken('token')->plainTextToken;
        // dan return responnnya
        return new LoginResource([
            'message' => 'success',
            'user' => $user,
            'token' => $token,
        ]);
    }
}