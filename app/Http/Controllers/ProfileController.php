<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Withdraw;
use DB;
use Mail;

class ProfileController extends BaseController
{
    private $withdraw_types = ['card', 'qiwi', 'payeer', 'yandex'];

	function profile () {
        $withdraws = Withdraw::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(15);
		return view('profile.settings', ['withdraws' => $withdraws]);
	}

    function password (Request $request) {
        //return $request->input('pin') . ' ' . Auth::user()->pin;
        if ($request->input('pin') == Auth::user()->pin && Auth::user()->pin != '') {
            $messages = [
                'old_password.required' => 'Вы не указали ваш старый пароль',
                'new_password.required' => 'Вы не указали новый пароль',
                'new_password.min' => 'Новый пароль не должен быть короче 8 символов',
                'new_password.confirmed' => 'Пароли не соответсвуют друг-другу'
            ];

            $validator = Validator::make($request->all(), [
                'old_password' => ['required', function ($attribute, $value, $fail) {
                        if (!\Hash::check($value, Auth::user()->password)) {
                            return $fail(__('Текущий пароль неверен'));
                        }
                    }],
                'new_password' => 'required|min:8|confirmed'
            ], $messages);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }
            else {
                Auth::user()->fill([
                    'password' => Hash::make($request->input('new_password')),
                    'pin' => ''
                ])->save();
                return redirect()->back()->with('message', 'Пароль успешно изменён!');
            }
        }
        else {
            return redirect()->back();
        }
    }

    function getpin () {
        $pin = mt_rand(100000, 999999);
        Auth::user()->pin = $pin;
        Auth::user()->save();

        Mail::send(['text' => 'mail.pin'], ['user' => Auth::user()], function($message) {
            $message->to(Auth::user()->email, 'Change password')->subject('Смена пароля Apartments4you');
        });

        return 'ok';
    }

	function update (Request $request)
    {
    	$messages = [
            'first_name.required' => 'Вы не указали своё имя',
            'last_name.required' => 'Вы не указали свою фамилию',
            'middle_name.required' => 'Вы не указали своё отчество',
            // 'ref_card.integer' => 'Номер карты должен быть численным',
            // 'ref_card.min' => 'Номер карты слишком короткий, попробуйте ещё раз',
    		// 'email.required' => 'Вы не указали свою электронную почту',
      //       'email.email' => 'Электронная почта указана в неверном формате',
      //       'email.max' => 'Электронная почта слишком длинная',
      //       'email.unique' => 'Данная электронная почта уже занята',
            'phone.required' => 'Укажите ваш телефон',
            'phone.min' => 'Номер телефона слишком короткий',
    	];
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'middle_name' => ['required'],
            //'ref_card' => ['integer', 'min:13'],
            'country' => [],
            // 'email' => ['required', 'email', 'max:64', 'unique:users,email,' . Auth::user()->id],
            'withdraw_type' => [],
            'requisites' => [],
            'phone' => ['required', 'min:9'],
        ], $messages);

        if ($validator->fails()) {
            return redirect(route('profile'))
                        ->withErrors($validator)
                        ->withInput();
        }
        else {
            $data = $validator->getData();
            $country = DB::table('countries')->where('country_code', $data['country'])->first();
            Auth::user()->email = $data['email'];
            Auth::user()->phone = $data['phone'];
            Auth::user()->first_name = $data['first_name'];
            Auth::user()->last_name = $data['last_name'];
            Auth::user()->middle_name = $data['middle_name'];
            //Auth::user()->ref_card = $data['ref_card'];
            Auth::user()->country_id = $country ? $country->id : null;
            // if (in_array($data['withdraw_type'], $this->withdraw_types))
            Auth::user()->withdraw_type = 'perfectmoney';
            Auth::user()->requisites = $data['requisites'];
            Auth::user()->save();
        	return redirect()->back()->with('message', 'Данные успешно обновлены!');
        }

        // Store the blog post...
    }

    function referrals () {
	    $user = User::where('id', Auth::id())->firstOrFail();
	    $referrals = User::where('referrer_id', $user->id)->get();
	    $rank = $user->getRank();



	    $weekly = 0;
	    $lastWeekly = 0;
	    foreach ($referrals as $referral) {
	        $lastWeekly = $this->lastWeekly($referral->id);
	        $lastWeekly = $lastWeekly * $rank['bonus'];

	        $weekly = $this->weekly($referral->id);
	        $weekly = $weekly * $rank['bonus'];
        }

        return view('profile.referrals')->with([
            'user'          => $user,
            'referrals'     => $referrals,
            'weekly'        => sprintf('%0.2f', $weekly),
            'lastWeekly'    => sprintf('%0.2f', $lastWeekly)
        ]);
    }

    function more ($id) {
        $user = User::where('id', $id)->where('referrer_id', Auth::user()->id)->first();
        if ($user)
            return view('profile.more', ['referrer' => $user]);
        else
            return redirect()->back();
    }

    function myProfile(){
    	return view('profile.my-profile');
    }

    function payments () {
        $fullHistory = DB::table('history')->where('user_id', Auth::user()->id)->paginate(15);
        return view('profile.my-payments', ['fullHistory' => $fullHistory]);
    }

    private function lastWeekly($user_id)
    {
        $start = Carbon::now()->startOfWeek()->subWeek();
        $end = Carbon::now()->endOfWeek()->subWeek();

        $histories = DB::table('history')
            ->where('user_id', $user_id)
            ->whereBetween('created_at', [$start->format('Y-m-d') . ' 00:00:00', $end->format('Y-m-d') . ' 23:59:59'])
            ->get();

        $amount = 0;
        foreach ($histories as $history) {
            $amount += $history->amount;
        }

        return $amount;
    }

    private function weekly($user_id)
    {
        $date = Carbon::now()->startOfWeek();
        $date = $date->format('Y-m-d') . ' 00:00:00';

        $histories = DB::table('history')
            ->where([
                ['user_id', $user_id],
                ['created_at', '>=', $date]
            ])
            ->get();

        $amount = 0;
        foreach ($histories as $history) {
            $amount += $history->amount;
        }

        return $amount;
    }
}
