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
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $token = $request->user()->createToken('userToken')->plainTextToken;

        $return = [
            'message' => 'Success!',
            'status' => 201,
            'user' => new UserResource($user),
            'token' => $token
        ];

        if(Auth::check($user)) 
        {
            $request->session()->regenerate();
            return response($return, 201);
        } 
        else 
        {
            return [
                'message' => 'Error',
                'status' => 'fuck you',
                'user' => null,
                'token' => null
            ];
        }
    }

    // logs the user who has previously registered
    public function login(LoginUserRequest $request): array
    {   
        $request->validated();
    
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            //$request->session()->regenerate();
            $token = $request->user()->createToken('userToken')->plainTextToken;
            $user = Auth::user();
            
            return [
                'message' => 'Success!',
                'status' => 200,
                'user' => new UserResource($user),
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
    public function logout(Request $request): array
    {
       auth()->logout();
        
       if(!Auth::check()) {
        return ['message' => 'successfully logged out' ];
       }
    }

    // delete the user's records and data
    public function deleteUser(User $user)/* : array */ {

    }
}
