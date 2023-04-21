<?php

namespace App\Http\Controllers\api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    
    // Registers a new user
     
    public function register(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|max:255|min:3',
            'email' => 'required|email:rfc,dns|unique:App\Models\User,email',
            'password' => [
                'required',
                Password::min(8)
                     ->numbers()
                     ->symbols()
                     ->letters()
            ],
            /* 'confirm_password' => 'same:password', */
        ]);

        $userPassword = Hash::make($attributes['password']);

        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => $userPassword,
            
        ]);
        /**
         * Auth::check() 
         * * does work because returns bool
         * Auth::attempt($attributes)
         * * does work
         * Auth::login($user)
         * ^ does not work but i know why (does not return bool)
         
        */
        Auth::login($user);
        if(Auth::check()) {
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
            return response()->json("hhhmm....., we can't seem to log you in");
        }
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
