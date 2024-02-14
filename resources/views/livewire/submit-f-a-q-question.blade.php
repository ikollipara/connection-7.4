<div x-data="{ showModal: false }">
  <button wire:target='submitQuestion' wire:loading.class='is-loading' @@click="showModal = true"
    class="button is-white">
    Submit A Question
  </button>

  <x-modal show-var="showModal" title="Submit a Question">
    <x-forms.input wire:model='question' label="Question" name="question" placeholder="What is a Post?" />
    <x-slot name="footer">
      <button @@question-submitted.document='showModal = false' wire:click='submitQuestion'
        wire:target='submitQuestion' wire:loading.class='is-loading' type="submit" class="button is-success">
        Submit
      </button>
      <button @@click="showModal = false" type="button" class="button">
        Cancel
      </button>
    </x-slot>
  </x-modal>
</div>
