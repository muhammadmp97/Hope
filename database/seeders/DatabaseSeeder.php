<?php

namespace Database\Seeders;

use App\Enums\AddictionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
        ]);

        DB::table('users')->insert([
            'email' => 'admin@hope.com',
            'password' => Hash::make('12345678'),
            'nick_name' => 'Administrator 🧑‍💻',
            'country_id' => 1,
            'addiction_type' => AddictionType::Unknown,
        ]);

        DB::table('users')->insert([
            'email' => 'bot@hope.com',
            'password' => Hash::make('12345678'),
            'nick_name' => 'Bot 🤖',
            'bio' => 'I am a bot.',
            'country_id' => 1,
            'addiction_type' => AddictionType::Unknown,
            'score' => 999999,
        ]);
    }
}
