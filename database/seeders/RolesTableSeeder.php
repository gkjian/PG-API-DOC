<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin',
                'guard_name' => 'admin',
                'created_at' => '2021-02-04 17:39:07',
                'updated_at' => '2021-02-04 17:39:07',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Merchant',
                'guard_name' => 'merchant',
                'created_at' => '2021-02-04 17:39:40',
                'updated_at' => '2021-02-05 13:42:32',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Partner',
                'guard_name' => 'partner',
                'created_at' => '2021-02-04 17:40:02',
                'updated_at' => '2021-02-05 13:42:59',
            ),
        ));
        
        
    }
}