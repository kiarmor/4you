<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Purchased;
use App\User;
use Carbon\Carbon;
use DB;

class TariffController extends BaseController
{
	function purchase (Request $request) {
		$messages = [
            'tariff.required' => 'Произошла ошибка при выборе тарифа. Попробуйте ещё раз',
            'tariff.integer' => 'Произошла ошибка при выборе тарифа. Попробуйте ещё раз',
            'tariff.exists' => 'Такой тариф не существует. Попробуйте выбрать другой',
            'amount.required' => 'Вы не указали сумму сделки',
            'amount.numeric' => 'Сумма сделки должны быть числом (в долларах)',
            'amount.min' => 'Сумма сделки не может быть меньше 50$',
            'amount.max' => 'Сумма не может быть больше 12.000$ или вашего баланса',
    		'period.required' => 'Вы не указали период выплаты средств',
    		'period.integer' => 'Произошла ошибка при выборе периода оплаты. Попробуйте ещё раз',
    		'period.between' => 'Произошла ошибка при выборе периода оплаты. Попробуйте ещё раз'
    	];
		$validator = Validator::make($request->all(), [
            'tariff' => ['required', 'integer', 'exists:tariff,id'],
            'amount' => ['required', 'numeric', 'min:50', 'max:' . (Auth::user()->balance > 12000 ? 12000 : Auth::user()->balance)],
            'period' => ['required', 'integer', 'min:1', 'max:5']
        ], $messages);

        if ($validator->fails())
            return redirect(route('tariff.index'))
                        ->withErrors($validator)
                        ->withInput();
        else {
        	$data = $validator->getData();
        	$tariff = DB::table('tariff')->where('id', $data['tariff'])->first();
        	Auth::user()->balance -= $data['amount'];
            Auth::user()->invested += $data['amount'];
            Auth::user()->total_purchased++;
			Auth::user()->total_volume += $data['amount'];
            #Auth::user()->updateVolume($data['amount']);
        	Auth::user()->save();
            $carbon = Carbon::now();

            DB::table('history')->insert([
                'user_id' => Auth::user()->id,
                'amount' => $data['amount'],
                'type' => 'buy',
                'addit' => 'Покупка тарифа «' . $tariff->name . '»'
            ]);

        	Purchased::create([
        		'user_id' => Auth::user()->id,
        		'tariff_id' => $tariff->id,
        		'period' => $data['period'],
        		'amount' => $data['amount'],
                'next_payment' => Purchased::new_next($data['period'], $carbon)
        	]);

            $ratio = 0;
            $referrer = User::where('id', Auth::user()->referrer_id)->first();
			if( $referrer ) {
				$referrer->update(['total_volume' => $referrer->total_volume + $data['amount']]);
			}
            while ($referrer) {
                $rank = $referrer->getRank();
                if ($rank['bonus'] >= $ratio) {
                    $referrerRatio = $rank['bonus'] - $ratio;
                    $ratio = $rank['bonus'];
                    $referrerBonus = $data['amount'] * $referrerRatio;
                    $referrer->balance += $referrerBonus;
                    $referrer->earned += $referrerBonus;
                    $referrer->ref_earned += $referrerBonus;
                    $referrer->save();
                    DB::table('history')->insert([
                        'user_id' => $referrer->id,
                        'amount' => $referrerBonus,
                        'type' => 'ref',
                        'addit' => 'Получено от реферрала: id ' . Auth::id()
                    ]);
                    if ($rank['turnover'] == User::maxTurnover())
                        break;
                }
                $referrer = User::where('id', $referrer->referrer_id)->first();
            }

        	return redirect()->back()->with('message', 'Вы успешно оплатили новый тариф. Подробности о действующих тарифах можно узнать во вкладке «Мои покупки»');
        }
	}

    function index(){
    	return view('tariff.index');
    }

    function my () {
	    $purchases = Purchased::where('user_id', Auth::user()->id)->where('active', true)->orderBy('id', 'desc')->get();
    	return view('tariff.my', [
    	    'purchases' => $purchases
        ]);
    }
}
