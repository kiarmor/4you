@extends('admin.template')
@section('title', 'Группы')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Группы</h1>
<p class="mb-4">В данном разделе можно создавать и редактировать группы пользователей</p>
<div class="card shadow">
	<div class="card-body">
		<a href="{{route('admin.groups.edit')}}/?id=new" class="btn btn-success btn-icon-split mb-3">
			<span class="icon text-white-50">
				<i class="fas fa-layer-group"></i>
			</span>
			<span class="text">Создать группу</span>
		</a>
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>ID</th>
						<th>Название</th>
						<th>Действия</th>
					</tr>
				</thead>
				<tbody>
					@foreach($groups as $group)
						<tr>
							<td><strong>{{$group->id}}</strong></td>
							<td>{{$group->name}}</td>
							<td>
								<a href="{{route('admin.groups.edit')}}/?id={{$group->id}}" class="btn btn-warning btn-circle">
				                    <i class="fas fa-edit"></i>
				                </a>

				                <a href="{{route('admin.groups.delete')}}/?id={{$group->id}}" class="btn btn-danger btn-circle">
				                    <i class="fas fa-trash"></i>
				                </a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{$groups->links()}}
	</div>
</div>
@stop