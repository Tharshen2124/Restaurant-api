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
     
    public function register(StoreUserRequest $request)
    {
        return new UserResource(User::create($request->all()));
    }

    
    // logs the user who has previously registered
     
    public function login(LoginUserRequest $request)
    {   
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
       
    }

    // logs out the user

    public function logout(string $id)
    {
        Auth::logout();

        return ([
            'message' => 'Goodbye!'
        ]);
    }

    public function deleteUser(User $user) {
        $user->delete();

        return ([
            'message' => 'Account successfully deleted'
        ]);
    }
}
