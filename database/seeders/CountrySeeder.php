<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domain = url('storage/countries') . '/';

        $countries = [
            [
                'name' => 'Estados Unidos',
                'code' => 'US',
                'flag' => $domain . 'us.png',
            ],
            [
                'name' => 'Colombia',
                'code' => 'CO',
                'flag' => $domain . 'co.png',
            ],
            [
                'name' => 'Chile',
                'code' => 'CL',
                'flag' => $domain . 'cl.png',
            ],
            [
                'name' => 'Argentina',
                'code' => 'AR',
                'flag' => $domain . 'ar.png',
            ],
            [
                'name' => 'España',
                'code' => 'ES',
                'flag' => $domain . 'es.png',
            ],
            [
                'name' => 'Portugal',
                'code' => 'PT',
                'flag' => $domain . 'pt.png',
            ],
            [
                'name' => 'Corea del Sur',
                'code' => 'CR',
                'flag' => $domain . 'cr.png',
            ],
            [
                'name' => 'Francia',
                'code' => 'FR',
                'flag' => $domain . 'fr.png',
            ],
            [
                'name' => 'Malasia',
                'code' => 'MY',
                'flag' => $domain . 'my.png',
            ],
            [
                'name' => 'Brasil',
                'code' => 'BR',
                'flag' => $domain . 'br.png',
            ],
        ];

        DB::table('countries')->insert($countries);
    }
}
