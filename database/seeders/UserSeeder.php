<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'type' => USER_TYPES['admin']
        ]);

        User::create([
            'name' => 'Kamran',
            'email' => 'kamranabrar90@gmail.com',
            'password' => bcrypt('12345678'),
            'type' => USER_TYPES['user']
        ]);

        User::create([
            'name' => 'Uzma Amjad',
            'email' => 'uzma11@hotmail.com',
            'password' => bcrypt('12345678'),
            'type' => USER_TYPES['user']
        ]);

        User::create([
            'name' => 'Asad Ali',
            'email' => 'asad24188@gmail.com',
            'password' => bcrypt('12345678'),
            'type' => USER_TYPES['user']
        ]);

        User::create([
            'name' => 'Waqar Saleem',
            'email' => 'waqarsaleem411@gmail.com',
            'password' => bcrypt('12345678'),
            'type' => USER_TYPES['user']
        ]);
        
    }
}
