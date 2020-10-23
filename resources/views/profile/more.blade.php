@extends('layout.master')
@section('title', 'Подробнее о реферале')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/css/table.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    <div class="col-12">
        <div class="card widget_2">
            <div class="body">
            	<div class='row'>
            		<div class='col-md-4'>
            			<p>ID участника: <strong>#<span class='text-success'>{{$referrer->id}}</span></strong></p>
            		</div>
            		<div class='col-md-4'>
            			<p>ФИО: <strong>@if ($referrer->fisrt_name || $referrer->last_name || $referrer->middle_name)
            								{{$referrer->last_name}} {{$referrer->first_name}} {{$referrer->middle_name}}
            							@else
            								-
            							@endif
            					</strong>
            			</p>
            		</div>
            		<div class='col-md-4'>
            			<p>Телефон: <strong>@if ($referrer->phone)
            									{{$referrer->phone}}
            								@else
            									-
            								@endif
            						</strong>
            			</p>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="card widget_2">
            <div class="body">
                <div class='row justify-content-center'>
                    <div class='col-12 mb-3'>
                        <h6>Основная информация</h6>
                    </div>

                    <div class='col-1 text-right'>
                        <p><i class="zmdi zmdi-star-half"></i></p>
                    </div>
                    <div class='col-5 text-left row'>
                        <p class='breadcrumb-item active'>Ранг</p>
                    </div>
                    <div class='col-6 text-right'>
                        <p><strong>{{$referrer->getRank()['name']}}</strong></p>
                    </div>

                    <div class='col-1 text-right'>
                        <p><i class="zmdi zmdi-card"></i></p>
                    </div>
                    <div class='col-5 text-left row'>
                        <p class='breadcrumb-item active'>Оборот сети</p>
                    </div>
                    <div class='col-6 text-right'>
						<p><strong class='text-success'>{{$referrer->total_volume}} USD</strong></p>
						{{-- <p><strong class='text-success'>{{$referrer->volume() + $referrer->invested}} USD</strong></p> --}}
                    </div>

                    <div class='col-1 text-right'>
                        <p><i class="zmdi zmdi-money"></i></p>
                    </div>
                    <div class='col-5 text-left row'>
                        <p class='breadcrumb-item active'>Инвестировано</p>
                    </div>
                    <div class='col-6 text-right'>
                        <p><strong class='text-success'>{{$referrer->invested}} USD</strong></p>
                    </div>

                    <div class='col-1 text-right'>
                        <p><i class="zmdi zmdi-calendar-note"></i></p>
                    </div>
                    <div class='col-5 text-left row'>
                        <p class='breadcrumb-item active'>Дата последней покупки</p>
                    </div>
                    <div class='col-6 text-right'>
                        <p><strong>{{App\Purchased::where('user_id', $referrer->id)->orderBy('id', 'desc')->first()['created_at']}}</strong></p>
                    </div>

                    <div class='col-1 text-right'>
                        <p><i class="zmdi zmdi-account"></i></p>
                    </div>
                    <div class='col-5 text-left row'>
                        <p class='breadcrumb-item active'>Рефералов первого уровня</p>
                    </div>
                    <div class='col-6 text-right'>
                        <p><strong>{{DB::table('users')->where('referrer_id', $referrer->id)->count()}}</strong></p>
                    </div>

                    <div class='col-1 text-right'>
                        <p><i class="zmdi zmdi-accounts"></i></p>
                    </div>
                    <div class='col-5 text-left row'>
                        <p class='breadcrumb-item active'>Всего рефералов</p>
                    </div>
                    <div class='col-6 text-right'>
                        <p><strong>{{$referrer->network()}}</strong></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card widget_2">
            <div class="body">
                <div class='row justify-content-center'>
                    <div class='col-12 mb-3'>
                        <h6>Глубина сети</h6>
                    </div>

                    <div class='table-responsive'>
                        <table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th scope='col'><small><strong>Уровень</strong></small></th>
                                    <th scope='col'><small><strong>Оборот сети, $</strong></small></th>
                                    <th scope='col'><small><strong>Заработано с сети за месяц, $</strong></small></th>
                                    <th scope='col'><small><strong>Заработано с сети за неделю, $</strong></small></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (App\User::where('referrer_id', $referrer->id)->get() as $referral)
                                    <tr>
                                        <th scope='row'>{{$referral->email}}</th>
                                        <td class='text-success'>{{$referral->volume()}}</td>
                                        <td class='text-success'>{{$referral->monthVolume()}}</td>
                                        <td class='text-success'>{{$referral->weeklyVolume()}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop