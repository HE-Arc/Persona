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
