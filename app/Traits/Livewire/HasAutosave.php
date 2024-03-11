<?php

namespace App\Traits\Livewire;

trait HasAutosave
{
    /**
     * @param string $field
     * @param mixed $value
     */
    public function updated(string $field, $value): void
    {
        if ($field === "body") {
            if ($decoded = json_decode($value, true)) {
                if (property_exists($this, "post")) {
                    $this->post->body = $decoded;
                    $this->post->exists and
                        $this->post->save() and
                        $this->dispatchBrowserEvent("editor-saved");
                } elseif (property_exists($this, "post_collection")) {
                    $this->post_collection->body = $decoded;
                    $this->post_collection->exists and
                        $this->post_collection->save() and
                        $this->dispatchBrowserEvent("editor-saved");
                }
            }
        } elseif ($field === "postTitle") {
            if (!property_exists($this, "post")) {
                return;
            }
            $this->post->exists and
                $this->post->save() and
                $this->dispatchBrowserEvent("editor-saved");
        } elseif ($field === "post_collection.title") {
            if (!property_exists($this, "post_collection")) {
                return;
            }
            $this->post_collection->exists and
                $this->post_collection->save() and
                $this->dispatchBrowserEvent("editor-saved");
        }
    }
}
