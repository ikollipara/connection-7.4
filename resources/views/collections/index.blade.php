<x-layout title="conneCTION - {{ Str::of($status)->title() }} Collections">
  <x-hero class="is-primary">
    <h1 class="title is-3">My {{ Str::of($status)->title() }} Collections</h1>
    @if ($status == 'archived')
      <p class="content">
        Archived collections are similar to unlisted playlists, if someone has the link they can access. But the
        video is unsearchable.
      </p>
    @endif
  </x-hero>
  <main class="container">
    @foreach ($collections as $collection)
      @livewire('post-collection-card', ['collection' => $collection], key($collection->id))
    @endforeach
  </main>
</x-layout>
