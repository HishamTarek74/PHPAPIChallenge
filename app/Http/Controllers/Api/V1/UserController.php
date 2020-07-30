<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function __construct()
    {
     $this->middleware('auth:api')->except([ 'update','show']);
    }


         /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
      public function show(User $user)
      {
          return new UserResource($user);

      }
  
      /**
       * Update the specified resource .
       *
       * @param  \Illuminate\Http\Request  $request
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function update(UpdateUserRequest $request, User $user)
  
      {
  
        // check if user authenticated 
  
        if ( $request->user() ) {
  
          return response()->json(['error' => 'You Must Auth!'], 403);
  
        }
  
        $user->update($request->all());
 
        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED); 
  
       }
}
