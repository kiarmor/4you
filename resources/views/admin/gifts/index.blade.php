@extends('admin.template')
@section('title', 'Подарочные сертификаты')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Подарочные сертификаты</h1>
<p class="mb-4">Список подарочных сертификатов, созданных администрацией проекта</p>
<form method='GET'>
	<div class="input-group mb-3 col-md-4">
		<input type="text" class="form-control" name="q" placeholder="Поиск (почта)" />
		<div class="input-group-append">
			<button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
		</div>
	</div>
</form>
<div class="card shadow">
	<div class="card-body">
		<a href="{{route('admin.gifts.edit')}}/?id=new" class="btn btn-success btn-icon-split mb-3">
			<span class="icon text-white-50">
				<i class="fas fa-layer-group"></i>
			</span>
			<span class="text">Создать сертификат</span>
		</a>
		<a href="{{route('admin.gifts.history')}}" class="btn btn-primary btn-icon-split mb-3">
			<span class="text">История</span>
		</a>
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>ID</th>
						<th>Сертификат</th>
						<th>Владелец</th>
						<th>Сумма</th>
						<th>Действия</th>
					</tr>
				</thead>
				<tbody>
					@foreach($gifts as $gift)
						<tr>
							@php ($tariff = DB::table('tariff')->where('id', $gift->tariff)->first())
							@php ($user = App\User::where('id', $gift->user)->first())
							<td><strong>{{$gift->id}}</strong></td>
							<td>{{$tariff->name}}</td>
							<td>{{$user->email}}</td>
							<td class='text-success'><strong>{{$gift->amount}}$</strong></td>
							<td>
								<a href="{{route('admin.gifts.edit')}}?id={{$gift->id}}" class="btn btn-warning btn-circle">
				                    <i class="fas fa-edit"></i>
				                </a>

				                <a href="{{route('admin.gifts.delete')}}?id={{$gift->id}}" class="btn btn-danger btn-circle">
				                    <i class="fas fa-trash"></i>
				                </a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{$gifts->links()}}
	</div>
</div>
@stop