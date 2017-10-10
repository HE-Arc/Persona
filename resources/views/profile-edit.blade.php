@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="">Profile Edit</span>
                </div>
                <!-- TODO : gérer le 's pour les alias qui finissent en S -->
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('profile-edit', Auth::user()->alias) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
                            <label for="alias" class="col-md-4 control-label">Alias</label>

                            <div class="col-md-6">
                                <input id="alias" type="text" class="form-control" name="alias" value="{{ $user->alias }}" required autofocus>

                                @if ($errors->has('alias'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('alias') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <label for="firstname" class="col-md-4 control-label">Firstname</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ $user->firstname }}" required autofocus>

                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <label for="lastname" class="col-md-4 control-label">Lastname</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ $user->lastname }}" required autofocus>

                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                            <label for="country_id" class="col-md-4 control-label">Select Your Country</label>

                            <div class="col-md-6">

                                <select class="form-control" name="country_id" id="country_id" required>

                                    <option>Choose...</option>
                                    @foreach ($countries as $country)
                                        <!-- TODO : optimisation possible du test ? -->
                                        @if ($user->country_id == $country->id)
                                            <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                        @else
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @if ($errors->has('country_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="col-md-4 control-label">Select Your Gender</label>

                            <div class="col-md-6">
                                <!-- TODO : optimisation possible du test ? -->
                                <select class="form-control" name="gender" id="gender" required>
                                    <option>Choose...</option>
                                    <option value="m" @if ($user->gender == 'm')selected @endif >Male</option>
                                    <option value="f" @if ($user->gender == 'f')selected @endif>Female</option>
                                </select>

                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('personality_id') ? ' has-error' : '' }}">
                            <label for="personality_id" class="col-md-4 control-label">Select Your Personality</label>

                            <div class="col-md-6">

                                <select class="form-control" name="personality_id" id="personality_id" required>

                                    <option>Choose...</option>
                                    @foreach ($personalities as $personality)
                                        <!-- TODO : optimisation possible du test ? -->
                                        @if ($user->personality_id == $personality->id)
                                            <option value="{{ $personality->id }}" selected>{{ $personality->type }}</option>
                                        @else
                                            <option value="{{ $personality->id }}">{{ $personality->type }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @if ($errors->has('personality_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('personality_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <label for="birthday" class="col-md-4 control-label">Birthday</label>

                            <div class="col-md-6">
                                <input id="birthday" type="date" class="form-control" name="birthday" value="{{ $user->birthday }}" required autofocus>

                                @if ($errors->has('birthday'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('quality_id') ? ' has-error' : '' }}">
                            <label for="quality_id" class="col-md-4 control-label">Select up to 8 qualities</label>

                            <div class="col-md-6">

                                <select class="form-control" name="quality_id[]" id="quality_id" multiple>
                                    @foreach ($qualities as $quality)
                                        <!-- TODO : optimisation possible du test ? -->
                                        @if (in_array($quality->quality, $arr_users_qualities))
                                            <option value="{{ $quality->id }}" selected>{{ $quality->quality }}</option>
                                        @else
                                            <option value="{{ $quality->id }}">{{ $quality->quality }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @if ($errors->has('quality_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('quality_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Apply changes
                                </button>
                                <button type="reset" class="btn btn-default" value="Reset">Reset</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
