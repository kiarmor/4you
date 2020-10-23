@extends('layout.master')
@section('title', 'Вывод средств')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
	<div class='col-xl-4 col-lg-12'>
		<form method='POST' class='card widget_2'>
            @csrf
			<div class='body'>
				<h5>Вывод средств</h5>
				@if (count($errors))
                    <div class='input-group mt-3'>
                        <div class="alert alert-danger w-100 text-center" role="alert">
                            <strong>{{$errors->first()}}</strong>
                        </div>
                    </div>
                @endif
				<div class="input-group mb-3">
                    <input type="text" class="form-control" name="amount" placeholder="Сумма вывода (USD)">
                </div>
                <input type='hidden' name='withdraw_type' name='requisites' />

                <p style="color: #ee2558">Для вывода средств, Вам необходимо в разделе <a href="{{ route('profile') }}">Настройки профиля</a>, ввести реквизиты Вашего кошелька</p>

                <button class="btn btn-primary waves-effect waves-light">ВЫВЕСТИ</button>
			</div>
		</form>
	</div>
</div>
@stop
