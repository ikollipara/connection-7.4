<div>
  <x-hero class="is-primary">
    <div class="is-flex" style="gap: 1rem;">
      <figure class="image is-128x128 mt-auto mb-auto">
        <img src="{{ $this->user->avatar() }}" alt="">
      </figure>
      <div class="is-flex is-flex-direction-column">
        <h1 class="title is-1">{{ $this->user->full_name() }}</h1>
        <div class="is-flex is-justify-content-start is-align-items-center" style="gap: 1em;">
          <a href="{{ route('users.followers.index', ['user' => $this->user]) }}"
            class="is-link">{{ $this->user->followers_count }}
            Followers</a>
          <a href="{{ route('users.followings.index', ['user' => $this->user]) }}"
            class="is-link">{{ $this->user->following_count }} Following</a>
        </div>
        <p class="is-italic content">
          {{ $this->user->subject }} Teacher at
          {{ $this->user->school }}
        </p>
      </div>
    </div>
    <x-forms.input name="search" placeholder="Search..." label="" wire:model.debounce.300ms="search" />
  </x-hero>
  <main class="container is-fluid mt-3">
    <table class="table is-fullwidth">
      <thead></thead>
      <tbody>
        @foreach ($this->followings as $follower)
          @livewire('user.row', ['user' => $follower], key($follower->id))
        @endforeach
      </tbody>
    </table>
    {{ $this->followings->links('pagination') }}
  </main>
</div>
