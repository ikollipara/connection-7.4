<div>
  <x-hero class="is-primary">
    <h1 class="title">{{ Str::of($this->status)->title() }} Posts</h1>
    <x-forms.input wire:target='search' wire:loading.class='is-loading' label="" placeholder="Filter..." name="Filter"
      wire:model.debounce.200ms="search" />
    @if ($this->status == 'archived')
      <p class="content">
        Archived posts are similar to unlisted videos, if someone has the link they can access. But the video is
        unsearchable.
      </p>
    @endif
  </x-hero>
  <main wire:init='loadPosts' class="container">
    @if ($this->ready_to_load_posts === false)
      <span style="margin-block: 5em;" class="loader"></span>
    @else
      <table class="table is-fullwidth is-hoverable">
        <thead>
          <tr>
            <th>Title</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Views</th>
            <th>Likes</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($this->posts as $post)
            @livewire('post.row', ['post' => $post], key($post->id))
          @endforeach
        </tbody>
      </table>
      {{ $this->posts->links('pagination') }}
    @endif
</div>
