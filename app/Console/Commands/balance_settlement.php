<?php

namespace App\Console\Commands;

use App\Models\Balance;
use App\Models\Product;
use App\Models\SavingAccount;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class balance_settlement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance_settlement:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Daily Balance Settlement';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Calculate Daily Balance Settlement');

        // SUM debit and credit groupBy saving_account_id
        $saving_account_ids = Balance::select(DB::raw('SUM(debit) as total_debit, SUM(credit) as total_credit'), 'saving_account_id')
                                    ->where('settlement_status', 0)
                                    ->groupBy('saving_account_id')
                                    ->get();

        // update SavingAccounts' total_credit
        foreach ($saving_account_ids as $sa_id) {
            $total = $sa_id->total_debit - $sa_id->total_credit;

            $saving_account = SavingAccount::find($sa_id->saving_account_id);
            $saving_account->total_credit = $saving_account->total_credit + $total;
            $saving_account->save();
        }

        // get Products where freeze_credit != 0
        $products = Product::where('freeze_credit', '<>', 0)->get();

        // update Products' current_credit
        foreach ($products as $product) {
            $product->current_credit = $product->current_credit + $product->freeze_credit;
            $product->freeze_credit = 0;
            $product->save();
        }

        $res['balance'] = Balance::where('settlement_status', 0)->update(['settlement_status' => '1']);

        $this->info('Done');
    }
}
