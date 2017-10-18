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
                <div class="panel-body">
                    Random:
                    <ul class="list-inline">
                        @foreach (Auth::user()->getRandomSuggestions(3) as $randomSuggestion)
                            <li class="list-inline-item"><a href="{{ route('profile', $randomSuggestion->alias) }}">{{ $randomSuggestion->alias }}</a></li>
                        @endforeach
                    </ul>
                    By personality:
                    <ul class="list-inline">
                        @foreach (Auth::user()->getPersonalitySuggestions(3) as $personalitySuggestion)
                            <li class="list-inline-item"><a href="{{ route('profile', $personalitySuggestion->alias) }}">{{ $personalitySuggestion->alias }}</a></li>
                        @endforeach
                    </ul>
                    By friends:
                    <ul class="list-inline">
                        @foreach (Auth::user()->getFriendsOfFriendsSuggestions(3) as $friendSuggestion)
                            <li class="list-inline-item"><a href="{{ route('profile', $friendSuggestion->alias) }}">{{ $friendSuggestion->alias }}</a></li>
                        @endforeach
                    </ul>
                    By qualities:
                    <ul class="list-inline">
                        @foreach (Auth::user()->getQualitySuggestions(3) as $qualitySuggestion)
                            <li class="list-inline-item"><a href="{{ route('profile', $qualitySuggestion->alias) }}">{{ $qualitySuggestion->alias }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
