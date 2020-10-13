<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Mohamad Murad',
            'username' => 'mhd',
            'password' => Hash::make('12345678'),
            'isAdmin' => 1,
        ]);

        User::create([
            'name' => 'Ahmad ',
            'username' => 'ahmad',
            'password' => Hash::make('12345678'),
            'isAdmin' => 1,
        ]);
    }
}
