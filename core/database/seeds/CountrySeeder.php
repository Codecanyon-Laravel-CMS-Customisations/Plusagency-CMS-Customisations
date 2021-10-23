<?php

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();

        $json = File::get("database/data/countries.json");
        $countries = json_decode($json);

        foreach ($countries as $country) {
            Country::create([
                'name' => $country->name,
                'alpha_2_code' => $country->alpha2Code,
                'alpha_3_code' => $country->alpha3Code,
                'calling_codes' => implode(',', $country->callingCodes),
                'alt_spellings' => implode(',', $country->altSpellings),
                'region' => $country->region,
                'sub_region' => $country->subregion,
                'demonym' => $country->demonym,
                'timezones' => implode(',', $country->timezones),
                'native_name' => $country->nativeName,
                'currencies' => $country->currencies,
            ]);
        }
    }
}
