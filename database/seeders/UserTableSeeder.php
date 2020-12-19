<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create( [
            'name'     => 'Al-Mamun Sarkar',
            'email'    => 'admin@example.com',
            'password' => Hash::make( 'password' ),
        ] );
    }
}
