<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::where('guard_name', 'admin')->get();
        $admin_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->name, -7, 7) != '_delete';
        });
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

        $merchant_permissions = Permission::where('guard_name', 'merchant')->get();
        $merchant_permissions = $merchant_permissions->filter(function ($permission) {
            if (substr($permission->name, -7, 7) == '_delete') {
                return;
            } else if ($permission->name == "user_management_access") {
                return $permission->name;
            } else {
                return $permission->name == 'transaction_management_access'
                    || $permission->name == 'balance_show'
                    || $permission->name == 'balance_access'
                    || $permission->name == 'deposit_show'
                    || $permission->name == 'deposit_access'
                    || substr($permission->name, 0, 7) == 'payout_'
                    || substr($permission->name, 0, 11) == 'settlement_' 
                    || substr($permission->name, 0, 7) == 'top_up_' 
                    || $permission->name == 'profile_password_edit'
                    || substr($permission->name, 0, 9) == 'merchant_';
            }
        });
        Role::findOrFail(2)->permissions()->sync($merchant_permissions);

        // $partner_permissions = Permission::where('guard_name', 'partner')->get();
        // $partner_permissions = $partner_permissions->filter(function ($permission) {
        //     if (substr($permission->name, -7, 7) == '_delete') {
        //         return;
        //     } else if ($permission->name == "user_management_access") {
        //         return $permission->name;
        //     } else {
        //         return substr($permission->name, 0, 9) == 'merchant_' || $permission->name == 'profile_password_edit';
        //     }
        // });
        // Role::findOrFail(3)->permissions()->sync($partner_permissions);
    }
}
