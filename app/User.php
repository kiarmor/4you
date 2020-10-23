<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    private static $ranks = [
        ['name' => 'Новичок',                   'turnover' => 0,         'bonus' => 0,      'cerificate' => 0],
        ['name' => 'Ассистент',                 'turnover' => 50,        'bonus' => 0.1,    'cerificate' => 1],
        ['name' => 'Старший ассистент',         'turnover' => 500,       'bonus' => 0.105,  'cerificate' => 1],
        ['name' => 'Консультант',               'turnover' => 2500,      'bonus' => 0.11,   'cerificate' => 1],
        ['name' => 'Старший консультант',       'turnover' => 10000,     'bonus' => 0.115,  'cerificate' => 1],
        ['name' => 'Менеджер',                  'turnover' => 50000,     'bonus' => 0.12,   'cerificate' => 1],
        ['name' => 'Старший менеджер',          'turnover' => 100000,    'bonus' => 0.125,  'cerificate' => 1],
        ['name' => 'Лидер',                     'turnover' => 250000,    'bonus' => 0.13,   'cerificate' => 1],
        ['name' => 'Старший лидер',             'turnover' => 500000,    'bonus' => 0.135,  'cerificate' => 1],
        ['name' => 'Директор',                  'turnover' => 750000,    'bonus' => 0.14,   'cerificate' => 1],
        ['name' => 'Директор-ассистент',        'turnover' => 1000000,   'bonus' => 0.145,  'cerificate' => 1],
        ['name' => 'Директор-консультант',      'turnover' => 2500000,   'bonus' => 0.15,   'cerificate' => 1],
        ['name' => 'Директор-лидер',            'turnover' => 5000000,   'bonus' => 0.155,  'cerificate' => 1],
        ['name' => 'Наставник',                 'turnover' => 7500000,   'bonus' => 0.16,   'cerificate' => 1],
        ['name' => 'Настваник-мастер',          'turnover' => 10000000,  'bonus' => 0.165,  'cerificate' => 1],
        ['name' => 'Наставник-лидер',           'turnover' => 25000000,  'bonus' => 0.17,   'cerificate' => 1],
        ['name' => 'Золотой наставник',         'turnover' => 50000000,  'bonus' => 0.175,  'cerificate' => 1],
        ['name' => 'Мастер',                    'turnover' => 75000000,  'bonus' => 0.18,   'cerificate' => 1],
        ['name' => 'Ведущий мастер',            'turnover' => 100000000, 'bonus' => 0.185,  'cerificate' => 1],
        ['name' => 'Член Совета директоров',    'turnover' => 150000000, 'bonus' => 0.19,   'cerificate' => 1]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'referrer_id', 'phone', 'balance', 'email_key', 'total_partners', 'total_volume'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function updateVolume($amount) {
        return $this::volumeUpdater($this::where('id', $this->referrer_id)->first(), $amount);
    }

    public function updatePartners() {
        return $this::partnersUpdater($this::where('id', $this->referrer_id)->first());
    }

    public function volume() {
        return $this->invested + $this->earned + $this::fullVolume($this::where('referrer_id', $this->id)->get());
    }

    public function referralVolume()
    {
        return $this::fullVolume($this::where('referrer_id', $this->id)->get());
    }

    public function network() {
        return $this::referralNetwork($this::where('referrer_id', $this->id)->get());
    }

    public function getRank() {
        $invested = $this->volume();
        if ($invested >= $this->nextRank()['turnover'] && $this->rank < count(User::$ranks) - 1) {
            $this->rank++;
            $this->save();
        }
        return User::$ranks[$this->rank];
    }

    public function refEarned()
    {
        $amount = DB::table('history')->where([
            ['user_id', $this->id],
            ['type', 'ref']
        ])->sum('amount');

        return $amount ? sprintf('%0.2f', $amount) : 0;
    }

    public function nextRank() {
        return $this->rank < count(User::$ranks) - 1 ? User::$ranks[$this->rank + 1] : null;
    }

    public function lastWeeklyVolume() {
        $start = Carbon::now()->startOfWeek()->subWeek();
        $end = Carbon::now()->endOfWeek()->subWeek();

        $amount = DB::table('history')
            ->where('user_id', $this->id)
            ->whereBetween('created_at', [$start->format('Y-m-d') . ' 00:00:00', $end->format('Y-m-d') . ' 23:59:59'])
            ->avg('amount');

    	return $amount ? sprintf('%0.2f', $amount) : 0;
    }

    public function weeklyVolume() {
        $date = Carbon::now()->startOfWeek();
        $date = $date->format('Y-m-d') . ' 00:00:00';

        $amount = DB::table('history')->where([
            ['user_id', $this->id],
            ['created_at', '>=', $date]
        ])->avg('amount');

    	return $amount ? sprintf('%0.2f', $amount) : 0;
    }

    public function monthVolume() {
    	$amount = DB::table('history')->where('user_id', $this->id)->where('created_at', '>=', Carbon::now()->subMonth())->avg('amount');
    	return $amount ? sprintf('%0.2f', $amount) : 0;
    }

    public static function maxTurnover() {
    	return User::$ranks[count(User::$ranks) - 1]['turnover'];
    }

    public function volumeUpdater($referrer, $amount, $line=1) {
        if ($line < 19) {
            if ($referrer) {
                $referrer->total_volume += $amount;
                $referrer->save();
                $referrer = User::where('id', $referrer->referrer_id)->first();
                User::volumeUpdater($referrer, $amount, $line + 1);
            }
            else
                return;
        }
    }

    public function partnersUpdater($referrer, $line=1) {
        if ($line < 19) {
            if ($referrer) {
                $referrer->total_partners++;
                $referrer->save();
                $referrer = User::where('id', $referrer->referrer_id)->first();
                User::partnersUpdater($referrer, $line + 1);
            }
            else
                return;
        }
    }

    public static function referralNetwork($referrals, $total_referrals=0, $line=1) {
        if ($line < 19) {
            $total_referrals += count($referrals);
            foreach ($referrals as $referral) {
                $total_referrals += User::referralNetwork(User::where('referrer_id', $referral->id)->get(), 0, $line+1);
            }
        }
        return $total_referrals;
    }

    public static function fullVolume($referrals, $total_volume=0, $line=1) {
        if ($line < 19) {
            foreach($referrals as $referral) {
                $total_volume += $referral->invested + $referral->earned + User::fullVolume(User::where('referrer_id', $referral->id)->get(), 0, $line+1);
            }
        }
        return $total_volume;
    }

    public function referrals()
    {
        return User::where('referrer_id', $this->id)->get();
    }
}
