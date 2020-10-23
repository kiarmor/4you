@extends('layout.master')
@section('title', 'Моя сеть')
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card" style='margin: 0;'>
            <div class="header">
                <p><strong>Здесь</strong> вы можете получать информацию о структуре своей сети</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2">
            <div class="body">
                <h6>Количество рефералов</h6>
                <h5 class='text-blue m-0'>{{$user->network()}}</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2">
            <div class="body">
                <h6>Оборот сети</h6>
				<h5 class='m-0'>{{$user->referralVolume()}}$</h5>
                {{-- <h5 class='m-0'>{{Auth::user()->volume() + Auth::user()->invested}}$</h5> --}}
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2">
            <div class="body">
                <h6>За прошлую неделю</h6>
                <h5 class='text-blue m-0'>{{ $lastWeekly }}$</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2">
            <div class="body">
                <h6>За текущую неделю</h6>
                <h5 class='text-green m-0'>{{ $weekly }}$</h5>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    @foreach ($referrals as $referral)
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card widget_2">
            <div class="body">
                <div class='row'>
                    @if ($referral->first_name && $referral->last_name)
                        <div class='col-12'><strong class='text-blue'>{{$referral->first_name}} {{$referral->last_name}}</strong></div>
                    @else
                        <div class='col-12'><strong class='text-blue'>{{$referral->email}}</strong></div>
                    @endif
                    <div class='col-6'><small>Номер участника:</small></div>
                    <div class='col-6'><strong>{{$referral->id}}</strong></div>
                    <div class='col-6'><small>Ранг:</small></div>
                    <div class='col-6'><strong>{{$referral->getRank()['name']}}</strong></div>
                    <div class='col-6'><small>Участников:</small></div>
                    <div class='col-6'><strong>{{$referral->network()}}</strong></div>
                    <div class='col-12'><a href="{{route('profile.referrals')}}/{{$referral->id}}" class='mt-2 btn btn-primary btn-block'>Подробнее</a></div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@stop
