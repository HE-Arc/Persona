<ul>
    @if ($user->isMyFriend($user->id))
        <li>{{ $user->firstname }} {{ $user->lastname }}</li>
    @endif
    <li>{{ $user->alias }}</li>
    <li>{{ $user->email }}</li>
    <li>{{ Carbon\Carbon::parse($user->birthday)->format('jS \\of F Y') }}</li>
    <li>{{ $user->gendertext }}</li>
    <li>{{ $user->country->name }}</li>
    <li>{{ $user->personality->type }}</li>
</ul>

<ul>
    @foreach ($arr_users_qualities as $quality)
        <li>{{ $quality }}</li>
    @endforeach
</ul>
