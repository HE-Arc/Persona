<?php

namespace App\Http\Controllers;

use App\User;
use App\Country;
use App\Personality;
use App\FriendRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\FriendRequestController;



//Pour les validations
use Illuminate\Validation\Rule;

class UserController extends Controller
{

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

    /**
     * Get a validator for an incoming edit profile request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //TODO : Fail alias email
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'alias' => 'string|max:20|unique:users', //TODO : Confirmation en direct ?
            'email' => 'string|email|max:255|unique:users',
            'country_id' => 'required|exists:countries,id',
            'personality_id' => 'required|exists:personalities,id',
            'gender' => ['required', Rule::in(['m', 'f'])],
            'birthday' => 'required|date'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($alias)
    {
        //TODO : à vérifier le &&
        if(Auth::check() && $alias == Auth::user()->alias){
            $user = Auth::user();
            return view('profile-auth', compact('user'));
        }
        else{
            $user = User::where('alias', $alias)->firstOrFail();
            return view('profile-others', compact('user'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showEdit($alias)
    {
        $user = Auth::user();

        if($user->alias == $alias){

            $countries = Country::all();
            $personalities = Personality::all();

            return view('profile-edit', compact('user', 'countries', 'personalities'));
        }
        else{
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateFromEdit(Request $request, $alias)
    {
        $user = Auth::user();

        if($user->alias == $alias){

             if($request->email == $user->email){
                unset($request['email']);
             }

             if($request->alias == $alias){
                unset($request['alias']);
             }
             else{
               $alias = $request->alias;
             }

             //$user = User::where('alias', $alias)->firstOrFail();

             $this->validator($request->all())->validate();


             // this 'fills' the user model with all fields of the Input that are fillable
             $user->fill($request->all());
             $user->save();

             return redirect()->route('profile', ['alias' => $alias]);
        }
        else{
            return abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
