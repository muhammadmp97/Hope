<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    protected string $pathInResource = 'data/countries.json';

    public function run(): void
    {
        if (DB::table('countries')->count() > 0) {
            return;
        }

        $countries = json_decode(
            file_get_contents(storage_path($this->pathInResource))
        );

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'id' => $country->id,
                'code' => $country->iso2,
                'name' => $country->name,
            ]);
        }
    }
}
