@extends('layout')
@section('title', "Flashcards - $set->name")
@push('styles')
  <link href="{{ asset('css/sets.css') }}" rel="stylesheet">
@endpush
@section('content')
  <div class="container">
    <main class="flashcards">
      <h2>{{ $set->name }}</h2>
      @livewire('flashcards', ['set' => $set])
    </main>
  </div>
@endsection
