<x-layout title="ConneCTION">
  <x-hero class="is-success">
    <div class="has-flex has-flex-direction-col ml-5 has-text-left">
      <p class="title">
        <x-logo width="300" height="125" />
      </p>
      <p class="subtitle">
        Connecting Teachers across the country around Computer Science Education
      </p>
      <div class="buttons">
        <a href="{{ route('about') }}" class="button is-primary">Learn More</a>
        <a href="{{ route('registration.create') }}" class="button is-primary is-outlined">Sign Up</a>
      </div>
    </div>
  </x-hero>
  <main class="column is-fullwidth mx-5">
    <section class="columns mt-5 mx-5">
      <span class="column is-two-thirds">
        <h2 class="title is-1 has-text-right">
          Learn about CS, together<span class="has-text-primary">.</span>
        </h2>
        <p style="font-size: 1.5rem;" class="content">
          Connect with teachers all over about Computer Science. Learn from their experiences, share your own.
          This is a community to help <em>You</em> grow!
        </p>
      </span>
      <div class="column is-one-third"
        style="filter: drop-shadow(0 4px 3px rgb(0 0 0 / 0.07)) drop-shadow(0 2px 2px rgb(0 0 0 / 0.06));">
        <img src="{{ mix('images/people.avif') }}" alt="" class="image" lazy="loading"
          style="border-radius: 10% 0 10% 0; border: #003049 0.5rem solid;">
      </div>
    </section>
    <section class="column is-fullwidth mx-5">
      <span class="column is-four-fifths mx-auto">
        <h2 class="title is-1 has-text-centered">
          Connect and Create<span class="has-text-primary">.</span>
        </h2>
        <p class="content is-large">
          conneCTION is designed to let you create and connect in many different ways.
        </p>
        <section class="columns">
          <div class="column is-one-third has-text-centered">
            <x-lucide-newspaper width="50" height="50" />
            <p class="title">Posts</p>
            <p class="content is-medium">
              Showcase your knowledge and ideas through a rich post system. Other teachers can comment,
              like, or even favorite your post.
            </p>
          </div>
          <div class="column is-one-third has-text-centered">
            <x-lucide-message-square width="50" height="50" />
            <p class="title">Comments</p>
            <p class="content is-medium">
              Discuss with a community of interested individuals around posts and collections.
            </p>
          </div>
          <div class="column is-one-third has-text-centered">
            <x-lucide-layers width="50" height="50" />
            <p class="title">Collections</p>
            <p class="content is-medium">
              Collect posts together into something shareable. Whether its for lesson planning or just to
              share, collections allow it all.
            </p>
          </div>
        </section>
      </span>
    </section>
  </main>
</x-layout>
