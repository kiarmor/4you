@extends('layout.master')
@section('title', 'Мои покупки')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/css/table.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
	<div class='table-responsive table-sm table-bordered'>
		<table class='table'>
			<thead>
				<tr>
					<th scope='col'><small>Дата покупки</small></th>
					<th scope='col'><small>Сертификат</small></th>
					<th scope='col'><small>Конец выплат</small></th>
					<th scope='col'><small>Период выплат</small></th>
					<th scope='col'><small>Сумма</small></th>
					<th scope='col'><small>%</small></th>
					<th scope='col'><small>Доход/нед.</small></th>
					<th scope='col'><small>След. выплата</small></th>
				</tr>
			</thead>
			<tbody>
				@foreach($purchases as $purchase)
					<tr>
						@php ($tariff = $purchase->get_tariff())
						<th scope='row'>{{$purchase->created_at}}</th>
						<td><strong>{{$tariff->name}}</strong></td>
						<td><strong>{{$purchase->created_at->addWeeks(52)}}</strong></td>
						<td><strong>{{$purchase->tariff_period()}}</strong></td>
						<td><strong class='text-success'>${{$purchase->amount}}</strong></td>
						<td><strong>{{$purchase->tariff_rate($tariff)}}</strong></td>
						<td><strong class='text-success'>${{round($purchase->amount * ($purchase->tariff_rate($tariff) / 100 / 52), 2)}}</strong></td>
						<td><strong>{{$purchase->next_payment}}</strong></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop
