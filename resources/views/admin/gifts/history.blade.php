@extends('admin.template')
@section('title', 'История подарков')
@section('content')
<h1 class="h3 mb-2 text-gray-800">История подарков</h1>
<p class="mb-4">В данном разделе можно посмотреть историю отправок подарочных сертификатов другим пользователям</p>
<div class="card shadow">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
                    <tr>
                        <th scope='col'><small><strong>ID</strong></small></th>
                    	<th scope='col'><small><strong>От</strong></small></th>
                        <th scope='col'><small><strong>Кому</strong></small></th>
                        <th scope='col'><small><strong>Сумма</strong></small></th>
                        <th scope='col'><small><strong>Активация</strong></small></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fullHistory as $history)
                        @php ($from = App\User::where('id', $history->user_id)->first())
                        <tr>
                            <th scope='row'>{{$history->activation_purchase ? $history->activation_purchase : '-'}}</th>
                        	<th>{{$from ? $from->email : 'Клиент удалён'}}</th>
                            <th>{{$history->destination}}</th>
                            <td>{{$history->amount}}$</td>
                            @if ($history->status)
                                <td class='text-success'>Активирован ({{$history->activation_date}})</td>
                            @else
                                <td class='text-danger'>Неактивирован</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
			</table>
		</div>
		{{$fullHistory->links()}}
	</div>
</div>
@stop