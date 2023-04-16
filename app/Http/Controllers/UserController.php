<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
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
       
        $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;
        Auth::login($user);
        // Why cant i use this for the if else part
        if(Auth::check()) {
            return ([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token,
            ]);
        } else {
            return response()->json("hhhmm....., we can't seem to log you in");
        }
    }

    /**
     * Display the specified resource.
     */
    public function login(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|email:rfc,dns|unique:App\Models\User,email',
            'password' => [
                'required',
                Password::min(8)
                     ->numbers()
                     ->symbols()
                     ->letters()
            ],
        ]);

       /*  if(Auth::attempt($attributes)) {
            session()->regenerate();
            return ([
                'name' => $user->name,
                'token' => $token,
            ]);
        }  */
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
