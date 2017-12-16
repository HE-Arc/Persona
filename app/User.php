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
        $users_list = User::inRandomOrder()->limit($number)->get();

        // Retire les users déjà amis et l'utilisateur appelant
        return $this->removeFriendsFromCollectionAndSelf($users_list);
    }

    /**
    * Returns <number> personality suggestions from the database
    *
    *@param  int $number
    */
    public function getSamePersonalitySuggestions($number) {
        $users_list = User::where(['personality_id' => $this->personality_id])->inRandomOrder()->limit($number)->get();
        // Retire les users déjà amis et l'utilisateur appelant
        return $this->removeFriendsFromCollectionAndSelf($users_list); 
    }

    /**
    * Returns <number> personality suggestions from the database
    *
    *@param  int $number
    */
    public function getMatchingPersonalitySuggestions($number) {

        // TODO: Solution rapide : AURAIT DU ETRE FAIT DANS UNE TABLE DE LA BASE en relation reflexive sur Personality
        $matching_array = array ("INTJ" => array("ENFP", "INTP", "ISTJ"),
                                 "INTP" => array("ISTP", "ENTJ", "INFP"),
                                 "ENTJ" => array("ESTJ", "ESTP", "ISTJ"),
                                 "ENTP" => array("ISFJ", "ENTJ", "ESFP"),

                                 "INFJ" => array("INTP", "ESTJ", "ISFP"),
                                 "INFP" => array("ESFJ", "ESTP", "ESTJ"),
                                 "ENFJ" => array("ESFJ", "ISFJ", "INFJ"),
                                 "ENFP" => array("INFP", "ENTP", "ENTJ"),

                                 "ISTJ" => array("ESTJ", "ESTP", "ESFP"),
                                 "ISFJ" => array("ESFJ", "ENFJ", "INTJ"),
                                 "ESTJ" => array("INTJ", "INTP", "ISFP"),
                                 "ESFJ" => array("ISTP", "INTP", "INFJ"),

                                 "ISTP" => array("ENTP", "INFJ", "ISTP"),
                                 "ISFP" => array("ENFJ", "ENFP", "INTJ"),
                                 "ESTP" => array("ISFP", "ENFP", "ENFJ"),
                                 "ESFP" => array("ISTP", "INTJ", "INTP"),

                                );

        $final_users_list = collect([]);

        foreach ($matching_array[$this->personality->type] as $matching_personality) {
          $final_users_list = $final_users_list->concat(Personality::where(['type' => $matching_personality])->first()->users);
        }

        foreach ($matching_array[$this->personality->type] as $matching_personality) {
          $final_users_list = $final_users_list->concat(Personality::where(['type' => $matching_personality])->first()->users);
        }

        $final_users_list = $final_users_list->unique();

        // Retire les users déjà amis et l'utilisateur appelant
        $final_users_list = $this->removeFriendsFromCollectionAndSelf($final_users_list);

        if($final_users_list->count() >= $number){
            return $final_users_list->random($number);
        }

        return $final_users_list;
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

            // NOTE : Pas bien s'il y a trop d'utilisateurs /!\
            // Récupère tous les utilisateurs partageant la qualité en cours
            $users_sharing_quality = $quality->users;

            //dd($users_sharing_quality);

            // Ajoute la liste de users pour la qualité en cours à la liste finale
            $final_list = $final_list->concat($users_sharing_quality);
        }

        // Retire les doublons
        $final_list = $final_list->unique(); // ->diff([$this]); Ne fonctionne pas car les Users sont différents ?
        // Retire les users déjà amis et l'utilisateur appelant
        $final_list = $this->removeFriendsFromCollectionAndSelf($final_list);

        // Choisi un certain nombre de users de la liste de manière aléatoire
        if($final_list->count() >= $number){
            return $final_list->random($number);
        }
        return $final_list;
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

            // NOTE : Pas bien s'il y a trop d'utilisateurs /!\
            // Récupère la liste d'amis de l'ami en cours
            $f_friend_list = $friend->friends;

            // Ajoute la liste d'amis de l'ami en cours à la liste finale
            $final_list = $final_list->concat($f_friend_list);
        }

        // Retire les doublons
        $final_list = $final_list->unique(); // ->diff([$this]); Ne fonctionne pas car les Users sont différents ?
        // Retire les users déjà amis et l'utilisateur appelant
        $final_list = $this->removeFriendsFromCollectionAndSelf($final_list);

        // Choisi un certain nombre de users de la liste de manière aléatoire
        if($final_list->count() >= $number){
            return $final_list->random($number);
        }
        return $final_list;
    }

    public function isMyFriend($id) {
        // NOTE : éventuellement passer par $this->friends->contains() ... plus performant ?
        return FriendRequest::where(['requester_id'=> $id, 'requested_id' => $this->id, 'friendship' => 1])->first();
    }

    public function getNumberOfFriendRequests() {
        return $this->friendRequestsFrom->count();
    }

    private function removeFriendsFromCollectionAndSelf($inital_collection){

        $friends = $this->friends;

        // Créer un tableau avec les alias des amis de l'utilisateur
        $alias_array = [];
        foreach ($friends as $friend) {
            array_push($alias_array, $friend->alias);
        }
        // Ajout du pseudo de l'utilisateur appelant
        array_push($alias_array, $this->alias);

        // Retourne la collection sans les personnes portant les alias identifés
        return $inital_collection->whereNotIn('alias', $alias_array);
    }

}
