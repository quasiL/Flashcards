@extends('layout')
@section('title', 'Flashcards - My sets')
@push('styles')
  <link href="{{ asset('css/sets.css') }}" rel="stylesheet">
@endpush
@section('content')
  <div class="container">
    <main>
      <div class="set-list">
        <div class="title">
          <h1>Your sets</h1>
          <span class="close-icon"><a href="{{ route('sets.create') }}">+</a></span>
        </div>
        @foreach($sets->all() as $set)
          <a class="list-item" href="{{ route('sets.show', $set->number) }}">{{ $set->name }}</a>
        @endforeach
      </div>
    </main>
  </div>
@endsection
