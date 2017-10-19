@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My Friend Requests</div>
                <div class="panel-body">
                    <h2 class="text-center">To you :</h2>
                    @foreach ($others_friend_requests as $friend_request)
                        <?php $requester_alias = \App\User::find($friend_request->requester_id)->alias ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="text-center">
                                    <p class="font-weight-bold">Friend request from : <a href="{{ route('profile', $requester_alias) }}">{{ $requester_alias }}</a></p>
                                    <a class="btn btn-default" role="button" href="{{ route('add-friend', $requester_alias) }}"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Accept</a>
                                    <a class="btn btn-default" role="button" href="{{ route('remove-friend', $requester_alias) }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>  Decline</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <hr>
                    <h2 class="text-center">From you : <small>(pending)</small></h2>

                    @foreach ($my_friend_requests as $friend_request)
                        <?php $requester_alias = \App\User::find($friend_request->requested_id)->alias ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="text-center">
                                    <p class="font-weight-bold">Friend request to : <a href="{{ route('profile', $requester_alias) }}">{{ $requester_alias }}</a></p>
                                    <a class="btn btn-default" role="button" href="{{ route('remove-friend', $requester_alias) }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancel</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <hr>
                    <p><b>Click <a href="{{ route('friends', Auth::user()->alias) }}">Here</a> to see your friend list.</b></p>


                </div>
            </div>

        </div>
    </div>
</div>
@endsection
