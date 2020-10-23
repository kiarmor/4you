<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request as Request;
use App\Transfer;
use App\User;

class TransferController extends BaseController
{
  function index( Request $request ) {
	if ($request->get('q')) {
		$users = User::where('email', 'LIKE', '%' . $request->get('q') . '%')->pluck('id')->toArray();
		$transfers = Transfer::whereIn('sender_id', $users)->orWhereIn('recipient_id', $users);
	} else {
        $transfers = Transfer::where('id', '>', 0)->orderBy('created_at', 'desc');

    }

	if ($request->get('sort')) {
		$method = $request->get('order') == 'asc' ? 'asc' : 'desc';
		switch ($request->get('sort')) {
			case 'amount':
				$transfers->orderBy('amount', $method);
				break;
			case 'date':
				$transfers->orderBy('created_at', $method);
				break;
		}
	}else
		$transfers->orderBy('id', 'desc');

    return view('admin.transfers.index', [
		'transfers'	=> $transfers->paginate(10)
	]);
  }
}
