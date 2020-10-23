<?php

namespace App\Http\Controllers;

use App\Exports\HistoryExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller 
{
    public function export() 
    {
        return Excel::download(new HistoryExport, 'history.xlsx');
    }
}

?>