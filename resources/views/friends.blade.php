@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My Friends</div>
                <div class="panel-body">
                    @include('layouts.flash_message')
                    <p><b>{{ count($friend_list) }} ami(s) au total</b></p>
                    <ul>
                        @foreach ($friend_list as $friend)
                            <li>
                                <a href="{{ route('profile', $friend->alias) }}">{{ $friend->alias }}</a> ({{ $friend->firstname }} {{ $friend->lastname }})
                                @if (Auth::user()->alias == $user->alias)
                                      - <a href="{{ route('remove-friend', $friend->alias) }}">Remove</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
