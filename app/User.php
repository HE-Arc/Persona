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



}
