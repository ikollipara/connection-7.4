<div x-data="{ showModal: false }">
  <button wire:target='submitQuestion' wire:loading.class='is-loading' @@click="showModal = true"
    class="button is-white">
    Submit A Question
  </button>

  <div class="modal" x-bind:class="{ 'is-active': showModal }">
    <div class="modal-background"></div>
    <div class="modal-card">
      <form wire:submit='submitQuestion'>
        <header class="modal-card-head">
          <p class="modal-card-title">Submit a Question</p>
          <button @@click="showModal = false" type="button" class="delete"
            aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <x-forms.input wire:model='question' label="Question" name="question" placeholder="What is a Post?" />

        </section>
        <footer class="modal-card-foot">
          <button wire:target='submitQuestion' wire:loading.class='is-loading' type="submit"
            class="button is-success">Submit</button>
          <button wire:target='submitQuestion' wire:loading.class='is-loading'
            @@click="showModal = false" type="button" class="button">Cancel</button>
        </footer>
      </form>
    </div>
  </div>
</div>
