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
          <div class="set">
            <a class="list-item" href="{{ route('sets.show', $set->number) }}">{{ $set->name }}</a>
            <div class="dropdown">
              <span>=</span>
              <div class="dropdown-content">
                <a href="#" class="dropdown-item">Rename set</a>
                <a href="{{ route('sets.destroy', $set->number) }}" class="dropdown-item">Delete set</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </main>
  </div>
@endsection
