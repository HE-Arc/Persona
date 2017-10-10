<?php

namespace App;

use App\Country;

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
    * Returns three random people from the database
    *
    */
    public static function getRandomSuggestions() {
        return User::inRandomOrder()->limit(3)->get();
    }

    /**
    * Returns three personality people from the database
    *
    */
    public static function getPersonalitySuggestions($personality) {
        return User::where('personality_id', $personality)->inRandomOrder()->limit(3)->get();
    }

    /**
    * Returns friend list of the user
    *
    */
    public function getFriendList() {
        $request_list = FriendRequest::where('requester_id', $this->id)->where('friendship', 1)->get(['requested_id']);

        $friend_list = array();

        foreach ($request_list as $request){
            $friend_list[] = User::find($request->requested_id);
        }

        return $friend_list;
    }

}
