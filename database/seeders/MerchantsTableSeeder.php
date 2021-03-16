<?php

namespace Database\Seeders;

use App\Models\Merchant;

use Illuminate\Database\Seeder;

class MerchantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Merchant = [
            [
                'id'                    => 1,
                'name'                  => 'Merchant01',
                'email'                 => 'Merchant01@merchant.com',
                'password'              => bcrypt('password'),
                'remember_token'        => null,
                'created_at'            => now(),
                'updated_at'            => now(),
                'deleted_at'            => null,
                'person_incharge_name'  => 'admin',
                'contact'               => '087654345679',
                'status'                => 0,
            ],
            [
                'id'                    => 2,
                'name'                  => 'Merchant02',
                'email'                 => 'Merchant02@merchant.com',
                'password'              => bcrypt('password'),
                'remember_token'        => null,
                'created_at'            => now(),
                'updated_at'            => now(),
                'deleted_at'            => null,
                'person_incharge_name'  => 'admin',
                'contact'               => '087654345679',
                'status'                => 0,
            ],
            [
                'id'                    => 3,
                'name'                  => 'Merchant03',
                'email'                 => 'Merchant03@merchant.com',
                'password'              => bcrypt('password'),
                'remember_token'        => null,
                'created_at'            => now(),
                'updated_at'            => now(),
                'deleted_at'            => null,
                'person_incharge_name'  => 'admin',
                'contact'               => '087654345679',
                'status'                => 0,
            ],
            [
                'id'                    => 4,
                'name'                  => 'Merchant04',
                'email'                 => 'Merchant04@merchant.com',
                'password'              => bcrypt('password'),
                'remember_token'        => null,
                'created_at'            => now(),
                'updated_at'            => now(),
                'deleted_at'            => null,
                'person_incharge_name'  => 'admin',
                'contact'               => '087654345679',
                'status'                => 0,
            ],
            [
                'id'                    => 5,
                'name'                  => 'Merchant05',
                'email'                 => 'Merchant05@merchant.com',
                'password'              => bcrypt('password'),
                'remember_token'        => null,
                'created_at'            => now(),
                'updated_at'            => now(),
                'deleted_at'            => null,
                'person_incharge_name'  => 'admin',
                'contact'               => '087654345679',
                'status'                => 0,
            ],
        ];

        Merchant::insert($Merchant);
    }
}
