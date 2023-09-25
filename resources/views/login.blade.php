@extends('layout')
@section('title', 'Flashcards - Login')
@push('styles')
  <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush
@section('content')
  <div class="container">
    @include('include.errors')
    <div class="auth-window">
      <h1>Login</h1>
      <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <a href="{{ route('forgot.password') }}">Forgot password?</a>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
@endsection
