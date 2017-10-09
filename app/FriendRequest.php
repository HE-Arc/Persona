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
        return FriendRequest::where('requester_id', $requester_id)->where('requested_id', $requested_id)->first();
    }

    public static function isFriendRequestBetweenAuthAndUser($alias){
        return FriendRequest::getFriendRequestBetweenTwoUsers(Auth::user()->id, User::where('alias', $alias)->first()->id);
    }

}
