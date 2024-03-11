<?php

namespace App\Traits\Livewire;

trait HasDispatch
{
    public function dispatchBrowserEventIf(
        bool $condition,
        string $event,
        array $data = []
    ): void {
        if ($condition) {
            $this->dispatchBrowserEvent($event, $data);
        }
    }
}
