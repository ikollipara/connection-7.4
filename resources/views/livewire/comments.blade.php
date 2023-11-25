<main>
  <form wire:submit.prevent="save" class="media">
    <figure class="media-left">
      <p class="image is-64x64">
        <img src="{{ auth()->user()->avatar_url() }}" alt="">
      </p>
    </figure>
    <article class="media-content">
      <div class="field">
        <p class="control">
          <textarea wire:model.lazy="comment_body" class="textarea is-primary content is-medium" style="min-height: 10rem"
            name="" id="" cols="30" rows="10"></textarea>
        </p>
      </div>
      <div class="field">
        <span class="control">
          <button class="button is-primary" type="submit">Comment</button>
        </span>
      </div>
    </article>
  </form>
  <section>
    @foreach ($this->item->comments as $comment)
      <article class="media">
        <figure class="media-left">
          <p class="image is-64x64">
            <img src="{{ $comment->user->avatar_url() }}" alt="">
          </p>
        </figure>
        <section class="media-content">
          <p class="content is-medium">
            <strong>
              @if ($comment->user)
                {{ $comment->user->full_name() }}
              @else
                [Deleted]
              @endif
            </strong>
            <br>
            {{ $comment->body }}
          </p>
          @livewire('likes', ['likable' => $comment])
        </section>
      </article>
    @endforeach
  </section>
</main>
