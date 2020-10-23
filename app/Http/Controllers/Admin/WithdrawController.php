<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\User;
use App\Withdraw;
use DB;

class WithdrawController extends BaseController
{
    function index(Request $request) {
        if ($request->get('q')) {
            $users = User::where('email', 'LIKE', '%' . $request->get('q') . '%')->get();
            $withdraw = Withdraw::where('user_id', 0);
            foreach ($users as $user) {
                $withdraw->orWhere('user_id', $user->id);
            }
        } else {
            $withdraw = Withdraw::where('id', '>', 0)->orderBy('created_at', 'desc');
        }

        $withdraws = $withdraw->paginate(15);

        foreach ($withdraws as $w) {
            if ($w->isnew) {
                $w->isnew = false;
                $w->save();
            }
        }

    	return view('admin.withdraw.index', ['withdraws' => $withdraws]);
    }

    function accept (Request $request) {
        $w = Withdraw::where('id', $request->get('id'))->first();
        if ($w->status == 'reserved') {
            $w->status = 'success';
            $w->save();

            DB::table('history')->insert([
                'user_id' => $w->user_id,
                'amount' => $w->amount,
                'type' => 'out',
                'addit' => 'Вывод средств'
            ]);
        }
        return redirect()->back();
    }

    function decline (Request $request) {
        $w = Withdraw::where('id', $request->get('id'))->first();
        if ($w->status == 'reserved') {
            $user = User::where('id', $w->user_id)->first();
            $user->balance += $w->amount;
            $user->save();
            $w->status = 'bad';
            $w->save();
        }
        return redirect()->back();
    }

}
