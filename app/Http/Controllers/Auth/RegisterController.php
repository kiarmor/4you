<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Purchased;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $this->create($request->all());

        return redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'email.required' => 'Вы не указали свою электронную почту',
            'email.email' => 'Электронная почта указана в неверном формате',
            'email.max' => 'Электронная почта слишком длинная',
            'email.unique' => 'Данная электронная почта уже занята',
            'password.required' => 'Вы не указали пароль',
            'password.min' => 'Пароль не может быть меньше 8 символов',
            'repeat.required' => 'Пожалуйста, повторите пароль',
            'repeat.same' => 'Пароли не соответствуют друг-другу',
            'phone.required' => 'Укажите ваш телефон',
            'phone.min' => 'Номер телефона слишком короткий',
            'agreement.required' => 'Вы не согласны с условиями пользования',
            'referrer.required' => 'Вы должны обязательно указать вашего наставника',
            'referrer.exists' => 'Наставника с таким E-Mail не существует'
        ];
        return Validator::make($data, [
            'email' => ['required', 'email', 'max:64', 'unique:users'],
            'password' => ['required', 'min:8'],
            'repeat' => ['required', 'same:password'],
            'phone' => ['required', 'min:9'],
            'agreement' => ['required'],
            'referrer' => ['required', 'exists:users,email'],
            'invite' => []
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $referrer = $data['email'] != $data['referrer'] ? User::where('email', $data['referrer'])->first() : null;
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'referrer_id' => $referrer ? $referrer->id : null,
            //User::where('email', 'youapartaments@gmail.com')->first()->id,
            'email_key' => mt_rand(1000000000, 9999999999),
            'balance' => 0
        ]);
        if ($referrer) {
            $user->updatePartners();
        }
        if ($data['invite']) {
            $invite = DB::table('invites')->where('user_id', $referrer->id)->where('email',
                $data['email'])->where('activation_key', $data['invite'])->first();
            if ($invite && $referrer->gifts > 0) {
                $tariff = DB::table('tariff')->where('is_gift', 1)->first();
                $referrer->gifts--;
                $referrer->save();
                $carbon = Carbon::now();

                DB::table('history')->insert([
                    'user_id' => $user->id,
                    'amount' => 50,
                    'type' => 'gift',
                    'addit' => 'Пригласительный сертификат на 50$'
                ]);

                $user->total_purchased++;
                $user->save();
                Purchased::create([
                    'user_id' => $user->id,
                    'tariff_id' => $tariff->id,
                    'period' => 1,
                    'amount' => 50,
                    'next_payment' => Purchased::new_next(1, $carbon),
                    'active' => false
                ]);
            }
        }
        Mail::send(['text' => 'mail.registration'], ['user' => $user], function ($message) use ($user) {
            $message->to($user->email, 'To new user')->subject('Регистрация Apartments4you');
        });

        return $user;
    }
}
