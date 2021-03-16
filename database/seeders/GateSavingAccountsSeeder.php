<?php

namespace Database\Seeders;
use App\Models\GateSavingAccount;
use Illuminate\Database\Seeder;

class GateSavingAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $GateSavingAccount = [
            [
                'id'                => 1,
                'created_at'        => now(),
                'updated_at'        => now(),
                'deleted_at'        => null,
                'gate_id'           => 1,
                'saving_account_id' => 1,
                'daily_limit'       => 10,
            ],
            [
                'id'                => 2,
                'created_at'        => now(),
                'updated_at'        => now(),
                'deleted_at'        => null,
                'gate_id'           => 2,
                'saving_account_id' => 1,
                'daily_limit'       => 10,
            ],
            [
                'id'                => 3,
                'created_at'        => now(),
                'updated_at'        => now(),
                'deleted_at'        => null,
                'gate_id'           => 3,
                'saving_account_id' => 1,
                'daily_limit'       => 10,
            ],
            [
                'id'                => 4,
                'created_at'        => now(),
                'updated_at'        => now(),
                'deleted_at'        => null,
                'gate_id'           => 4,
                'saving_account_id' => 1,
                'daily_limit'       => 10,
            ],
            [
                'id'                => 5,
                'created_at'        => now(),
                'updated_at'        => now(),
                'deleted_at'        => null,
                'gate_id'           => 5,
                'saving_account_id' => 1,
                'daily_limit'       => 10,
            ],
            [
                'id'                => 6,
                'created_at'        => now(),
                'updated_at'        => now(),
                'deleted_at'        => null,
                'gate_id'           => 6,
                'saving_account_id' => 1,
                'daily_limit'       => 10,
            ],
            [
                'id'                => 7,
                'created_at'        => now(),
                'updated_at'        => now(),
                'deleted_at'        => null,
                'gate_id'           => 7,
                'saving_account_id' => 1,
                'daily_limit'       => 10,
            ],
            [
                'id'                => 8,
                'created_at'        => now(),
                'updated_at'        => now(),
                'deleted_at'        => null,
                'gate_id'           => 8,
                'saving_account_id' => 1,
                'daily_limit'       => 10,
            ],
            [
                'id'                => 9,
                'created_at'        => now(),
                'updated_at'        => now(),
                'deleted_at'        => null,
                'gate_id'           => 9,
                'saving_account_id' => 1,
                'daily_limit'       => 10,
            ],
            [
                'id'                => 10,
                'created_at'        => now(),
                'updated_at'        => now(),
                'deleted_at'        => null,
                'gate_id'           => 10,
                'saving_account_id' => 1,
                'daily_limit'       => 10,
            ]
        ];

        GateSavingAccount::insert($GateSavingAccount);
    }
}
