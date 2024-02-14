<tr x-data x-on:entry-removed.document="if ($event.detail.id === '{{ $this->post->id }}') { $el.remove() }">
  <td>{{ $this->post->title ?? 'Unnamed Post' }}</td>
  @if ($this->post->user)
    <td>{{ $this->post->user->full_name() }}</td>
  @else
    <td>[Deleted]</td>
  @endif
  <td><a href="{{ route('posts.show', ['post' => $this->post]) }}">Visit</a></td>
  <td>
    <button type="button" wire:click='remove' class='delete'></button>
  </td>
</tr>
