@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Suggestions</div>
                <!-- TODO : DRY ? -->
                <div class="panel-body">
                    Random:
                    <ul class="list-inline">
                        <!-- TODO : Uitliser un use pour les models depuis les views -->
                        @foreach (\App\User::getRandomFriends() as $randomFriend)
                            @if ($randomFriend != Auth::user())
                                <li class="list-inline-item"><a href="{{ route('profile', $randomFriend->alias) }}">{{ $randomFriend->alias }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                    By personality:
                    <ul class="list-inline">
                        <!-- TODO : Uitliser un use pour les models depuis les views -->
                        @foreach (\App\User::getPersonalityFriends(Auth::user()->personality_id) as $personalityFriend)
                            @if ($personalityFriend != Auth::user())
                                <li class="list-inline-item"><a href="{{ route('profile', $personalityFriend->alias) }}">{{ $personalityFriend->alias }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
