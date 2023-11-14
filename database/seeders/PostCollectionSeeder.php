<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PostCollection::factory(10)->has(\App\Models\Post::factory()->count(10))->create();
    }
}
