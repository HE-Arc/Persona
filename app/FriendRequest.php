<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FriendRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'requester_id', 'requested_id'
    ];


    public static function getFriendRequestBetweenTwoUsers($requester_id, $requested_id){
        // TODO : éventuellement passer par $requester->friendRequestsTo->contains(requested) ... plus performant ?
        return FriendRequest::where(['requester_id' => $requester_id, 'requested_id' => $requested_id])->first();
    }

}
