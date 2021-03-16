<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModelHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('model_has_roles')->insert(array (
            0 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\Models\Admin',
                'model_id' => 1,
            ),
            1 => 
            array (
                'role_id' => 2,
                'model_type' => 'App\Models\Merchant',
                'model_id' => 1,
            ),
            2 => 
            array (
                'role_id' => 2,
                'model_type' => 'App\Models\Merchant',
                'model_id' => 2,
            ),
            3 => 
            array (
                'role_id' => 2,
                'model_type' => 'App\Models\Merchant',
                'model_id' => 3,
            ),
            4 => 
            array (
                'role_id' => 2,
                'model_type' => 'App\Models\Merchant',
                'model_id' => 4,
            ),
            5 => 
            array (
                'role_id' => 2,
                'model_type' => 'App\Models\Merchant',
                'model_id' => 5,
            ),
        ));
    }
}
