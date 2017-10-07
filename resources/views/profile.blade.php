@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My Profile</div>
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

                      <!-- <li>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</li>
                      <li>{{ Auth::user()->alias }}</li>
                      <li>{{ Auth::user()->email }}</li>
                      <li>{{ Auth::user()->birthday }}</li>
                      <li>{{ Auth::user()->gender }}</li>
                      <li>{{ Auth::user()->country_id }}</li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
