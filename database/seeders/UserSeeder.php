<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan data seeder untuk daata User.
        $user = [
            [
                'nama' => 'Akbar Umar Alfaroq',
                'email' => 'akbarumar88@gmail.com',
                'username' => 'akbarumar88',
                'password' => bcrypt('akbar1234'),
                'role' => 1
            ],
            [
                'nama' => 'Saiful Abroriy',
                'email' => 'saiful@gmail.com',
                'username' => 'saiful',
                'password' => bcrypt('saiful'),
                'role' => 1
            ],
        ];

        foreach ($user as $i => $user) {
            User::create($user);
        }
    }
}
