@extends('layout.master')
@section('title', 'Создание тикета')

@section('page-style')
    <link href='/assets/css/ticket.css?v=2' rel='stylesheet' />
@stop

@section('content')
<div class='row clearfix'>
    <div class='col-12 card widget_2'>
        <div class='row'>
            <div class='col-12 col-md-6'>
                <form method='POST' enctype="multipart/form-data">
                    @csrf
                    <div class='body'>
                        <h5>Создание нового тикета</h5>
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
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="topic" placeholder="Тема обращения" />
                        </div>
                        <div class="input-group mb-3">
                            <textarea class="form-control" name="message" placeholder="Ваше сообщение"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="exampleFormControlFile1">Вложение (необязательно)</label>
                            <input type="file" class="form-control-file" name='attachment'>
                        </div>
                        <button class="btn btn-primary waves-effect waves-light">СОЗДАТЬ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop