<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use App\User;
use Mail;

class AuthenticationController extends BaseController
{
    public function check_login($view) {
        if (!Auth::guest())
            return redirect()->guest('dashboard/index/');
        else
            return view($view);
    }

    public function confirm(Request $request) {
        $user = User::where('email', $request->get('email'))->where('email_key', $request->get('k'))->first();
        if ($user) {
            $user->email_confirmed = true;
            $user->save();
            return redirect(route('login'))->with('message', 'Электронная почта успешно подтверждена!');
        }
        else
            return redirect(route('login'));
    }

    public function forgotSend(Request $request) {
        $messages = [
            'email.required' => 'Вы не указали E-Mail пользователя',
            'email.exists' => 'Пользователя с такой почтой не найдено. Попробуйте другую почту'
        ];
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'exists:users']
        ], $messages);

        if ($validator->fails())
            return redirect(route('authentication.forgot'))
                        ->withErrors($validator)
                        ->withInput();
        else {
            $data = $validator->getData();
            $user = User::where('email', $data['email'])->first();
            $user->reset_key = mt_rand(100000000, 999999999);
            $user->save();
            $mailArr = explode('@', $user->email);
            $hiddenSection = mb_substr($mailArr[0], mb_strlen($mailArr[0]) - 1, mb_strlen($mailArr[0]));

            Mail::send('mail.reset', ["user"=>$user], function($message) use ($user) {
                $message->to($user->email, $user->login)
                        ->subject('Восстановление пароля – Apartments4you');
                $message->from('apartments@denbro.ru');
            });

            return redirect(route('authentication.forgot'))->with('message', 'Сообщение с восстановлением пароля успешно отправлено на ' . str_repeat('*', mb_strlen($mailArr[0]) - 1) . $hiddenSection . '@' . $mailArr[1]);
        }
    }

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'qk' => ['required'],
            'from' => ['required', 'exists:users,email']
        ]);

        if (!$validator->fails()) {
            $data = $validator->getData();
            $user = User::where('email', $data['from'])->first();
            $key = md5($user->id . ':' . $user->email . '->' . $user->reset_key);
            if ($key == $data['qk'])
                return view('authentication.password');
        }
        return redirect('/');
    }

    public function completeReset(Request $request) {
        $messages = [
            'qk.required' => 'Переданы не все параметры. Попробуйте перейти по ссылке из письма ещё раз',
            'from.required' => 'Переданы не все параметры. Попробуйте перейти по ссылке из письма ещё раз',
            'from.exists' => 'Ссылка неактивна. Попробуйте восстановить пароль ещё раз',
            'password.required' => 'Укажите новый пароль, с помощью которого вы сможете получить доступ к аккаунту',
            'password.min' => 'Минимальная длина пароля – 8 символов. Попробуйте другой',
            'password.confirmed' => 'Пароли не совпадают. Проверьте ввод и попробуйте ещё раз'
        ];

        $validator = Validator::make($request->all(), [
            'qk' => ['required'],
            'from' => ['required', 'exists:users,email'],
            'password' => ['required', 'confirmed', 'min:8']
        ], $messages);

        if ($validator->fails())
            return redirect('/complete-reset')
                        ->withErrors($validator)
                        ->withInput();
        else {
            $data = $validator->getData();
            $user = User::where('email', $data['from'])->first();
            $key = md5($user->id . ':' . $user->email . '->' . $user->reset_key);
            if ($key == $data['qk']) {
                $user->password = Hash::make($data['password']);
                $user->reset_key = mt_rand(100, 999999999);
                $user->save();
                return redirect(route('login'))->with('message', 'Пароль успешно изменён! Попробуйте войти в аккаунт');
            }
        }
        return redirect('/complete-reset')->with('message', 'Произошла ошибка. Попробуйте восстановить пароль ещё раз');
    }

    function login() {
    	return $this->check_login('authentication.login');
    }

    function register(){
    	return $this->check_login('authentication.register');
    }

    function lockscreen(){
        return $this->check_login('authentication.lockscreen');
    }

    function forgot(){
    	return $this->check_login('authentication.forgot');
    }
    
    function page404(){
    	return $this->check_login('authentication.page404');
    }

    function page500(){
        return $this->check_login('authentication.page500');
    }

    function offline(){
    	return $this->check_login('authentication.offline');
    }
}
