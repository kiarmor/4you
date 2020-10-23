@extends('admin.template')
@section('title', 'Пользователь')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Редактирование пользователя</h1>
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
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Почта</span>
				</div>
				<input type="text" name='email' class="form-control bg-light border-1 small" placeholder="E-Mail" value="{{$user->email}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Имя</span>
				</div>
				<input type="text" name='first_name' class="form-control bg-light border-1 small" placeholder="Имя" value="{{$user->first_name}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Фамилия</span>
				</div>
				<input type="text" name='last_name' class="form-control bg-light border-1 small" placeholder="Фамилия" value="{{$user->last_name}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Отчество</span>
				</div>
				<input type="text" name='middle_name' class="form-control bg-light border-1 small" placeholder="Отчество" value="{{$user->middle_name}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Телефон</span>
				</div>
				<input type="text" name='phone' class="form-control bg-light border-1 small" placeholder="Телефон" value="{{$user->phone}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Баланс</span>
				</div>
				<input type="text" name='balance' class="form-control bg-light border-1 small" placeholder="Баланс" value="{{$user->balance}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Айди пригласившего</span>
				</div>
				<input type="text" name='referrer_id' class="form-control bg-light border-1 small" placeholder="Айди пригласившего" value="{{$user->referrer_id}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Номер карты</span>
				</div>
				<input type="text" name='ref_card' class="form-control bg-light border-1 small" placeholder="Номер карты" value="{{$user->ref_card}}">
			</div>
			<div class="input-group mb-3">
				<select name="group_id" class="form-control">
					<option value=''>-- Выберите группу --</option>
					@foreach (DB::table('groups')->get() as $group)
						<option value='{{$group->id}}' @if ($user->group_id == $group->id) selected @endif>{{$group->name}}</option>
					@endforeach
				</select>
			</div>
			<button class='btn btn-primary mt-3'>Сохранить</button>
			<a href="{{route('admin.users.history')}}?id={{$user->id}}"><button type='button' class='btn btn-secondary mt-3'>Просмотреть историю</button></a>
		</form>
	</div>
</div>
@stop