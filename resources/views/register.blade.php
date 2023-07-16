<!-- register.blade.php -->
@extends('layouts.app')

@section('content')
  <div class="register-container">
    <form method="POST" action="{{ route('register') }}" class="register-form">
        @csrf

        <h2>Register</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
          <label for="password_confirmation">Password Confirmation</label>
          <div class="password-field">
            <input type="password" name="password_confirmation" id="password_confirmation" required>
            <i class="password-toggle fas fa-eye" aria-hidden="true"></i>
          </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn-register">Register</button>
        </div>

        <div class="form-links">
            <a href="{{ route('login') }}">Login</a>
        </div>
    </form>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush


@push('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
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