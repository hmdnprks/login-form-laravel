<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function showResetForm(Request $request)
    {
        return view('password.reset');
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => User::passwordRules(),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('username', $request->input('username'))->first();

        if ($user) {
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return redirect('/login')->with('success', 'Password reset successful. Please log in with your new password.');
        } else {
            return back()->withErrors(['username' => 'Invalid username. Please try again.'])->withInput();
        }
    }
}
