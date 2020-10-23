@extends('layout.master')
@section('title', 'Подарочные сертификаты')
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
    
    <div class="col-lg-12">
        <div class="card" style='margin: 0;'>
            <div class="header">
                <p><strong>В данном</strong> разделе вы можете активировать или отправить подарочный сертификат другому пользователю</p>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2 class='pr-4'><i class="zmdi zmdi-key"></i> <strong>Активировать сертификат</strong></h2>
            </div>
            <form class='body row' method='POST'>
                @csrf
                <div class='col-md-4'>
                    <div class='row justify-content-center'>
                        <h6>Поле для ввода пин-кода</h6>
                        <p class='text-center mb-0'>Вы можете ввести пин-код, полученный от пригласителя, и получить подарочный сертификат</p>
                    </div>
                </div>
                <div class='col-md-8 d-flex align-items-center justify-content-center'>
                    <div class='row w-100'>
                        <div class='input-group'>
                            <input type='text' class='form-control' name='pin' value=''>
                            <button name='type' value='pin' class="input-group-addon btn btn-primary waves-effect waves-light" style='height: 100%; margin: 0; margin-left: -3px;'>Активировать</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <form class='card row' method='GET'>
            <div class="input-group mb-2 col-md-4">
                <input type="text" class="form-control" name="q" placeholder="Поиск (почта)" />
                <div class="input-group-append">
                    <button class="btn btn-primary my-0 mx-0" type="submit"><p class='my-0'><i class="zmdi zmdi-zoom-in"></i></p></button>
                </div> 
            </div>
        </form>
    </div>
</div>

<div class="row clearfix">
    @foreach (DB::table('certificates')->where('user', Auth::user()->id)->get() as $gift)
    <div class="col-lg-3 col-md-6 col-sm-12">
        <form class="card widget_2" method='POST'>
            @csrf
            <input type='hidden' name='id' value='{{$gift->id}}' />
            <div class="body">
                <div class='row'>
                    @php ($tariff = DB::table('tariff')->where('id', $gift->tariff)->first())
                    <div class='col-12'><strong class='text-blue'>{{$tariff->name}}</strong></div>
                    <div class='col-6'><small>На сумму:</small></div>
                    <div class='col-6'><strong class='text-success'>{{$gift->amount}}$</strong></div>
                    <div class='col-6'><small>Период:</small></div>
                    <div class='col-6'><strong>{{App\Purchased::get_period($gift->period)}}</strong></div>
                    <div class='col-12 d-flex justify-content-center mt-1'>
                        <div class='row w-100'>
                            <div class='input-group'>
                                <input type='text' class='form-control' name='email' placeholder='E-Mail' value=''>
                            </div>
                        </div>
                    </div>
                    <div class='col-12'><button name='type' value='gift' class='mt-2 btn btn-primary btn-block'>Отправить</button></div>
                </div>
            </div>
        </form>
    </div>
    @endforeach

    @if ($fullHistory->count() > 0)
        <div class='table-responsive table-bordered'>
            <table class='table table-striped' style='margin-bottom: 0;'>
                <thead>
                    <tr>
                        <th scope='col'><small><strong>ID</strong></small></th>
                        <th scope='col'><small><strong>Кому</strong></small></th>
                        <th scope='col'><small><strong>Сумма</strong></small></th>
                        <th scope='col'><small><strong>Активация</strong></small></th>
                        <th scope='col'><small><strong>Дата создания</strong></small></th>
                        <th scope='col'><small><strong>Дата отправки</strong></small></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fullHistory as $history)
                    <tr>
                        <th>{{ $history->id }}</th>
                        <th scope='row'>{{$history->destination}}</th>
                        <td>{{$history->amount}}$</td>
                        @if ($history->status)
                            <td class='text-success'>Активирован ({{$history->activation_date}})</td>
                        @else
                            <td class='text-danger'>Неактивирован</td>
                        @endif
                        <td>{{$history->created_at}}</td>
                        @if ($history->sended_at)
                            <td>{{ $history->sended_at }}</td>
                        @else
                            <td class='text-danger'>Не отправлен</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@stop