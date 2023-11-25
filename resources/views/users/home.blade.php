<x-layout title="ConneCTION - Home">
  <x-hero class="is-primary">
    <h1 class="title">Welcome to ConneCTION</h1>
  </x-hero>
  <main class="mt-5">
    <section class="container is-fluid">
      <article class="mb-5" id="viewed-posts">
        <h2 class="subtitle is-3">Most Viewed Posts</h2>
        <table class="table is-fullwidth">
          <thead>
            <tr>
              <th>Name</th>
              <th>Author</th>
              <th>Rating</th>
              <th>Views</th>
              <th>Visit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($most_viewed_posts as $post)
              <tr>
                <td>{{ $post->title }}</td>
                @if ($post->user)
                  <td>{{ $post->user->full_name() }}</td>
                @else
                  <td>[Deleted]</td>
                @endif
                <td>
                  <span class="icon-text">
                    <x-lucide-heart class="icon" width="30" height="30" />
                    <span>{{ $post->likes_count }}</span>
                  </span>
                </td>
                <td>
                  <span class="icon-text">
                    <x-lucide-eye class="icon" width="30" height="30" />
                    <span>{{ $post->views }}</span>
                  </span>
                </td>
                <td><a href="{{ URL::route('posts.show', ['post' => $post]) }}">Visit</a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </article>
      <hr>
      <article class="mb-5" id="viewed-collections">
        <h2 class="subtitle is-3">Most Viewed Collections</h2>
        <table class="table is-fullwidth">
          <thead>
            <tr>
              <th>Name</th>
              <th>Author</th>
              <th>Rating</th>
              <th>Views</th>
              <th>Visit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($most_viewed_post_collections as $collection)
              <tr>
                <td>{{ $collection->title }}</td>
                @if ($collection->user)
                  <td>{{ $collection->user->full_name() }}</td>
                @else
                  <td>[Deleted]</td>
                @endif
                <td>
                  <span class="icon-text">
                    <x-lucide-heart class="icon" width="30" height="30" />
                    <span>{{ $collection->likes_count }}</span>
                  </span>
                </td>
                <td>
                  <span class="icon-text">
                    <x-lucide-eye class="icon" width="30" height="30" />
                    <span>{{ $collection->views }}</span>
                  </span>
                </td>
                <td><a href="{{ URL::route('collections.show', ['post_collection' => $collection]) }}">Visit</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </article>
    </section>
  </main>
</x-layout>
