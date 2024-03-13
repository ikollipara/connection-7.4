@props(['step', 'currentStep', 'isFinal' => false])

<section {{ $attributes->except(['step', 'isFinal', 'currentStep']) }}
  x-show="{{ $currentStep }} == {{ $step }}">
  {{ $slot }}
  <div class="field is-group is-grouped-centered">
    <div class="control">
      @if ($step > 0)
        <button type="button" x-on:click="{{ $currentStep }}--" class="button is-primary is-outlined">
          Back
        </button>
      @endif
      @if ($isFinal)
        <button type="submit" class="button is-primary">
          Submit
        </button>
      @else
        <button type="button" x-on:click="{{ $currentStep }}++" class="button is-primary">
          Next
        </button>
      @endif
    </div>
  </div>
</section>
