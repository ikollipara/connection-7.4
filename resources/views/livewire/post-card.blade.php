<article id="post-{{ $this->post->id }}" class="mt-3 mx-5">
  <div class="level">
    <div class="level-start">
      <p class="title is-4">{{ $this->post->title ?? 'Unamed Post' }}</p>
    </div>
    <div class="level-end" style="display: inline-flex; gap: 1rem;">
      <a href="{{ URL::route('posts.edit', ['post' => $this->post]) }}"
        class="level-item button is-primary is-outlined">Edit</a>
      @if ($this->post->trashed())
        <form wire:submit.prevent="restore" method="post">
          @csrf
          <button class="button is-primary">Restore</button>
        </form>
      @else
        <form wire:submit.prevent="archive" method="post">
          @method('delete')
          @csrf
          <button class="button is-primary">Archive</button>
        </form>
      @endif
    </div>
  </div>
  <table class="table is-fullwidth">
    <tbody>
      <tr class="content is-italic">
        <td>Last Updated</td>
        @if ($this->post->updated_at)
          <td>{{ $this->post->updated_at->toFormattedDateString() }}</td>
        @else
          <td></td>
        @endif
      </tr>
      @if ($this->post->published)
        <tr class="content is-italic">
          <td>Views</td>
          <td>{{ $this->post->views }}</td>
        </tr>
        <tr>
          <td></td>
          <td>
            <a href="{{ URL::route('posts.show', ['post' => $this->post]) }}">Visit</a>
          </td>
        </tr>
      @endif
    </tbody>
  </table>
  @push('scripts')
    <script>
      document.addEventListener('livewire:load', function() {
        Livewire.on('postArchived', (postId) => {
          if (postId != "{{ $this->post->id }}") return
          document.querySelector('#post-{{ $this->post->id }}').classList.add(
            'animate__animated',
            'animate__fadeOut')
          window.setTimeout(() => {
            document.querySelector('#post-{{ $this->post->id }}').remove()
          }, 1000)
        })
        Livewire.on('postRestored', (postId) => {
          if (postId != "{{ $this->post->id }}") return
          document.querySelector('#post-{{ $this->post->id }}').classList.add(
            'animate__animated',
            'animate__fadeOut')
          window.setTimeout(() => {
            document.querySelector('#post-{{ $this->post->id }}').remove()
          }, 1000)
        })

      })
    </script>
  @endpush
</article>
