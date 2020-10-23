@extends('admin.template')
@section('title', 'Редактирование сертификата')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Редактирование подарочного сертификата</h1>
<div class="card shadow">
	<div class="card-body">
		@if (count($errors))
            <div class='input-group mb-3'>
                <div class="alert alert-danger w-100 text-center" role="alert">
                    <strong>{{$errors->first()}}</strong>
                </div>
            </div>
        @endif
		<form class='col-12 col-md-6' method='POST'>
			@if (request()->get('id') != 'new')
				@php ($user = App\User::where('id', $gift->user)->first())
				@php ($tariff = DB::table('tariff')->where('id', $gift->tariff)->first())
			@endif
			@csrf
			<input type='hidden' name='id' value="{{request()->get('id')}}" />
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">E-Mail владельца</span>
				</div>
				<input type="text" name='email' class="form-control bg-light border-1 small" placeholder="E-Mail" value="{{request()->get('id') != 'new' ? $user->email : ''}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Сумма</span>
				</div>
				<input type="text" name='amount' class="form-control bg-light border-1 small" placeholder="Сумма ($)" value="{{request()->get('id') != 'new' ? $gift->amount : ''}}">
			</div>
			<div class="input-group mb-3">
				<select name="tariff" class="form-control">
					<option value=''>-- Выберите тариф --</option>
					@foreach (DB::table('tariff')->get() as $cTariff)
						<option value='{{$cTariff->id}}' @if (request()->get('id') != 'new' && $cTariff->id == $tariff->id) selected @endif>{{$cTariff->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="input-group mb-3">
				<select name="period" class="form-control">
					<option value=''>-- Выберите период --</option>
					<option value='1' @if (request()->get('id') != 'new' && $gift->period == 1) selected @endif>1 неделя</option>
					<option value='2' @if (request()->get('id') != 'new' && $gift->period == 2) selected @endif>1 месяц</option>
					<option value='3' @if (request()->get('id') != 'new' && $gift->period == 3) selected @endif>3 месяца</option>
					<option value='4' @if (request()->get('id') != 'new' && $gift->period == 4) selected @endif>1/2 года</option>
					<option value='5' @if (request()->get('id') != 'new' && $gift->period == 5) selected @endif>1 год</option>
				</select>
			</div>
			<button class='btn btn-primary mt-3'>Сохранить</button>
		</form>
	</div>
</div>
@stop