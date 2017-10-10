@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My Friends</div>
                <div class="panel-body">
                    @include('layouts.flash_message')
                    <ul>
                        @foreach ($user->getFriendList() as $friend)
                            <li>
                                <a href="{{ route('profile', $friend->alias) }}">{{ $friend->alias }}</a> - <a href="{{ route('remove-friend', $friend->alias) }}">Remove</a>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
