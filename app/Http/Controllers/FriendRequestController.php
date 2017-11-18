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
        $friend_list = $user->friends;
        return view('friends', compact('user', 'friend_list'));
    }


    public function showFriendRequest($alias){

        $user = Auth::user();

        if($user->alias == $alias){
            $others_friend_requests = $user->friendRequestsFrom;
            $my_friend_requests = $user->friendRequestsTo;

            return view('friend-requests', compact('others_friend_requests', 'my_friend_requests'));
        }
        else{
            return abort(404);
        }
    }




    public function removeFriend($friendAlias)
    {
        //Vérifie qu'on n'essaie pas de se retirer soi-même
        if($friendAlias != Auth::user()->alias){

            // Vérifie l'existence de la personne
            $friendId = User::where('alias', $friendAlias)->firstOrFail()->id;

            // SUPPRIMER UNE AMITIE : On doit supprimer le lien dans les deux sens
            if(FriendRequest::where('requester_id', Auth::user()->id)->where(['requested_id' => $friendId, 'friendship' => 1])->delete()){
                FriendRequest::where('requested_id', Auth::user()->id)->where(['requester_id' => $friendId, 'friendship' => 1])->delete();
                $msg = 'Friendship with ' . $friendAlias . ' has been canceled.';
            }
            // SUPPRIMER NOTRE REQUETE : S'il n'y a pas de lien d'amitié, c'est donc une demande d'ami de notre part
            elseif(FriendRequest::where('requester_id', Auth::user()->id)->where(['requested_id' => $friendId, 'friendship' => 0])->delete()){
                $msg = 'Friend request to ' . $friendAlias . ' has been canceled.';
            }
            //  REFUS D'UNE REQUETE : Sinon c'est une demande d'ami à notre encontre
            else{
                FriendRequest::where('requested_id', Auth::user()->id)->where(['requester_id' => $friendId, 'friendship' => 0])->delete();
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

            // Vérifie l'existence de la personne
            $friendId = User::where('alias', $friendAlias)->firstOrFail()->id;

            //Test si une telle requête d'ami existe deja entre les deux personnes
            if(FriendRequest::getFriendRequestBetweenTwoUsers(Auth::user()->id, $friendId)){
                Session::flash('status-danger', 'You already requested this user to be your friend!');
                return redirect()->back();
            }

            // CREATION DE LA REQUETE D'AMITIE
            $new_request = FriendRequest::create([
                'requester_id' => Auth::user()->id,
                'requested_id' => $friendId,
            ]);

            $other_request = FriendRequest::getFriendRequestBetweenTwoUsers($friendId, Auth::user()->id);

            // CREATION AMITIE : S'il existait deja une requête depuis l'autre personne
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
