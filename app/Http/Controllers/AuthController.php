<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\v2\User\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    //store a user
    public function store(UserRequest $request)
    {
        //validate data
        $request->validated($request->all());

        //create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //generate token
        $userToken = $user->createToken("api token for {$user->name}")->plainTextToken;

        // return response
        return $this->success(
            [
                'user' => new UserResource($user),
                'token' => $userToken
            ],
            'User successfully created'
        );
    }

    //logging in
    public function login(LoginUserRequest $request)
    {
        //validate data
        $request->validated($request->all());

        //fetch the user data
        $user = User::where('email', $request->email)->first();

        //check user credentials and return error if not matched
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error(null, 'Credentials does not match', 401);
        }

        //generate token
        $userToken = $user->createToken('api token for {$user->name}')->plainTextToken;

        //return response
        return $this->success([
            'user' => new UserResource($user),
            'token' => $userToken,

        ], 'successfully logged in.');
    }

    //log out
    public function logout(Request $request)
    {
        //delete the current token
        $request->user()->currentAccessToken()->delete();

        //return response
        return $this->success(null, 'logged out successfully');
    }
}