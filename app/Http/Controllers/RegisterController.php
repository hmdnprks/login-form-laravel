<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => User::passwordRules(),
        ], [
          'password.regex' => 'The :attribute must contain at least one lowercase letter, one uppercase letter, one number, and one special character.',
        ]);

        $validator->setAttributeNames([
          'password' => 'Password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'username' => $request->input('username'),
            'password' => $request->input('password'), // Store the password without hashing
        ]);

        return redirect('/login')->with('success', 'Registration successful. Please log in.');
    }
}
