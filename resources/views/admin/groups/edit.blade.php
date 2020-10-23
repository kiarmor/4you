@extends('admin.template')
@section('title', 'Группы')
@section('content')
<h1 class="h3 mb-2 text-gray-800">{{request()->get('id') == 'new' ? 'Создание' : 'Редактирование'}} группы</h1>
<div class="card shadow">
	<div class="card-body">
		@if (count($errors))
            <div class='input-group mb-3'>
                <div class="alert alert-danger w-100 text-center" role="alert">
                    <strong>{{$errors->first()}}</strong>
                </div>
            </div>
        @endif
		<form class='col-12 col-md-6' method='POST'>
			@csrf
			<input type='hidden' name='id' value="{{request()->get('id')}}" />
			<div class="input-group">
				<input type="text" name='name' class="form-control bg-light border-1 small" placeholder="Название группы" value="{{request()->get('id') == 'new' ? '' : $group->name}}">
			</div>
			<button class='btn btn-primary mt-3'>Сохранить</button>
		</form>
	</div>
</div>
@stop