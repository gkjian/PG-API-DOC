<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('permissions')->delete();

        \DB::table('permissions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'user_management_access',
                'guard_name' => 'admin',
                'type' => 'management',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'permission_create',
                'guard_name' => 'admin',
                'type' => 'permission',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'permission_edit',
                'guard_name' => 'admin',
                'type' => 'permission',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'permission_show',
                'guard_name' => 'admin',
                'type' => 'permission',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            // 4 =>
            // array (
            //     'id' => 5,
            //     'name' => 'permission_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'permission',
            //     'created_at' => '2021-02-04 17:40:31',
            //     'updated_at' => '2021-02-04 17:40:31',
            // ),
            5 =>
            array (
                'id' => 6,
                'name' => 'permission_access',
                'guard_name' => 'admin',
                'type' => 'permission',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'role_create',
                'guard_name' => 'admin',
                'type' => 'role',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'role_edit',
                'guard_name' => 'admin',
                'type' => 'role',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'role_show',
                'guard_name' => 'admin',
                'type' => 'role',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            // 9 =>
            // array (
            //     'id' => 10,
            //     'name' => 'role_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'role',
            //     'created_at' => '2021-02-04 17:40:31',
            //     'updated_at' => '2021-02-04 17:40:31',
            // ),
            10 =>
            array (
                'id' => 11,
                'name' => 'role_access',
                'guard_name' => 'admin',
                'type' => 'role',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            // 11 =>
            // array (
            //     'id' => 12,
            //     'name' => 'user_create',
            //     'guard_name' => 'admin',
            //     'type' => 'user',
            //     'created_at' => '2021-02-04 17:40:31',
            //     'updated_at' => '2021-02-04 17:40:31',
            // ),
            // 12 =>
            // array (
            //     'id' => 13,
            //     'name' => 'user_edit',
            //     'guard_name' => 'admin',
            //     'type' => 'user',
            //     'created_at' => '2021-02-04 17:40:31',
            //     'updated_at' => '2021-02-04 17:40:31',
            // ),
            // 13 =>
            // array (
            //     'id' => 14,
            //     'name' => 'user_show',
            //     'guard_name' => 'admin',
            //     'type' => 'user',
            //     'created_at' => '2021-02-04 17:40:31',
            //     'updated_at' => '2021-02-04 17:40:31',
            // ),
            // 14 =>
            // array (
            //     'id' => 15,
            //     'name' => 'user_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'user',
            //     'created_at' => '2021-02-04 17:40:31',
            //     'updated_at' => '2021-02-04 17:40:31',
            // ),
            // 15 =>
            // array (
            //     'id' => 16,
            //     'name' => 'user_access',
            //     'guard_name' => 'admin',
            //     'type' => 'user',
            //     'created_at' => '2021-02-04 17:40:31',
            //     'updated_at' => '2021-02-04 17:40:31',
            // ),
            16 =>
            array (
                'id' => 17,
                'name' => 'admin_create',
                'guard_name' => 'admin',
                'type' => 'admin',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            17 =>
            array (
                'id' => 18,
                'name' => 'admin_edit',
                'guard_name' => 'admin',
                'type' => 'admin',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            18 =>
            array (
                'id' => 19,
                'name' => 'admin_show',
                'guard_name' => 'admin',
                'type' => 'admin',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            // 19 =>
            // array (
            //     'id' => 20,
            //     'name' => 'admin_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'admin',
            //     'created_at' => '2021-02-04 17:40:31',
            //     'updated_at' => '2021-02-04 17:40:31',
            // ),
            20 =>
            array (
                'id' => 21,
                'name' => 'admin_access',
                'guard_name' => 'admin',
                'type' => 'admin',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            21 =>
            array (
                'id' => 22,
                'name' => 'merchant_create',
                'guard_name' => 'admin',
                'type' => 'merchant',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            22 =>
            array (
                'id' => 23,
                'name' => 'merchant_edit',
                'guard_name' => 'admin',
                'type' => 'merchant',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            23 =>
            array (
                'id' => 24,
                'name' => 'merchant_show',
                'guard_name' => 'admin',
                'type' => 'merchant',
                'created_at' => '2021-02-04 17:40:31',
                'updated_at' => '2021-02-04 17:40:31',
            ),
            // 24 =>
            // array (
            //     'id' => 25,
            //     'name' => 'merchant_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'merchant',
            //     'created_at' => '2021-02-04 17:40:31',
            //     'updated_at' => '2021-02-04 17:40:31',
            // ),
            25 =>
            array (
                'id' => 26,
                'name' => 'merchant_access',
                'guard_name' => 'admin',
                'type' => 'merchant',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            26 =>
            array (
                'id' => 27,
                'name' => 'partner_create',
                'guard_name' => 'admin',
                'type' => 'partner',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            27 =>
            array (
                'id' => 28,
                'name' => 'partner_edit',
                'guard_name' => 'admin',
                'type' => 'partner',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            28 =>
            array (
                'id' => 29,
                'name' => 'partner_show',
                'guard_name' => 'admin',
                'type' => 'partner',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 29 =>
            // array (
            //     'id' => 30,
            //     'name' => 'partner_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'partner',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            30 =>
            array (
                'id' => 31,
                'name' => 'partner_access',
                'guard_name' => 'admin',
                'type' => 'partner',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            31 =>
            array (
                'id' => 32,
                'name' => 'transaction_management_access',
                'guard_name' => 'admin',
                'type' => 'management',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            32 =>
            array (
                'id' => 33,
                'name' => 'top_up_create',
                'guard_name' => 'admin',
                'type' => 'top_up',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 33 =>
            // array (
            //     'id' => 34,
            //     'name' => 'top_up_edit',
            //     'guard_name' => 'admin',
            //     'type' => 'top_up',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            34 =>
            array (
                'id' => 35,
                'name' => 'top_up_show',
                'guard_name' => 'admin',
                'type' => 'top_up',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 35 =>
            // array (
            //     'id' => 36,
            //     'name' => 'top_up_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'top_up',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            36 =>
            array (
                'id' => 37,
                'name' => 'top_up_access',
                'guard_name' => 'admin',
                'type' => 'top_up',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            37 =>
            array (
                'id' => 38,
                'name' => 'payout_management_access',
                'guard_name' => 'admin',
                'type' => 'management',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            38 =>
            array (
                'id' => 39,
                'name' => 'payout_create',
                'guard_name' => 'admin',
                'type' => 'payout',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 39 =>
            // array (
            //     'id' => 40,
            //     'name' => 'payout_edit',
            //     'guard_name' => 'admin',
            //     'type' => 'payout',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            40 =>
            array (
                'id' => 41,
                'name' => 'payout_show',
                'guard_name' => 'admin',
                'type' => 'payout',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 41 =>
            // array (
            //     'id' => 42,
            //     'name' => 'payout_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'payout',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            42 =>
            array (
                'id' => 43,
                'name' => 'payout_access',
                'guard_name' => 'admin',
                'type' => 'payout',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            43 =>
            array (
                'id' => 44,
                'name' => 'payout_bulk_create',
                'guard_name' => 'admin',
                'type' => 'payout_bulk',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 44 =>
            // array (
            //     'id' => 45,
            //     'name' => 'payout_bulk_edit',
            //     'guard_name' => 'admin',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 45 =>
            // array (
            //     'id' => 46,
            //     'name' => 'payout_bulk_show',
            //     'guard_name' => 'admin',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 46 =>
            // array (
            //     'id' => 47,
            //     'name' => 'payout_bulk_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 47 =>
            // array (
            //     'id' => 48,
            //     'name' => 'payout_bulk_access',
            //     'guard_name' => 'admin',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            48 =>
            array (
                'id' => 49,
                'name' => 'currency_management_access',
                'guard_name' => 'admin',
                'type' => 'management',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            49 =>
            array (
                'id' => 50,
                'name' => 'currency_create',
                'guard_name' => 'admin',
                'type' => 'currency',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            50 =>
            array (
                'id' => 51,
                'name' => 'currency_edit',
                'guard_name' => 'admin',
                'type' => 'currency',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            51 =>
            array (
                'id' => 52,
                'name' => 'currency_show',
                'guard_name' => 'admin',
                'type' => 'currency',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 52 =>
            // array (
            //     'id' => 53,
            //     'name' => 'currency_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'currency',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            53 =>
            array (
                'id' => 54,
                'name' => 'currency_access',
                'guard_name' => 'admin',
                'type' => 'currency',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 54 =>
            // array (
            //     'id' => 55,
            //     'name' => 'payout_bank_create',
            //     'guard_name' => 'admin',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 55 =>
            // array (
            //     'id' => 56,
            //     'name' => 'payout_bank_edit',
            //     'guard_name' => 'admin',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 56 =>
            // array (
            //     'id' => 57,
            //     'name' => 'payout_bank_show',
            //     'guard_name' => 'admin',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 57 =>
            // array (
            //     'id' => 58,
            //     'name' => 'payout_bank_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 58 =>
            // array (
            //     'id' => 59,
            //     'name' => 'payout_bank_access',
            //     'guard_name' => 'admin',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            59 =>
            array (
                'id' => 60,
                'name' => 'settlement_management_access',
                'guard_name' => 'admin',
                'type' => 'management',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            60 =>
            array (
                'id' => 61,
                'name' => 'settlement_create',
                'guard_name' => 'admin',
                'type' => 'settlement',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            61 =>
            array (
                'id' => 62,
                'name' => 'settlement_edit',
                'guard_name' => 'admin',
                'type' => 'settlement',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            62 =>
            array (
                'id' => 63,
                'name' => 'settlement_show',
                'guard_name' => 'admin',
                'type' => 'settlement',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 63 =>
            // array (
            //     'id' => 64,
            //     'name' => 'settlement_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'settlement',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            64 =>
            array (
                'id' => 65,
                'name' => 'settlement_access',
                'guard_name' => 'admin',
                'type' => 'settlement',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            65 =>
            array (
                'id' => 66,
                'name' => 'settlement_bank_create',
                'guard_name' => 'admin',
                'type' => 'settlement_bank',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            66 =>
            array (
                'id' => 67,
                'name' => 'settlement_bank_edit',
                'guard_name' => 'admin',
                'type' => 'settlement_bank',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            67 =>
            array (
                'id' => 68,
                'name' => 'settlement_bank_show',
                'guard_name' => 'admin',
                'type' => 'settlement_bank',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 68 =>
            // array (
            //     'id' => 69,
            //     'name' => 'settlement_bank_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'settlement_bank',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            69 =>
            array (
                'id' => 70,
                'name' => 'settlement_bank_access',
                'guard_name' => 'admin',
                'type' => 'settlement_bank',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            70 =>
            array (
                'id' => 71,
                'name' => 'balance_create',
                'guard_name' => 'admin',
                'type' => 'balance',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            71 =>
            array (
                'id' => 72,
                'name' => 'balance_edit',
                'guard_name' => 'admin',
                'type' => 'balance',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            72 =>
            array (
                'id' => 73,
                'name' => 'balance_show',
                'guard_name' => 'admin',
                'type' => 'balance',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 73 =>
            // array (
            //     'id' => 74,
            //     'name' => 'balance_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'balance',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            74 =>
            array (
                'id' => 75,
                'name' => 'balance_access',
                'guard_name' => 'admin',
                'type' => 'balance',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            75 =>
            array (
                'id' => 76,
                'name' => 'project_management_access',
                'guard_name' => 'admin',
                'type' => 'management',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 76 =>
            // array (
            //     'id' => 77,
            //     'name' => 'deposit_create',
            //     'guard_name' => 'admin',
            //     'type' => 'deposit',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            77 =>
            array (
                'id' => 78,
                'name' => 'deposit_edit',
                'guard_name' => 'admin',
                'type' => 'deposit',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            78 =>
            array (
                'id' => 79,
                'name' => 'deposit_show',
                'guard_name' => 'admin',
                'type' => 'deposit',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 79 =>
            // array (
            //     'id' => 80,
            //     'name' => 'deposit_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'deposit',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            80 =>
            array (
                'id' => 81,
                'name' => 'deposit_access',
                'guard_name' => 'admin',
                'type' => 'deposit',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            81 =>
            array (
                'id' => 82,
                'name' => 'saving_account_management_access',
                'guard_name' => 'admin',
                'type' => 'management',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 82 =>
            // array (
            //     'id' => 83,
            //     'name' => 'api_key_create',
            //     'guard_name' => 'admin',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 83 =>
            // array (
            //     'id' => 84,
            //     'name' => 'api_key_edit',
            //     'guard_name' => 'admin',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 84 =>
            // array (
            //     'id' => 85,
            //     'name' => 'api_key_show',
            //     'guard_name' => 'admin',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 85 =>
            // array (
            //     'id' => 86,
            //     'name' => 'api_key_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 86 =>
            // array (
            //     'id' => 87,
            //     'name' => 'api_key_access',
            //     'guard_name' => 'admin',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            87 =>
            array (
                'id' => 88,
                'name' => 'saving_account_create',
                'guard_name' => 'admin',
                'type' => 'saving_account',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            88 =>
            array (
                'id' => 89,
                'name' => 'saving_account_edit',
                'guard_name' => 'admin',
                'type' => 'saving_account',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            89 =>
            array (
                'id' => 90,
                'name' => 'saving_account_show',
                'guard_name' => 'admin',
                'type' => 'saving_account',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 90 =>
            // array (
            //     'id' => 91,
            //     'name' => 'saving_account_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'saving_account',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            91 =>
            array (
                'id' => 92,
                'name' => 'saving_account_access',
                'guard_name' => 'admin',
                'type' => 'saving_account',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            92 =>
            array (
                'id' => 93,
                'name' => 'project_saving_account_create',
                'guard_name' => 'admin',
                'type' => 'project_saving_account',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            93 =>
            array (
                'id' => 94,
                'name' => 'project_saving_account_edit',
                'guard_name' => 'admin',
                'type' => 'project_saving_account',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            94 =>
            array (
                'id' => 95,
                'name' => 'project_saving_account_show',
                'guard_name' => 'admin',
                'type' => 'project_saving_account',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            // 95 =>
            // array (
            //     'id' => 96,
            //     'name' => 'project_saving_account_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'project_saving_account',
            //     'created_at' => '2021-02-04 17:40:33',
            //     'updated_at' => '2021-02-04 17:40:33',
            // ),
            96 =>
            array (
                'id' => 97,
                'name' => 'project_saving_account_access',
                'guard_name' => 'admin',
                'type' => 'project_saving_account',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            97 =>
            array (
                'id' => 98,
                'name' => 'security_management_access',
                'guard_name' => 'admin',
                'type' => 'management',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            98 =>
            array (
                'id' => 99,
                'name' => 'whitelist_ip_address_create',
                'guard_name' => 'admin',
                'type' => 'whitelist_ip_address',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            99 =>
            array (
                'id' => 100,
                'name' => 'whitelist_ip_address_edit',
                'guard_name' => 'admin',
                'type' => 'whitelist_ip_address',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            100 =>
            array (
                'id' => 101,
                'name' => 'whitelist_ip_address_show',
                'guard_name' => 'admin',
                'type' => 'whitelist_ip_address',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            // 101 =>
            // array (
            //     'id' => 102,
            //     'name' => 'whitelist_ip_address_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'whitelist_ip_address',
            //     'created_at' => '2021-02-04 17:40:33',
            //     'updated_at' => '2021-02-04 17:40:33',
            // ),
            102 =>
            array (
                'id' => 103,
                'name' => 'whitelist_ip_address_access',
                'guard_name' => 'admin',
                'type' => 'whitelist_ip_address',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            103 =>
            array (
                'id' => 104,
                'name' => 'audit_log_show',
                'guard_name' => 'admin',
                'type' => 'audit_log',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            104 =>
            array (
                'id' => 105,
                'name' => 'audit_log_access',
                'guard_name' => 'admin',
                'type' => 'audit_log',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            105 =>
            array (
                'id' => 106,
                'name' => 'product_create',
                'guard_name' => 'admin',
                'type' => 'product',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            106 =>
            array (
                'id' => 107,
                'name' => 'product_edit',
                'guard_name' => 'admin',
                'type' => 'product',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            107 =>
            array (
                'id' => 108,
                'name' => 'product_show',
                'guard_name' => 'admin',
                'type' => 'product',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            // 108 =>
            // array (
            //     'id' => 109,
            //     'name' => 'product_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'product',
            //     'created_at' => '2021-02-04 17:40:33',
            //     'updated_at' => '2021-02-04 17:40:33',
            // ),
            109 =>
            array (
                'id' => 110,
                'name' => 'product_access',
                'guard_name' => 'admin',
                'type' => 'product',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            // 110 =>
            // array (
            //     'id' => 111,
            //     'name' => 'whitelist_email_create',
            //     'guard_name' => 'admin',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-04 17:40:33',
            //     'updated_at' => '2021-02-04 17:40:33',
            // ),
            // 111 =>
            // array (
            //     'id' => 112,
            //     'name' => 'whitelist_email_edit',
            //     'guard_name' => 'admin',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-04 17:40:33',
            //     'updated_at' => '2021-02-04 17:40:33',
            // ),
            // 112 =>
            // array (
            //     'id' => 113,
            //     'name' => 'whitelist_email_show',
            //     'guard_name' => 'admin',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-04 17:40:33',
            //     'updated_at' => '2021-02-04 17:40:33',
            // ),
            // 113 =>
            // array (
            //     'id' => 114,
            //     'name' => 'whitelist_email_delete',
            //     'guard_name' => 'admin',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-04 17:40:33',
            //     'updated_at' => '2021-02-04 17:40:33',
            // ),
            // 114 =>
            // array (
            //     'id' => 115,
            //     'name' => 'whitelist_email_access',
            //     'guard_name' => 'admin',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-04 17:40:33',
            //     'updated_at' => '2021-02-04 17:40:33',
            // ),
            115 =>
            array (
                'id' => 116,
                'name' => 'profile_password_edit',
                'guard_name' => 'admin',
                'type' => 'profile_password',
                'created_at' => '2021-02-04 17:40:33',
                'updated_at' => '2021-02-04 17:40:33',
            ),
            116 =>
            array (
                'id' => 117,
                'name' => 'user_management_access',
                'guard_name' => 'merchant',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:07',
                'updated_at' => '2021-02-05 09:37:07',
            ),
            117 =>
            array (
                'id' => 118,
                'name' => 'permission_create',
                'guard_name' => 'merchant',
                'type' => 'permission',
                'created_at' => '2021-02-05 09:37:07',
                'updated_at' => '2021-02-05 09:37:07',
            ),
            118 =>
            array (
                'id' => 119,
                'name' => 'permission_edit',
                'guard_name' => 'merchant',
                'type' => 'permission',
                'created_at' => '2021-02-05 09:37:07',
                'updated_at' => '2021-02-05 09:37:07',
            ),
            119 =>
            array (
                'id' => 120,
                'name' => 'permission_show',
                'guard_name' => 'merchant',
                'type' => 'permission',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            // 120 =>
            // array (
            //     'id' => 121,
            //     'name' => 'permission_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'permission',
            //     'created_at' => '2021-02-05 09:37:08',
            //     'updated_at' => '2021-02-05 09:37:08',
            // ),
            121 =>
            array (
                'id' => 122,
                'name' => 'permission_access',
                'guard_name' => 'merchant',
                'type' => 'permission',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            122 =>
            array (
                'id' => 123,
                'name' => 'role_create',
                'guard_name' => 'merchant',
                'type' => 'role',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            123 =>
            array (
                'id' => 124,
                'name' => 'role_edit',
                'guard_name' => 'merchant',
                'type' => 'role',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            124 =>
            array (
                'id' => 125,
                'name' => 'role_show',
                'guard_name' => 'merchant',
                'type' => 'role',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            // 125 =>
            // array (
            //     'id' => 126,
            //     'name' => 'role_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'role',
            //     'created_at' => '2021-02-05 09:37:08',
            //     'updated_at' => '2021-02-05 09:37:08',
            // ),
            126 =>
            array (
                'id' => 127,
                'name' => 'role_access',
                'guard_name' => 'merchant',
                'type' => 'role',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            // 127 =>
            // array (
            //     'id' => 128,
            //     'name' => 'user_create',
            //     'guard_name' => 'merchant',
            //     'type' => 'user',
            //     'created_at' => '2021-02-05 09:37:08',
            //     'updated_at' => '2021-02-05 09:37:08',
            // ),
            // 128 =>
            // array (
            //     'id' => 129,
            //     'name' => 'user_edit',
            //     'guard_name' => 'merchant',
            //     'type' => 'user',
            //     'created_at' => '2021-02-05 09:37:08',
            //     'updated_at' => '2021-02-05 09:37:08',
            // ),
            // 129 =>
            // array (
            //     'id' => 130,
            //     'name' => 'user_show',
            //     'guard_name' => 'merchant',
            //     'type' => 'user',
            //     'created_at' => '2021-02-05 09:37:08',
            //     'updated_at' => '2021-02-05 09:37:08',
            // ),
            // 130 =>
            // array (
            //     'id' => 131,
            //     'name' => 'user_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'user',
            //     'created_at' => '2021-02-05 09:37:08',
            //     'updated_at' => '2021-02-05 09:37:08',
            // ),
            // 131 =>
            // array (
            //     'id' => 132,
            //     'name' => 'user_access',
            //     'guard_name' => 'merchant',
            //     'type' => 'user',
            //     'created_at' => '2021-02-05 09:37:08',
            //     'updated_at' => '2021-02-05 09:37:08',
            // ),
            132 =>
            array (
                'id' => 133,
                'name' => 'admin_create',
                'guard_name' => 'merchant',
                'type' => 'admin',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            133 =>
            array (
                'id' => 134,
                'name' => 'admin_edit',
                'guard_name' => 'merchant',
                'type' => 'admin',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            134 =>
            array (
                'id' => 135,
                'name' => 'admin_show',
                'guard_name' => 'merchant',
                'type' => 'admin',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            // 135 =>
            // array (
            //     'id' => 136,
            //     'name' => 'admin_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'admin',
            //     'created_at' => '2021-02-05 09:37:08',
            //     'updated_at' => '2021-02-05 09:37:08',
            // ),
            136 =>
            array (
                'id' => 137,
                'name' => 'admin_access',
                'guard_name' => 'merchant',
                'type' => 'admin',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            137 =>
            array (
                'id' => 138,
                'name' => 'merchant_create',
                'guard_name' => 'merchant',
                'type' => 'merchant',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            138 =>
            array (
                'id' => 139,
                'name' => 'merchant_edit',
                'guard_name' => 'merchant',
                'type' => 'merchant',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            139 =>
            array (
                'id' => 140,
                'name' => 'merchant_show',
                'guard_name' => 'merchant',
                'type' => 'merchant',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            // 140 =>
            // array (
            //     'id' => 141,
            //     'name' => 'merchant_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'merchant',
            //     'created_at' => '2021-02-05 09:37:08',
            //     'updated_at' => '2021-02-05 09:37:08',
            // ),
            141 =>
            array (
                'id' => 142,
                'name' => 'merchant_access',
                'guard_name' => 'merchant',
                'type' => 'merchant',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            142 =>
            array (
                'id' => 143,
                'name' => 'partner_create',
                'guard_name' => 'merchant',
                'type' => 'partner',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            143 =>
            array (
                'id' => 144,
                'name' => 'partner_edit',
                'guard_name' => 'merchant',
                'type' => 'partner',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            144 =>
            array (
                'id' => 145,
                'name' => 'partner_show',
                'guard_name' => 'merchant',
                'type' => 'partner',
                'created_at' => '2021-02-05 09:37:08',
                'updated_at' => '2021-02-05 09:37:08',
            ),
            // 145 =>
            // array (
            //     'id' => 146,
            //     'name' => 'partner_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'partner',
            //     'created_at' => '2021-02-05 09:37:08',
            //     'updated_at' => '2021-02-05 09:37:08',
            // ),
            146 =>
            array (
                'id' => 147,
                'name' => 'partner_access',
                'guard_name' => 'merchant',
                'type' => 'partner',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            147 =>
            array (
                'id' => 148,
                'name' => 'transaction_management_access',
                'guard_name' => 'merchant',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            148 =>
            array (
                'id' => 149,
                'name' => 'top_up_create',
                'guard_name' => 'merchant',
                'type' => 'top_up',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            // 149 =>
            // array (
            //     'id' => 150,
            //     'name' => 'top_up_edit',
            //     'guard_name' => 'merchant',
            //     'type' => 'top_up',
            //     'created_at' => '2021-02-05 09:37:09',
            //     'updated_at' => '2021-02-05 09:37:09',
            // ),
            150 =>
            array (
                'id' => 151,
                'name' => 'top_up_show',
                'guard_name' => 'merchant',
                'type' => 'top_up',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            // 151 =>
            // array (
            //     'id' => 152,
            //     'name' => 'top_up_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'top_up',
            //     'created_at' => '2021-02-05 09:37:09',
            //     'updated_at' => '2021-02-05 09:37:09',
            // ),
            152 =>
            array (
                'id' => 153,
                'name' => 'top_up_access',
                'guard_name' => 'merchant',
                'type' => 'top_up',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            153 =>
            array (
                'id' => 154,
                'name' => 'payout_management_access',
                'guard_name' => 'merchant',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            154 =>
            array (
                'id' => 155,
                'name' => 'payout_create',
                'guard_name' => 'merchant',
                'type' => 'payout',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            // 155 =>
            // array (
            //     'id' => 156,
            //     'name' => 'payout_edit',
            //     'guard_name' => 'merchant',
            //     'type' => 'payout',
            //     'created_at' => '2021-02-05 09:37:09',
            //     'updated_at' => '2021-02-05 09:37:09',
            // ),
            156 =>
            array (
                'id' => 157,
                'name' => 'payout_show',
                'guard_name' => 'merchant',
                'type' => 'payout',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            // 157 =>
            // array (
            //     'id' => 158,
            //     'name' => 'payout_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'payout',
            //     'created_at' => '2021-02-05 09:37:09',
            //     'updated_at' => '2021-02-05 09:37:09',
            // ),
            158 =>
            array (
                'id' => 159,
                'name' => 'payout_access',
                'guard_name' => 'merchant',
                'type' => 'payout',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            159 =>
            array (
                'id' => 160,
                'name' => 'payout_bulk_create',
                'guard_name' => 'merchant',
                'type' => 'payout_bulk',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            // 160 =>
            // array (
            //     'id' => 161,
            //     'name' => 'payout_bulk_edit',
            //     'guard_name' => 'merchant',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-05 09:37:09',
            //     'updated_at' => '2021-02-05 09:37:09',
            // ),
            // 161 =>
            // array (
            //     'id' => 162,
            //     'name' => 'payout_bulk_show',
            //     'guard_name' => 'merchant',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-05 09:37:09',
            //     'updated_at' => '2021-02-05 09:37:09',
            // ),
            // 162 =>
            // array (
            //     'id' => 163,
            //     'name' => 'payout_bulk_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-05 09:37:09',
            //     'updated_at' => '2021-02-05 09:37:09',
            // ),
            // 163 =>
            // array (
            //     'id' => 164,
            //     'name' => 'payout_bulk_access',
            //     'guard_name' => 'merchant',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-05 09:37:09',
            //     'updated_at' => '2021-02-05 09:37:09',
            // ),
            164 =>
            array (
                'id' => 165,
                'name' => 'currency_management_access',
                'guard_name' => 'merchant',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            165 =>
            array (
                'id' => 166,
                'name' => 'currency_create',
                'guard_name' => 'merchant',
                'type' => 'currency',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            166 =>
            array (
                'id' => 167,
                'name' => 'currency_edit',
                'guard_name' => 'merchant',
                'type' => 'currency',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            167 =>
            array (
                'id' => 168,
                'name' => 'currency_show',
                'guard_name' => 'merchant',
                'type' => 'currency',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            // 168 =>
            // array (
            //     'id' => 169,
            //     'name' => 'currency_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'currency',
            //     'created_at' => '2021-02-05 09:37:09',
            //     'updated_at' => '2021-02-05 09:37:09',
            // ),
            169 =>
            array (
                'id' => 170,
                'name' => 'currency_access',
                'guard_name' => 'merchant',
                'type' => 'currency',
                'created_at' => '2021-02-05 09:37:09',
                'updated_at' => '2021-02-05 09:37:09',
            ),
            // 170 =>
            // array (
            //     'id' => 171,
            //     'name' => 'payout_bank_create',
            //     'guard_name' => 'merchant',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-05 09:37:09',
            //     'updated_at' => '2021-02-05 09:37:09',
            // ),
            // 171 =>
            // array (
            //     'id' => 172,
            //     'name' => 'payout_bank_edit',
            //     'guard_name' => 'merchant',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-05 09:37:09',
            //     'updated_at' => '2021-02-05 09:37:09',
            // ),
            // 172 =>
            // array (
            //     'id' => 173,
            //     'name' => 'payout_bank_show',
            //     'guard_name' => 'merchant',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-05 09:37:10',
            //     'updated_at' => '2021-02-05 09:37:10',
            // ),
            // 173 =>
            // array (
            //     'id' => 174,
            //     'name' => 'payout_bank_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-05 09:37:10',
            //     'updated_at' => '2021-02-05 09:37:10',
            // ),
            // 174 =>
            // array (
            //     'id' => 175,
            //     'name' => 'payout_bank_access',
            //     'guard_name' => 'merchant',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-05 09:37:10',
            //     'updated_at' => '2021-02-05 09:37:10',
            // ),
            175 =>
            array (
                'id' => 176,
                'name' => 'settlement_management_access',
                'guard_name' => 'merchant',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            176 =>
            array (
                'id' => 177,
                'name' => 'settlement_create',
                'guard_name' => 'merchant',
                'type' => 'settlement',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            177 =>
            array (
                'id' => 178,
                'name' => 'settlement_edit',
                'guard_name' => 'merchant',
                'type' => 'settlement',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            178 =>
            array (
                'id' => 179,
                'name' => 'settlement_show',
                'guard_name' => 'merchant',
                'type' => 'settlement',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            // 179 =>
            // array (
            //     'id' => 180,
            //     'name' => 'settlement_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'settlement',
            //     'created_at' => '2021-02-05 09:37:10',
            //     'updated_at' => '2021-02-05 09:37:10',
            // ),
            180 =>
            array (
                'id' => 181,
                'name' => 'settlement_access',
                'guard_name' => 'merchant',
                'type' => 'settlement',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            181 =>
            array (
                'id' => 182,
                'name' => 'settlement_bank_create',
                'guard_name' => 'merchant',
                'type' => 'settlement_bank',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            182 =>
            array (
                'id' => 183,
                'name' => 'settlement_bank_edit',
                'guard_name' => 'merchant',
                'type' => 'settlement_bank',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            183 =>
            array (
                'id' => 184,
                'name' => 'settlement_bank_show',
                'guard_name' => 'merchant',
                'type' => 'settlement_bank',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            // 184 =>
            // array (
            //     'id' => 185,
            //     'name' => 'settlement_bank_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'settlement_bank',
            //     'created_at' => '2021-02-05 09:37:10',
            //     'updated_at' => '2021-02-05 09:37:10',
            // ),
            185 =>
            array (
                'id' => 186,
                'name' => 'settlement_bank_access',
                'guard_name' => 'merchant',
                'type' => 'settlement_bank',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            186 =>
            array (
                'id' => 187,
                'name' => 'balance_create',
                'guard_name' => 'merchant',
                'type' => 'balance',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            187 =>
            array (
                'id' => 188,
                'name' => 'balance_edit',
                'guard_name' => 'merchant',
                'type' => 'balance',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            188 =>
            array (
                'id' => 189,
                'name' => 'balance_show',
                'guard_name' => 'merchant',
                'type' => 'balance',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            // 189 =>
            // array (
            //     'id' => 190,
            //     'name' => 'balance_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'balance',
            //     'created_at' => '2021-02-05 09:37:10',
            //     'updated_at' => '2021-02-05 09:37:10',
            // ),
            190 =>
            array (
                'id' => 191,
                'name' => 'balance_access',
                'guard_name' => 'merchant',
                'type' => 'balance',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            191 =>
            array (
                'id' => 192,
                'name' => 'project_management_access',
                'guard_name' => 'merchant',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            // 192 =>
            // array (
            //     'id' => 193,
            //     'name' => 'deposit_create',
            //     'guard_name' => 'merchant',
            //     'type' => 'deposit',
            //     'created_at' => '2021-02-05 09:37:10',
            //     'updated_at' => '2021-02-05 09:37:10',
            // ),
            193 =>
            array (
                'id' => 194,
                'name' => 'deposit_edit',
                'guard_name' => 'merchant',
                'type' => 'deposit',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            194 =>
            array (
                'id' => 195,
                'name' => 'deposit_show',
                'guard_name' => 'merchant',
                'type' => 'deposit',
                'created_at' => '2021-02-05 09:37:10',
                'updated_at' => '2021-02-05 09:37:10',
            ),
            // 195 =>
            // array (
            //     'id' => 196,
            //     'name' => 'deposit_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'deposit',
            //     'created_at' => '2021-02-05 09:37:11',
            //     'updated_at' => '2021-02-05 09:37:11',
            // ),
            196 =>
            array (
                'id' => 197,
                'name' => 'deposit_access',
                'guard_name' => 'merchant',
                'type' => 'deposit',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            197 =>
            array (
                'id' => 198,
                'name' => 'saving_account_management_access',
                'guard_name' => 'merchant',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            // 198 =>
            // array (
            //     'id' => 199,
            //     'name' => 'api_key_create',
            //     'guard_name' => 'merchant',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-05 09:37:11',
            //     'updated_at' => '2021-02-05 09:37:11',
            // ),
            // 199 =>
            // array (
            //     'id' => 200,
            //     'name' => 'api_key_edit',
            //     'guard_name' => 'merchant',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-05 09:37:11',
            //     'updated_at' => '2021-02-05 09:37:11',
            // ),
            // 200 =>
            // array (
            //     'id' => 201,
            //     'name' => 'api_key_show',
            //     'guard_name' => 'merchant',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-05 09:37:11',
            //     'updated_at' => '2021-02-05 09:37:11',
            // ),
            // 201 =>
            // array (
            //     'id' => 202,
            //     'name' => 'api_key_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-05 09:37:11',
            //     'updated_at' => '2021-02-05 09:37:11',
            // ),
            // 202 =>
            // array (
            //     'id' => 203,
            //     'name' => 'api_key_access',
            //     'guard_name' => 'merchant',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-05 09:37:11',
            //     'updated_at' => '2021-02-05 09:37:11',
            // ),
            203 =>
            array (
                'id' => 204,
                'name' => 'saving_account_create',
                'guard_name' => 'merchant',
                'type' => 'saving_account',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            204 =>
            array (
                'id' => 205,
                'name' => 'saving_account_edit',
                'guard_name' => 'merchant',
                'type' => 'saving_account',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            205 =>
            array (
                'id' => 206,
                'name' => 'saving_account_show',
                'guard_name' => 'merchant',
                'type' => 'saving_account',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            // 206 =>
            // array (
            //     'id' => 207,
            //     'name' => 'saving_account_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'saving_account',
            //     'created_at' => '2021-02-05 09:37:11',
            //     'updated_at' => '2021-02-05 09:37:11',
            // ),
            207 =>
            array (
                'id' => 208,
                'name' => 'saving_account_access',
                'guard_name' => 'merchant',
                'type' => 'saving_account',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            208 =>
            array (
                'id' => 209,
                'name' => 'project_saving_account_create',
                'guard_name' => 'merchant',
                'type' => 'project_saving_account',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            209 =>
            array (
                'id' => 210,
                'name' => 'project_saving_account_edit',
                'guard_name' => 'merchant',
                'type' => 'project_saving_account',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            210 =>
            array (
                'id' => 211,
                'name' => 'project_saving_account_show',
                'guard_name' => 'merchant',
                'type' => 'project_saving_account',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            // 211 =>
            // array (
            //     'id' => 212,
            //     'name' => 'project_saving_account_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'project_saving_account',
            //     'created_at' => '2021-02-05 09:37:11',
            //     'updated_at' => '2021-02-05 09:37:11',
            // ),
            212 =>
            array (
                'id' => 213,
                'name' => 'project_saving_account_access',
                'guard_name' => 'merchant',
                'type' => 'project_saving_account',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            213 =>
            array (
                'id' => 214,
                'name' => 'security_management_access',
                'guard_name' => 'merchant',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            214 =>
            array (
                'id' => 215,
                'name' => 'whitelist_ip_address_create',
                'guard_name' => 'merchant',
                'type' => 'whitelist_ip_address',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            215 =>
            array (
                'id' => 216,
                'name' => 'whitelist_ip_address_edit',
                'guard_name' => 'merchant',
                'type' => 'whitelist_ip_address',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            216 =>
            array (
                'id' => 217,
                'name' => 'whitelist_ip_address_show',
                'guard_name' => 'merchant',
                'type' => 'whitelist_ip_address',
                'created_at' => '2021-02-05 09:37:11',
                'updated_at' => '2021-02-05 09:37:11',
            ),
            // 217 =>
            // array (
            //     'id' => 218,
            //     'name' => 'whitelist_ip_address_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'whitelist_ip_address',
            //     'created_at' => '2021-02-05 09:37:12',
            //     'updated_at' => '2021-02-05 09:37:12',
            // ),
            218 =>
            array (
                'id' => 219,
                'name' => 'whitelist_ip_address_access',
                'guard_name' => 'merchant',
                'type' => 'whitelist_ip_address',
                'created_at' => '2021-02-05 09:37:12',
                'updated_at' => '2021-02-05 09:37:12',
            ),
            219 =>
            array (
                'id' => 220,
                'name' => 'audit_log_show',
                'guard_name' => 'merchant',
                'type' => 'audit_log',
                'created_at' => '2021-02-05 09:37:12',
                'updated_at' => '2021-02-05 09:37:12',
            ),
            220 =>
            array (
                'id' => 221,
                'name' => 'audit_log_access',
                'guard_name' => 'merchant',
                'type' => 'audit_log',
                'created_at' => '2021-02-05 09:37:12',
                'updated_at' => '2021-02-05 09:37:12',
            ),
            221 =>
            array (
                'id' => 222,
                'name' => 'product_create',
                'guard_name' => 'merchant',
                'type' => 'product',
                'created_at' => '2021-02-05 09:37:12',
                'updated_at' => '2021-02-05 09:37:12',
            ),
            222 =>
            array (
                'id' => 223,
                'name' => 'product_edit',
                'guard_name' => 'merchant',
                'type' => 'product',
                'created_at' => '2021-02-05 09:37:12',
                'updated_at' => '2021-02-05 09:37:12',
            ),
            223 =>
            array (
                'id' => 224,
                'name' => 'product_show',
                'guard_name' => 'merchant',
                'type' => 'product',
                'created_at' => '2021-02-05 09:37:12',
                'updated_at' => '2021-02-05 09:37:12',
            ),
            // 224 =>
            // array (
            //     'id' => 225,
            //     'name' => 'product_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'product',
            //     'created_at' => '2021-02-05 09:37:12',
            //     'updated_at' => '2021-02-05 09:37:12',
            // ),
            225 =>
            array (
                'id' => 226,
                'name' => 'product_access',
                'guard_name' => 'merchant',
                'type' => 'product',
                'created_at' => '2021-02-05 09:37:12',
                'updated_at' => '2021-02-05 09:37:12',
            ),
            // 226 =>
            // array (
            //     'id' => 227,
            //     'name' => 'whitelist_email_create',
            //     'guard_name' => 'merchant',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-05 09:37:13',
            //     'updated_at' => '2021-02-05 09:37:13',
            // ),
            // 227 =>
            // array (
            //     'id' => 228,
            //     'name' => 'whitelist_email_edit',
            //     'guard_name' => 'merchant',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-05 09:37:13',
            //     'updated_at' => '2021-02-05 09:37:13',
            // ),
            // 228 =>
            // array (
            //     'id' => 229,
            //     'name' => 'whitelist_email_show',
            //     'guard_name' => 'merchant',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-05 09:37:13',
            //     'updated_at' => '2021-02-05 09:37:13',
            // ),
            // 229 =>
            // array (
            //     'id' => 230,
            //     'name' => 'whitelist_email_delete',
            //     'guard_name' => 'merchant',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-05 09:37:13',
            //     'updated_at' => '2021-02-05 09:37:13',
            // ),
            // 230 =>
            // array (
            //     'id' => 231,
            //     'name' => 'whitelist_email_access',
            //     'guard_name' => 'merchant',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-05 09:37:13',
            //     'updated_at' => '2021-02-05 09:37:13',
            // ),
            231 =>
            array (
                'id' => 232,
                'name' => 'profile_password_edit',
                'guard_name' => 'merchant',
                'type' => 'profile_password',
                'created_at' => '2021-02-05 09:37:13',
                'updated_at' => '2021-02-05 09:37:13',
            ),
            232 =>
            array (
                'id' => 233,
                'name' => 'user_management_access',
                'guard_name' => 'partner',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:33',
                'updated_at' => '2021-02-05 09:37:33',
            ),
            233 =>
            array (
                'id' => 234,
                'name' => 'permission_create',
                'guard_name' => 'partner',
                'type' => 'permission',
                'created_at' => '2021-02-05 09:37:33',
                'updated_at' => '2021-02-05 09:37:33',
            ),
            234 =>
            array (
                'id' => 235,
                'name' => 'permission_edit',
                'guard_name' => 'partner',
                'type' => 'permission',
                'created_at' => '2021-02-05 09:37:33',
                'updated_at' => '2021-02-05 09:37:33',
            ),
            235 =>
            array (
                'id' => 236,
                'name' => 'permission_show',
                'guard_name' => 'partner',
                'type' => 'permission',
                'created_at' => '2021-02-05 09:37:33',
                'updated_at' => '2021-02-05 09:37:33',
            ),
            // 236 =>
            // array (
            //     'id' => 237,
            //     'name' => 'permission_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'permission',
            //     'created_at' => '2021-02-05 09:37:33',
            //     'updated_at' => '2021-02-05 09:37:33',
            // ),
            237 =>
            array (
                'id' => 238,
                'name' => 'permission_access',
                'guard_name' => 'partner',
                'type' => 'permission',
                'created_at' => '2021-02-05 09:37:33',
                'updated_at' => '2021-02-05 09:37:33',
            ),
            238 =>
            array (
                'id' => 239,
                'name' => 'role_create',
                'guard_name' => 'partner',
                'type' => 'role',
                'created_at' => '2021-02-05 09:37:33',
                'updated_at' => '2021-02-05 09:37:33',
            ),
            239 =>
            array (
                'id' => 240,
                'name' => 'role_edit',
                'guard_name' => 'partner',
                'type' => 'role',
                'created_at' => '2021-02-05 09:37:33',
                'updated_at' => '2021-02-05 09:37:33',
            ),
            240 =>
            array (
                'id' => 241,
                'name' => 'role_show',
                'guard_name' => 'partner',
                'type' => 'role',
                'created_at' => '2021-02-05 09:37:33',
                'updated_at' => '2021-02-05 09:37:33',
            ),
            // 241 =>
            // array (
            //     'id' => 242,
            //     'name' => 'role_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'role',
            //     'created_at' => '2021-02-05 09:37:33',
            //     'updated_at' => '2021-02-05 09:37:33',
            // ),
            242 =>
            array (
                'id' => 243,
                'name' => 'role_access',
                'guard_name' => 'partner',
                'type' => 'role',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            // 243 =>
            // array (
            //     'id' => 244,
            //     'name' => 'user_create',
            //     'guard_name' => 'partner',
            //     'type' => 'user',
            //     'created_at' => '2021-02-05 09:37:34',
            //     'updated_at' => '2021-02-05 09:37:34',
            // ),
            // 244 =>
            // array (
            //     'id' => 245,
            //     'name' => 'user_edit',
            //     'guard_name' => 'partner',
            //     'type' => 'user',
            //     'created_at' => '2021-02-05 09:37:34',
            //     'updated_at' => '2021-02-05 09:37:34',
            // ),
            // 245 =>
            // array (
            //     'id' => 246,
            //     'name' => 'user_show',
            //     'guard_name' => 'partner',
            //     'type' => 'user',
            //     'created_at' => '2021-02-05 09:37:34',
            //     'updated_at' => '2021-02-05 09:37:34',
            // ),
            // 246 =>
            // array (
            //     'id' => 247,
            //     'name' => 'user_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'user',
            //     'created_at' => '2021-02-05 09:37:34',
            //     'updated_at' => '2021-02-05 09:37:34',
            // ),
            // 247 =>
            // array (
            //     'id' => 248,
            //     'name' => 'user_access',
            //     'guard_name' => 'partner',
            //     'type' => 'user',
            //     'created_at' => '2021-02-05 09:37:34',
            //     'updated_at' => '2021-02-05 09:37:34',
            // ),
            248 =>
            array (
                'id' => 249,
                'name' => 'admin_create',
                'guard_name' => 'partner',
                'type' => 'admin',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            249 =>
            array (
                'id' => 250,
                'name' => 'admin_edit',
                'guard_name' => 'partner',
                'type' => 'admin',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            250 =>
            array (
                'id' => 251,
                'name' => 'admin_show',
                'guard_name' => 'partner',
                'type' => 'admin',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            // 251 =>
            // array (
            //     'id' => 252,
            //     'name' => 'admin_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'admin',
            //     'created_at' => '2021-02-05 09:37:34',
            //     'updated_at' => '2021-02-05 09:37:34',
            // ),
            252 =>
            array (
                'id' => 253,
                'name' => 'admin_access',
                'guard_name' => 'partner',
                'type' => 'admin',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            253 =>
            array (
                'id' => 254,
                'name' => 'merchant_create',
                'guard_name' => 'partner',
                'type' => 'merchant',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            254 =>
            array (
                'id' => 255,
                'name' => 'merchant_edit',
                'guard_name' => 'partner',
                'type' => 'merchant',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            255 =>
            array (
                'id' => 256,
                'name' => 'merchant_show',
                'guard_name' => 'partner',
                'type' => 'merchant',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            // 256 =>
            // array (
            //     'id' => 257,
            //     'name' => 'merchant_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'merchant',
            //     'created_at' => '2021-02-05 09:37:34',
            //     'updated_at' => '2021-02-05 09:37:34',
            // ),
            257 =>
            array (
                'id' => 258,
                'name' => 'merchant_access',
                'guard_name' => 'partner',
                'type' => 'merchant',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            258 =>
            array (
                'id' => 259,
                'name' => 'partner_create',
                'guard_name' => 'partner',
                'type' => 'partner',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            259 =>
            array (
                'id' => 260,
                'name' => 'partner_edit',
                'guard_name' => 'partner',
                'type' => 'partner',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            260 =>
            array (
                'id' => 261,
                'name' => 'partner_show',
                'guard_name' => 'partner',
                'type' => 'partner',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            // 261 =>
            // array (
            //     'id' => 262,
            //     'name' => 'partner_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'partner',
            //     'created_at' => '2021-02-05 09:37:34',
            //     'updated_at' => '2021-02-05 09:37:34',
            // ),
            262 =>
            array (
                'id' => 263,
                'name' => 'partner_access',
                'guard_name' => 'partner',
                'type' => 'partner',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            263 =>
            array (
                'id' => 264,
                'name' => 'transaction_management_access',
                'guard_name' => 'partner',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            264 =>
            array (
                'id' => 265,
                'name' => 'top_up_create',
                'guard_name' => 'partner',
                'type' => 'top_up',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            // 265 =>
            // array (
            //     'id' => 266,
            //     'name' => 'top_up_edit',
            //     'guard_name' => 'partner',
            //     'type' => 'top_up',
            //     'created_at' => '2021-02-05 09:37:34',
            //     'updated_at' => '2021-02-05 09:37:34',
            // ),
            266 =>
            array (
                'id' => 267,
                'name' => 'top_up_show',
                'guard_name' => 'partner',
                'type' => 'top_up',
                'created_at' => '2021-02-05 09:37:34',
                'updated_at' => '2021-02-05 09:37:34',
            ),
            // 267 =>
            // array (
            //     'id' => 268,
            //     'name' => 'top_up_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'top_up',
            //     'created_at' => '2021-02-05 09:37:35',
            //     'updated_at' => '2021-02-05 09:37:35',
            // ),
            268 =>
            array (
                'id' => 269,
                'name' => 'top_up_access',
                'guard_name' => 'partner',
                'type' => 'top_up',
                'created_at' => '2021-02-05 09:37:35',
                'updated_at' => '2021-02-05 09:37:35',
            ),
            269 =>
            array (
                'id' => 270,
                'name' => 'payout_management_access',
                'guard_name' => 'partner',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:35',
                'updated_at' => '2021-02-05 09:37:35',
            ),
            // 270 =>
            // array (
            //     'id' => 271,
            //     'name' => 'payout_create',
            //     'guard_name' => 'partner',
            //     'type' => 'payout',
            //     'created_at' => '2021-02-05 09:37:35',
            //     'updated_at' => '2021-02-05 09:37:35',
            // ),
            // 271 =>
            // array (
            //     'id' => 272,
            //     'name' => 'payout_edit',
            //     'guard_name' => 'partner',
            //     'type' => 'payout',
            //     'created_at' => '2021-02-05 09:37:35',
            //     'updated_at' => '2021-02-05 09:37:35',
            // ),
            272 =>
            array (
                'id' => 273,
                'name' => 'payout_show',
                'guard_name' => 'partner',
                'type' => 'payout',
                'created_at' => '2021-02-05 09:37:35',
                'updated_at' => '2021-02-05 09:37:35',
            ),
            // 273 =>
            // array (
            //     'id' => 274,
            //     'name' => 'payout_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'payout',
            //     'created_at' => '2021-02-05 09:37:35',
            //     'updated_at' => '2021-02-05 09:37:35',
            // ),
            274 =>
            array (
                'id' => 275,
                'name' => 'payout_access',
                'guard_name' => 'partner',
                'type' => 'payout',
                'created_at' => '2021-02-05 09:37:35',
                'updated_at' => '2021-02-05 09:37:35',
            ),
            // 275 =>
            // array (
            //     'id' => 276,
            //     'name' => 'payout_bulk_create',
            //     'guard_name' => 'partner',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-05 09:37:35',
            //     'updated_at' => '2021-02-05 09:37:35',
            // ),
            // 276 =>
            // array (
            //     'id' => 277,
            //     'name' => 'payout_bulk_edit',
            //     'guard_name' => 'partner',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-05 09:37:35',
            //     'updated_at' => '2021-02-05 09:37:35',
            // ),
            // 277 =>
            // array (
            //     'id' => 278,
            //     'name' => 'payout_bulk_show',
            //     'guard_name' => 'partner',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-05 09:37:35',
            //     'updated_at' => '2021-02-05 09:37:35',
            // ),
            // 278 =>
            // array (
            //     'id' => 279,
            //     'name' => 'payout_bulk_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-05 09:37:35',
            //     'updated_at' => '2021-02-05 09:37:35',
            // ),
            // 279 =>
            // array (
            //     'id' => 280,
            //     'name' => 'payout_bulk_access',
            //     'guard_name' => 'partner',
            //     'type' => 'payout_bulk',
            //     'created_at' => '2021-02-05 09:37:36',
            //     'updated_at' => '2021-02-05 09:37:36',
            // ),
            280 =>
            array (
                'id' => 281,
                'name' => 'currency_management_access',
                'guard_name' => 'partner',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:36',
                'updated_at' => '2021-02-05 09:37:36',
            ),
            281 =>
            array (
                'id' => 282,
                'name' => 'currency_create',
                'guard_name' => 'partner',
                'type' => 'currency',
                'created_at' => '2021-02-05 09:37:36',
                'updated_at' => '2021-02-05 09:37:36',
            ),
            282 =>
            array (
                'id' => 283,
                'name' => 'currency_edit',
                'guard_name' => 'partner',
                'type' => 'currency',
                'created_at' => '2021-02-05 09:37:36',
                'updated_at' => '2021-02-05 09:37:36',
            ),
            283 =>
            array (
                'id' => 284,
                'name' => 'currency_show',
                'guard_name' => 'partner',
                'type' => 'currency',
                'created_at' => '2021-02-05 09:37:36',
                'updated_at' => '2021-02-05 09:37:36',
            ),
            // 284 =>
            // array (
            //     'id' => 285,
            //     'name' => 'currency_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'currency',
            //     'created_at' => '2021-02-05 09:37:36',
            //     'updated_at' => '2021-02-05 09:37:36',
            // ),
            285 =>
            array (
                'id' => 286,
                'name' => 'currency_access',
                'guard_name' => 'partner',
                'type' => 'currency',
                'created_at' => '2021-02-05 09:37:36',
                'updated_at' => '2021-02-05 09:37:36',
            ),
            // 286 =>
            // array (
            //     'id' => 287,
            //     'name' => 'payout_bank_create',
            //     'guard_name' => 'partner',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-05 09:37:36',
            //     'updated_at' => '2021-02-05 09:37:36',
            // ),
            // 287 =>
            // array (
            //     'id' => 288,
            //     'name' => 'payout_bank_edit',
            //     'guard_name' => 'partner',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-05 09:37:36',
            //     'updated_at' => '2021-02-05 09:37:36',
            // ),
            // 288 =>
            // array (
            //     'id' => 289,
            //     'name' => 'payout_bank_show',
            //     'guard_name' => 'partner',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-05 09:37:36',
            //     'updated_at' => '2021-02-05 09:37:36',
            // ),
            // 289 =>
            // array (
            //     'id' => 290,
            //     'name' => 'payout_bank_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-05 09:37:36',
            //     'updated_at' => '2021-02-05 09:37:36',
            // ),
            // 290 =>
            // array (
            //     'id' => 291,
            //     'name' => 'payout_bank_access',
            //     'guard_name' => 'partner',
            //     'type' => 'payout_bank',
            //     'created_at' => '2021-02-05 09:37:36',
            //     'updated_at' => '2021-02-05 09:37:36',
            // ),
            291 =>
            array (
                'id' => 292,
                'name' => 'settlement_management_access',
                'guard_name' => 'partner',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:36',
                'updated_at' => '2021-02-05 09:37:36',
            ),
            292 =>
            array (
                'id' => 293,
                'name' => 'settlement_create',
                'guard_name' => 'partner',
                'type' => 'settlement',
                'created_at' => '2021-02-05 09:37:36',
                'updated_at' => '2021-02-05 09:37:36',
            ),
            293 =>
            array (
                'id' => 294,
                'name' => 'settlement_edit',
                'guard_name' => 'partner',
                'type' => 'settlement',
                'created_at' => '2021-02-05 09:37:36',
                'updated_at' => '2021-02-05 09:37:36',
            ),
            294 =>
            array (
                'id' => 295,
                'name' => 'settlement_show',
                'guard_name' => 'partner',
                'type' => 'settlement',
                'created_at' => '2021-02-05 09:37:36',
                'updated_at' => '2021-02-05 09:37:36',
            ),
            // 295 =>
            // array (
            //     'id' => 296,
            //     'name' => 'settlement_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'settlement',
            //     'created_at' => '2021-02-05 09:37:36',
            //     'updated_at' => '2021-02-05 09:37:36',
            // ),
            296 =>
            array (
                'id' => 297,
                'name' => 'settlement_access',
                'guard_name' => 'partner',
                'type' => 'settlement',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            297 =>
            array (
                'id' => 298,
                'name' => 'settlement_bank_create',
                'guard_name' => 'partner',
                'type' => 'settlement_bank',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            298 =>
            array (
                'id' => 299,
                'name' => 'settlement_bank_edit',
                'guard_name' => 'partner',
                'type' => 'settlement_bank',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            299 =>
            array (
                'id' => 300,
                'name' => 'settlement_bank_show',
                'guard_name' => 'partner',
                'type' => 'settlement_bank',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            // 300 =>
            // array (
            //     'id' => 301,
            //     'name' => 'settlement_bank_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'settlement_bank',
            //     'created_at' => '2021-02-05 09:37:37',
            //     'updated_at' => '2021-02-05 09:37:37',
            // ),
            301 =>
            array (
                'id' => 302,
                'name' => 'settlement_bank_access',
                'guard_name' => 'partner',
                'type' => 'settlement_bank',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            302 =>
            array (
                'id' => 303,
                'name' => 'balance_create',
                'guard_name' => 'partner',
                'type' => 'balance',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            303 =>
            array (
                'id' => 304,
                'name' => 'balance_edit',
                'guard_name' => 'partner',
                'type' => 'balance',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            304 =>
            array (
                'id' => 305,
                'name' => 'balance_show',
                'guard_name' => 'partner',
                'type' => 'balance',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            // 305 =>
            // array (
            //     'id' => 306,
            //     'name' => 'balance_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'balance',
            //     'created_at' => '2021-02-05 09:37:37',
            //     'updated_at' => '2021-02-05 09:37:37',
            // ),
            306 =>
            array (
                'id' => 307,
                'name' => 'balance_access',
                'guard_name' => 'partner',
                'type' => 'balance',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            307 =>
            array (
                'id' => 308,
                'name' => 'project_management_access',
                'guard_name' => 'partner',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            // 308 =>
            // array (
            //     'id' => 309,
            //     'name' => 'deposit_create',
            //     'guard_name' => 'partner',
            //     'type' => 'deposit',
            //     'created_at' => '2021-02-05 09:37:37',
            //     'updated_at' => '2021-02-05 09:37:37',
            // ),
            309 =>
            array (
                'id' => 310,
                'name' => 'deposit_edit',
                'guard_name' => 'partner',
                'type' => 'deposit',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            310 =>
            array (
                'id' => 311,
                'name' => 'deposit_show',
                'guard_name' => 'partner',
                'type' => 'deposit',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            // 311 =>
            // array (
            //     'id' => 312,
            //     'name' => 'deposit_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'deposit',
            //     'created_at' => '2021-02-05 09:37:37',
            //     'updated_at' => '2021-02-05 09:37:37',
            // ),
            312 =>
            array (
                'id' => 313,
                'name' => 'deposit_access',
                'guard_name' => 'partner',
                'type' => 'deposit',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            313 =>
            array (
                'id' => 314,
                'name' => 'saving_account_management_access',
                'guard_name' => 'partner',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:37',
                'updated_at' => '2021-02-05 09:37:37',
            ),
            // 314 =>
            // array (
            //     'id' => 315,
            //     'name' => 'api_key_create',
            //     'guard_name' => 'partner',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-05 09:37:38',
            //     'updated_at' => '2021-02-05 09:37:38',
            // ),
            // 315 =>
            // array (
            //     'id' => 316,
            //     'name' => 'api_key_edit',
            //     'guard_name' => 'partner',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-05 09:37:38',
            //     'updated_at' => '2021-02-05 09:37:38',
            // ),
            // 316 =>
            // array (
            //     'id' => 317,
            //     'name' => 'api_key_show',
            //     'guard_name' => 'partner',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-05 09:37:38',
            //     'updated_at' => '2021-02-05 09:37:38',
            // ),
            // 317 =>
            // array (
            //     'id' => 318,
            //     'name' => 'api_key_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-05 09:37:38',
            //     'updated_at' => '2021-02-05 09:37:38',
            // ),
            // 318 =>
            // array (
            //     'id' => 319,
            //     'name' => 'api_key_access',
            //     'guard_name' => 'partner',
            //     'type' => 'api_key',
            //     'created_at' => '2021-02-05 09:37:38',
            //     'updated_at' => '2021-02-05 09:37:38',
            // ),
            319 =>
            array (
                'id' => 320,
                'name' => 'saving_account_create',
                'guard_name' => 'partner',
                'type' => 'saving_account',
                'created_at' => '2021-02-05 09:37:38',
                'updated_at' => '2021-02-05 09:37:38',
            ),
            320 =>
            array (
                'id' => 321,
                'name' => 'saving_account_edit',
                'guard_name' => 'partner',
                'type' => 'saving_account',
                'created_at' => '2021-02-05 09:37:38',
                'updated_at' => '2021-02-05 09:37:38',
            ),
            321 =>
            array (
                'id' => 322,
                'name' => 'saving_account_show',
                'guard_name' => 'partner',
                'type' => 'saving_account',
                'created_at' => '2021-02-05 09:37:38',
                'updated_at' => '2021-02-05 09:37:38',
            ),
            // 322 =>
            // array (
            //     'id' => 323,
            //     'name' => 'saving_account_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'saving_account',
            //     'created_at' => '2021-02-05 09:37:38',
            //     'updated_at' => '2021-02-05 09:37:38',
            // ),
            323 =>
            array (
                'id' => 324,
                'name' => 'saving_account_access',
                'guard_name' => 'partner',
                'type' => 'saving_account',
                'created_at' => '2021-02-05 09:37:38',
                'updated_at' => '2021-02-05 09:37:38',
            ),
            324 =>
            array (
                'id' => 325,
                'name' => 'project_saving_account_create',
                'guard_name' => 'partner',
                'type' => 'project_saving_account',
                'created_at' => '2021-02-05 09:37:38',
                'updated_at' => '2021-02-05 09:37:38',
            ),
            325 =>
            array (
                'id' => 326,
                'name' => 'project_saving_account_edit',
                'guard_name' => 'partner',
                'type' => 'project_saving_account',
                'created_at' => '2021-02-05 09:37:38',
                'updated_at' => '2021-02-05 09:37:38',
            ),
            326 =>
            array (
                'id' => 327,
                'name' => 'project_saving_account_show',
                'guard_name' => 'partner',
                'type' => 'project_saving_account',
                'created_at' => '2021-02-05 09:37:38',
                'updated_at' => '2021-02-05 09:37:38',
            ),
            // 327 =>
            // array (
            //     'id' => 328,
            //     'name' => 'project_saving_account_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'project_saving_account',
            //     'created_at' => '2021-02-05 09:37:38',
            //     'updated_at' => '2021-02-05 09:37:38',
            // ),
            328 =>
            array (
                'id' => 329,
                'name' => 'project_saving_account_access',
                'guard_name' => 'partner',
                'type' => 'project_saving_account',
                'created_at' => '2021-02-05 09:37:38',
                'updated_at' => '2021-02-05 09:37:38',
            ),
            329 =>
            array (
                'id' => 330,
                'name' => 'security_management_access',
                'guard_name' => 'partner',
                'type' => 'management',
                'created_at' => '2021-02-05 09:37:38',
                'updated_at' => '2021-02-05 09:37:38',
            ),
            330 =>
            array (
                'id' => 331,
                'name' => 'whitelist_ip_address_create',
                'guard_name' => 'partner',
                'type' => 'whitelist_ip_address',
                'created_at' => '2021-02-05 09:37:39',
                'updated_at' => '2021-02-05 09:37:39',
            ),
            331 =>
            array (
                'id' => 332,
                'name' => 'whitelist_ip_address_edit',
                'guard_name' => 'partner',
                'type' => 'whitelist_ip_address',
                'created_at' => '2021-02-05 09:37:39',
                'updated_at' => '2021-02-05 09:37:39',
            ),
            332 =>
            array (
                'id' => 333,
                'name' => 'whitelist_ip_address_show',
                'guard_name' => 'partner',
                'type' => 'whitelist_ip_address',
                'created_at' => '2021-02-05 09:37:39',
                'updated_at' => '2021-02-05 09:37:39',
            ),
            // 333 =>
            // array (
            //     'id' => 334,
            //     'name' => 'whitelist_ip_address_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'whitelist_ip_address',
            //     'created_at' => '2021-02-05 09:37:39',
            //     'updated_at' => '2021-02-05 09:37:39',
            // ),
            334 =>
            array (
                'id' => 335,
                'name' => 'whitelist_ip_address_access',
                'guard_name' => 'partner',
                'type' => 'whitelist_ip_address',
                'created_at' => '2021-02-05 09:37:39',
                'updated_at' => '2021-02-05 09:37:39',
            ),
            335 =>
            array (
                'id' => 336,
                'name' => 'audit_log_show',
                'guard_name' => 'partner',
                'type' => 'audit_log',
                'created_at' => '2021-02-05 09:37:39',
                'updated_at' => '2021-02-05 09:37:39',
            ),
            336 =>
            array (
                'id' => 337,
                'name' => 'audit_log_access',
                'guard_name' => 'partner',
                'type' => 'audit_log',
                'created_at' => '2021-02-05 09:37:39',
                'updated_at' => '2021-02-05 09:37:39',
            ),
            337 =>
            array (
                'id' => 338,
                'name' => 'product_create',
                'guard_name' => 'partner',
                'type' => 'product',
                'created_at' => '2021-02-05 09:37:39',
                'updated_at' => '2021-02-05 09:37:39',
            ),
            338 =>
            array (
                'id' => 339,
                'name' => 'product_edit',
                'guard_name' => 'partner',
                'type' => 'product',
                'created_at' => '2021-02-05 09:37:39',
                'updated_at' => '2021-02-05 09:37:39',
            ),
            339 =>
            array (
                'id' => 340,
                'name' => 'product_show',
                'guard_name' => 'partner',
                'type' => 'product',
                'created_at' => '2021-02-05 09:37:39',
                'updated_at' => '2021-02-05 09:37:39',
            ),
            // 340 =>
            // array (
            //     'id' => 341,
            //     'name' => 'product_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'product',
            //     'created_at' => '2021-02-05 09:37:39',
            //     'updated_at' => '2021-02-05 09:37:39',
            // ),
            341 =>
            array (
                'id' => 342,
                'name' => 'product_access',
                'guard_name' => 'partner',
                'type' => 'product',
                'created_at' => '2021-02-05 09:37:39',
                'updated_at' => '2021-02-05 09:37:39',
            ),
            // 342 =>
            // array (
            //     'id' => 343,
            //     'name' => 'whitelist_email_create',
            //     'guard_name' => 'partner',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-05 09:37:39',
            //     'updated_at' => '2021-02-05 09:37:39',
            // ),
            // 343 =>
            // array (
            //     'id' => 344,
            //     'name' => 'whitelist_email_edit',
            //     'guard_name' => 'partner',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-05 09:37:39',
            //     'updated_at' => '2021-02-05 09:37:39',
            // ),
            // 344 =>
            // array (
            //     'id' => 345,
            //     'name' => 'whitelist_email_show',
            //     'guard_name' => 'partner',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-05 09:37:39',
            //     'updated_at' => '2021-02-05 09:37:39',
            // ),
            // 345 =>
            // array (
            //     'id' => 346,
            //     'name' => 'whitelist_email_delete',
            //     'guard_name' => 'partner',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-05 09:37:39',
            //     'updated_at' => '2021-02-05 09:37:39',
            // ),
            // 346 =>
            // array (
            //     'id' => 347,
            //     'name' => 'whitelist_email_access',
            //     'guard_name' => 'partner',
            //     'type' => 'whitelist_email',
            //     'created_at' => '2021-02-05 09:37:39',
            //     'updated_at' => '2021-02-05 09:37:39',
            // ),
            347 =>
            array (
                'id' => 347,
                'name' => 'profile_password_edit',
                'guard_name' => 'partner',
                'type' => 'profile_password',
                'created_at' => '2021-02-05 09:37:39',
                'updated_at' => '2021-02-05 09:37:39',
            ),
            348 =>
            array (
                'id' => 348,
                'name' => 'deposit_adjustment',
                'guard_name' => 'admin',
                'type' => 'deposit',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            349 =>
            array (
                'id' => 349,
                'name' => 'deposit_adjustment',
                'guard_name' => 'partner',
                'type' => 'deposit',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            350 =>
            array (
                'id' => 350,
                'name' => 'deposit_adjustment',
                'guard_name' => 'merchant',
                'type' => 'deposit',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            351 =>
            array (
                'id' => 351,
                'name' => 'reporting_access',
                'guard_name' => 'admin',
                'type' => 'reporting',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            352=>
            array (
                'id' => 352,
                'name' => 'reporting_access',
                'guard_name' => 'partner',
                'type' => 'reporting',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            353 =>
            array (
                'id' => 353,
                'name' => 'reporting_access',
                'guard_name' => 'merchant',
                'type' => 'reporting',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            // 354 =>
            // array (
            //     'id' => 354,
            //     'name' => 'daily_statement_access',
            //     'guard_name' => 'admin',
            //     'type' => 'reporting',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 355=>
            // array (
            //     'id' => 355,
            //     'name' => 'daily_statement_access',
            //     'guard_name' => 'partner',
            //     'type' => 'reporting',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            // 356 =>
            // array (
            //     'id' => 356,
            //     'name' => 'daily_statement_access',
            //     'guard_name' => 'merchant',
            //     'type' => 'reporting',
            //     'created_at' => '2021-02-04 17:40:32',
            //     'updated_at' => '2021-02-04 17:40:32',
            // ),
            357 =>
            array (
                'id' => 357,
                'name' => 'deposit_daily_adjustment_access',
                'guard_name' => 'admin',
                'type' => 'reporting',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            358=>
            array (
                'id' => 358,
                'name' => 'deposit_daily_adjustment_access',
                'guard_name' => 'partner',
                'type' => 'reporting',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
            359 =>
            array (
                'id' => 359,
                'name' => 'deposit_daily_adjustment_access',
                'guard_name' => 'merchant',
                'type' => 'reporting',
                'created_at' => '2021-02-04 17:40:32',
                'updated_at' => '2021-02-04 17:40:32',
            ),
        ));
    }
}
