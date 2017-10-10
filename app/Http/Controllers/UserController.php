<?php

namespace App\Http\Controllers;

use App\User;
use App\Country;
use App\Personality;
use App\FriendRequest;
use App\Quality;
use App\UserQuality;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\FriendRequestController;



//Pour les validations
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function removeFriend($friendAlias)
    {
        //Vérifie qu'on ne s'ajoute pas soi-même en ami
        if($friendAlias != Auth::user()->alias){

            $friendId = User::where('alias', $friendAlias)->firstOrFail()->id;

            if(FriendRequest::where('requester_id', Auth::user()->id)->where('requested_id', $friendId)->delete()){
                $msg = 'Friend request to ' . $friendAlias . ' has been successfully canceled';
                Session::flash('status-success', $msg);
                return redirect()->back();
            }


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
            if(FriendRequest::isFriendRequestBetweenTwoUsers(Auth::user()->id, $friendId)){
                Session::flash('status-danger', 'You already requested this user to be your friend!');
                return redirect()->back();
            }


            FriendRequest::create([
                'requester_id' => Auth::user()->id,
                'requested_id' => $friendId
            ]);

            $msg = 'Friend request sent to ' . $friendAlias . '!';
            Session::flash('status-success', $msg);

            echo ('super salami');

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
            //'quality_id' => 'exists:qualities,id'
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
        $user = User::where('alias', $alias)->firstOrFail();
        $user_qualities = UserQuality::where('user_id',$user->id)->get();

        //TODO : pas dry
        if($alias == Auth::user()->alias){
            $user = Auth::user();
            return view('profile-auth', compact('user', 'user_qualities'));
        }
        else{
            return view('profile-others', compact('user', 'user_qualities'));
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
            $qualities = Quality::all();

            $users_qualtities = UserQuality::where('user_id', $user->id)->get();

            $arr_users_qualities=array();

            foreach ($users_qualtities as $user_quality){
                $arr_users_qualities[] = $user_quality->quality;
            }

            return view('profile-edit', compact('user', 'countries', 'personalities', 'qualities', 'arr_users_qualities'));
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

            //supprime toutes les qulaités de l'utilisateur.
            UserQuality::where('user_id', $user->id)->delete();

            $data=array();
            foreach ($request->quality_id as $quality_id) {
                $data[] = array('user_id'=>$user->id,
                                'quality_id'=>$quality_id,
                                "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
                                "updated_at" => \Carbon\Carbon::now(),  # \Datetime()
                                );
            }

            UserQuality::insert($data);

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
