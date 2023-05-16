<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->insert([
            [
                'name' => 'momo',
                'email' => 'hayatana1116@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('gesra7-niMmoq-gedneq'), // password
                'remember_token' => Str::random(10),
                'profile' => fake()->word,
            ]
            ]);
            
        
        $users = User::factory()->count(50)->create();
        
        
    }
}
