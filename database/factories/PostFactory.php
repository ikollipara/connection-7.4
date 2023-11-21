<?php

namespace Database\Factories;

use App\Enums\Audience;
use App\Enums\Category;
use App\Enums\Grade;
use App\Enums\Practice;
use App\Enums\Standard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'body' => ['blocks' => []],
            'metadata' => ['category' => $this->faker->randomElement(Category::cases()), 'audience' => $this->faker->randomElement(Audience::cases()), 'grades' => $this->faker->randomElements(Grade::cases()), 'standards' => $this->faker->randomElements(Standard::cases()), 'practices' => $this->faker->randomElements(Practice::cases())],
            'published' => $this->faker->boolean(),
            'user_id' => User::factory(),
        ];
    }
}
