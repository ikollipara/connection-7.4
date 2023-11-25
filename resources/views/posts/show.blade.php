<x-layout title="conneCTION - {{ $post->title }}">
  <span x-data="{ showModal: false }">
    <x-hero class="is-primary">
      <h1 class="title">{{ $post->title }}</h1>
      <div style="display: flex; gap: 1rem; align-items:center">
        <span class="image is-64x64">
          <img style="width: 50px; height: 50px; object-fit:cover;" class="is-rounded"
            src="{{ $post->user->avatar_url() }}" alt="">
        </span>
        <p class="is-italic content">
          @if ($post->user)
            {{ $post->user->full_name() }} - {{ $post->user->subject }} Teacher at
            {{ $post->user->school }}
          @else
            [Deleted]
          @endif
        </p>
      </div>
      <div class="level" style="padding-block: 0.25rem; border-top: white 1px solid; border-bottom: white 1px solid;">
        <div class="level-left">
          <div class="level-item">
            <p class="icon-text">
              <x-lucide-eye class="icon" width="30" height="30" />
              <span>{{ $post->views }}</span>
            </p>
          </div>
          <div class="level-item">
            @livewire('likes', ['likable' => $post])
          </div>
        </div>
        <div class="level-right">
          <div class="level-item">
            <button @@click='showModal = true' type="button" class="button is-primary mx-3"
              title="Add Post to Collection">
              <x-lucide-bookmark class="icon" width="30" height="30" />
            </button>
          </div>
          <a href="{{ URL::route('posts.comments.index', ['post' => $post]) }}" class="level-item button is-primary">
            See Comments
          </a>
        </div>
      </div>
    </x-hero>
    <main class="container is-fluid content mt-5">
      <details>
        <summary>Metadata</summary>
        <div class="table-container">
          <table class="table">
            <thead>
              <tr>
                <th>Metadata</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @if (count($post->metadata['standards']) > 0)
                <tr>
                  <td>Standards</td>
                  <td class="level">
                    <div class="level-left">
                      @foreach ($post->metadata['standards'] as $standard)
                        <span class="tag">{{ $standard }}</span>
                      @endforeach
                    </div>
                  </td>
                </tr>
              @endif
              @if (count($post->metadata['practices']) > 0)
                <tr>
                  <td>Practices</td>
                  <td class="level">
                    <div class="level-left">
                      @foreach ($post->metadata['practices'] as $practice)
                        <span class="tag">{{ $practice }}</span>
                      @endforeach
                    </div>
                  </td>
                </tr>
              @endif
              @if (count($post->metadata['grades']) > 0)
                <tr>
                  <td>Grades</td>
                  <td class="level">
                    <div class="level-left">
                      @foreach ($post->metadata['grades'] as $grade)
                        <span class="tag">{{ $grade }}</span>
                      @endforeach
                    </div>
                  </td>
                </tr>
              @endif
              <tr>
                <td>Category</td>
                <td><span class="tag">{{ Str::of($post->metadata['category'])->title() }}</span>
                </td>
              </tr>
              <tr>
                <td>Audience</td>
                <td><span class="tag">{{ $post->metadata['audience'] }}</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </details>
      <x-editor model="{{ Js::from($post->body) }}" name="editor" read-only />
      <section class='modal' x-bind:class="{ 'is-active': showModal }">
        <div class='modal-background'></div>
        <article class='modal-card'>
          <header class='modal-card-head'>
            <p class='modal-card-title' style="margin-block: auto">Add to Collection</p>
            <button @@click='showModal = false' type='button' class='delete'
              aria-label="close"></button>
          </header>
          <section class='modal-card-body'>
            <table class="table is-fullwidth">
              <thead>
                <tr>
                  <th>Action</th>
                  <th>Collection</th>
                </tr>
              </thead>
              <tbody>
                @foreach (auth()->user()->postCollections as $collection)
                  @livewire('add-collection-row', ['collection' => $collection, 'post' => $post], key($collection->id))
                @endforeach
              </tbody>
            </table>
          </section>
        </article>
      </section>
    </main>

  </span>
</x-layout>
