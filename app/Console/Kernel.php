<?php

namespace App\Console;

use App\Console\Commands\balance_settlement;
use App\Console\Commands\expire_top_up;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        expire_top_up::class,
        balance_settlement::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('top_up_expire:minute')->everyMinute();
        $schedule->command('balance_settlement:daily:daily')->daily();

        // $schedule->call(function(){
        //     DB::table('payouts')->update('status' , )
        // })
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
