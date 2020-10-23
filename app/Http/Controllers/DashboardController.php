<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController
{
    function index() {
        $user = User::where('id', Auth::id())->firstOrFail();

    	return view('dashboard.index')->with([
    	    'user'       => $user,
            'invested'   => $user->volume(),
            'network'    => $user->network(),
            'rank'       => $user->getRank(),
            'nextRank'   => $user->nextRank(),
            'ref_earned' => $user->refEarned(),
            'referralVolume' => $user->referralVolume()
        ]);
    }
}
