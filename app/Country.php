<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
    * Get the users corresponding to the country.
    */
    public function users()
    {
        return $this->hasMany('App\User', 'country_id', 'id');
    }
}
