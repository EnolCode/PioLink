<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $userAdmin =  User::create([
            'name' => 'Enol Igareta',
            'email' => 'enoligareta@gmail.com',
            'password' => bcrypt('12345678')
        ])->assignRole('admin');

        Profile::create([
            'id' => $userAdmin->id,
            'user_id'=>$userAdmin->id
        ]);

       $userDefault = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678')
        ])->assignRole('user');

        Profile::create([
            'id' => $userDefault->id,
            'user_id'=>$userDefault->id
        ]);

    }
}
