<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $user = User::create([
             'name' => 'Mohana',
             'email' => 'admin@gmail.com',
             'password' => Hash::make('123123123'),
             'phone' => '0592523230',
             'address' => 'Palestine/Gaza',
             'type' => 1,
         ]);
         $this->call(PermissionTableSeeder::class);

         $user->assignRole('Super Admin');

    }
}
