<tr @@click="window.location.href = '{{ route('users.show', ['user' => $this->user]) }}'"
  style="cursor: pointer;">
  <td>
    {{ $this->user->full_name() }}
  </td>
  <td>
    <span class="icon-text">
      <span class="icon">
        <x-lucide-newspaper class="icon" width="30" height="30" fill="none" />
      </span>
      <span>{{ $this->user->posts()->count() }}</span>
    </span>
  </td>
  <td>
    <span class="icon-text">
      <span class="icon">
        <x-lucide-layers class="icon" width="30" height="30" fill="none" />
      </span>
      <span>{{ $this->user->postCollections()->count() }}</span>
    </span>
  </td>
  <td>
    <a href="{{ route('users.show', ['user' => $this->user]) }}" class="link">See Profile</a>
  </td>
</tr>
