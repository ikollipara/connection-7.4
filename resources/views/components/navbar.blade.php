<nav x-data="{ active: false }" class="navbar is-light" id="nav">
  <div class="navbar-brand">
    @auth
      <a href="{{ URL::route('home') }}" class="navbar-item">
        <x-logo :width="100" :height="55" />
      </a>
    @else
      <a href="{{ URL::route('index') }}" class="navbar-item">
        <x-logo :width="100" :height="55" />
      </a>
    @endauth
    <a x-on:click="active = !active" x-bind:class="{ 'is-active': active }" id="hamburger" class="navbar-burger"
      aria-label="menu" aria-expanded="false" role="button" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>
  <div x-bind:class="{ 'is-active': active }" id="nav-menu" class="navbar-menu animate__animated">
    <ul class="navbar-start">
      @auth
        <div class="navbar-item has-dropdown is-hoverable">
          <p class="navbar-link mt-2 mb-2">Posts</p>
          <div class="navbar-dropdown">
            <a href="{{ URL::route('posts.index', ['status' => 'draft']) }}" class="navbar-item">Post Drafts</a>
            <a href="{{ URL::route('posts.index', ['status' => 'published']) }}" class="navbar-item">Published Posts</a>
            <a href="{{ URL::route('posts.index', ['status' => 'archived']) }}" class="navbar-item">Archived Posts</a>
            <span class="navbar-divider"></span>
            <a href="{{ URL::route('posts.create') }}" class="navbar-item">Create Post</a>
          </div>
        </div>
        <div class="navbar-item has-dropdown is-hoverable">
          <p class="navbar-link mt-2 mb-2">Collections</p>
          <div class="navbar-dropdown">
            <a href="{{ URL::route('collections.index', ['status' => 'draft']) }}" class="navbar-item">Collection
              Drafts</a>
            <a href="{{ URL::route('collections.index', ['status' => 'published']) }}" class="navbar-item">Published
              Collections</a>
            <a href="{{ URL::route('collections.index', ['status' => 'archived']) }}" class="navbar-item">Archived
              Collections</a>
            <span class="navbar-divider"></span>
            <a href="{{ URL::route('collections.create') }}" class="navbar-item">
              Create Collection
            </a>
          </div>
        </div>
      @else
        <a href="{{ URL::route('index') }}" class="navbar-item mt-2 mb-2">Home</a>
        <a href="{{ URL::route('about') }}" class="navbar-item mt-2 mb-2">About</a>
      @endauth
    </ul>
    <ul class="navbar-end">
      @auth
        <div class="navbar-item">
          <div x-data="{ text: '', show: false, saved: false }"
            x-on:editor-changed.window="console.log($data.text); text = 'Unsaved Changes'; show = true; saved = false"
            x-on:editor-saved.window="text = 'Changes Saved'; show = true; saved = true; setTimeout(() => { show = false }, 300)"
            x-bind:class="{ 'is-hidden': !show, 'is-danger': !saved, 'is-success': saved }" x-text="text"
            class="notification pt-1 pb-1"></div>
        </div>
        <a href="{{ route('faq') }}" class="navbar-item mt-2 mb-2">FAQ/Help</a>
        <a href="{{ URL::route('search') }}" class="navbar-item mt-2 mb-2">Search</a>
        <a href="{{ URL::route('users.edit', ['user' => auth()->user()]) }}" class="navbar-item mt-2 mb-2">Settings</a>
        <li class="navbar-item">
          <img src="{{ auth()->user()->avatar_url() }}" alt="">
          <script>
            document.addEventListener('livewire:load', function() {
              Livewire.on('avatarUpdated', (avatar_url) => {
                document.querySelector('#nav img').src = avatar_url;
              })
            })
          </script>
        </li>
        <li class="navbar-item">
          <form action="{{ URL::route('logout') }}" method="post">
            @method('delete')
            @csrf
            <button class="button is-primary is-outlined">Logout</button>
          </form>
        </li>
      @else
        <li class="navbar-item">
          <a href="{{ URL::route('registration.create') }}" class="button is-primary is-outlined">
            Sign Up
          </a>
        </li>
        <li class="navbar-item">
          <a href="{{ URL::route('login.create') }}" class="button is-primary">
            Login
          </a>
        </li>
      @endauth
    </ul>
  </div>
</nav>
