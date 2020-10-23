@extends('admin.template')
@section('title', 'Вывод средств')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Вывод средств</h1>
<p class="mb-4">В данном разделе вы можете посмотреть список активных заявок на вывод средств</p>
<form method='GET'>
	<div class="input-group mb-3 col-md-4">
		<input type="text" class="form-control" name="q" placeholder="Поиск (номер телефона, почта)" />
		<div class="input-group-append">
			<button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
		</div>
	</div>
</form>
<div class="card shadow">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Дата</th>
						<th>E-Mail</th>
						<th>Полное имя</th>
						<th>Ранг</th>
						<th>Сумма вывода</th>
						<th>Реквизиты (карта)</th>
						<th>Действия</th>
					</tr>
				</thead>
				<tbody>
					@foreach($withdraws as $withdraw)
						@php ($user = App\User::where('id', $withdraw->user_id)->first())
						<tr @if ($withdraw->status == 'reserved') style='background-color: #E6FFD8; ' @endif>
							<td>{{$withdraw->created_at}}</td>
							<td>{{$user->email}}</td>
							<td>{{$user->last_name}} {{$user->first_name}} {{$user->middle_name}}</td>
							<td><strong>{{$user->getRank()['name']}}</strong></td>
							<td class='text-success'><strong>{{$withdraw->amount}}$</strong></td>
							<td><strong>{{$withdraw->wallet}} (PerfectMoney)</strong></td>
							<td>
								@if ($withdraw->status == 'reserved')
									<a href="{{route('admin.withdraw.accept')}}?id={{$withdraw->id}}" class="btn btn-success btn-circle">
					                    <i class="fas fa-check"></i>
					                </a>

					                <a href="{{route('admin.withdraw.decline')}}?id={{$withdraw->id}}" class="btn btn-danger btn-circle">
					                    <i class="fas fa-trash"></i>
					                </a>

					                <a href="{{route('admin.users.history')}}?id={{$user->id}}" class='btn btn-secondary btn-circle'>
										<i class="fas fa-history"></i>
					                </a>
				                @else
				                	-
				                @endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{$withdraws->links()}}
	</div>
</div>
@stop