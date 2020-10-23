@extends('layout.master')
@section('title', 'Пополнение баланса')
@section('content')
<p>Сейчас вы будете перенаправлены на сайт Payeer.</p>
@php
	$m_shop = '1015313574';
	$m_desc = base64_encode('Пополнение баланса на сайте Apartments4you');	
	$m_curr = 'USD';
	$m_amount = $amount;
	$m_orderid = Auth::user()->id;
	$m_key = 'qzT@hk34Q8EkYYw';	
	$ma_key = 'qzT@hk34Q8EkYYw';
	$arHash = array(
		$m_shop,
		$m_orderid,
		$m_amount,
		$m_curr,
		$m_desc
	);
	$arParams = array(
		'success_url' => route('payment.success'),
		'fail_url' => route('payment.bad'),
		'status_url' => route('payeer.handler'),
	);	
	$key = md5($ma_key.$m_orderid);
	$m_params = @urlencode(base64_encode(openssl_encrypt(json_encode($arParams),'AES-256-CBC', $key, OPENSSL_RAW_DATA)));
	$arHash[] = $m_params;
	$arHash[] = $m_key;
	$sign = strtoupper(hash('sha256', implode(':', $arHash)));
@endphp
<form method="post" action="https://payeer.com/merchant/" id="payment_form">
<input type="hidden" name="m_shop" value="{{$m_shop}}">
<input type="hidden" name="m_orderid" value="{{$m_orderid}}">
<input type="hidden" name="m_amount" value="{{$amount}}">
<input type="hidden" name="m_curr" value="{{$m_curr}}">
<input type="hidden" name="m_desc" value="{{$m_desc}}">
<input type="hidden" name="m_sign" value="{{$sign}}">
<input type="hidden" name="m_params" value="{{$m_params}}">
<input type="hidden" name="m_cipher_method" value="AES-256-CBC">
<input type="hidden" name="m_process" value="send" />
<button type="submit">Перейти</button>
</form>
<script type="text/javascript">
	//document.querySelector('#payment_form').submit();
</script>
@endsection