@extends('layout.master')
@section('title', 'Тарифы')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/css/tariff.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
	<div class='col-12 col-md-6 d-flex justify-content-center mx-auto'>
		<div class='row w-100 justify-content-center'>
			@if (count($errors))
                <div class="alert alert-danger w-100 text-center" role="alert">
                    <strong>{{$errors->first()}}</strong>
                </div>
            @endif
            @if (session()->has('message'))
            	<div class="alert alert-success w-100 text-center" role="alert">
                    <strong>{{session()->get('message')}}</strong>
                </div>
            @endif
		</div>
	</div>
	<div class='col-12'>
		<ul class="list-group flex-lg-row justify-content-center">
			@foreach (DB::table('tariff')->where('is_gift', false)->get() as $tariff)
				<li class='list-group-item tariff-card m-3 mx-auto mx-lg-3' data-tariff='{{$tariff->id}}'>
					<form method='POST' class='row justify-content-center'>
						@csrf
						<input type='hidden' name='tariff' value='{{$tariff->id}}' />
						<div class='col-12 text-center'>
							<img src="{{ asset('storage'.$tariff->image) }}" alt='Tariff' />
							<h6 class='my-4'>{{$tariff->name}}</h6>
						</div>
						<div class='col-5 mb-4 mb-lg-0 period-block'>
							<small>Сумма вклада</small>
							<div class="input-group">
								<span class="input-group-btn">
									<button type="button" class="btn btn-danger btn-number take-m" data-type="minus" data-field="amount" style='margin: 0; border-radius: 0; padding: 9.5px 8px;'>
										<i class="zmdi zmdi-minus"></i>
									</button>
								</span>
								<input type="text" name="amount" class="form-control input-number text-center input-moneys" value="0" min="0">
								<span class="input-group-btn">
									<button type="button" class="btn btn-success btn-number add-m" data-type="plus" data-field="amount" style='margin: 0; border-radius: 0; padding: 9.5px 8px;'>
										<i class="zmdi zmdi-plus"></i>
									</button>
								</span>
					      	</div>
						</div>
						<div class='col-12 col-lg-7 select-block'>
							<div class='input-group mb-3'>
			                	<select name="period" class="form-control period-change">
			               			<option value='1' data-rate='{{$tariff->period_1}}'>Раз в неделю</option>
			               			<option value='2' data-rate='{{$tariff->period_2}}'>Раз в месяц</option>
			               			<option value='3' data-rate='{{$tariff->period_3}}'>Раз в 3 месяца</option>
			               			<option value='4' data-rate='{{$tariff->period_4}}'>Раз в пол года</option>
			               			<option value='5' data-rate='{{$tariff->period_5}}'>Раз в год</option>
			               		</select>
			                </div>
			                <button class="btn btn-danger btn-block waves-effect waves-light">КУПИТЬ</button>
			                <p><span class='text-success rate'>+{{$tariff->period_1}}%</span> <span class='moneys'>{{$tariff->period_1 / 100 * 0}}$</span></p>
						</div>
					</form>
				</li>
			@endforeach
		</ul>
	</div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/js_new/pages/tariff.js')}}"></script>
@stop