<x-layout title="conneCTION - {{ Str::of($status)->title() }} Posts">
    <x-hero class="is-primary">
        <h1 class="title is-3">My {{ Str::of($status)->title() }} Posts</h1>
        @if ($status == 'archived')
            <p class="content">
                Archived posts are similar to unlisted videos, if someone has the link they can access. But the video is
                unsearchable.
            </p>
        @endif
    </x-hero>
    <main class="container">
        @foreach ($posts as $post)
            <span wire:key="{{ $post->id }}">
                @livewire('post-card', ['post' => $post])
            </span>
        @endforeach
    </main>
</x-layout>
