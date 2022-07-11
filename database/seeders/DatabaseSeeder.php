<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Role::truncate();
        Category::truncate();
        Post::truncate();
        Tag::truncate();
        Comment::truncate();
        Image::truncate();

        Schema::enableForeignKeyConstraints();
         \App\Models\Role::factory(1)->create();

         $users = \App\Models\User::factory(10)->create();

         foreach ($users as $user) {
             $user->image()->save(\App\Models\Image::factory()->make());
         }

         \App\Models\Category::factory(10)->create();

        $posts =  \App\Models\Post::factory(10)->create();

         \App\Models\Tag::factory(10)->create();
         \App\Models\Comment::factory(100)->create();

         foreach ($posts as $post) {
             $tags_ids = [];
             $tags_ids[] = \App\Models\Tag::all()->random()->id;
             $tags_ids[] = \App\Models\Tag::all()->random()->id;
             $tags_ids[] = \App\Models\Tag::all()->random()->id;
             $post->tags()->sync($tags_ids);

             $post->image()->save(\App\Models\Image::factory()->make());

         }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
