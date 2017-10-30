<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function getCountryAttribute(){
        return Country::find($this->country_id);
    }

    public function getPersonalityAttribute(){
        return Personality::find($this->personality_id);
    }

    public function getGenderTextAttribute(){
        if($this->gender == 'm'){ return 'Male'; }
        else{ return 'Female'; }
    }

    /**
     * Get the country record associated with the user.
     */
    public function country()
    {
        return $this->hasOne('App\Country');
    }

    /**
     * Get the personality record associated with the user.
     */
    public function personality()
    {
        return $this->hasOne('App\Personality');
    }

    public function friendRequest()
    {
        return $this->hasMany('App\FriendRequest');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname', 'email', 'password', 'alias', 'country_id', 'firstname', 'gender', 'birthday', 'personality_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    * Returns <number> random suggestions from the database
    *
    *@param  int $number
    */
    public function getRandomSuggestions($number) {
        return User::where('id', '!=', $this->id)->inRandomOrder()->limit($number)->get();

    }

    /**
    * Returns <number> personality suggestions from the database
    *
    *@param  int $number
    */
    public function getPersonalitySuggestions($number) {
        return User::where('personality_id', $this->personality_id)->where('id', '!=', $this->id)->inRandomOrder()->limit($number)->get();
    }

    /**
    * Returns <number> quality suggestions from the database
    *
    *@param  int $number
    */
    public function getQualitySuggestions($number) {
        $id_list = array();
        $qualities = User::getQualities();

        //TODO: Je sais plus faire de requêtes SQL... Je pense qu'il y a mieux
        foreach ($qualities as $quality) {
            $user_qualities = UserQuality::where('quality_id', $quality->quality_id)->get();

            foreach ($user_qualities as $user_quality) {
                if (!in_array($user_quality->user_id, $id_list, true) && ($user_quality->user_id != $this->id)) {
                    $id_list[] = $user_quality->user_id;
                }
            }
        }

        return User::whereIn('id', $id_list)->inRandomOrder()->limit($number)->get();
    }

    /**
    * Returns <number> friends of friends suggestions from the database
    *
    *@param  int $number
    */
    public function getFriendsOfFriendsSuggestions($number) {
        $final_list = array();
        $friend_list = User::getFriendList();

        foreach ($friend_list as $friend) {
            $f_friend_list = User::getFriendListOfUser($friend);

            foreach ($f_friend_list as $f_friend) {
                if (!in_array($f_friend, $final_list, true) && $f_friend != $this) {
                    $final_list[] = $f_friend;
                }
            }
        }

        shuffle($final_list);
        $sliced_array = array_slice($final_list, 0, $number);

        return $sliced_array;
    }

    /**
    * Returns friend list of the user
    *
    */
    public function getFriendList() {
        return User::getFriendListOfUser($this);
    }

    /**
    * Returns friend list of a user
    *
    *@param  User $user
    */
    public function getFriendListOfUser($user) {
        $request_list = FriendRequest::where('requester_id', $user->id)->where('friendship', 1)->get(['requested_id']);
        $friend_list = array();

        foreach ($request_list as $request) {
            $friend_list[] = User::find($request->requested_id);
        }

        return $friend_list;
    }

    public function getQualities() {
        return UserQuality::where('user_id', $this->id)->get();
    }

    public function isMyFriend($id) {
        return FriendRequest::where('requester_id', $id)->where('friendship', 1)->first();
    }

    public function getNumberOfFriendRequests() {
        return FriendRequest::where('requested_id', $this->id)->where('friendship', 0)->count();
    }

}
