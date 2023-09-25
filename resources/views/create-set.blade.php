@extends('layout')
@section('title', "Flashcards - Create a new set")
@push('styles')
  <link href="{{ asset('css/sets.css') }}" rel="stylesheet">
@endpush
@section('content')
  <div class="container">
    <main>
      <div class="set-list">
        <div class="title">
          <h1>Create a new set</h1>
        </div>
        <form action="{{ route('sets.store') }}" method="post">
          @csrf
          <input type="text" name="set-name" placeholder="Set name">
          <button type="submit">Create</button>
        </form>
      </div>
    </main>
  </div>
@endsection
