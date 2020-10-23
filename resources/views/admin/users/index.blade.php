@extends('admin.template')
@section('title', 'Пользователи')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Пользователи</h1>
<p class="mb-4">В данном разделе вы можете посмотреть список всех пользователей сайта, а также отредактировать каждого из них</p>
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
						<th>ID <a href="{{route('admin.users')}}?sort=id&order={{request()->order == 'asc' ? 'desc' : 'asc'}}" @if (request()->sort == 'id') class='text-success' @endif><i class="fas fa-sort"></i></a></th>
						<th>Дата рег.</th>
						<th>E-Mail</th>
						<th>Полное имя</th>
						<th>Ранг <a href="{{route('admin.users')}}?sort=rank&order={{request()->order == 'asc' ? 'desc' : 'asc'}}" @if (request()->sort == 'rank') class='text-success' @endif><i class="fas fa-sort"></i></a></th>
						<th>Телефон</th>
						<th>Баланс</th>
						<th>Страна</th>
						<th>Партнёров <a href="{{route('admin.users')}}?sort=partners&order={{request()->order == 'asc' ? 'desc' : 'asc'}}" @if (request()->sort == 'partners') class='text-success' @endif><i class="fas fa-sort"></i></a></th>
						<th>Оборот сети <a href="{{route('admin.users')}}?sort=volume&order={{request()->order == 'asc' ? 'desc' : 'asc'}}" @if (request()->sort == 'volume') class='text-success' @endif><i class="fas fa-sort"></i></a></th>
						<th>Покупок <a href="{{route('admin.users')}}?sort=purchase&order={{request()->order == 'asc' ? 'desc' : 'asc'}}" @if (request()->sort == 'purchase') class='text-success' @endif><i class="fas fa-sort"></i></a></th>
						<th>Действия</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
						<tr>
							<td @if($user->isnew) style="color: #ee2558" @endif><strong>{{$user->id}}</strong></td>
							<td><small>{{$user->created_at}}</small></td>
							<td><small>{{$user->email}}</small></td>
							<td><small>{{$user->last_name}} {{$user->first_name}} {{$user->middle_name}}</small></td>
							<td><small><strong>{{$user->getRank()['name']}}</strong></small></td>
							<td><small>{{$user->phone}}</small></td>
							<td class='text-success'><strong>{{$user->balance}}$</strong></td>
							<td><strong>{{$user->country_id != null ? DB::table('countries')->where('id', $user->country_id)->first()->country_name : ''}}</strong></td>
							<td>{{$user->total_partners}}</td>
							<td class='text-success'><strong>{{$user->referralVolume()}}$</strong></td>
							<td>{{$user->total_purchased}}</td>
							<td style="display: flex; align-items: center; height: 100px;">
								<a href="{{route('admin.users.referrals', $user->id)}}" class="btn btn-info btn-circle">
									<i class="fas fa-money-check-alt"></i>
								</a>

								<a href="{{route('admin.users.edit')}}?id={{$user->id}}" class="btn btn-warning btn-circle">
				                    <i class="fas fa-edit"></i>
				                </a>

				                <a href="{{route('admin.users.delete')}}?id={{$user->id}}" class="btn btn-danger btn-circle">
				                    <i class="fas fa-trash"></i>
				                </a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@if (request()->q)
			<div class='col-12'>
				<div class='row'>
					<a href="{{route('admin.users')}}"><button class='btn btn-primary'>Все пользователи</button></a>
				</div>
			</div>
		@endif
		{{$users->links()}}
	</div>
</div>
@stop