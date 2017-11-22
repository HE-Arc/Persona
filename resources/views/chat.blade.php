@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <nav class="navbar navbar-sub">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="navbar-brand" style="margin: 0px;">Friends</div>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            @foreach($users as $chatuser)
                                <li>
                                    <a class="friends-chat" v-on:click="getUserId" id="{{ $chatuser->id }}" value="{{ $chatuser->alias }}">{{ $chatuser->alias }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
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
