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
            'username' => 'mhdite7',
            'password' => '$2y$10$sQFR.qOMExAwP/sPU4Q/4OcWwEmRk5zx2dTc1lRzNYHK.4dBzSHU.', // mero
            'isAdmin' => 1,
        ]);

        User::create([
            'name' => 'Ahmad ',
            'username' => 'ahmad',
            'password' => '$2y$10$qMc3B7kEA1hdGwZ6R3cu9.fDpm4CxJyvaC5hFDOsQMF7cTXy9lt76', // 123
            'isAdmin' => 1,
        ]);
    }
}
