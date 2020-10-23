@extends('admin.template')
@section('title', 'Активные сертификаты - редактирование')
@section('content')

<h1 class="h3 mb-2 text-gray-800">Редактирование сертификата</h1>
<div class="card shadow">
	<div class="card-body">
		@if (count($errors))
            <div class='input-group mb-3'>
                <div class="alert alert-danger w-100 text-center" role="alert">
                    <strong>{{$errors->first()}}</strong>
                </div>
            </div>
        @endif

		<form enctype="multipart/form-data" class='col-12 col-md-6' method='POST' action="/admin/active/update/{{$purchased->id}}">
			@csrf
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Тариф</span>
				</div>
				<select name="period">
                    @foreach ($periods as $p)
                        <option value="{{$p['id']}}" @if ($purchased->period == $p['id']) selected @endif>{{$p['name']}}</option>
                    @endforeach
                </select>
			</div>
			<button type="submit" class='btn btn-primary mt-3'>Сохранить</button>
		</form>
	</div>
</div>
@stop
