@extends('layout')
@section('title', 'Flashcards - Home')
@push('styles')
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endpush
@section('content')
  <div class="container">
    @auth
      <h1>My recent sets</h1>
    @endauth
    <h1>Home page</h1>
  </div>
@endsection
