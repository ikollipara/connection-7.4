<form wire:submit.prevent="save" x-data="{ showModal: false }" method="post">
    @csrf
    <input type="hidden" name="status" wire:model="is_published">
    <x-hero class="is-primary">
        <div class="field has-addons">
            <div class="control is-expanded">
                <input placeholder="Post Title..." wire:model="title"
                    x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor-changed')"
                    type="text" class="input">
            </div>
            <div class="control">
                <button class="button is-dark">Save</button>
            </div>
            <div class="control">
                <button type="button" x-on:click="showModal = true; $wire.is_published = true"
                    class="button is-light">Publish</button>
            </div>
        </div>
    </x-hero>
    <main class="container is-fluid mt-5">
        <x-editor name="body" wire:model="body" />
    </main>
    <section class="modal" x-bind:class="{ 'is-active': showModal }">
        <div class="modal-background"></div>
        <article class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Set Post Metadata</p>
                <button @@click="showModal = false" type="button" class="delete"></button>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <div class="control">
                        <x-forms.grades multiple wire:model="metadata.grades" />
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <x-forms.standards multiple wire:model="metadata.standards" />
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <x-forms.practices multiple wire:model="metadata.practices" />
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <x-forms.categories wire:model="metadata.category" />
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <x-forms.audiences wire:model="metadata.audience" />
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button type="button" x-on:click="showModal = false; $wire.is_published = false"
                    class="button is-primary is-outlined">
                    Cancel
                </button>
                <button x-on:click="showModal = false" class="button is-primary">Publish</button>
            </footer>
        </article>
    </section>
</form>
