<?php

namespace App\Http\Controllers\api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\V1\UserResource;
use App\Http\Requests\V1\StoreUserRequest;

/* use App\Traits\HttpResponses; */


class UserController extends Controller
{

    // Registers a new user
    public function register(StoreUserRequest $request): UserResource
    {
        // return new UserResource(User::create($request->all()));

        // creates a new user and stores it into the database
        $user = User::create($request->all());

        // logs the user into the session
        Auth::login($user);

        // checks if the user is authenticated or not
        return Auth::check() ?  new UserResource($user) : ['message' => 'Hhhmm we cant seem to log you in'];
    }

    
    // logs the user who has previously registered
    public function login(LoginUserRequest $request): array 
    {   
        //
        $request->validated($request->all());

        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => 'Error has occured...',
                'message' => 'Credentials do not match',
                'data' => null
            ], 401);
        } 

        $user = User::where('email', $request->email)->first();

        return [
            'user' => new UserResource($user),
            'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken
        ];
    }

    // Update the specified resource in storage.
    public function update(Request $request, string $id)
    {
    
    }

    // logs out the user
    public function logout(string $id): array {
        Auth::logout();

        return ([
            'message' => 'Goodbye!'
        ]);
    }

    // delete the user's records and data
    public function deleteUser(User $user): array {
        $user->delete();

        return ([
            'message' => 'Account successfully deleted'
        ]);
    }
}
