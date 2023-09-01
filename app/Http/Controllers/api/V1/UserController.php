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

class UserController extends Controller
{
    // Registers a new user
    public function register(StoreUserRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $token = $request->user()->createToken('userToken')->plainTextToken;

        if(Auth::check($user)) 
        {
            return response()->json([
                'message' => 'Success!',
                'user' => new UserResource($user),
                'token' => $token
            ], 201);
            
        } else {
            return response()->json([
                "message" => "an error has occured"
            ], 403);
        }
    }

    // logs the user who has previously registered
    public function login(LoginUserRequest $request)
    {   
        $request->validated();
    
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) 
        {
            $token = $request->user()->createToken('userToken')->plainTextToken;
            $user = Auth::user();

            return response()->json([
                'message' => 'Success!',
                'user' => new UserResource($user),
                'token' => $token,
            ], 200);
        } 
        
        else 
        {
            $return =  [
                'message' => 'Error',
                'user' => null,
                'token' => null
            ];

            return response($return, 404);
        }
    }

    // Update the specified resource in storage.
    public function update(Request $request, string $id)
    {
        
    }

    // logs out the user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->user()->currentAccessToken()->delete();
        
        if(Auth::check()) {
            return response()->json([
                'message' => 'User successfully logged out'
            ], 200);
        } else {
            return response()->json([
                'message' => 'User sufdofsdfosdofnsfccessfully logged out'
            ], 200);
    
        }
        
    }

    // delete the user's records and data
    public function deleteUser(User $user)/* : array */ {
        
    }
}
