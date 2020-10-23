@extends('layout.master')
@section('title', 'Платёж проведён')
@section('content')
<div class="row clearfix">
	<div class='col-xl-4 col-lg-12'>
		<div class='card widget_2'>
			<div class='body'>
				<h5>Платёж проведён</h5>
				<p>Платёж успешно проведён – деньги зачислены на ваш счёт</p>
                <a href="{{ route('dashboard.index') }}"><button class='btn btn-primary'>НА ГЛАВНУЮ</button></a>
			</div>
		</div>
	</div>
</div>
@stop
