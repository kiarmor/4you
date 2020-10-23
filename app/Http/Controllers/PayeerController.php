<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\User;
use DB;

class PayeerController extends BaseController {
	
	function handler( Request $request ) {
		if (!in_array($_SERVER['REMOTE_ADDR'], array('185.71.65.92', '185.71.65.189','149.202.17.210'))) return;
		if( $request->has('m_operation_id') && $request->has('m_sign') ) {
			$m_key = 'qzT@hk34Q8EkYYw';
			$arHash = array(
				$request->m_operation_id,
				$request->m_operation_ps,
				$request->m_operation_date,
				$request->m_operation_pay_date,
				$request->m_shop,
				$request->m_orderid,				
				$request->m_amount,
				$request->m_curr,
				$request->m_desc,
				$request->m_status
			);
			if( $request->has('m_params') ) {
				$arHash[] = $request->m_params;
			}
			$arHash[] = $m_key;
			$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));
			if( $request->m_sign == $sign_hash && $request->m_status == 'success') {
				$user = User::where('id', $request->m_orderid)->first();
				if ($user) {
					DB::table('history')->insert([
						'user_id' => $user->id,
						'amount' => $request->m_amount,
						'type' => 'in',
						'addit' => 'Пополнение баланса'
					]);
					$user->balance += $request->m_amount;
					$user->save();
					return $request->m_orderid . '|success';
				}
			}
		}
		return $request->m_orderid . '|error';
	}
	
}