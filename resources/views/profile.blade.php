@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My Profile</div>
                <div class="panel-body">
                    <ul>
                      <li>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</li>
                      <li>{{ Auth::user()->alias }}</li>
                      <li>{{ Auth::user()->email }}</li>
                      <li>{{ Auth::user()->birthday }}</li>
                      <li>{{ Auth::user()->gender }}</li>
                      <li>{{ Auth::user()->country_id }}</li>
                      <!-- TODO : Faire des méthodes dans model pour gender et country_id pour récupérer le vrai contenu -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
