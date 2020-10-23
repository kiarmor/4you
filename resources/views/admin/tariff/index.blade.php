@extends('admin.template')
@section('title', 'Сертификаты')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Сертификаты</h1>
<p class="mb-4">В данном разделе вы просматривать, редактировать и создавать сертификаты</p>
<div class="card shadow">
	<div class="card-body">
		<a href="{{route('admin.tariff.edit')}}/?id=new" class="btn btn-success btn-icon-split mb-3">
			<span class="icon text-white-50">
				<i class="fas fa-layer-group"></i>
			</span>
			<span class="text">Создать сертификат</span>
		</a>
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Название</th>
						<th>Действия</th>
					</tr>
				</thead>
				<tbody>
					@foreach($tariffs as $tariff)
						<tr>
							<td><strong>{{$tariff->name}}</strong></td>
							<td>
								<a href="{{route('admin.tariff.edit')}}?id={{$tariff->id}}" class="btn btn-warning btn-circle">
				                    <i class="fas fa-edit"></i>
				                </a>

				                <a href="{{route('admin.tariff.delete')}}?id={{$tariff->id}}" class="btn btn-danger btn-circle">
				                    <i class="fas fa-trash"></i>
				                </a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{$tariffs->links()}}
	</div>
</div>
@stop