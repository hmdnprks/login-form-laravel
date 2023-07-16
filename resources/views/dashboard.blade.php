<!-- dashboard.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="dashboard-container">
        <h2>Welcome, {{ Auth::user()->username }}!</h2>
        <p>This is your dashboard.</p>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
@endsection

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush
