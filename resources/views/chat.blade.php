@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Friends</div>
                <div class="panel-body">
                    <ul class="list-inline">
                        @foreach($users as $chatuser)
                        <li class="friends-chat" v-on:click="getUserId" class="list-inline-item" id="{{ $chatuser->id }}" value="{{ $chatuser->alias }}">{{ $chatuser->alias }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div v-for="(chatWindow, index) in chatWindows" v-bind:sendid="index.senderid" v-bind:name="index.name">
                <div class="panel panel-default">
                    <div class="panel-heading" id="accordion">
                        <span class="glyphicon glyphicon-comment"></span> @{{chatWindow.name}}
                    </div>
                    <div class="panel-collapse" id="collapseOne">
                        <div class="panel-body">
                            <ul style="list-style-type:none;" class="chat" id="chat">
                                <li sytel="list-style:none;" class="left clearfix" v-for="chat in chats[chatWindow.senderid]" v-bind:message="chat.message" v-bind:username="chat.username">
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font"> @{{chat.name}}</strong>
                                        </div>
                                        <p>@{{chat.message}}</p>
                                    </div>
                                </li>                                
                            </ul>
                        </div>
                        <div class="panel-footer">
                            <div class="input-group">
                                <input :id="chatWindow.senderid" v-model="chatMessage[chatWindow.senderid]" v-on:keyup.enter="sendMessage" type="text" class="form-control input-md" placeholder="Type your message here..." />
                                <span class="input-group-btn"><button :id="chatWindow.senderid" class="btn btn-default btn-md" v-on:click="sendMessage">Send</button></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
