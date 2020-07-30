<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\UserAuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use App\User;

class UserAuthController extends Controller
{

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(UserAuthRequest $request) {

           $credentials = request(['email', 'password']);
           if (!$token = auth()->attempt($credentials)) {
               return response()->json(['error' => 'Email or password does\'t exist'], 401);
           }
           
               return $this->createNewToken($token);
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout() {
        auth()->logout();
        return $this->respondWithMessage('User successfully logged out');
    }


    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    public function me() {
        return $this->respond(auth()->user());
    }
}
