<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $table = 'tariff';
    protected $fillable = [
        'name',
        'period_1',
        'period_2',
        'period_3',
        'period_4',
        'period_5',
        'is_gift',
        'image'
    ];
}
