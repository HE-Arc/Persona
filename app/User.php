<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // /**
    //  * Get the country of a user with user->country
    //  */
    // public function getCountryAttribute(){
    //     return Country::find($this->country_id);
    // }
    //
    // /**
    //  * Get the personality of a user with user->personality
    //  */
    // public function getPersonalityAttribute(){
    //     return Personality::find($this->personality_id);
    // }

    public function getGenderTextAttribute(){
        if($this->gender == 'm'){ return 'Male'; }
        else{ return 'Female'; }
    }

    /**
     * Get the country record associated with the user.
     */
    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id', 'id');
    }

    /**
     * Get the personality record associated with the user.
     */
    public function personality()
    {
        return $this->belongsTo('App\Personality', 'personality_id', 'id');
    }

    /**
    * Get the people that the user requested as friends.
    */
    public function friendRequestsTo()
    {
      return $this->belongsToMany('App\User', 'friend_requests', 'requester_id', 'requested_id')->as('friendRequest')->withTimestamps()->withPivot('friendship')->wherePivot('friendship', 0);
    }

    /**
    * Get the people that requested the user as their friend.
    */
    public function friendRequestsFrom()
    {
      return $this->belongsToMany('App\User', 'friend_requests', 'requested_id', 'requester_id')->as('friendRequest')->withTimestamps()->withPivot('friendship')->wherePivot('friendship', 0);
    }

    /**
    * Get the people that are friends with the user.
    */
    public function friends()
    {
      return $this->belongsToMany('App\User', 'friend_requests', 'requester_id', 'requested_id')->as('friendRequest')->withTimestamps()->withPivot('friendship')->wherePivot('friendship', 1);
    }

    /**
    * Get the qualities of a user.
    */
    public function qualities()
    {
      return $this->belongsToMany('App\Quality', 'user_qualities');
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
        return User::where(['personality_id' => $this->personality_id, ['id', '!=', $this->id]])->inRandomOrder()->limit($number)->get();
    }

    /**
    * Returns <number> quality suggestions from the database
    *
    *@param  int $number
    */
    public function getQualitySuggestions($number) {
        //Liste finale des utilisateurs random partageant les qualités du user appelant
        $final_list = collect([]);

        //Récupère toutes les qualités de l'utilisateur
        $qualities = $this->qualities;

        // Parcours les qualités
        foreach ($qualities as $quality) {

            // TODO : Pas bien s'il y a trop d'utilisateurs /!\
            // Récupère tous les utilisateurs partageant la qualité en cours
            $users_sharing_quality = $quality->users;

            //dd($users_sharing_quality);

            // Ajoute la liste de users pour la qualité en cours à la liste finale
            $final_list = $final_list->concat($users_sharing_quality);
        }

        // Retire les doublons et l'utilisateur appelant
        // Choisi un certain nombre de users de la liste de manière aléatoire
        return $final_list->unique()->diff([$this])->random($number);
    }

    /**
    * Returns <number> friends of friends suggestions from the database
    *
    *@param  int $number
    */
    public function getFriendsOfFriendsSuggestions($number) {

        //Liste finale des utilisateurs random ayant un amis commun avec l'utilisateur appelant
        $final_list = collect([]);
        $friend_list = $this->friends;

        // Parcours les amis
        foreach ($friend_list as $friend) {

            // TODO : Pas bien s'il y a trop d'utilisateurs /!\
            // Récupère la liste d'amis de l'ami en cours
            $f_friend_list = $friend->friends;

            // Ajoute la liste d'amis de l'ami en cours à la liste finale
            $final_list = $final_list->concat($f_friend_list);
        }

        // Retire les doublons et l'utilisateur appelant
        // Choisi un certain nombre de users de la liste de manière aléatoire
        return $final_list->unique()->diff([$this])->random($number);
    }

    public function isMyFriend($id) {
        // TODO : éventuellement passer par $this->friends->contains() ... plus performant ?
        return FriendRequest::where(['requester_id'=> $id, 'requested_id' => $this->id, 'friendship' => 1])->first();
    }

    public function getNumberOfFriendRequests() {
        return $this->friendRequestsFrom->count();
    }

}
