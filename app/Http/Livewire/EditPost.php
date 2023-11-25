<?php

namespace App\Http\Livewire;

use App\Enums\Audience;
use App\Enums\Category;
use App\Models\Post;
use Livewire\Component;

class EditPost extends Component
{
    public Post $post;

    public array $grades = [];

    public array $standards = [];

    public array $practices = [];

    public string $category = Category::Material;

    public string $audience = Audience::Students;


    public string $title;

    public string $body;

    public bool $is_published = false;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->fill([
            'title' => $post->title,
            'body' => json_encode($post->body),
            'is_published' => $post->published,
            'audience' => $post->metadata['audience'],
            'category' => $post->metadata['category'],
            'grades' => $post->metadata['grades'],
            'standards' => $post->metadata['standards'],
            'practices' => $post->metadata['practices'],
        ]);
    }

    public function rules()
    {
        return [
            'body' => ['json'],
            'audience' => ['string'],
            'category' => ['string'],
            'grades' => ['array'],
            'standards' => ['array'],
            'practices' => ['array'],
        ];
    }

    public function save()
    {
        $this->validate();
        $result = $this->post->update([
            'title' => $this->title,
            'body' => json_decode($this->body, true),
            'published' => $this->is_published,
            'metadata' => [
                'audience' => $this->audience,
                'category' => $this->category,
                'grades' => $this->grades,
                'standards' => $this->standards,
                'practices' => $this->practices,
            ],
        ]);


        if ($result) {
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully Updated!']);
            $this->dispatchBrowserEvent('editor-saved');
        } else {
            $this->dispatchBrowserEvent('error', ['message' => 'Something went wrong!']);
        }

        return back();
    }

    public function render()
    {
        return view('livewire.edit-post');
    }
}
