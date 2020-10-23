<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\User;
use DB;

class UsersController extends BaseController
{
    function index(Request $request) {

        if ($request->get('q')) {
            $users = User::where('phone', 'LIKE', '%' . str_replace('+', '', $request->get('q')) . '%')
                ->orWhere('email', 'LIKE', '%' . $request->get('q') . '%');

        } else {
            $users = User::where('id', '>', 0);
        }


        if ($request->get('sort')) {

            $method = $request->get('order') == 'asc' ? 'asc' : 'desc';

            switch ($request->get('sort')) {

                case 'id':

                    $users->orderBy('id', $method);

                    break;

                case 'rank':

                    $users->orderBy('rank', $method);

                    break;

                case 'partners':

                    $users->orderBy('total_partners', $method);

                    break;

                case 'volume':

                    $users->orderBy('total_volume', $method);

                    break;

                case 'purchase':

                    $users->orderBy('total_purchased', $method);

                    break;
            }

        } else {
            $users->orderBy('created_at', 'desc');
        }

    	return view('admin.users.index', ['users' => $users->paginate(15)]);

    }



    function history(Request $request) {

        $user = User::where('id', $request->get('id'))->first();

        if ($user) {
            $fullHistory = DB::table('history')->where('user_id', $user->id)->paginate(15);

            return view('admin.users.history', ['user' => $user, 'fullHistory' => $fullHistory]);
        } else {
            return redirect()->back()->withErrors(['empty', 'Данный пользователь не найден.']);
        }
    }

    function edit (Request $request) {
    	$user = User::where('id', $request->get('id'))->first();

    	if ($user) {
            if ($user->isnew) {
                $user->isnew = false;
                $user->save();
            }

            return view('admin.users.edit', ['user' => $user]);
        } else {
            return redirect()->back();
        }
    }



    function save (Request $request) {

    	$user = User::where('id', $request->input('id'))->first();

    	$user->email = $request->input('email');

    	$user->phone = $request->input('phone');

    	$user->first_name = $request->input('first_name');

    	$user->last_name = $request->input('last_name');

    	$user->middle_name = $request->input('middle_name');

    	$user->ref_card = $request->input('ref_card');

    	$user->balance = $request->input('balance');

    	$user->group_id = $request->input('group_id');

    	$user->save();

    	return redirect()->back();

    }



    function delete (Request $request) {

    	$user = User::where('id', $request->get('id'))->first();

		if( $user->referrer_id ) {
			if( $ref = User::find($user->referrer_id) ) {
				$ref->update(['total_partners' => ($ref->total_partners - 1)]);
			}
		}

		$user->delete();
    	return redirect()->back();

    }

    public function referrals(User $user)
    {
        return view('admin.users.referrals')->with(compact('user'));
    }
}

