<!-- partie commune au profile authentifié et non authentifié -->

<div class="box box-info">
  <div class="box-body">
    <div class="col-sm-6">
      <div  align="center"> <img alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_{{ $user->gender=="m"?'m':'f'}}.original.jpg" id="profile-image1" class="img-circle img-responsive">

        <input id="profile-image-upload" class="hidden" type="file">
        @if (Auth::user() == $user)
            <div style="color:#999;" >click here to change profile image</div>
        @endif
        <!--Upload Image Js And Css-->
      </div>
      <br>
      <!-- /input-group -->
    </div>
    <div class="col-sm-6">
      <h4 style="color:#e87878;">{{ $user->alias }} </h4></span>
      <span><p>User</p></span>
      @if(!empty($relation) && $relation->friendship)<p>You've been friends for {{ $relation->updated_at->diffForHumans(null, true) }}</p>@endif
    </div>
    <div class="clearfix"></div>
    <hr style="margin:5px 0 5px 0;">

    <!-- Nom prénom  -->
    @if (Auth::user()->isMyFriend($user->id) || Auth::user() == $user)
        <div class="col-sm-5 col-xs-6 tital " >First Name:</div><div class="col-sm-7 col-xs-6 "> {{ $user->firstname }} </div>
        <div class="clearfix"></div>
        <div class="bot-border"></div>

        <div class="col-sm-5 col-xs-6 tital " >Last Name:</div><div class="col-sm-7"> {{ $user->lastname }}</div>
        <div class="clearfix"></div>
        <div class="bot-border"></div>
    @endif

    <!-- affichage des information de l'utilisateur-->
    <div class="col-sm-5 col-xs-6 tital " >Date Of Joining:</div><div class="col-sm-7">{{ $user->created_at->diffForHumans()  }}</div>

    <div class="clearfix"></div>
    <div class="bot-border"></div>

    <div class="col-sm-5 col-xs-6 tital " >Email:</div><div class="col-sm-7">{{ $user->email }}</div>

    <div class="clearfix"></div>
    <div class="bot-border"></div>

    <div class="col-sm-5 col-xs-6 tital " >Date Of Birth:</div><div class="col-sm-7">{{ Carbon\Carbon::parse($user->birthday)->format('jS \\of F Y') }}</div>

    <div class="clearfix"></div>
    <div class="bot-border"></div>

    <div class="col-sm-5 col-xs-6 tital " >Gender:</div><div class="col-sm-7">{{ $user->gendertext }}</div>

    <div class="clearfix"></div>
    <div class="bot-border"></div>

    <div class="col-sm-5 col-xs-6 tital " >Country:</div><div class="col-sm-7">{{ $user->country->name }}</div>

    <div class="clearfix"></div>
    <div class="bot-border"></div>

    <div class="col-sm-5 col-xs-6 tital " >Personality:</div><div class="col-sm-7">{{ $user->personality->type }}</div>

    <div class="clearfix"></div>
    <div class="bot-border"></div>

    <div class="col-sm-5 col-xs-6 tital " >Qualities:</div>
    <div class="col-sm-7">
    <?php $at_least_one_quality = false; ?>
    <ul>
      <!--  boucle d'affichage des qualités -->
      @foreach ($arr_users_qualities as $quality)
          <li>{{ $quality }}</li>
          <?php $at_least_one_quality = true; ?>
      @endforeach
      @if (!$at_least_one_quality)
        <li><i>Edit your profile to add qualities</i></li>
      @endif
    </ul>

    </div>
  </div>
</div>
