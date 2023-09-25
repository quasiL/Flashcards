@extends('layout')
@section('title', 'Flashcards - Set password')
@push('styles')
  <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush
@section('content')
  <div class="container">
    @include('include.errors')
    <div class="auth-window">
      <p>Create a new password</p>
      <form action="{{ route('reset.password.post') }}" method="POST">
        @csrf
        <input type="text" name="token" hidden value="{{ $token }}">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="confirm_password" placeholder="Confirm password">
        <button type="submit">Save</button>
      </form>
    </div>
  </div>
@endsection
