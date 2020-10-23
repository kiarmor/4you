@extends('layout.master')
@section('title', 'Пополнение баланса')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
	<div class='col-xl-4 col-lg-12'>
	<form method="POST" action="{{route('payment.submit')}}" class="card widget_2">
		@csrf
		<div class='body'>
			<h5>Пополнение лицевого счёта</h5>
			@if (count($errors))
				<div class='input-group mt-3'>
					<div class="alert alert-danger w-100 text-center" role="alert">
						<strong>{{ $errors->first() }}</strong>
					</div>
				</div>
			@endif
			<div class="input-group mb-3">
				<input type="text" class="form-control" name="amount" placeholder="Сумма пополнения (USD)">
			</div>
			<div class="input-group mb-3">
				<select name="type" class="form-control">
					<option value="perfect_money">Perfect Money</option>
					<option value="payeer">Payeer</option>
				</select>
			</div>
			<input type='submit' class="btn btn-primary waves-effect waves-light" value='ПОПОЛНИТЬ' />
		</div>
	</form>
	{{-- OLD FORM
		<form action="https://perfectmoney.com/api/step1.asp" method="POST" class='card widget_2'>
            <!-- <input type="hidden" name="PAYEE_ACCOUNT" value="U21691378">
            <input type="hidden" name="PAYEE_NAME" value="Apartments4you">
            <input type="hidden" name="PAYMENT_UNITS" value="USD">
            <input type="hidden" name="STATUS_URL" 
                value="{{route('payment.handler')}}">
            <input type="hidden" name="PAYMENT_URL" 
                value="{{route('payment.success')}}">
            <input type="hidden" name="NOPAYMENT_URL" 
                value="{{route('payment.bad')}}">
            <input type="hidden" name="PAYMENT_ID" value="{{Auth::user()->id}}"> -->

            <input type="hidden" name="PAYEE_ACCOUNT" value="U21691378">
            <input type="hidden" name="PAYEE_NAME" value="Apartments4you">
            <input type="hidden" name="PAYMENT_ID" value="{{Auth::user()->id}}">
            <input type="hidden" name="PAYMENT_UNITS" value="USD">
            <input type="hidden" name="STATUS_URL" value="{{route('payment.handler')}}">
            <input type="hidden" name="PAYMENT_URL" value="{{route('payment.success')}}">
            <input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
            <input type="hidden" name="NOPAYMENT_URL" value="{{route('payment.bad')}}">
            <input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
            <input type="hidden" name="SUGGESTED_MEMO" value="">
            <input type="hidden" name="BAGGAGE_FIELDS" value="">

			<div class='body'>
				<h5>Пополнение лицевого счёта</h5>
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
                    <input type="text" class="form-control" name="PAYMENT_AMOUNT" placeholder="Сумма пополнения (USD)">
                </div>
                <input type='submit' class="btn btn-primary waves-effect waves-light" name='PAYMENT_METHOD' value='ПОПОЛНИТЬ' />
			</div>
		</form>
	--}}
	</div>
</div>
@stop
