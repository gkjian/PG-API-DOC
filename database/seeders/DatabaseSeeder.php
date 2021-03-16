<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AdminsTableSeeder::class,
            UsersTableSeeder::class,
            RolesTableSeeder::class,
            ModelHasRoleSeeder::class,
            PermissionsTableSeeder::class,
            PermissionRoleTableSeeder::class,
            CurrencyTableSeeder::class,
            SavingAccountsTableSeeder::class,
            MerchantsTableSeeder::class,
            ProductTableSeeder::class,
            ApiKeyTableSeeder::class,
            GateSavingAccountsSeeder::class,
            WhitelistAddressSeeder::class,
        ]);
        // $this->call(PermissionsTableSeeder::class);
        // $this->call(RolesTableSeeder::class);
        // $this->call(ProductsTableSeeder::class);
        // $this->call(CallbackTopupsTableSeeder::class);
    }
}
