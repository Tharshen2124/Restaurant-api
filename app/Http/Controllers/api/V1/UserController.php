<?php

namespace App\Http\Controllers\api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\V1\UserResource;
use App\Http\Requests\V1\LoginUserRequest;
use App\Http\Requests\V1\StoreUserRequest;
use Illuminate\Validation\ValidationException;

/* use App\Traits\HttpResponses; */


class UserController extends Controller
{

    // Registers a new user
    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        if(Auth::check($user)) {
            $token = $request->user()->createToken('userToken')->plainTextToken;
            return [
                'message' => 'Success!',
                'status' => 201,
                'user' => new UserResource($user),
                'token' => $token
            ];
        } else {
            return [
                'message' => 'Error',
                'status' => 'fuck you',
                'user' => null,
                'token' => null
            ];
        }
    }

    // logs the user who has previously registered
    public function login(LoginUserRequest $request)
    {   
        $request->validated($request->all());
    
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $token = $request->user()->createToken('userToken')->plainTextToken;
            return [
                'message' => 'Success!',
                'status' => 200,
                'user' => User::where('email', $request->email)->get(),
                'token' => $token,
                
            ]; 
        } else {
            return [
                'message' => 'Error',
                'status' => 'Fuck you',
                'user' => null,
                'token' => null
            ];
        }
    }

    // Update the specified resource in storage.
    public function update(Request $request, string $id)
    {
    
    }

    // logs out the user
    public function logout(string $id)/* : array */ {
    
    }

    // delete the user's records and data
    public function deleteUser(User $user)/* : array */ {

    }
}
