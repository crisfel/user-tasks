<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Administrator';
        $user->email = 'administrator@gmail.com';
        $user->password = Hash::make('1234');
        $user->save();

        $user = new User();
        $user->name = 'Felipe';
        $user->email = 'felipe@gmail.com';
        $user->password = Hash::make('1234');
        $user->save();

        $user = new User();
        $user->name = 'Cristian';
        $user->email = 'cristian@gmail.com';
        $user->password = Hash::make('1234');
        $user->save();

        $user = new User();
        $user->name = 'Fernando';
        $user->email = 'fernando@gmail.com';
        $user->password = Hash::make('1234');
        $user->save();

        $user = new User();
        $user->name = 'Jose';
        $user->email = 'jose@gmail.com';
        $user->password = Hash::make('1234');
        $user->save();


    }
}
