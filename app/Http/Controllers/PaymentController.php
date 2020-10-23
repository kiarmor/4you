<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use DB;

class PaymentController extends BaseController
{
    function index() {
    	return view('payment.payment');
    }

    function success() {
        return view('payment.success');
    }

    function bad() {
        return view('payment.bad');
    }
	
	function submit( Request $request ) {
		$v = Validator::make($request->all(), [
			'amount'	=> 'required|numeric',
			'type'		=> 'required|in:perfect_money,payeer'
		])->setAttributeNames([
			'type'		=> 'Метод пополнения',
			'amount'	=> 'Сумма'
		]);
		if( $v->fails() ) return back()->withErrors($v->errors());
		if( $request->type == 'perfect_money' ) {
			return view('payment.auto_forms.perfect_money', [
				'amount'	=> $request->amount
			]);
		}
		return view('payment.auto_forms.payeer', [
			'amount'	=> number_format($request->amount, 2, '.', '')
		]);
	}

    function handler(Request $request) {
        $secret = strtoupper( md5('Afsg34157PQvwkDZMUAMPRKXJ') );
        $hash = $request->input('PAYMENT_ID') . ':' . 
                $request->input('PAYEE_ACCOUNT') . ':' .
                $request->input('PAYMENT_AMOUNT') . ':' .
                $request->input('PAYMENT_UNITS') . ':' .
                $request->input('PAYMENT_BATCH_NUM') . ':' .
                $request->input('PAYER_ACCOUNT') . ':' .
                $secret . ':' . $request->input('TIMESTAMPGMT');
        $hash = strtoupper( md5($hash) );

        if ($hash == $request->input('V2_HASH')) {
            $user = User::where('id', $request->input('PAYMENT_ID'))->first();
            if ($user) {
                DB::table('history')->insert([
                    'user_id' => $user->id,
                    'amount' => $request->input('PAYMENT_AMOUNT'),
                    'type' => 'in',
                    'addit' => 'Пополнение баланса'
                ]);
                $user->balance += $request->input('PAYMENT_AMOUNT');
                $user->save();
                return 'ok';
            }
        }
        return 'error';
    }
}
