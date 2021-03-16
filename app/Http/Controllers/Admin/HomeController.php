<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Merchant;
use App\Models\Product;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Currency;

class HomeController extends Controller
{
    public function index()
    {

        // $role = Role::create(['name' => 'Admin']);
        // $role = Role::create(['guard_name' => 'partner', 'name' => 'Partner']);


        // dd(Auth::user('admin'));
        // $user = Merchant::first();
        // Permission::where('name','!=', '')->delete();
        // $user->assignRole('Merchant');



        // app()['cache']->forget('spatie.permission.cache');

        // $permission = Permission::create(['name' => 'role_create', 'guard_name' => 'partner']);
        // $permission2 = Permission::create(['name' => 'role_edit']);
        // $permission3 = Permission::create(['name' => 'role_show']);
        // $permission4 = Permission::create(['name' => 'role_delete']);
        // $permission5 = Permission::create(['name' => 'role_access']);

        // $results = DB::select('select * from permissions2');

        // foreach($results as $value){

        //     $permission = Permission::create(['name' => $value->title, 'guard_name' => 'partner']);

        // }

        // $role = Role::where('name','Admin')->first();
        // $role->givePermissionTo(Permission::all());

        $user = Auth::user();

        $balances = Balance::with(['gate', 'gate.currency', 'merchant'])->get();

        $total_processing_fee = 0;
        $pending_processing_fee = 0;

        $group_by_currency = [];

        $currency_arr = Currency::all();

        foreach ($currency_arr  as $c) {
            $group_by_currency[$c['short_code']] = [
                'complete' => 0,
                'pending' => 0,
            ];
        }


        $group_by_project = [];

        $project_arr = Product::all();

        foreach ($project_arr  as $p) {
            $group_by_project[$p['name']] = [
                'complete' => 0,
                'pending' => 0,
            ];
        }

        $group_by_merchant = [];

        $merchant_arr = Merchant::all();

        foreach ($merchant_arr  as $m) {
            $group_by_merchant[$m['name']] = [
                'complete' => 0,
                'pending' => 0,
            ];
        }

        foreach ($balances as $balance) {

            // dd($balance->gate->currency->short_code);

            if ($balance->settlement_status == 1) {
                $total_processing_fee += $balance->processing_fee;

                $group_by_currency[$balance->gate->currency->short_code]['complete'] += $balance->processing_fee;
                $group_by_project[$balance->gate->name]['complete'] += $balance->processing_fee;
                $group_by_merchant[$balance->gate->merchant->name]['complete'] += $balance->processing_fee;

                // if (isset($group_by_currency[$balance->gate->currency->short_code]['complete'])) {
                //     $group_by_currency[$balance->gate->currency->short_code]['complete'] += $balance->processing_fee;
                //     $group_by_project[$balance->gate->name]['complete'] += $balance->processing_fee;
                // } else {
                //     $group_by_currency[$balance->gate->currency->short_code]['complete'] = 0 + $balance->processing_fee;
                // }
            } else {
                $pending_processing_fee += $balance->processing_fee;

                $group_by_currency[$balance->gate->currency->short_code]['pending'] += $balance->processing_fee;
                $group_by_project[$balance->gate->name]['pending'] += $balance->processing_fee;
                $group_by_merchant[$balance->gate->merchant->name]['pending'] += $balance->processing_fee;
                // if (isset($group_by_currency[$balance->gate->currency->short_code]['pending'])) {
                //     $group_by_currency[$balance->gate->currency->short_code]['pending'] += $balance->processing_fee;
                // } else {
                //     $group_by_currency[$balance->gate->currency->short_code]['pending'] = 0 + $balance->processing_fee;
                // }
            }
        }
        // dd($group_by_currency['VND']['pending']);

        return view('home', compact('user', 'pending_processing_fee', 'total_processing_fee', 'balances', 'group_by_currency', 'group_by_merchant', 'group_by_project'));
    }
}
