<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('username', 'password');

        $user = User::where('username', $credentials['username'])->first();

        if ($user) {
            // Check if the user's login attempts have exceeded the limit
            if ($user->login_attempts >= 3 && time() - strtotime($user->last_login_attempt) < 30) {
                $remainingAttempts = 3 - $user->login_attempts;
                $waitTime = 30 - (time() - strtotime($user->last_login_attempt));

                if ($remainingAttempts === 0) {
                    $waitTime = max(0, $waitTime);
                } else {
                    $waitTime = max(0, $waitTime);
                    $user->last_login_attempt = Carbon::now(); // Update the last login attempt time
                    $user->save();
                }

                return back()->withErrors([
                    'message' => 'You have exceeded the maximum login attempts. Please try again later.',
                    'login_attempts' => $remainingAttempts,
                    'wait_time' => $waitTime,
                ])->withInput()->with('waitTime', $waitTime);;
            }

            // Verify the password
            if (Hash::check($credentials['password'], $user->password)) {
                // Reset the login attempts and last login attempt
                $user->login_attempts = 0;
                $user->last_login_attempt = null;
                $user->save();

                Auth::login($user); // Log in the user

                return redirect()->intended('/dashboard');
            } else {
                // Clear previous validation errors
                $request->session()->forget('errors');

                $inputPasswordHashed = Hash::make($credentials['password']);
                $databasePasswordHashed = $user->password;
                $remainingAttempts = 3 - $user->login_attempts;
                $waitTime = 30 - (time() - strtotime($user->last_login_attempt));
                 // Check if the user has reached the maximum login attempts
                 if ($remainingAttempts <= 0) {
                    $user->last_login_attempt = now(); // Update the last login attempt time
                    $user->save();
                    $waitTime = 30 - (time() - strtotime($user->last_login_attempt));
                    return back()->withErrors([
                        'message' => 'You have exceeded the maximum login attempts. Please try again later.',
                        'login_attempts' => $remainingAttempts,
                        'wait_time' => $waitTime,
                    ])->withInput()->with('waitTime', $waitTime);;
                } else {
                    $waitTime = max(0, $waitTime);
                    $user->login_attempts++;
                    $user->last_login_attempt = now(); // Update the last login attempt time
                    $user->save();
                }

                return back()->withErrors([
                    'message' => 'Invalid credentials. Please try again.',
                    'input_password_hashed' => $inputPasswordHashed,
                    'database_password_hashed' => $databasePasswordHashed,
                    'login_attempts' => $remainingAttempts,
                ])->withInput();
            }
        } else {
            return back()->withErrors(['message' => 'Invalid credentials. Please try again.'])->withInput();
        }
    }


    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }

}
