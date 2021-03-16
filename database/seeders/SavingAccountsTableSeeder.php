<?php

namespace Database\Seeders;

use App\Models\SavingAccount;

use Illuminate\Database\Seeder;

class SavingAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $SavingAccount = [
            [
                'id'                    => 1,
                'bank_name'             => 'CIMB',
                'bank_account_name'     => 'testing',
                'bank_account_number'   => '123123123',
                'daily_limit'           => 123123123.00,
                'transaction_limit'     => 12312312.00,
                'status'                => '0',
                'created_at'            => now(),
                'updated_at'            => now(),
                'deleted_at'            => null,
                'currency_id'           => 1,
                'total_credit'         => 0.00,
                'bank_id'             => '9856812365127',
            ],
        ];

        SavingAccount::insert($SavingAccount);
    }
}
