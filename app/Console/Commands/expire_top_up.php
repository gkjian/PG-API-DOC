<?php

namespace App\Console\Commands;

use App\Models\TopUp;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;

class expire_top_up extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'top_up_expire:minute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'expire top up request when it is intial';

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
        $this->info('exceute expire top up request when it is intial');

        // $formatted_date = Carbon::now()->addMinutes(env('TOP_UP_EXRIRE_TIME'))->toDateTimeString();

        $formatted_date = Carbon::now()->toDateTimeString();

        $this->info('expired_time :' . $formatted_date);

        TopUp::where('status', 0)->where('expire_time', '>', $formatted_date)->update(['status' => 9]);
        $this->info('done');
    }
}
