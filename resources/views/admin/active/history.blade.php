@extends('admin.template')
@section('title', 'История начислений')
@section('content')
<h1 class="h3 mb-2 text-gray-800">История начислений</h1>
<p class="mb-4">История начислений по активным сертификатам</p>

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
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Дата начисления</th>
						<th>Пользователь</th>
						<th>Сумма</th>
						<th>Примечание</th>
					</tr>
				</thead>
				<tbody>
					@foreach($historyList as $history)
						@php ($user = App\User::where('id', $history->user_id)->first())
						@if ($user)
							<tr>
								<td><strong>{{$history->created_at}}</strong></td>
								<td>{{$user->email}}</td>
								<td class='text-success'><strong>{{$history->amount}}$</strong></td>
								<td>{{$history->addit}}</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
		</div>
		{{$historyList->links()}}
	</div>
</div>
@stop
