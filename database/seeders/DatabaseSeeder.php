<?php

namespace Database\Seeders;

use App\Actions\User\CreateUserAction;
use App\Models\Country;
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
    public function run(CreateUserAction $createUserAction): void
    {
        $this->call([
            CountrySeeder::class,
        ]);

        $createUserAction->execute((object) [
            'email' => 'johndoe@gmail.com',
            'password' => '12345678',
            'nick_name' => 'John',
            'country_id' => 1,
        DB::table('users')->create([
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
