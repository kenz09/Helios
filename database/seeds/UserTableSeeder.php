<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // create a test user
        factory(User::class)->create([
            'name' => 'Test User',
            'email' => 'user@example.com'
        ]);
        
        // create 50 random test users
        factory(User::class, 50)->create();
    }
}
