@extends('layout')
@section('title', 'Flashcards - Sign up')
@push('styles')
  <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush
@section('content')
  <div class="container">
    @include('include.errors')
    <div class="auth-window">
      <h1>Sign up</h1>
      <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Your name">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="confirm_password" placeholder="Confirm password">
        <button type="submit">Sign up</button>
      </form>
    </div>
  </div>
@endsection
