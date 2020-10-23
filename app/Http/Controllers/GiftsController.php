<?php

namespace App\Http\Controllers;

use App\Http\Requests\Gifts\HandleRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\Purchased;
use DB;
use Mail;

class GiftsController extends BaseController
{
    function index (Request $request) {
        if ($request->get('q'))
            $gifts = DB::table('gift_sending')->where('user_id', Auth::user()->id)->where('destination', 'LIKE', '%' . $request->get('q') . '%');
        else
            $gifts = DB::table('gift_sending')->where('user_id', Auth::user()->id);
        return view('profile.gifts', ['fullHistory' => $gifts->get()]);
    }

    function handle(HandleRequest $request)
    {
        $data = $request->validated();
        if (array_key_exists('type', $data) && $data['type'] == 'pin') {
            if (!array_key_exists('pin', $data) || !$data['pin']) {
                return back()
                    ->withErrors(['Вы не указали пин-код. Повторите ввод и попробуйте ещё раз']);
            }

            $gift = DB::table('certificates')->where('pin', $data['pin'])->first();
            if ($gift) {
                $used = DB::table('gift_sending')->where([
                    ['destination', Auth::user()->email],
                    ['status', true]
                ])->first();

                if (!$used) {
                    $giftData = DB::table('gift_sending')->where([
                        ['gift_id', $gift->id],
                        ['destination', Auth::user()->email]
                    ])
                        ->first();

                    if (!$giftData) {
                        return back()
                            ->withErrors(['Подарок не найден']);
                    }

                    $tariff = DB::table('tariff')->where('id', $gift->tariff)->first();
                    $sender = User::where('id', $gift->user)->first();
                    Auth::user()->invested += $gift->amount;
                    Auth::user()->updateVolume($gift->amount);
                    Auth::user()->total_purchased++;
                    Auth::user()->save();
                    $carbon = Carbon::now();

                    DB::table('history')->insert([
                        'user_id' => Auth::user()->id,
                        'amount' => $gift->amount,
                        'type' => 'gift',
                        'addit' => 'Активация сертификата «' . $tariff->name . '» от ' . $sender->email
                    ]);

                    $purchase = Purchased::create([
                        'user_id' => Auth::user()->id,
                        'tariff_id' => $gift->tariff,
                        'period' => $gift->period,
                        'amount' => $gift->amount,
                        'next_payment' => Purchased::new_next($gift->period, $carbon)
                    ]);

                    DB::table('gift_sending')->where([
                        ['gift_id', $gift->id],
                        ['destination', Auth::user()->email]
                    ])
                        ->update([
                        'status' => true,
                        'activation_date' => Carbon::now(),
                        'activation_purchase' => $purchase->id
                    ]);


                    DB::table('certificates')->where('pin', $data['pin'])->delete();
                    return redirect()->back()->with('message', 'Подарочный сертификат успешно активирован!');
                } else {
                    return redirect()->back()->withErrors(['empty' => 'Вы уже активировали подарочный сертификат раннее']);
                }
            } else {
                return redirect()->back()->withErrors(['empty' => 'Пин-код не найден, попробуйте ещё раз']);
            }
        } else {
            if (!array_key_exists('email', $data)) {
                return back()
                    ->withErrors(['Вы не указали E-Mail. Повторите ввод и попробуйте ещё раз']);
            }

            $target = User::where('email', $data['email'])->first();
            if (!$target) {
                $gift = DB::table('certificates')->where('user', Auth::id())->first();
                if ($gift) {
                    $giftPin = substr(md5(mt_rand(10000000, 999999999)), 0, mt_rand(9, 14));
                    DB::table('certificates')->where('id', $gift->id)->update(['pin' => $giftPin]);

                    DB::table('gift_sending')->insert([
                        'gift_id'       => $gift->id,
                        'destination'   => $data['email'],
                        'user_id'       => Auth::user()->id,
                        'amount'        => $gift->amount,
                        'sended_at'     => Carbon::now()
                    ]);

                    Mail::send(['text' => 'mail.gift'], ['user' => Auth::user(), 'gift' => $giftPin], function($message) use ($data) {
                        $message->to($data['email'], 'To new user')->subject('Приглашение Apartments4you');
                    });
                    return redirect()->back()->with('message', 'Подарочный сертификат успешно отправлен');
                } else {
                    return redirect()->back()->withErrors(['empty' => 'Приглашение не найдено. Попробуйте ещё раз']);
                }
            } else {
                return redirect()->back()->withErrors(['empty' => 'Данный пользователь уже есть в системе']);
            }
        }
    }

    function send (Request $request) {
        $messages = [
            'email.required' => 'Вы не указали адрес электронной почты человека, которому хотите подарить сертификат',
            'email.email' => 'Адрес электронной почты указан в неверном формате. Попробуйте ещё раз',
            'email.unique' => 'Данный пользователь уже зарегистрирован',
        ];
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'unique:users'],
        ], $messages);

        if ($validator->fails())
            return redirect(route('dashboard.index'))
                        ->withErrors($validator)
                        ->withInput();
        else {
            $data = $validator->getData();

            if (Auth::user()->gifts > 0) {
                $activation_key = mt_rand(1000000, 9999999);
                DB::table('invites')->insert([
                    'user_id' => Auth::user()->id,
                    'activation_key' => $activation_key,
                    'email' => $data['email']
                ]);
                Mail::send(['text' => 'mail.invite'], ['user' => Auth::user(), 'key' => $activation_key], function($message) use ($data) {
                    $message->to($data['email'], 'To new user')->subject('Приглашение Apartments4you');
                });
                return redirect()->back()->with('message', 'Подарочный сертификат успешно отправлен');
            }
            else
                return redirect()->back();

            // $user = User::where('email', $data['email'])->first();
            // if(!$user->gift_activated && $user->id != Auth::user()->id && Auth::user()->gifts > 0) {
            //     Auth::user()->gifts--;
            //     Auth::user()->save();
            //     $user->gift_activated = true;
            //     $user->save();
            //     $special_tariff = DB::table('tariff')->where('is_gift', true)->first();
            //     $carbon = Carbon::now();
            //     Purchased::create([
            //         'user_id' => $user->id,
            //         'tariff_id' => $special_tariff->id,
            //         'period' => 1,
            //         'amount' => 1000,
            //         'next_payment' => Purchased::new_next(1, $carbon),
            //         'active' => false
            //     ]);
            //     return redirect()->back()->with('message', 'Подарочный сертификат успешно отправлен');
            // }
            // else
            //     return redirect()->back();
        }
    }
}
