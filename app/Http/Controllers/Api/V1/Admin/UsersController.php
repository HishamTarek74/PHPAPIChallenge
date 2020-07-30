<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {

        return new UserResource(User::with(['posts'])->get());
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(User $user)
    {

        return new UserResource($user->load(['posts']));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
