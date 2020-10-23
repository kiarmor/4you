@extends('layout.master')
@section('title', 'Мои выплаты')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/css/table.css')}}"/>
@stop

@section('content')
<div class="row clearfix">
	<div class="col-md-12">
        <div class="card widget_2">
            <div class="body">
                <div class='row justify-content-center'>
                	<div class='col-12 mb-3'>
                        <h6>Мои выплаты</h6>
                        <a href="{{route('history.export')}}" target='_blank'><button class='btn btn-primary' id='export'>ВЫГРУЗИТЬ</button></a>
                    </div>

					<div class='table-responsive table-bordered'>
						<table class='table table-striped' style='margin-bottom: 0;'>
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
					{{$fullHistory->links()}}
				</div>
			</div>
		</div>
	</div>
</div>
@stop