<?php

namespace App\Http\Controllers\api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\V1\UserResource;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\V1\StoreUserRequest;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    
    // Registers a new user
     
    public function register(StoreUserRequest $request)
    {
        return new UserResource(User::create($request->all()));
        
        
    }

    
    // logs the user who has previously registered
     
    public function login(Request $request)
    {   
        $attributes = $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
            
        ]);

        if(Auth::attempt($attributes)) {
            session()->regenerate();

            $user = User::where('email', $attributes['email'])->first();
           
            return ([
                'message' => 'Success!',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
                ]                
            ]);
        } else {
            return ([
                'message' => "hhhmm...it seems we can't find your credentials. Are you sure you have registered already?"
            ]);
        }
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
