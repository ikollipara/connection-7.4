<?php

namespace App\Http\Livewire;

use App\Enums\Audience;
use App\Enums\Category;
use App\Models\Post;
use Livewire\Component;

class CreatePost extends Component
{
    public string $title = '';

    public string $body = '{"blocks": []}';

    public bool $is_published = false;

    public array $grades = [];

    public array $standards = [];

    public array $practices = [];

    public string $category = Category::Material;

    public string $audience = Audience::Students;

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

        $post = Post::create([
            'title' => $this->title,
            'body' => json_decode($this->body, true),
            'metadata' => [
                'audience' => $this->audience,
                'category' => $this->category,
                'grades' => $this->grades,
                'standards' => $this->standards,
                'practices' => $this->practices,
            ],
            'published' => $this->is_published,
            'user_id' => request()->user()->id,
        ]);


        return redirect()->route('posts.edit', ['post' => $post]);
    }

    public function render()
    {
        return view('livewire.create-post');
    }
}
