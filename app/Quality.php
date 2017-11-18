<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quality extends Model
{
  /**
  * Get the users that shared a quality
  */
  public function users()
  {
    return $this->belongsToMany('App\User', 'user_qualities');
  }
}
