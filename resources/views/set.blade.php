@extends('layout')
@section('title', "Flashcards - $set->name")
@push('styles')
  <link href="{{ asset('css/sets.css') }}" rel="stylesheet">
@endpush
@section('content')
  <div class="container">
    <main>
      <div>{{ $set->name }}</div>
      <div>
        @foreach($set->flashcards->all() as $flashcard)
          <div>{{ $flashcard->question }}</div>
        @endforeach
      </div>
    </main>
  </div>
@endsection
