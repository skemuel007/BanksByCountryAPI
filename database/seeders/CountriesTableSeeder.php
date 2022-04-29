<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->delete();
        $json = File::get("database/sample_db/countries.json");
        $data = json_decode($json);

        foreach($data as $obj) {
            Country::create(array(
                'name' => $obj->name,
                'code' => $obj->code,
                'active' => true
            ));
        }

    }
}
