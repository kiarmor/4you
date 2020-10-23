<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Purchased;
use App\User;
use DB;

class ActiveController extends BaseController {
    function index (Request $request) {
        if ($request->get('q')) {
    		$requests = [
    			User::where('phone', 'LIKE', '%' . str_replace('+', '', $request->get('q')) . '%'),
    			User::where('email', 'LIKE', '%' . $request->get('q') . '%'),
    			User::where('ref_card', 'LIKE', '%' . $request->get('q') . '%')
    		];

    		$purchased = Purchased::where('user_id', 0);

    		foreach ($requests as $query) {
	    		foreach ($query->get() as $user) {
	    			$purchased->orWhere('user_id', $user->id);
	    		}
	    	}
    	} else {
            $purchased = Purchased::orderBy('id', 'desc');
        }

    	if ($request->get('sort')) {
            $method = $request->get('order') == 'asc' ? 'asc' : 'desc';

            switch ($request->get('sort')) {
                case 'created':
                    $purchased->orderBy('created_at', $method);
                    break;
                case 'payment':
                    $purchased->orderBy('next_payment', $method);
                    break;
                case 'user':
                    $purchased->orderBy('user_id', $method);
                    break;
                case 'tariff':
                    $purchased->orderBy('period', $method);
                    break;

                case 'amount':
                    $purchased->orderBy('amount', $method);
                    break;
            }
        }

    	return view('admin.active.index', ['purchased' => $purchased->paginate(15)]);
    }

    public function history (Request $request) {
        if ($request->has('q')) {
            $users = User::where('email', 'LIKE', '%' . $request->get('q') . '%')
                ->pluck('id')
                ->toArray();

            $historyList = DB::table('history')
                ->where('addit', 'LIKE', '%Сертификат%')
                ->whereIn('user_id', $users)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            $historyList = DB::table('history')
                ->where('addit', 'LIKE', '%Сертификат%')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

    	return view('admin.active.history', [
    	    'historyList' => $historyList
        ]);
    }

    function edit($id) {
        $purchased = Purchased::find($id);
        !$purchased ? abort(404) : null;
        $periods = [
            ["id" => 1, "name" => "Раз в неделю"],
            ["id" => 2, "name" => "Раз в месяц"],
            ["id" => 3, "name" => "Раз в 3 месяца"],
            ["id" => 4, "name" => "Раз в полгода"],
            ["id" => 5, "name" => "Раз в год"],
        ];

        return view('admin.active.edit')
            ->with("purchased", $purchased)
            ->with("periods", $periods);
    }

    function update(Request $request, $id) {
        $purchased = Purchased::find($id);
        !$purchased ? abort(404) : null;
        $purchased->period = $request->period;
        $purchased->save();

        return redirect ("/admin/active");
    }
}
