<nav x-data="{ active: false }" class="navbar is-light" id="nav">
  <div class="navbar-brand">
    @auth
      <x-nav.item route="{{ route('home') }}">
        <x-logo :width="100" :height="55" />
      </x-nav.item>
    @else
      <x-nav.item route="{{ route('index') }}">
        <x-logo :width="100" :height="55" />
      </x-nav.item>
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
        <x-nav.dropdown title="Posts">
          <x-slot name="icon">
            <x-lucide-newspaper class="icon" width="30" height="30" />
          </x-slot>
          <x-nav.item route="{{ route('posts.index', ['status' => 'draft']) }}">Post Drafts</x-nav.item>
          <x-nav.item route="{{ route('posts.index', ['status' => 'published']) }}">Published Posts</x-nav.item>
          <x-nav.item route="{{ route('posts.index', ['status' => 'archived']) }}">Archived Posts</x-nav.item>
          <x-nav.divider />
          <x-nav.item route="{{ route('posts.create') }}">Create Post</x-nav.item>
        </x-nav.dropdown>
        <x-nav.dropdown title="Collections">
          <x-slot name="icon">
            <x-lucide-layers class="icon" width="30" height="30" />
          </x-slot>
          <x-nav.item route="{{ route('collections.index', ['status' => 'draft']) }}">Collection Drafts</x-nav.item>
          <x-nav.item route="{{ route('collections.index', ['status' => 'published']) }}">Published
            Collections</x-nav.item>
          <x-nav.item route="{{ route('collections.index', ['status' => 'archived']) }}">Archived Collections</x-nav.item>
          <x-nav.divider />
          <x-nav.item route="{{ route('collections.create') }}">Create Collection</x-nav.item>
        </x-nav.dropdown>
      @else
        <x-nav.item route="{{ route('index') }}">Home</x-nav.item>
        <x-nav.item route="{{ route('about') }}">About</x-nav.item>
      @endauth
    </ul>
    <ul class="navbar-end">
      @auth
        <x-nav.unsaved-changes />
        <x-nav.item class="icon-text" route="{{ route('faq') }}">
          <span class="icon">
            <x-lucide-help-circle class="icon" width="30" height="30" />
          </span>
          <span>FAQ/Help</span>
        </x-nav.item>
        <x-nav.item class="icon-text" route="{{ route('search') }}">
          <span class="icon">
            <x-lucide-search class="icon" width="30" height="30" />
          </span>
          <span>Search</span>
        </x-nav.item>
        <x-nav.dropdown title="My Profile">
          <x-slot name="icon">
            <x-lucide-user class="icon" width="30" height="30" />
          </x-slot>
          <x-nav.item route="{{ route('users.show', ['user' => auth()->user()]) }}">My Profile</x-nav.item>
          <x-nav.item route="{{ route('users.edit', ['user' => auth()->user()]) }}">Settings</x-nav.item>
        </x-nav.dropdown>
        <x-nav.avatar />
        <li class="navbar-item">
          @livewire('user.logout', ['user' => auth()->user()])
        </li>
      @else
        <x-nav.item is-button class="is-outlined" route="{{ route('registration.create') }}">Sign Up</x-nav.item>
        <x-nav.item is-button route="{{ route('login.create') }}">Login</x-nav.item>
      @endauth
    </ul>
  </div>
</nav>
