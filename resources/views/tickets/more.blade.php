@extends('layout.master')
@section('title', 'Диалог с администрацией')

@section('page-style')
    <link href='/assets/css/ticket.css?v=33' rel='stylesheet' />
@stop

@section('content')
<div class='row clearfix'>
    <form class='col-12 card widget_2' method='POST'>
        @csrf
        <h6>Тикет №{{ $ticket->id }} – {{ $ticket->topic }}</h6>
        <div class='row'>
            <div class='col-12 col-md-8 ticket-dialog'>
                <div class='ticket-messages'>
                    @foreach ($messages as $message)
                        <div class='{{ $message->sender == Auth::user()->id ? "ticket-message__sent ml-auto" : "ticket-message__received" }} col-12 col-md-6'>
                            <p class='ticket-message__sender mb-1'>{{ $message->sender == Auth::user()->id ? "Вы" : "Администрация" }}</p>
                            <p class='ticket-message__content'>{{ $message->message }}</p>
                            @if ($message->attachment)
                                <img class='ticket-message__attachment' src='{{ asset("storage" . $message->attachment) }}' />
                            @endif
                            <p class='ticket-message__bottom mt-1'>{{ $message->created_at }}</p>
                        </div>
                    @endforeach
                </div>
                @if ($ticket->status == 1)
                    <div class='row'>
                        <div class="input-group ticket-bottom">
                            <textarea class="form-control" name="message" placeholder="Введите сообщение..."></textarea>
                            <div class="input-group-append">
                                <span class='input-group-text'>
                                    <button class='btn btn-info btn-circle'><i class="zmdi zmdi-mail-send"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class='row w-100 d-flex justify-content-center bg-dark'>
                        <div class='ticket-bottom bg-dark w-100 py-2'>
                            <p class='text-center text-white'>Тикет закрыт.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>

@stop

@section('page-script')
    <script src='/assets/js_new/ticket.js?v=2'></script>
@stop