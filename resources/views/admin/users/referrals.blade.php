@extends('admin.template')
@section('title', 'Рефералы')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Рефералы пользователя {{ $user->email }}</h1>
<p class="mb-4">В данном разделе вы можете посмотреть список рефералов пользователя</p>

<div class="card shadow">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>ID</th>
						<th>E-Mail</th>
						<th>Полное имя</th>
						<th>Партнёров</th>
						<th>Оборот сети</th>
						<th>Покупок</th>
					</tr>
				</thead>
				<tbody>
					@foreach($user->referrals() as $ref)
						<tr>
							<td><strong>{{$ref->id}}</strong></td>
							<td><a href="{{ route('admin.users.referrals', $ref->id) }}">{{ $ref->email }}</a></td>
							<td><small>{{$ref->last_name}} {{$ref->first_name}} {{$ref->middle_name}}</small></td>
							<td>{{$ref->total_partners}}</td>
							<td class='text-success'><strong>{{$ref->referralVolume()}}$</strong></td>
							<td>{{$ref->total_purchased}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop