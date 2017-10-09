@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $user->alias }}'s Profile
                    @if ($result = \App\FriendRequest::isFriendRequestBetweenAuthAndUser(Request::segment(2)))
                        <a href="{{ route('remove-friend', Request::segment(2)) }}" class="pull-right"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            @if ($result->friendship)
                                Cancel friendship
                            @else
                                Cancel friend request
                            @endif
                        </a>
                    @else
                        <a href="{{ route('add-friend', Request::segment(2)) }}" class="pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add as friend</a>
                    @endif
                </div>
                <!-- TODO : gérer le 's pour les alias qui finissent en S -->
                <div class="panel-body">
                    @include('layouts.flash_message')
                    <ul>
                        <!-- TODO : Faire une page différente pour le profil de l'utilisateur connecté-->
                        <li>{{ $user->firstname }} {{ $user->lastname }}</li>
                        <li>{{ $user->alias }}</li>
                        <li>{{ $user->email }}</li>
                        <li>{{ Carbon\Carbon::parse($user->birthday)->format('jS \\of F Y') }}</li>
                        <li>{{ $user->gendertext }}</li>
                        <li>{{ $user->country->name }}</li>
                        <li>{{ $user->personality->type }}</li>


                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
