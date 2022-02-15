<?php

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::truncate();

        $json = File::get("database/data/countries.json");
        $countries = json_decode($json);

        foreach ($countries as $country) {
            foreach ($country->currencies as $currency) {
                $currency       = Currency::firstOrCreate([
                    'acronym'   => $currency,
                ]);
                $currency->save();
            }
        }
    }
}
