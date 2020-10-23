@extends('admin.template')
@section('title', 'Группы')
@section('content')
<h1 class="h3 mb-2 text-gray-800">{{request()->get('id') == 'new' ? 'Создание' : 'Редактирование'}} сертификата</h1>
<div class="card shadow">
	<div class="card-body">
		@if (count($errors))
            <div class='input-group mb-3'>
                <div class="alert alert-danger w-100 text-center" role="alert">
                    <strong>{{$errors->first()}}</strong>
                </div>
            </div>
        @endif
		<form enctype="multipart/form-data" class='col-12 col-md-6' method='POST'>
			@csrf
			<input type='hidden' name='id' value="{{request()->get('id')}}" />
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Название</span>
				</div>
				<input type="text" name='name' class="form-control bg-light border-1 small" placeholder="Название сертификата" value="{{request()->get('id') == 'new' ? '' : $tariff->name}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Проценты в неделю</span>
				</div>
				<input type="text" name='period_1' class="form-control bg-light border-1 small" placeholder="N%" value="{{request()->get('id') == 'new' ? '' : $tariff->period_1}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Проценты в месяц</span>
				</div>
				<input type="text" name='period_2' class="form-control bg-light border-1 small" placeholder="N%" value="{{request()->get('id') == 'new' ? '' : $tariff->period_2}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Проценты в 3 месяца</span>
				</div>
				<input type="text" name='period_3' class="form-control bg-light border-1 small" placeholder="N%" value="{{request()->get('id') == 'new' ? '' : $tariff->period_3}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Проценты в полгода</span>
				</div>
				<input type="text" name='period_4' class="form-control bg-light border-1 small" placeholder="N%" value="{{request()->get('id') == 'new' ? '' : $tariff->period_4}}">
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon3">Проценты в год</span>
				</div>
				<input type="text" name='period_5' class="form-control bg-light border-1 small" placeholder="N%" value="{{request()->get('id') == 'new' ? '' : $tariff->period_5}}">
			</div>
			<h5 class='mt-1 mb-1'>Логотип сайта</h5>
			<div class="input-group d-block mb-4">
				<input type="file" name='image' class="form-control-file mt-3 border-0" placeholder="Логотип сайта">
			</div>
			<div class="form-check mb-3">
				<input type="checkbox" name='is_gift' class="form-check-input" id="is_gift" @if(request()->get('id') != 'new' && $tariff->is_gift) checked @endif>
				<label class="form-check-label" for="is_gift">Это подарочный сертификат</label>
			</div>
			<button class='btn btn-primary mt-3'>Сохранить</button>
		</form>
	</div>
</div>
@stop