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
                        <p><b>Random:</b></p>
                        <div class="row">
                            @foreach (Auth::user()->getRandomSuggestions(3) as $randomSuggestion)
                                <div class="col-sx-12 col-sm-6 col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="text-center">
                                                <a href="{{ route('profile', $randomSuggestion->alias) }}">{{ $randomSuggestion->alias }}</a>
                                            </div>                                      
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p><b>Personality:</b></p>
                        <div class="row">
                            @foreach (Auth::user()->getPersonalitySuggestions(3) as $personalitySuggestion)
                                <div class="col-sx-12 col-sm-6 col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="text-center">
                                                <a href="{{ route('profile', $personalitySuggestion->alias) }}">{{ $personalitySuggestion->alias }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p><b>Friends:</b></p>
                        <div class="row">
                            @foreach (Auth::user()->getFriendsOfFriendsSuggestions(3) as $friendSuggestion)
                                <div class="col-sx-12 col-sm-6 col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="text-center">
                                                <a href="{{ route('profile', $friendSuggestion->alias) }}">{{ $friendSuggestion->alias }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p><b>Qualities:</b></p>
                        <div class="row">
                            @foreach (Auth::user()->getQualitySuggestions(3) as $qualitySuggestion)
                                <div class="col-sx-12 col-sm-6 col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="text-center">
                                                <a href="{{ route('profile', $qualitySuggestion->alias) }}">{{ $qualitySuggestion->alias }}</a></li>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
