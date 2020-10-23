<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Withdraw;
use DB;

class WithdrawController extends BaseController
{
    private $method = [
        'card' => 'Карта',
        'qiwi' => 'QIWI Кошелёк',
        'payeer' => 'PAYEER',
        'yandex' => 'Яндекс.Деньги',
        'perfectmoney' => 'PerfectMoney'
    ];

    function index() {
    	return view('profile.payout');
    }

    function create(Request $request) {
        $messages = [
            'amount.required' => 'Вы не указали сумму вывода',
            'amount.numeric' => 'Сумма вывода введена в неверном формате',
            'amount.min' => 'Нельзя вывести меньше 1$',
            'amount.max' => 'На вашем балансе недостаточно средств'
        ];
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'min:1', 'max:' . Auth::user()->balance],
            'withdraw_type' => []
        ], $messages);

        if ($validator->fails())
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        else {
            if (Auth::user()->requisites != '' && Auth::user()->requisites != null) {
                $data = $validator->getData();
                $wallet = Auth::user()->requisites;
                $method = 'PerfectMoney';
                Withdraw::create([
                    'user_id' => Auth::user()->id,
                    'amount' => $data['amount'],
                    'wallet' => $wallet,
                    'method' => $method,
                    'status' => 'reserved'
                ]);
                Auth::user()->balance -= $data['amount'];
                Auth::user()->save();
                return redirect(route('profile'));
            }
            else
                return redirect(route('profile'))->withErrors(['У вас не указаны реквизиты для вывода денег.']);
        }
    }
}
