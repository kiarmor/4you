@extends('admin.template')
@section('title', 'Общение по тикету')

@section('content')
<link href='/assets/css/ticket.css?v=33' rel='stylesheet' />

<h1 class="h3 mb-2 text-gray-800">Тикет №{{ $ticket->id }}</h1>
<p>{{$ticket->topic}}</p>
<div class="card shadow">
	<form class="card-body" method='POST'>
		@if(session()->has('message'))
            <div class='input-group mt-3'>
                <div class="alert alert-success w-100 text-center" role="alert">
                    <strong>{{ session()->get('message') }}</strong>
                </div>
            </div>
        @endif
		@csrf
		<div class='col-12 col-md-8 ticket-dialog mb-3'>
            <div class='ticket-messages'>
                @foreach ($messages as $message)
                    <div class='{{ $message->sender != $ticket->user ? "ticket-message__sent ml-auto" : "ticket-message__received" }} col-12 col-md-6'>
                        <p class='ticket-message__sender mb-1'>{{ $message->sender == $ticket->user ? $user->email : "Администрация" }}</p>
                        <p class='ticket-message__content'>{{ $message->message }}</p>
                        @if ($message->attachment)
                            <img class='ticket-message__attachment' src='{{ asset("storage" . $message->attachment) }}' />
                        @endif
                        <p class='ticket-message__bottom mt-1'>{{ $message->created_at }}</p>
                    </div>
                @endforeach
            </div>
            <div class='row'>
                <div class="input-group ticket-bottom">
                    <textarea class="form-control" name="message" placeholder="Введите сообщение..."></textarea>
                    <div class="input-group-append">
                        <span class='input-group-text'>
                            <button class='btn btn-info btn-circle'><i class="fas fa-paper-plane"></i></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @if ($ticket->status == 1)
        	<a href='{{ route("admin.ticket.close", ["id" => $ticket->id]) }}' class='mt-5'><button type='button' class='btn btn-danger'>Закрыть тикет</button></a>
        @endif
	</form>
</div>
@stop

@section('scripts')
	<script src='/assets/js/ticket.js?v=3'></script>
@stop