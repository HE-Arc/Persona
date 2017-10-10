@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My Friend Requests</div>
                <div class="panel-body">
                    @include('layouts.flash_message')
                    <b>From :</b>
                    <ul>
                        @foreach ($others_friend_requests as $friend_request)
                            <?php $requester_alias = \App\User::find($friend_request->requester_id)->alias ?>
                            <li>
                                Demande d'ami de : <a href="{{ route('profile', $requester_alias) }}">{{ $requester_alias }}</a> -
                                <a href="{{ route('add-friend', $requester_alias) }}">Accept</a> -
                                <a href="{{ route('remove-friend', $requester_alias) }}">Decline</a>
                            </li>
                        @endforeach
                    </ul>
                    <hr>
                    <b>To (pending) :</b>
                    <ul>
                        @foreach ($my_friend_requests as $friend_request)
                            <?php $requester_alias = \App\User::find($friend_request->requester_id)->alias ?>
                            <li>
                                Demande d'ami à : <a href="{{ route('profile', $requester_alias) }}">{{ $requester_alias }}</a> -
                                <a href="{{ route('remove-friend', $requester_alias) }}">Cancel</a>
                            </li>
                        @endforeach
                    </ul>
                    <hr>
                    <p><b>Click <a href="{{ route('friends', Auth::user()->alias) }}">Here</a> to see your friend list.</b></p>


                </div>
            </div>

        </div>
    </div>
</div>
@endsection
