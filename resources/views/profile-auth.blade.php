@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="">My Profile</span>

                    <a href="{{ route('profile-edit', Auth::user()->alias) }}" class="pull-right"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>

                </div>
                <!-- TODO : gérer le 's pour les alias qui finissent en S -->
                <div class="panel-body">
                    @include('profile-common')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
