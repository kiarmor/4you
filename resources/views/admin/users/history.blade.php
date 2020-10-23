@extends('admin.template')
@section('title', 'История')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Просмотр истории</h1>
<p class="mb-4">История пользователя {{$user->email}}</p>
<div class="card shadow">
	<div class="card-body">
		@if (count($errors))
            <div class='input-group mb-3'>
                <div class="alert alert-danger w-100 text-center" role="alert">
                    <strong>{{$errors->first()}}</strong>
                </div>
            </div>
        @endif
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th scope='col'><small><strong>Дата</strong></small></th>
						<th scope='col'><small><strong>Тип</strong></small></th>
						<th scope='col'><small><strong>Сумма</strong></small></th>
						<th scope='col'><small><strong>Примечание</strong></small></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($fullHistory as $history)
					<tr>
	                    <th scope='row'>{{$history->created_at}}</th>
	                    <td>{{$history->type == 'in' ? 'Пополнение'
				                    						:  ($history->type == 'out' ? 'Вывод'
				                    						:  ($history->type == 'ref' ? 'Реферальное начисление'
				                    						:  ($history->type == 'gift' ? 'Подарок'
				                    						:  ($history->type == 'buy' ? 'Покупка' : '-'))))}}</td>
	                    <td class='text-success'>{{$history->amount}}$</td>
	                    <td>{{$history->addit}}</td>
	                </tr>
	                @endforeach
				</tbody>
			</table>
		</div>
		{{$fullHistory->appends(request()->input())->links()}}
	</div>
</div>
@stop