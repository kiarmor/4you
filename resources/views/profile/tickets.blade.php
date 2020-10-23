@extends('layout.master')
@section('title', 'Тикеты')

@section('page-style')
    <link href='/assets/css/ticket.css?v=2' rel='stylesheet' />
@stop

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card" style='margin: 0;'>
            <div class="header">
                <a href='{{ route("ticket.create") }}'><button class='btn btn-success'>Создать тикет</button></a>
            </div>
        </div>
    </div>
</div>

<div class='row clearfix'>
    <div class='col-12 col-md-6'>
        @if (count($tickets) > 0)
            @foreach ($tickets as $ticket)
                @php ($lastMessage = DB::table('messages')->where('ticket', $ticket->id)->latest()->first())
                <div class='col-12 ticket-row mb-3'>
                    <div class='row'>
                        <div class='col-2'>
                            <a href='{{ route("ticket.create") }}?id={{ $ticket->id }}'><button class='btn btn-info btn-circle'><i class="zmdi zmdi-eye"></i></button></a>
                        </div>
                        <div class='col-10 align-items-center d-flex'>
                            <p class='mb-0'>
                                <small>тема –</small> {{ mb_strlen($ticket->topic) > 25 ? mb_substr($ticket->topic, 0, 25) . '...' : $ticket->topic }}
                                <br>
                                <small class='text-secondary'>Посл. сообщение: {{ date('d.m.Y', strtotime($lastMessage->created_at)) }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>У вас нет ни 1-го тикета. Создайте ваш первый тикет с помощью кнопки "Создать тикет"</p>
        @endif
    </div>
</div>

@stop