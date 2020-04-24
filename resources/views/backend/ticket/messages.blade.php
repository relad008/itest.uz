@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            {{ $ticket->theme }}
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <p>
                        <span class="text-muted">
                            <i class="fa fa-clock-o"></i> Последнее сообщение:
                        </span><br/> {{ $last_message ? $last_message->created_at->format('d-m-Y H:i:s') : '' }}
                    </p>
                    <span>
                        <span class="text-muted">
                            <i class="fa fa-clock-o"></i> Дата создания:
                        </span><br/> {{ $ticket->created_at->format('d-m-Y H:i:s') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="row chat-window" id="chat_window_1">
                <div class="col-xs-12 col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading top-bar">
                            <div class="col-md-8 col-xs-8">
                                <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat - {{ $ticket->user->name ?? 'Deleted' }}</h3>
                            </div>
                        </div>
                        <div class="panel-body msg_container_base">
                            @foreach($messages as $message)
                            <div class="row msg_container {{ $message->user_id == $user->id ? 'base_sent' : 'base_receive' }}">
                                <div class="col-md-10 col-xs-10">
                                    <div class="messages {{ $message->user_id == $user->id ? 'msg_sent' : 'msg_receive' }}">
                                        <b>{{ $message->user->name ?? '' }}</b><br/>
                                        <p>{{ $message->message }}</p>
                                        <time datetime="{{ $message->created_at }}">{{ Carbon\Carbon::now()->diffForHumans($message->created_at) }}</time>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                        <div class="panel-footer">
                            {!! Form::open([
                                'action' => 'Backend\TicketController@send',
                                'class'  => 'js-send-message'
                            ]) !!}
                            <div class="input-group">
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <input name="message" type="text" class="form-control input-sm chat_input" placeholder="Текст сообщения..." />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm js-send-btn">Отправить</button>
                                </span>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('backend/css/chat.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('backend/js/ticket.js') }}"></script>
<script>
    Ticket.init();
</script>
@endsection
