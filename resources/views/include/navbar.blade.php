<nav>
  <div class="logo-section">
    <span>Simple Flashcards</span>
  </div>
  <div class="links-section">
    <a href="{{ route('home') }}">Home</a>
    @auth
      <a href="{{ route('sets.index') }}">My sets</a>
      <a href="#">Create a set</a>
      <a href="{{ route('logout') }}">Logout</a>
    @else
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}">Sign up</a>
    @endauth
  </div>
</nav>
