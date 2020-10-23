<?php

namespace App\Exports;

use App\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class HistoryExport implements FromCollection
{
    public function collection()
    {
    	return DB::table('history')->where('user_id', Auth::user()->id)->orderBy('created_at')->get();
    }
}

?>