<div>
  @push('meta')
    <meta name="turbolinks-visit-control" content="reload">
  @endpush
  <x-hero class="is-primary">
    <h1 class="title">Welcome to conneCTION</h1>
  </x-hero>
  <main x-data="{ tab: 0 }" class="container is-fluid mt-5">
    <section class="tabs is-centered">
      <ul>
        <li x-bind:class="{ 'is-active': tab == 0 }"><a @@click="tab = 0">Top Posts</a></li>
        <li x-bind:class="{ 'is-active': tab == 1 }"><a @@click="tab = 1">Top Collections</a></li>
        <li x-bind:class="{ 'is-active': tab == 2 }"><a @@click="tab = 2">Your Follower Feed</a></li>
      </ul>
    </section>
    <section wire:init='loadPosts' x-bind:class="{ 'is-hidden': tab !== 0 }">
      @if ($this->ready_to_load_top_posts === false)
        <span style="margin-block: 5em;" class="loader"></span>
      @else
        <table class="table is-fullwidth">
          <tbody>
            @foreach ($this->topPosts as $post)
              <x-search.row :item="$post" />
            @endforeach
          </tbody>
        </table>
      @endif
    </section>
    <section wire:init='loadCollections' class="is-hidden" x-bind:class="{ 'is-hidden': tab !== 1 }">
      @if ($this->ready_to_load_top_collections === false)
        <span style="margin-block: 5em;" class="loader"></span>
      @else
        <table class="table is-fullwidth">
          <tbody>
            @foreach ($this->topCollections as $collection)
              <x-search.row :item="$collection" />
            @endforeach
          </tbody>
        </table>
      @endif
    </section>
    <section wire:init='loadFollowingsItems' class="is-hidden" x-bind:class="{ 'is-hidden': tab !== 2 }">
      @if ($this->ready_to_load_followings_items === false)
        <span style="margin-block: 5em;" class="loader"></span>
      @else
        <table class="table is-fullwidth">
          <tbody>
            @forelse ($this->followingsItems as $item)
              <x-search.row :item="$item" />
            @empty
              @if (auth()->user()->following()->count() > 0)
                <tr>
                  <td colspan="5">
                    <p class="content is-medium has-text-centered">No posts or collections from your followers yet.</p>
                  </td>
                </tr>
              @else
                <tr>
                  <td colspan="5">
                    <p class="content is-medium has-text-centered">You are not following anyone yet.</p>
                  </td>
                </tr>
              @endif
            @endforelse
          </tbody>
        </table>
      @endif
    </section>
  </main>
</div>
