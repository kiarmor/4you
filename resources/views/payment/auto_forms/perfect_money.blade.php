@extends('layout.master')
@section('title', 'Пополнение баланса')
@section('content')
<p>Сейчас вы будете перенаправлены на сайт PerfectMoney.</p>
<form action="https://perfectmoney.com/api/step1.asp" method="POST" id="payment_form">
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
	<input type="hidden" name="PAYMENT_AMOUNT" value="{{ $amount }}">
	<input type="hidden" name="PAYMENT_METHOD" value="ПОПОЛНИТЬ">			
	<button type="submit">Перейти</button>
</form>
<script type="text/javascript">
	document.querySelector('#payment_form').submit();
</script>
@endsection