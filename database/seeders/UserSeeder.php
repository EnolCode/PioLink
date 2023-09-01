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
            'email' => 'enoligareta@gmail.com',
            'password' => bcrypt('12345678')
        ])->assignRole('admin');

        Profile::create([
            'id' => $userAdmin->id,
            'name' => 'Enol',
            'lastName' => 'Igareta',
            'user_id'=>$userAdmin->id
        ]);

       $userDefault = User::create([
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678')
        ])->assignRole('user');

        Profile::create([
            'id' => $userDefault->id,
            'name' => 'User',
            'lastName' => 'lastName',
            'user_id'=>$userDefault->id
        ]);

    }
}
