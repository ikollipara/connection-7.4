@props(['item', 'showUser' => true])
@if ($item instanceof \App\Models\Post)
  <tr>
    <td><span class="tag is-link">Post</span></td>
    @if ($item->title)
      <td>{{ $item->title }}</td>
    @else
      <td>Unnamed Post</td>
    @endif
    @if ($showUser)
      @if ($item->user)
        <td><a href="{{ route('users.show', ['user' => $item->user]) }}" class="link">{{ $item->user->full_name() }}</a>
        </td>
      @else
        <td>[Deleted]</td>
      @endif
    @endif
    <td>
      <span class="icon-text">
        <span class="icon">
          <x-lucide-eye class="icon" width="30" height="30" />
        </span>
        <span>{{ $item->views }}</span>
      </span>
    </td>
    <td>
      <span class="icon-text">
        <span class="icon">
          <x-lucide-heart class="icon" width="30" height="30" />
        </span>
        <span>{{ $item->likes_count }}</span>
      </span>
    </td>
    <td><a href="{{ route('posts.show', ['post' => $item]) }}">Visit</a></td>
  </tr>
@else
  <tr>
    <td><span class="tag is-link">Collection</span></td>
    @if ($item->title)
      <td>{{ $item->title }}</td>
    @else
      <td>Unnamed Collection</td>
    @endif
    @if ($showUser)
      @if ($item->user)
        <td><a href="{{ route('users.show', ['user' => $item->user]) }}"
            class="link">{{ $item->user->full_name() }}</a>
        @else
        <td>[Deleted]</td>
      @endif
    @endif
    <td>
      <span class="icon-text">
        <span class="icon">
          <x-lucide-eye class="icon" width="30" height="30" />
        </span>
        <span>{{ $item->views }}</span>
      </span>
    </td>
    <td>
      <span class="icon-text">
        <span class="icon">
          <x-lucide-heart class="icon" width="30" height="30" />
        </span>
        <span>{{ $item->likes_count }}</span>
      </span>
    </td>
    <td>
      <span class="icon-text">
        <span class="icon">
          <x-lucide-book class="icon" width="30" height="30" />
        </span>
        <span>{{ $item->posts()->count() }}</span>
      </span>
    <td><a href="{{ route('collections.show', ['post_collection' => $item]) }}">Visit</a></td>
  </tr>
@endif
