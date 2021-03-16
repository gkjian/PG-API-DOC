<?php

namespace Database\Seeders;
use App\Models\Currency;

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Currency = [
            [
                'id'         => 1,
                'name'       => 'Vietnam',
                'short_code' => 'VND',
                'status'     => '0',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ];

        Currency::insert($Currency);
    }
}
