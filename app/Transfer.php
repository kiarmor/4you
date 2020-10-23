<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'transfer';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $casts = [

    ];

    protected $fillable = [
        'sender_id', 'recipient_id', 'amount'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo('App\User', 'recipient_id');
    }
}
