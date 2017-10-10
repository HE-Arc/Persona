<?php

namespace App\Http\Controllers;

use App\FriendRequest;

use App\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FriendRequestController extends Controller
{

    public function showFriends($alias){

        $user = User::where('alias', $alias)->firstOrFail();

        $friend_list = $user->getFriendList();

        return view('friends', compact('user', 'friend_list'));
    }


    public function showFriendRequest($alias){

        $user = Auth::user();

        if($user->alias == $alias){

            $others_friend_requests = FriendRequest::where('requested_id', $user->id)->where('friendship', 0)->get();

            $my_friend_requests = FriendRequest::where('requester_id', $user->id)->where('friendship', 0)->get();

            $my_friends = FriendRequest::where('requester_id', $user->id)->where('friendship', 1)->get();

            return view('friend-requests', compact('others_friend_requests', 'my_friend_requests', 'my_friends'));
        }
        else{
            return abort(404);
        }
    }




    public function removeFriend($friendAlias)
    {
        //Vérifie qu'on ne s'ajoute pas soi-même en ami
        if($friendAlias != Auth::user()->alias){

            $friendId = User::where('alias', $friendAlias)->firstOrFail()->id;

            // if(FriendRequest::where('requester_id', Auth::user()->id)->where('requested_id', $friendId)->delete()){
            //     $msg = 'Friend request to ' . $friendAlias . ' has been successfully canceled';
            //
            //     if(FriendRequest::where('requester_id', $friendId )->where('requested_id', Auth::user()->id)->delete()){
            //         $msg = 'Friendship with ' . $friendAlias . ' has been successfully canceled';
            //     }
            // }

            //TODO : Passer les multiples where dans un tableau


            if(FriendRequest::where('requester_id', Auth::user()->id)->where('requested_id', $friendId)->where('friendship', 1)->delete()){
                FriendRequest::where('requested_id', Auth::user()->id)->where('requester_id', $friendId)->where('friendship', 1)->delete();
                $msg = 'Friendship with ' . $friendAlias . ' has been canceled.';
            }
            elseif(FriendRequest::where('requester_id', Auth::user()->id)->where('requested_id', $friendId)->where('friendship', 0)->delete()){
                $msg = 'Friend request to ' . $friendAlias . ' has been canceled.';
            }
            else{
                FriendRequest::where('requested_id', Auth::user()->id)->where('requester_id', $friendId)->where('friendship', 0)->delete();
                $msg = 'Friend request from ' . $friendAlias . ' has been declined.';
            }

            Session::flash('status-success', $msg);
            return redirect()->back();


        }
        else{
            return abort(404);
        }
    }


    public function addFriend($friendAlias)
    {
        //Vérifie qu'on ne s'ajoute pas soi-même en ami
        if($friendAlias != Auth::user()->alias){

            $friendId = User::where('alias', $friendAlias)->firstOrFail()->id;

            //TODO : Cas de l'autre sens à traiter
            //Test si une telle requête d'ami existe deja entre les deux personnes
            if(FriendRequest::getFriendRequestBetweenTwoUsers(Auth::user()->id, $friendId)){
                Session::flash('status-danger', 'You already requested this user to be your friend!');
                return redirect()->back();
            }

            $new_request = FriendRequest::create([
                'requester_id' => Auth::user()->id,
                'requested_id' => $friendId,
            ]);

            $other_request = FriendRequest::getFriendRequestBetweenTwoUsers($friendId, Auth::user()->id);

            if($other_request){
                FriendRequest::where('id', $other_request->id)->update(['friendship' => 1]);
                FriendRequest::where('id', $new_request->id)->update(['friendship' => 1]);

                $msg = 'You are now friend with ' . $friendAlias . '!';
            }
            else{
                $msg = 'Friend request sent to ' . $friendAlias . '!';
            }

            Session::flash('status-success', $msg);

            return redirect()->back();
        }
        else{
            return abort(404);
        }
    }
}
