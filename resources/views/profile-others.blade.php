@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $user->alias }}'s Profile
                    <!-- Request::segment(2) -->
                    @if ($relation = \App\FriendRequest::getFriendRequestBetweenTwoUsers(Auth::user()->id, $user->id))
                        <a href="{{ route('remove-friend', $user->alias) }}" class="pull-right"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            @if ($relation->friendship)
                                Cancel friendship
                            @else
                                Cancel friend request
                            @endif
                        </a>
                    @else
                        <a href="{{ route('add-friend', $user->alias) }}" class="pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add as friend</a>
                    @endif
                </div>
                <div class="panel-body">
                    @include('layouts.flash_message')
                    @include('profile-common')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
