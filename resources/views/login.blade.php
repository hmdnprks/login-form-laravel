@extends('layouts.app')

@section('content')
<!-- login.blade.php -->

<div class="login-container">
    <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf

        <h2>Login</h2>

        @if ($errors->has('captcha'))
          <div class="alert alert-danger">
              {{ $errors->first('captcha') }}
          </div>
        @endif

        @if(session('dashboardRedirect'))
            <div class="alert alert-warning">
                You must be logged in to access the dashboard.
            </div>
        @endif

        @if ($errors->has('message'))
          <div class="alert alert-danger">
              {{ $errors->first('message') }}
              @if ($errors->has('login_attempts'))
                  You have {{ $errors->first('login_attempts') }} attempts left.
                  @if ($errors->has('wait_time'))
                      @php
                          $waitTime = max(0, $errors->first('wait_time'));
                          $minutes = floor($waitTime / 60);
                          $seconds = $waitTime % 60;
                      @endphp
                      Please wait for <span id="countdown-timer">{{ $minutes }}:{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}</span> before trying again.
                  @endif
              @endif
          </div>
        @endif

        @if ($errors->has('username') || $errors->has('password'))
            <div class="alert alert-danger">
                Invalid credentials. Please try again.
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="password-field">
            <input type="password" name="password" id="password" required>
            <i class="password-toggle fas fa-eye" aria-hidden="true"></i>
          </div>
        </div>

        <div class="form-group">
          {!! NoCaptcha::renderJs() !!}
          {!! NoCaptcha::display() !!}
          @if ($errors->has('g-recaptcha-response'))
              <span class="error">{{ $errors->first('g-recaptcha-response') }}</span>
          @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn-login" id="login-button" >Login</button>
        </div>

        <div class="form-links">
            <a href="{{ route('register') }}">Register</a>
            <a href="{{ route('password.reset') }}">Forgot Password?</a>
        </div>
    </form>
</div>
@endsection

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush


@push('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
        // Countdown timer
        var countdownTime = {{ $waitTime ?? 0 }};
        var countdownInterval;

        function startCountdown() {
            countdownInterval = setInterval(function () {
                if (countdownTime > 0) {
                    countdownTime--;
                    updateCountdownDisplay();
                } else {
                    stopCountdown();
                    enableLoginButton();
                }
            }, 1000);
        }

        function stopCountdown() {
            clearInterval(countdownInterval);
        }

        function updateCountdownDisplay() {
            var minutes = Math.floor(countdownTime / 60);
            var seconds = countdownTime % 60;
            var countdownDisplay = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
            $('#countdown-timer').text(countdownDisplay);
        }

        function enableLoginButton() {
            $('#login-button').prop('disabled', false);
        }

        // Start the countdown if there is a wait time
        @if(isset($waitTime) && $waitTime > 0)
            startCountdown();
           $('#login-button').prop('disabled', true);
        @endif

        $('.password-toggle').click(function () {
            var inputField = $(this).prev('input');
            var fieldType = inputField.attr('type');

            if (fieldType === 'password') {
                inputField.attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                inputField.attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
  </script>
@endpush