@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="">Profile Edit</span>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('profile-edit', Auth::user()->alias) }}">
                        {{ csrf_field() }}


                        <!-- Pseudo -->
                        <div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
                            <label for="alias" class="col-md-4 control-label">Alias</label>
                            <div class="col-md-6">

                                <!-- if ternaire permettant en cas d'érreur de garder le choix de l'utilisateur au lieu de remettre ceux entrée auparavant -->
                                <input id="alias" type="text" class="form-control" name="alias" value="{{ empty(old()) ? $user->alias :  old('alias') }}" required autofocus>
                                @if ($errors->has('alias'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('alias') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <!-- Prénom -->
                        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <label for="firstname" class="col-md-4 control-label">Firstname</label>
                            <div class="col-md-6">

                                <!-- if ternaire permettant en cas d'érreur de garder le choix de l'utilisateur au lieu de remettre ceux entrée auparavant -->
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ empty(old()) ? $user->firstname :  old('firstname') }}" required autofocus>
                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <!-- Nom -->
                        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <label for="lastname" class="col-md-4 control-label">Lastname</label>
                            <div class="col-md-6">

                                <!-- if ternaire permettant en cas d'érreur de garder le choix de l'utilisateur au lieu de remettre ceux entrée auparavant -->
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{  empty(old()) ? $user->lastname :  old('lastname') }}" required autofocus>
                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <!-- E-mail -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">

                                <!-- if ternaire permettant en cas d'érreur de garder les choix de l'utilisateur au lieu de remettre ceux entrée auparavant -->
                                <input id="email" type="email" class="form-control" name="email" value="{{ empty(old()) ? $user->email :  old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <!-- Choix des pays -->
                        <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                            <label for="country_id" class="col-md-4 control-label">Select Your Country</label>
                            <div class="col-md-6">
                                <select class="form-control" name="country_id" id="country_id" required>
                                    <option>Choose...</option>

                                    <!-- if ternaire permettant en cas d'érreur de garder les choix de l'utilisateur au lieu de remettre ceux entrée auparavant -->
                                    <?php empty(old()) ? $country_id = $user->country_id : $country_id = old('country_id'); ?>

                                    <!-- Boucle remplissant le choix des pays -->
                                    @foreach ($countries as $country)
                                        <!-- Test permettant de selectionner le précédant choix de l'utilisateur -->
                                        <option value="{{ $country->id }}" {{$country_id == $country->id ? 'selected' : ''}}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <!-- Choix du sexe -->
                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="col-md-4 control-label">Select Your Gender</label>
                            <div class="col-md-6">
                                <select class="form-control" name="gender" id="gender" required>
                                    <option>Choose...</option>

                                    <!-- if ternaire permettant en cas d'érreur de garder le choix de l'utilisateur au lieu de remettre ceux entrée auparavant -->
                                    <?php empty(old()) ? $gender = $user->gender : $gender = old('gender'); ?>

                                    <!-- Test permettant de selectionner le précédant choix de l'utilisateur -->
                                    <option value="m" @if ($gender == 'm')selected @endif >Male</option>
                                    <option value="f" @if ($gender == 'f')selected @endif>Female</option>

                                </select>
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <!-- Choix des personalités -->
                        <div class="form-group{{ $errors->has('personality_id') ? ' has-error' : '' }}">
                            <label for="personality_id" class="col-md-4 control-label">Select Your Personality</label>
                            <div class="col-md-6">
                                <select class="form-control" name="personality_id" id="personality_id" required>
                                    <option>Choose...</option>

                                    <!-- if ternaire permettant en cas d'érreur de garder les choix de l'utilisateur au lieu de remettre ceux entrée auparavant -->
                                    <?php empty(old()) ? $personality_id = $user->personality_id : $personality_id = old('personality_id'); ?>

                                    <!-- Boucle remplissant le choix des personalités -->
                                    @foreach ($personalities as $personality)
                                        <!-- Test permettant de selectionner le précédant choix de l'utilisateur -->
                                        <option value="{{ $personality->id }}" {{$user->personality_id == $personality->id ? 'selected' : ''}} >{{ $personality->type }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('personality_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('personality_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <!-- Choix de la date d'anniversaire -->
                        <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <label for="birthday" class="col-md-4 control-label">Birthday</label>
                            <div class="col-md-6">

                                <!-- if ternaire permettant en cas d'érreur de garder les choix de l'utilisateur au lieu de remettre ceux entrée auparavant -->
                                <input id="birthday" type="date" class="form-control" name="birthday" value="{{ empty(old()) ? $user->birthday : old('birthday') }}" required autofocus>
                                @if ($errors->has('birthday'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <!-- Choix des qualités -->
                        <div class="form-group{{ $errors->has('quality_id') ? ' has-error' : '' }}">
                            <label for="quality_id" class="col-md-4 control-label">Select up to 8 qualities</label>
                            <div class="col-md-6" id="div_edit">

                                <!-- Liste des qualités à choisir -->
                                <div class="col-md-6" class="div_edit" id="div_sortable1">
                                    <p id="p_sortable1">List of qualities</p>
                                    <ul id="sortable1" class="connectedSortable" size="10" multiple></ul>
                                </div>

                                <!-- Liste des qualités choisies -->
                                <div class="col-md-6" class="div_edit" id="div_sortable2">
                                    <p id="p_sortable2">My qualities</p>
                                    <ul id="sortable2" class="connectedSortable" size="10"></ul>
                                </div>

                                <?php
                                    $tmp_arr_users_qualities = array();
                                    // if ternaire permettant en cas d'érreur de garder les choix de l'utilisateur au lieu de remettre ceux entrée auparavant
                                    empty(old()) ? $tmp_arr_users_qualities = $arr_users_qualities : $tmp_arr_users_qualities = old('quality_id');
                                ?>

                                <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                                <script src="{{ asset('js/edit_switch_name.js') }}"></script>
                                <script src="{{ asset('js/create_sortable_lists.js') }}"></script>

                                <!-- Boucle permettant de remplire les listes de qualités-->
                                @foreach ($qualities as $quality)
                                    <!-- Test permettant de selectionner le précédant choix de l'utilisateur -->
                                    <script type="text/javascript">
                                        @if (in_array($quality->quality, $tmp_arr_users_qualities))
                                            //crée un nouveau li dans l'ul "sortable2" avec comme text la qualité et comme nom quality_id[]
                                            createList("sortable2", <?php echo json_encode($quality->quality) ?>,"quality_id[]");
                                        @else
                                            //crée un nouveau li dans l'ul "sortable1" avec comme text la qualité et comme nom quality_not_id[]
                                            createList("sortable1", <?php echo json_encode($quality->quality) ?>,"quality_not_id[]");
                                        @endif
                                    </script>
                                @endforeach

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
