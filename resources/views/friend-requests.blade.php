@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My Friend Requests</div>
                <div class="panel-body">
                    @include('layouts.flash_message')
                    People that requested me as friend :
                    <ul>
                        @foreach ($others_friend_requests as $friend_request)
                            <li>
                                Demande d'ami de : {{ $requester_alias = \App\User::find($friend_request->requester_id)->alias }} -
                                <a href="{{ route('add-friend', $requester_alias) }}">Accept</a> -
                                <a href="{{ route('remove-friend', $requester_alias) }}">Decline</a>
                            </li>
                        @endforeach
                    </ul>
                    <hr>
                    People that I requested as friend (pending) :
                    <ul>
                        @foreach ($my_friend_requests as $friend_request)
                            <li>
                                Demande d'ami à : {{ $requester_alias = \App\User::find($friend_request->requested_id)->alias }} -
                                <a href="{{ route('remove-friend', $requester_alias) }}">Cancel</a>
                            </li>
                        @endforeach
                    </ul>
                    <hr>
                    My Friends :
                    <ul>
                        @foreach ($my_friends as $friend)
                            <li>
                                {{$requester_alias =  \App\User::find($friend->requested_id)->alias }} -
                                <a href="{{ route('remove-friend', $requester_alias) }}">Remove</a>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
