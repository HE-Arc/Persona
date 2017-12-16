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
                    <div class="row">
                        @forelse ($results as $result)
                            <div class="col-sx-12 col-sm-6 col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="text-center">
                                            <a href="{{ route('profile', $result->alias) }}">{{ $result->alias }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-sx-12 col-sm-6 col-md-4">
                                <p>No user corresponding</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
