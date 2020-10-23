<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
	private static $statusList = [
		'reserved' => 'Зарезервировано',
		'success' => 'Выплачено',
		'bad' => 'Отказано'
	];
	private static $statusClasses = [
		'reserved' => 'text-warning',
		'success' => 'text-success',
		'bad' => 'text-danger'
	];
    protected $table = 'withdraw';
    protected $fillable = [
        'user_id', 'amount', 'status', 'addit', 'wallet', 'method'
    ];
    protected $dates = ['created_at', 'updated_at'];

    public function getStatus() {
    	return Withdraw::$statusList[$this->status];
    }

    public function statusClass() {
    	return Withdraw::$statusClasses[$this->status];
    }
}
