@extends('layout.master')
@section('title', 'Мой профиль')
@section('content')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
<div class="row clearfix">
	<div class='col-xl-4 col-lg-12'>
		<form action="{{ route('profile.update') }}" method='POST' class='card widget_2'>
			@csrf
			<div class='body'>
				<h5>Настройки профиля</h5>
				@if (count($errors))
                    <div class='input-group mt-3'>
                        <div class="alert alert-danger w-100 text-center" role="alert">
                            <strong>{{$errors->first()}}</strong>
                        </div>
                    </div>
                @endif
                @if(session()->has('message'))
	                <div class='input-group mt-3'>
					    <div class="alert alert-success w-100 text-center" role="alert">
					        <strong>{{ session()->get('message') }}</strong>
					    </div>
					</div>
				@endif
				<div class="input-group mb-3">
                    <input type="text" class="form-control" name="last_name" placeholder="Фамилия" value='{{ Auth::user()->last_name }}'>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="first_name" placeholder="Имя" value='{{ Auth::user()->first_name }}'>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="middle_name" placeholder="Отчество" value='{{ Auth::user()->middle_name }}'>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="phone" placeholder="Телефон" value='{{ Auth::user()->phone }}' required>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-smartphone-iphone"></i></span>
                    </div>
                </div>
                <div class='input-group mb-3'>
                	@include('widgets.countries')
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="email" placeholder="E-Mail" value='{{ Auth::user()->email }}' required readonly>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="requisites" placeholder="PerfectMoney" value='{{ Auth::user()->requisites }}'>
                </div>
                <!-- <div class='row'>
                    <div class='col-md-4'>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="ref_card" placeholder="Карта" value='{{ Auth::user()->ref_card }}'>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="requisites" placeholder="Реквизиты" value='{{ Auth::user()->requisites }}'>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class="input-group mb-3">
                            <select name="withdraw_type" class="form-control">
                                <option value='qiwi' @if (Auth::user()->withdraw_type == 'qiwi') selected @endif>QIWI</option>
                                <option value='payeer' @if (Auth::user()->withdraw_type == 'payeer') selected @endif>PAYEER</option>
                                <option value='yandex' @if (Auth::user()->withdraw_type == 'yandex') selected @endif>Яндекс.Деньги</option>
                            </select>
                        </div>
                    </div>
                </div> -->
                <button class="btn btn-primary waves-effect waves-light">СОХРАНИТЬ</button>
			</div>
		</form>
	</div>

    <div class='col-xl-6 col-lg-12'>
        <div class='row'>
            <div class='col-12'>
                <div class='card widget_2'>
                    <div class='body'>
                        <h5 class='mb-1'>Вывод средств</h5>
                        <p class='mb-1'>Здесь вы можете посмотреть статус своих платежей, а также оформить новую выплату</p>
                        <a href="{{ route('payout.new') }}"><button class='btn btn-primary'>ВЫВЕСТИ</button></a>
                        <p style="color: #ee2558">Для вывода средств, Вам необходимо в разделе <a href="{{ route('profile') }}">Настройки профиля</a>, ввести реквизиты Вашего кошелька</p>
                    @if (count($withdraws) > 0)
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Дата</th>
                                            <th>Сумма</th>
                                            <th>Статус</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($withdraws as $withdraw)
                                            <tr>
                                                <td>{{$withdraw->created_at}}</td>
                                                <td class='text-success'><strong>{{$withdraw->amount}}$</strong></td>
                                                <td class='{{$withdraw->statusClass()}}'>{{$withdraw->getStatus()}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{$withdraws->links()}}
                        @else
                            <h6 class='mt-3 mb-0 text-warning text-center'>Платежи отсутствуют</h6>
                        @endif
                    </div>
                </div>
            </div>

            <div class='col-12'>
                <form action="{{route('profile.change.password')}}" method='POST' class='card widget_2'>
                    @csrf
                    <div class='body'>
                        <h5 class='mb-1'>Смена пароля</h5>
                        <p class='mb-3'>Укажите все данные и подтвердите смену с помощью пин-кода</p>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="old_password" placeholder='Старый пароль' required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="new_password" placeholder='Новый пароль' required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="new_password_confirmation" placeholder='Повторите пароль' required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="pin" placeholder='Пин-код' required>
                            <div class="input-group-append">
                                <button type='button' id='getpin' data-csrf='{{csrf_token()}}' class='btn btn-info h-100 my-0'>Получить</button>
                            </div>
                        </div>
                        <button class='btn btn-primary'>ПОДТВЕРДИТЬ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('page-script')
<script src="{{asset('assets/js_new/pages/pass.js')}}"></script>
@stop
