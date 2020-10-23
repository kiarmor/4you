<?php

namespace App\Http\Controllers;

use App\Transfer;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TransferController extends BaseController
{
    function index(Request $request)
    {
        $transfers = Transfer::where('sender_id', Auth::id())->orWhere('recipient_id', Auth::id())->orderBy('id',
            'desc')->get();

        if (Auth::guest()) {
            return redirect()->guest('dashboard/index/');
        } else {
            if ($request->isMethod('post')) {
                $request->validate([
                    'recipient-email' => ['required', Rule::notIn([$request->user()->email])],
                    'amount' => 'required|numeric|gt:0'
                ], [
                    'required' => 'Заполните поле :attribute.',
                    'not_in' => 'Вы не можете отправить средства себе',
                    'gt' => [
                        'numeric' => 'Сумма должна быть больше :value.',
                    ],
                ]);

                $success = false;

                if (Auth::id() == $_POST['sender-id']) {
                    $sender = User::where('id', $_POST['sender-id'])->first();
                    $recipient = User::where('email', $_POST['recipient-email'])->first();
                    if ($recipient) {

                        $sender->balance = $sender->balance - $_POST['amount'];
                        if ($sender->balance >= 0) {

                            $recipient->balance = $recipient->balance + $_POST['amount'];

                            $sender->save();
                            $recipient->save();

                            $success = true;
                            $message = 'Перевод средств пользователю '.$_POST['recipient-email'].' был успешно выполнен, со счета снято '.$_POST['amount'].'$';

                            Transfer::create(array(
                                'id' => 1,
                                'sender_id' => $sender->id,
                                'recipient_id' => $recipient->id,
                                'amount' => $_POST['amount']
                            ));

                        } else {
                            $message = 'На вашем балансе недостаточно средств';
                        }

                    } else {
                        $message = 'Пользователя которому вы хотите перевести средства не существует';
                    }
                }

                return redirect()
                    ->back()
                    ->with('transfers', $transfers)
                    ->with('success', $success)
                    ->with('message', $message);

                //return view('transfer.transfer', ['transfers' => $transfers, 'success' => $success, 'message' => $message]);

            } else {
                return view('transfer.transfer', ['transfers' => $transfers]);
            }
        }
    }
}
