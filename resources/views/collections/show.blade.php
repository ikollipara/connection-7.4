<x-layout title="conneCTION - {{ $collection->title }}">
  <x-hero class="is-primary">
    <h1 class="title">{{ $collection->title }}</h1>
    <div style="display: flex; gap: 1rem; align-items:center">
      <span class="image is-64x64">
        <img style="width: 50px; height: 50px; object-fit:cover;" class="is-rounded"
          src="{{ $collection->user->avatar_url() }}" alt="">
      </span>
      <p class="is-italic content">
        @if ($collection->user)
          {{ $collection->user->full_name() }} - {{ $collection->user->subject }} Teacher at
          {{ $collection->user->school }}
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
            <span>{{ $collection->views }}</span>
          </p>
        </div>
        <div class="level-item">
          @livewire('likes', ['likable' => $collection])
        </div>
      </div>
      <div class="level-right">
        <a href="{{ URL::route('collections.comments.index', ['post_collection' => $collection]) }}"
          class="level-item button is-primary">
          See Comments
        </a>
      </div>
    </div>
  </x-hero>
  <main x-data="{ tab: 0 }" class="container is-fluid content mt-5">
    <section class="tabs is-centered">
      <ul>
        <li x-bind:class="{ 'is-active': tab == 0 }"><a x-on:click="tab = 0">Description</a></li>
        <li x-bind:class="{ 'is-active': tab == 1 }"><a x-on:click="tab = 1">Entries</a></li>
      </ul>
    </section>
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
            @if (count($collection->metadata['standards']) > 0)
              <tr>
                <td>Standards</td>
                <td class="level">
                  <div class="level-left">
                    @foreach ($collection->metadata['standards'] as $standard)
                      <span class="tag">{{ $standard }}</span>
                    @endforeach
                  </div>
                </td>
              </tr>
            @endif
            @if (count($collection->metadata['practices']) > 0)
              <tr>
                <td>Practices</td>
                <td class="level">
                  <div class="level-left">
                    @foreach ($collection->metadata['practices'] as $practice)
                      <span class="tag">{{ $practice }}</span>
                    @endforeach
                  </div>
                </td>
              </tr>
            @endif
            @if (count($collection->metadata['grades']) > 0)
              <tr>
                <td>Grades</td>
                <td class="level">
                  <div class="level-left">
                    @foreach ($collection->metadata['grades'] as $grade)
                      <span class="tag">{{ $grade }}</span>
                    @endforeach
                  </div>
                </td>
              </tr>
            @endif
            <tr>
              <td>Category</td>
              <td><span class="tag">{{ Str::of($collection->metadata['category'])->title() }}</span>
              </td>
            </tr>
            <tr>
              <td>Audience</td>
              <td><span class="tag">{{ $collection->metadata['audience'] }}</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </details>
    <section x-bind:class="{ 'is-hidden': tab == 1 }">
      <span x-data="{ text: '{{ json_encode($collection->body) }}' }">
        <x-editor x-model='text' name="editor" read-only />
      </span>
    </section>
    <section class="is-hidden" x-bind:class="{ 'is-hidden': tab == 0 }">
      <table class="table is-fullwidth">
        <thead>
          <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Link</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($collection->posts as $post)
            <tr>
              <td>{{ $post->title }}</td>
              <td>
                @if ($post->user)
                  {{ $post->user->full_name() }}
                @else
                  [Deleted]
                @endif
              </td>
              <td><a href="{{ URL::route('posts.show', ['post' => $post]) }}">Visit</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </main>
</x-layout>
