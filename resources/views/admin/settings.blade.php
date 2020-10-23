@extends('admin.template')
@section('title', 'Настройки сайта')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Настройки сайта</h1>
<p class="mb-4">Редактирование настроек сайта</p>
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
			<div class="input-group">
				<input type="text" name='name' class="form-control bg-light border-1 small" placeholder="Название сайта" value="{{config('app.name')}}">
			</div>
			<h5 class='mt-5 mb-0'>Логотип сайта</h5>
			<div class="input-group d-block">
				<input type="file" name='logo' class="form-control-file mt-3 border-0" placeholder="Логотип сайта">
			</div>
			<button class='btn btn-primary mt-3'>Сохранить</button>
		</form>
	</div>
</div>
@stop