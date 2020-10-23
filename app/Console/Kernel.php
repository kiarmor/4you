<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use App\Purchased;
use App\User;
use DB;
use Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {		
        $schedule->call(function() {
			// file_put_contents(__DIR__ . '/b_log.txt', date('Y-m-d H:i:s') . ' start' . PHP_EOL, FILE_APPEND);
            foreach(Purchased::where('active', 0)->get() as $purchase) {				
                $user = User::where('id', $purchase->user_id)->first();
                if ($user && $user->balance >= $purchase->amount) {		
					file_put_contents(__DIR__ . '/b_log.txt', date('Y-m-d H:i:s') . ' Purchase ID=' . $purchase->id . ' , User_Id=' . $user->id . ' Set ACTIVE' . PHP_EOL, FILE_APPEND);
                    $purchase->active = true;
                    $purchase->save();
                }
            }

            foreach(Purchased::where('next_payment', '<=', DB::raw('NOW()'))->where('active', true)->get() as $purchase) {				
                $tariff = $purchase->get_tariff();
                $user = User::where('id', $purchase->user_id)->first();								
                if ($user && $tariff) {							
					file_put_contents(__DIR__ . '/b_log.txt', date('Y-m-d H:i:s') . ' Purchase ID:' . $purchase->id . ' Tariff_Id=' . $purchase->tariff_id . ' User_Id=' . $purchase->user_id .' next_payment=' . $purchase->next_payment . ' Period=' . $purchase->period . PHP_EOL, FILE_APPEND);
                    $amount = round($purchase->amount * ($purchase->tariff_rate($tariff) / 100 / 52) * $purchase->get_weeks(), 2);					
					file_put_contents(__DIR__ . '/b_log.txt', 'Purchase ID:' . $purchase->id . ' User_Id=' . $user->id . ' Old_balance=' . $user->balance . ' + Amount= ' . $amount . PHP_EOL , FILE_APPEND);				
                    $user->balance += $amount;
                    $user->earned += $amount;
                    $user->save();					
					
                    DB::table('history')->insert([
                        'user_id' => $user->id,
                        'amount' => $amount,
                        'type' => 'in',
                        'addit' => 'Сертификат: ' . $tariff->name . ' (ID: ' . $tariff->id . ')'
                    ]);					

                    $purchase->next_payment = Purchased::new_next($purchase->period, Carbon::now());
					
					file_put_contents(__DIR__ . '/b_log.txt', 'Purchase ID:' . $purchase->id . ' Next_payment=' . $purchase->next_payment . PHP_EOL , FILE_APPEND);				

                    if($purchase->next_payment > $purchase->created_at->addWeeks(52)) {
                        $user->total_purchased--;
                        $user->save();
						file_put_contents(__DIR__ . '/b_log.txt', 'Purchase ID:' . $purchase->id . ' DELETED' . PHP_EOL , FILE_APPEND);			
                        $purchase->delete();
                    }
                    else
                        $purchase->save();					
					file_put_contents(__DIR__ . '/b_log.txt', '------' . PHP_EOL , FILE_APPEND);			
                }else {
					//file_put_contents(__DIR__ . '/b_log.txt', 'Purchase ID:' . $purchase->id . ' USER:' . ( $user ? 'FOUND' : 'NOT FOUND' ) . ' TARIFF:' . ( $tariff ? 'FOUND' : 'NOT FOUND' ) . PHP_EOL , FILE_APPEND);
				}				
            }
			
			// file_put_contents(__DIR__ . '/b_log.txt', date('Y-m-d H:i:s') . ' end' . PHP_EOL . ' ------------------------------- ' . PHP_EOL, FILE_APPEND);
        })->everyMinute();
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
