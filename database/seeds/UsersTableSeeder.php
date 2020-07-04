<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->delete();

        App\User::create([
        	'name' => 'root',
        	'email' => 'root@example.com',
        	'password' => Hash::make('password'),
        ]);
    }
}
