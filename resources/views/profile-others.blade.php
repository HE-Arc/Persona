@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $user->alias }}'s Profile
                    @if (\App\FriendRequest::isFriendRequestBetweenAuthAndUser(Request::segment(2)))
                        <a href="{{ route('remove-friend', Request::segment(2)) }}" class="pull-right"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancel friend request</a>
                    @else
                        <a href="{{ route('add-friend', Request::segment(2)) }}" class="pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add as friend</a>
                    @endif
                </div>
                <!-- TODO : gérer le 's pour les alias qui finissent en S -->
                <div class="panel-body">
                    @include('layouts.flash_message')
                    @include('profile-common')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
