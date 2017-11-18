<!-- partie commune au profile authentifié et non authentifié -->
<ul>
    <!-- TODO: isMyFriend ne se comporte pas comme voulu -->
    @if (Auth::user()->isMyFriend($user->id) || Auth::user() == $user)
        <li>{{ $user->firstname }} {{ $user->lastname }}</li>
    @endif
    <!-- affichage des information de l'utilisateur-->
    <li>{{ $user->alias }}</li>
    <li>{{ $user->email }}</li>
    <li>{{ Carbon\Carbon::parse($user->birthday)->format('jS \\of F Y') }}</li>
    <li>{{ $user->gendertext }}</li>
    <li>{{ $user->country->name }}</li>
    <li>{{ $user->personality->type }}</li>
</ul>

<!--  boucle d'affichage des qualités -->
<ul>
    @foreach ($arr_users_qualities as $quality)
        <li>{{ $quality }}</li>
    @endforeach
</ul>
