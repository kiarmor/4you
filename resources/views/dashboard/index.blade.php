@extends('layout.master')
@section('title', 'Рабочий стол')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/plugin.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}" />
<script src="//code.tidio.co/grcxatyzmiladnwgunujc8twvkalr9ju.js" async></script>
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card" style='margin: 0;'>
            <div class="header d-flex">
                <h2 class='pr-4'><strong>Ранг:</strong> {{$rank['name']}} ({{ round($rank['bonus'] * 100, 1) }}%)</h2>
                <h2><strong>До след. уровня:</strong> {{$nextRank['turnover'] - $invested}}$</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2">
            <div class="body">
                <h6>Инвестировано / Заработано</h6>
                <h5 style='margin: 0;'>{{$user->invested}}$ <small class="info">/</small> {{$user->earned}}$</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2">
            <div class="body">
                <h6>Прибыль от сети</h6>
                <h5 style='margin: 0;'>{{ $ref_earned }}$</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2">
            <div class="body">
                <h6>Оборот сети</h6>
				<h5 style='margin: 0;'>{{$user->referralVolume() }}$</h5>
                {{-- <h5 style='margin: 0;'>{{Auth::user()->volume() + Auth::user()->invested}}$</h5> --}}
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2">
            <div class="body">
                <h6>Команда</h6>
                <h5 style='margin: 0;'>{{$network}}</h5>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class='body row'>
                <div class='col-md-4'>
                    <div class='row justify-content-center'>
                        <h6 class='d-block w-100 text-center my-0'>Текущий ранг</h6>
                        <h4 class='text-success my-0' style='font-size: 18px;'><strong>{{$rank['name']}}</strong></h4>
                        <h5 class='w-100 text-center my-0'>{{$referralVolume}}$</h5>
                    </div>
                </div>
                <div class='col-md-8'>
                    <div class='row justify-content-center'>
                        <p class='my-0'>До следующего ранга — <span>{{$nextRank['turnover'] - $referralVolume}} USD</span></p>
                        <div class="progress" style='margin-top: 20px; height: 8px; width: 80%;'>
                            <div class="progress-bar l-blue" role="progressbar" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100" style="width: {{($invested/Auth::user()->nextRank()['turnover']) * 100}}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2 class='pr-4'><i class="zmdi zmdi-accounts-add"></i> <strong>Пригласить участника</strong></h2>
            </div>
            <div class='body row'>
                <div class='col-md-4'>
                    <div class='row justify-content-center'>
                        <h6>Ваша ссылка для приглашения</h6>
                        <p class='text-center mb-0'>Человек, зарегистрировавшийся по данной ссылке становится вашим рефералом 1-й линии</p>
                    </div>
                </div>
                <div class='col-md-8 d-flex align-items-center justify-content-center'>
                    <div class='row w-100'>
                        <div class='input-group'>
                            <input type='text' class='form-control' id="ref-input" value='{{url("/")}}/register?r={{ $user->id }}' readonly>
                            <button class="copy-ref input-group-addon btn btn-primary waves-effect waves-light" style='height: 100%; margin: 0; margin-left: -3px;'>Скопировать</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (Auth::user()->gifts > 0)
<div class="row clearfix">
    <div class="col-md-5">
        <div class="card">
            <form action="{{route('gifts.send')}}" method='POST' class='body row'>
                @csrf
                @if (count($errors))
                    <div class='input-group mt-3'>
                        <div class="alert alert-danger w-100 text-center" role="alert">
                            <strong>{{$errors->first()}}</strong>
                        </div>
                    </div>
                @endif
                @if(session()->has('message'))
                    <div class='input-group mt-3'>
                        <div class="alert alert-success w-100 text-center" role="alert">
                            <strong>{{ session()->get('message') }}</strong>
                        </div>
                    </div>
                @endif
                <div class='col-3 justify-content-center align-items-center d-flex'>
                    <p class='mb-0'><i class="zmdi zmdi-card-giftcard zmdi-hc-3x"></i></p>
                </div>
                <div class='col-9'>
                    <div class='row justify-content-center'>
                        <div class='col-12 text-center'><h6>Подарочные сертификаты на 50$</h6></div>
                        <div class='col-12'><p class='mb-2 text-success text-center'>Доступно: {{$user->gifts}}</p></div>
                        <small>Чтобы пригласить человека, введите его e-mail</small>
                    </div>
                </div>
                <div class='col-12 mt-3'>
                    <div class='input-group'>
                        <input type='text' name='email' placeholder='Электронная почта' class='form-control' id="ref-input" />
                        <button class="input-group-addon btn btn-primary waves-effect waves-light" style='margin: 0; margin-left: -3px;'>Отправить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@stop
@section('page-script')
<script src="{{asset('assets/bundles_new/jvectormap.bundle.js')}}"></script>
<script src="{{asset('assets/bundles_new/sparkline.bundle.js')}}"></script>
<script src="{{asset('assets/bundles_new/c3.bundle.js')}}"></script>
<script src="{{asset('assets/js_new/pages/index.js')}}"></script>

@stop
