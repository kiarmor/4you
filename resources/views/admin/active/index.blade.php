@extends('admin.template')
@section('title', 'Активные сертификаты')
@section('content')

<h1 class="h3 mb-2 text-gray-800">Активные сертификаты</h1>
<p class="mb-4">В данном разделе вы можете посмотреть сертификаты, купленные другими пользователями</p>
<form method='GET'>
	<div class="input-group mb-3 col-md-4">
		<input type="text" class="form-control" name="q" placeholder="Поиск (номер, почта, реквизиты)" />
		<div class="input-group-append">
			<button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
		</div>
		<a href="{{route('admin.active.history')}}" class='btn btn-primary ml-3'>История начислений</a>
	</div>
</form>

<div class="card shadow">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Дата покупки <a href="{{route('admin.active')}}?sort=created&order={{request()->order == 'asc' ? 'desc' : 'asc'}}" @if (request()->sort == 'created') class='text-success' @endif><i class="fas fa-sort"></i></a></th>
						<th>Дата выплаты <a href="{{route('admin.active')}}?sort=payment&order={{request()->order == 'asc' ? 'desc' : 'asc'}}" @if (request()->sort == 'payment') class='text-success' @endif><i class="fas fa-sort"></i></a></th>
						<th>Пользователь <a href="{{route('admin.active')}}?sort=user&order={{request()->order == 'asc' ? 'desc' : 'asc'}}" @if (request()->sort == 'user') class='text-success' @endif><i class="fas fa-sort"></i></a></th>
						<th>Тарифы <a href="{{route('admin.active')}}?sort=tariff&order={{request()->order == 'asc' ? 'desc' : 'asc'}}" @if (request()->sort == 'tariff') class='text-success' @endif><i class="fas fa-sort"></i></a></th>
						<th>Полное имя</th>
						<th>Сумма покупки <a href="{{route('admin.active')}}?sort=amount&order={{request()->order == 'asc' ? 'desc' : 'asc'}}" @if (request()->sort == 'amount') class='text-success' @endif><i class="fas fa-sort"></i></a></th>
						<th>Телефон</th>
						<th>Сумма выплаты</th>
						<th>Реквизиты</th>
						<th>Действия</th>
					</tr>
				</thead>

				<tbody>
					@foreach($purchased as $purchase)
                        <tr>
                            <td><strong>{{$purchase->created_at}}</strong></td>
                            <td><strong>{{$purchase->next_payment}}</strong></td>
                            <td>{{$purchase->user->email}}</td>
                            <td>{{$purchase->tariff_period()}}</td>
                            <td>{{$purchase->user->last_name}} {{$purchase->user->first_name}} {{$purchase->user->middle_name}}</td>
                            <td class='text-success'><b>{{$purchase->amount}}$</b></td>
                            <td>{{$purchase->user->phone}}</td>
                            <td class='text-success'><strong>{{round($purchase->amount * ($purchase->tariff_rate($purchase->tariff) / 100 / 52) * $purchase->get_weeks(), 2)}}$</strong></td>
                            <td><strong>{{$purchase->user->ref_card}}</strong></td>
                            <td>
                                <a href="/admin/active/edit/{{$purchase->id}}" class="btn btn-warning btn-circle"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{$purchased->links()}}
	</div>
</div>
@stop
