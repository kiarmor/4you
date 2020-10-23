@extends('layout.master')
@section('title', 'Ошибка платежа')
@section('content')
<div class="row clearfix">
	<div class='col-xl-4 col-lg-12'>
		<div class='card widget_2'>
			<div class='body'>
				<h5>Ошибка платежа</h5>
				<p>Не удалось провести платёж. Попробуйте сделать это ещё раз</p>
                <a href="{{ route('dashboard.index') }}"><button class='btn btn-primary'>НА ГЛАВНУЮ</button></a>
			</div>
		</div>
	</div>
</div>
@stop
