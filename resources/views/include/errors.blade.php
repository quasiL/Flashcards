@if($errors->any())
  <div class="col-12">
    @foreach($errors->all() as $error)
      <div class="alert">{{ $error }}</div>
    @endforeach
  </div>
@endif
