<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

use App\User;

class UserRegistrationController extends Controller
{
    
    /**
     * Register User
     *
     * @param UserRegistrationRequest $request
     */
    public function register(UserRegistrationRequest $request) {

        $user= User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password'=> $request->get('password'),
        ]);
        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
 
     }
}
