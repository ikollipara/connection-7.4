<x-layout title="ConneCTION - Frequently Asked Questions">
  <x-hero class="is-primary">
    <h1 class="title">Frequently Asked Questions</h1>
    @livewire('submit-f-a-q-question')
  </x-hero>
  <main class="container is-fluid mt-2 content">
    <article>
      <h2 class="subtitle">How do I use ConneCTION?</h2>
      <p>
        ConneCTION is a platform for teachers to share, comment, and collect materials to aid in teaching Computer
        Science.
        ConneCTION is focused on building an online learning community around Computer Science education. So to use
        ConneCTION,
        you only need to <a class="link" href="{{ route('search') }}">search</a> for the materials you need, and if you
        have any
        materials to share, you can create a <a href="{{ route('posts.create') }}" class="link">post</a> or a <a
          href="{{ route('collections.create') }}" class="link">collection</a>.
      </p>
    </article>
    <hr>
    <article>
      <h2 class="subtitle">What is a Post?</h2>
      <p>
        In ConneCTION, a post is a piece of content that a user shares with the community. A post can be a link to an
        article, a video, a file, or a text.
        A post can be commented on and liked by other users. A post can also be added to a collection. Posts are a way
        to showcase what you have learned over
        the course of your teaching career and to share that knowledge with others.
      </p>
    </article>
    <hr>
    <article>
      <h2 class="subtitle">What is a Collection?</h2>
      <p>
        A Collection is a group of posts that a user has curated. A collection can be shared with the community and can
        be added to by other users. A collection
        is a way to organize and share the materials you have found useful in your teaching career. A collection can be
        a list of resources for a specific topic,
        a list of resources for a specific course, or a list of resources for a specific grade level. For example, one
        collection could be a list of resources for
        teaching Python to high school students.
      </p>
    </article>
    <hr>
    <article>
      <h2 class="subtitle">What does "Draft", "Published", and "Archived" mean?</h2>
      <p>
        In ConneCTION a post or collection can be in one of three states: draft, published, or archived. A draft is an
        unplublished post or collection that is still being worked on. A published post or collection is a post or
        collection that is visible to the community. An archived post or collection is a post or collection that is no
        longer visible to the community, but if a member does have the link to the post or collection, they can still
        view it.
        <br>
        Noticably, an archived post or collection is not a deleted post or collection. In an effort to not remove
        resources
        from teachers, posts are never deleted, but rather archived. This way, if a post or collection is no longer
        something
        you want to share with the community, you can archive it, but if you ever want to share it again, you can
        unarchive it.
        But also teachers who have found your post or collection helpful can still access it.
      </p>
    </article>
  </main>
</x-layout>
