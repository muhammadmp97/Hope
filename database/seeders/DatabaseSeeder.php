<?php

namespace Database\Seeders;

use App\Actions\User\CreateUserAction;
use App\Models\Country;
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
        ]);
    }
}
