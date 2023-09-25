@extends('layout')
@section('title', 'Flashcards - Password Reset')
@push('styles')
  <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush
@section('content')
  <div class="container">
    @include('include.errors')
    <div class="auth-window">
      <p>We will send a link to reset your password</p>
      <form action="{{ route('forgot.password.post') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email">
        <button type="submit">Send</button>
      </form>
    </div>
  </div>
@endsection
