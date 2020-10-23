@extends('layout.master')

@section('title', 'Трансфер')

@section('page-style')

<link rel="stylesheet" href="{{asset('assets/css/transfer.css')}}"/>

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

		<form method="POST" action="transfer" style="margin-bottom: 5%">

			@csrf

			<input type='hidden' name='sender-id' value='{{ Auth::id() }}' />

            <div class="col-md-6">
                <div class="form-group">
                    <label for="amount">Сумма</label>
                    <input type="text" id="amount" class="form-control" name="amount" value="0" placeholder="сумма">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="recipient-email">E-mail получателя</label>
                    <input type="text" id="recipient-email" name="recipient-email" class="form-control" placeholder="ввведите e-mail">
                </div>
            </div>

		    <button type="submit" class="btn btn-primary">Отправить</button>
		</form>

		@if (isset($transfers) && count($transfers))
			<div class="transfers">
				<div class="row clearfix">

					<div class='table-responsive table-sm table-bordered'>

						<table class='table'>

							<thead>

								<tr>

									<th scope='col'><small>Отправитель</small></th>

									<th scope='col'><small>Получатель</small></th>

									<th scope='col'><small>Сумма</small></th>

									<th scope='col'><small>Дата</small></th>

								</tr>

							</thead>

							<tbody>

								@foreach($transfers as $transfer)

									<tr>

										<th >{{$transfer->sender->email}}</th>

										<th >{{$transfer->recipient->email}}</th>

										@if (Auth::id() == $transfer->sender->id)
											<td><strong style="color: red">{{$transfer->amount}}</strong></td>
										@else
											<td><strong style="color: green">{{$transfer->amount}}</strong></td>
										@endif
										<td scope='row'><strong>{{$transfer->created_at}}</strong></td>


									</tr>

								@endforeach

							</tbody>

						</table>

					</div>

				</div>
			</div>
			@endif

	</div>

</div>

@stop

@section('page-script')

<script src="{{asset('assets/js_new/pages/transfer.js')}}"></script>

@stop
