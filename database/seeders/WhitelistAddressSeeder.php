<?php

namespace Database\Seeders;

use App\Models\WhitelistIpAddress;
use Illuminate\Database\Seeder;

class WhitelistAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'ip_address'     => '127.0.0.1',
                'status'         => 0,
                'gate_id'        => 1,
            ],
            [
                'id'             => 2,
                'ip_address'     => '2400:6180:0:d1::720:4001', // coin.techworld 的后台 server ip address
                'status'         => 0,
                'gate_id'        => 1,
            ],

            
        ];

        WhitelistIpAddress::insert($users);
    }
}
