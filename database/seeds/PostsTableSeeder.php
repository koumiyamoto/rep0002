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
        $user = App\User::find(11);

        factory(App\Post::class, 20)->create([
            'user_id' => $user->id,
        ]);
    }
}
