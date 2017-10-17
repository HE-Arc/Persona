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



    /**
     * Get a validator for an incoming edit profile request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'alias' => 'string|max:20|unique:users', //TODO : Confirmation en direct ?
            'email' => 'string|email|max:255|unique:users',
            'country_id' => 'required|exists:countries,id',
            'personality_id' => 'required|exists:personalities,id',
            'gender' => ['required', Rule::in(['m', 'f'])],
            'birthday' => 'required|date',
            'quality_id' => 'exists:qualities,quality|max:8'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProfile($alias)
    {
        $user = User::where('alias', $alias)->firstOrFail();
        $users_qualities = UserQuality::where('user_id',$user->id)->get();

        $arr_users_qualities=array();
        // TODO: methode dans model
        foreach ($users_qualities as $user_quality){
            $arr_users_qualities[] = Quality::find($user_quality->quality_id)->quality;
        }

        if($alias == Auth::user()->alias){
            $user = Auth::user();
            $view = 'profile-auth';
        }
        else{
            $view = 'profile-others';
        }
        return view($view, compact('user', 'user_qualities', 'arr_users_qualities'));
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

            //TODO : methode dans model
            $arr_users_qualities=array();

            foreach ($users_qualtities as $user_quality){
                $arr_users_qualities[] = Quality::find($user_quality->quality_id)->quality;
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
        $tmp_request = array();
        $tmp_request = $request->all();

        if($user->alias == $alias){

             if($request->email == $user->email){
                unset($tmp_request['email']);
             }

             if($request->alias == $alias){
                unset($tmp_request['alias']);
             }
             else{
               $alias = $request->alias;
             }

             //$user = User::where('alias', $alias)->firstOrFail();

             $this->validator($tmp_request)->validate();


             // this 'fills' the user model with all fields of the Input that are fillable
             $user->fill($tmp_request);
             $user->save();

            //supprime toutes les qulaités de l'utilisateur.
            UserQuality::where('user_id', $user->id)->delete();


            if(!empty($request->quality_id)){
                $data=array();
                //TODO : surement améliorable (nombre de requêtes pour trouver id)
                foreach ($request->quality_id as $quality_id) {
                    $tmp_quality_id = Quality::where('quality',$quality_id )->value('id');
                    $data[] = array('user_id'=>$user->id,
                                    'quality_id'=>$tmp_quality_id,
                                    "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
                                    "updated_at" => \Carbon\Carbon::now(),  # \Datetime()
                                    );
                }
                UserQuality::insert($data);
            }



             return redirect()->route('profile', ['alias' => $alias]);
        }
        else{
            return abort(404);
        }
    }

}
