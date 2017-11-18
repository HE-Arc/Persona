<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personality extends Model
{
    /**
    * Get the users corresponding to the personality.
    */
    public function users()
    {
        return $this->hasMany('App\User', 'personality_id', 'id');
    }
}
