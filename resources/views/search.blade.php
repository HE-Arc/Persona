@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Search results
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach ($results as $result)
                            <li><a href="{{ route('profile', $result->alias) }}">{{ $result->alias }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
