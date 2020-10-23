<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request as Request;
use App\User;
use DB;

class GiftsController extends BaseController
{

    function index (Request $request) {
        if ($request->get('q')) {
            $users = User::where('email', 'LIKE', '%' . $request->get('q') . '%')->get();
            $gifts = DB::table('certificates')->where('user', 0);
            foreach ($users as $user) {
                $gifts->orWhere('user', $user->id);
            }
        } else {
            $gifts = DB::table('certificates');
        }

    	return view('admin.gifts.index', ['gifts' => $gifts->paginate(15)]);
    }

    function history () {
        $history = DB::table('gift_sending')->paginate(15);
        return view('admin.gifts.history', ['fullHistory' => $history]);
    }

    function edit (Request $request) {
    	$gift = DB::table('certificates')->where('id', $request->get('id'))->first();
    	return view('admin.gifts.edit', ['gift' => $gift]);
    }

    function delete (Request $request) {
    	DB::table('certificates')->where('id', $request->get('id'))->delete();
    	return redirect()->back();
    }

    function save (Request $request) {
        $messages = [
            'id.required' => 'Не был передан айди сертификата',
            'email.required' => 'Вы не указали E-Mail владельца',
            'email.exists' => 'Пользователя с таким E-Mail не найдено',
            'amount.required' => 'Вы не указали сумму подарочного сертификата',
            'amount.numeric' => 'Сумма должна являться числом',
            'tariff.required' => 'Вы не указали тариф подарочного сертификата',
            'tariff.exists' => 'Такого тарифа не существует. Проверьте ввод',
            'period.required' => 'Вы не указали период выплат'
        ];

        $validator = Validator::make($request->all(), [
            'id' => ['required'],
            'email' => ['required', 'exists:users'],
            'amount' => ['required', 'numeric'],
            'tariff' => ['required', 'exists:tariff,id'],
            'period' => ['required']
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else {
            $data = $validator->getData();
            $user = User::where('email', $data['email'])->first();
            $tariff = DB::table('tariff')->where('id', $data['tariff'])->first();
            if ($data['id'] == 'new') {
                DB::table('certificates')->insert([
                    'user' => $user->id,
                    'tariff' => $tariff->id,
                    'amount' => $data['amount'],
                    'period' => $data['period']
                ]);
            }
            else {
                DB::table('certificates')->where('id', $data['id'])->update([
                    'user' => $user->id,
                    'tariff' => $tariff->id,
                    'amount' => $data['amount'],
                    'period' => $data['period']
                ]);
            }
            return redirect(route('admin.gifts'));
        }
    }

}
