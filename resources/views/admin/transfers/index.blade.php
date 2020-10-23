@extends('admin.template')
@section('title', 'Переводы')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Переводы</h1>
<form method='GET'>
	<div class="input-group mb-3 col-md-4">
		<input type="text" class="form-control" name="q" placeholder="Поиск (почта)" value="{{request()->q}}"/>
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
						<th>Отправитель</th>
						<th>Получатель</th>
						<th>
							<a href="{{route('admin.transfers')}}?sort=amount&order={{request()->order == 'asc' ? 'desc' : 'asc'}}" @if (request()->sort == 'amount') class='text-success' @endif><i class="fas fa-sort"></i></a>
							Сумма
						</th>
						<th>
							<a href="{{route('admin.transfers')}}?sort=date&order={{request()->order == 'asc' ? 'desc' : 'asc'}}" @if (request()->sort == 'date') class='text-success' @endif><i class="fas fa-sort"></i></a>
							Дата
						</th>
					</tr>
				</thead>
				<tbody>
				@foreach( $transfers as $transfer )
					<tr>
						<td><a href="{{route('admin.users.edit')}}?id={{$transfer->sender->id}}">{{$transfer->sender->email}}</a></td>
						<td><a href="{{route('admin.users.edit')}}?id={{$transfer->recipient->id}}">{{$transfer->recipient->email}}</a></td>
						<td class='text-success'>{{$transfer->amount}}$</td>
						<td>{{$transfer->created_at}}</td>
					</tr>
				@endforeach
				</tbody>
			</table>	
		</div>
		{{ $transfers->appends(request()->all())->links() }}
	</div>
</div>
@endsection