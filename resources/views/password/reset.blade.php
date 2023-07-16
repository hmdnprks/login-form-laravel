@extends('layouts.app')

@section('content')
  <div class="reset-container">
    <h2>Reset Password</h2>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.reset') }}" class="reset-form">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}">
            @error('username')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
          <label for="password">New Password</label>
          <div class="password-field">
            <input type="password" name="password" id="password" required>
            <i class="password-toggle fas fa-eye" aria-hidden="true"></i>
          </div>
          @error('password')
              <span class="error">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirm New Password</label>
          <div class="password-field">
            <input type="password" name="password_confirmation" id="password_confirmation" required>
            <i class="password-toggle fas fa-eye" aria-hidden="true"></i>
          </div>
          @error('password_confirmation')
              <span class="error">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn-reset">Reset Password</button>
        </div>
    </form>
    <div class="form-links">
        <a href="{{ route('register') }}">Register</a>
        <a href="{{ route('login') }}">Login</a>
    </div>
  </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
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