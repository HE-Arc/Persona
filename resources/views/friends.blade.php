@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My Friends</div>
                <div class="panel-body">
                    @include('layouts.flash_message')
                    <p><b>{{ count($friend_list) }} friend(s)</b></p>
                    @foreach ($friend_list as $friend)
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="text-center">
                                    <a href="{{ route('profile', $friend->alias) }}">{{ $friend->alias }}</a> ({{ $friend->firstname }} {{ $friend->lastname }})
                                    @if (Auth::user()->alias == $user->alias)
                                          <a class="btn btn-default" role="button" href="{{ route('remove-friend', $friend->alias) }}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
