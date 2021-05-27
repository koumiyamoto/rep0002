<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::find(2);

        factory(App\Post::class, 5)->create([
            'user_id' => $user->id,
        ]);
    }
}
