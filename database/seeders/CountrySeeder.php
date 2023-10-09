<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Support\Facades\DB; 

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = Countries::all();

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'name' => $country->name->common,
            ]);
        }
    }
}