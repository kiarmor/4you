<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;


class Purchased extends Model
{
    private $weeks = [1, 4, 13, 26, 52];
	protected $table = 'purchased';
    protected $fillable = [
        'user_id', 'tariff_id', 'period', 'amount', 'next_payment', 'active',
    ];
    protected $dates = ['created_at', 'updated_at', 'next_payment', 'last_payment'];

    public function get_tariff() {
    	return DB::table('tariff')->where('id', $this->tariff_id)->first();
    }

    public function tariff_period() {
    	return ['Раз в неделю', 'Раз в месяц', 'Раз в 3 месяца', 'Раз в пол года', 'Раз в год'][$this->period - 1];
    }

    public static function get_period($currPeriod) {
        return ['Раз в неделю', 'Раз в месяц', 'Раз в 3 месяца', 'Раз в пол года', 'Раз в год'][$currPeriod - 1];
    }

    public function tariff_rate($tariff) {
    	return [$tariff->period_1, $tariff->period_2, $tariff->period_3, $tariff->period_4, $tariff->period_5][$this->period - 1];
    }

    public function get_weeks() {
        return $this->weeks[$this->period - 1];
    }

    public static function new_next($period, $carbon) {
        return $period == 1 ? $carbon->addWeek() :
            ($period == 2 ? $carbon->addMonth() :
            ($period == 3 ? $carbon->addMonths(3) :
            ($period == 4 ? $carbon->addMonths(6) : $carbon->addYear())));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}
