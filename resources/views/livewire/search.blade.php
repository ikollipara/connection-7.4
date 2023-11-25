<main class="container is-fluid mt-5">
  <form wire:submit.prevent="search">
    <x-forms.input name="search" wire:model.lazy="query" label="Search" />
    <details>
      <summary>Advanced Search</summary>
      <x-forms.standards wire:model.lazy="standards" multiple />
      <x-forms.practices wire:model.lazy="practices" multiple />
      <x-forms.grades wire:model.lazy="grades" multiple />
      <x-forms.categories wire:model.lazy="categories" multiple />
      <x-forms.audiences wire:model.lazy="audiences" multiple />
    </details>
    <div class="buttons">
      <div class="field has-addons mr-5">
        <span class="control is-expanded">
          <div class="select">
            <select wire:model.lazy="type">
              <option value="">Both</option>
              <option value="post">Post</option>
              <option value="collection">Collection</option>
            </select>
          </div>
        </span>
      </div>
      <button wire:loading.class="is-loading" class="button is-primary">Search</button>
    </div>
  </form>
  <section>
    @if (count($this->results) > 0)
      <p class="content is-medium mt-5">Total Results: {{ count($this->results) }}</p>
      <table class="table is-fullwidth">
        <thead>
          <tr>
            <th>Name</th>
            <th>Author</th>
            <th>Rating</th>
            <th>Views</th>
            <th>Type</th>
            <th>Visit</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($this->results as $result)
            <tr wire:key="{{ $loop->index }}">
              <td>{{ $result['title'] }}</td>
              <td>{{ $result['user'] }}</td>
              <td>
                <span class="icon-text">
                  <x-lucide-heart class="icon" width="30" height="30" />
                  <span>{{ $result['likes_count'] }}</span>
                </span>
              </td>
              <td>
                <span class="icon-text">
                  <x-lucide-eye class="icon" width="30" height="30" />
                  <span>{{ $result['views'] }}</span>
                </span>
              </td>
              <td>
                <span class="tag is-link">
                  {{ Str::of($result['type'])->title() }}
                </span>
              </td>
              <td>
                @if ($result['type'] == 'post')
                  <a class="link" href="{{ URL::route('posts.show', ['post' => $result['id']]) }}">Visit</a>
                @else
                  <a class="link"
                    href="{{ URL::route('collections.show', ['post_collection' => $result['id']]) }}">Visit</a>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p class="content is-medium mt-5">No Results</p>
    @endif
  </section>

</main>
