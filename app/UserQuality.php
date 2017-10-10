<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserQuality extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'quality_id'
    ];
}
