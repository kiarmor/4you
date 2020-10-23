@extends('admin.template')
@section('title', 'Тикеты')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Список тикетов</h1>
<div class="card shadow">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Тема обращения</th>
						<th>Пользователь</th>
						<th>Статус</th>
						<th>Действия</th>
					</tr>
				</thead>
				<tbody>
					@foreach($tickets as $ticket)
						@php ($user = \App\User::where('id', $ticket->user)->first())
						<tr>
							<td>{{ $ticket->topic }}</td>
							<td>{{ $user->email }}</td>
							<td class='{{ $ticket->status == 1 ? "text-success" : ""}}'>{{ $ticket->status == 1 ? 'Открыт' : 'Закрыт' }}</td>
							<td>
								<a href="{{ route('admin.ticket.more', ['id' => $ticket->id]) }}" class="btn btn-warning btn-circle">
				                    <i class="fas fa-edit"></i>
				                </a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{$tickets->links()}}
	</div>
</div>
@stop