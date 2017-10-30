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
    //TODO : Voir si existe moyen pour avoir un seul validator entre userRegistration et UserController
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

        //Graphique des personalités
        $nb_friends_personality = array();
        $friend_list = $user->getFriendList();
        $personalities = Personality::get();

        //TODO : Possible de faire l'éauivelent avec un groupby et un count ?

        //boucle permettant de remplir le tableau avec le nombre d'ami possédant une personalité
        foreach ($personalities as $personality) {
            $nb_friends_personality += array($personality->type => 0);

            foreach ($friend_list as $friend) {
                if($personality->id == $friend->personality_id)
                {
                    //compte le nombre d'ami par personnalité
                    $nb_friends_personality[$personality->type] +=1;
                }
            }
        }

        //Graphique des qualités
        $nb_friends_quality_id =  array();
        $friend_list = $user->getFriendList();

        //TODO : Possible de faire l'éauivelent avec un groupby et un count ?

        //boucle permettant de remplire le tableau avec le nombre d'ami possédant une qualité
            foreach ($friend_list as $friend) {
                $friend_qualities = $friend->getQualities();

                foreach ($friend_qualities as $friend_quality) {

                    if (in_array($friend_quality->quality_id, array_keys($nb_friends_quality_id))){
                        $nb_friends_quality_id[$friend_quality->quality_id] +=1;
                    }
                    else{
                        $nb_friends_quality_id[$friend_quality->quality_id]=1;
                    }
                }
            }

            $nb_friends_quality_name =  array();

            foreach ($nb_friends_quality_id as $key => $value) {
                $nb_friends_quality_name[Quality::find($key)->quality] = $value;
            }

        return view($view, compact('user', 'user_qualities', 'arr_users_qualities', 'nb_friends_personality', 'nb_friends_quality_name'));
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

            //récupère tous les id du tableau $request->quality_id
            $qualities_ids = Quality::select('id')->whereIn('quality',$request->quality_id )->get();

            $iterator_qualities_ids = $qualities_ids->getIterator();
            $first = 1;

            if(!empty($request->quality_id)){
                $data=array();

                foreach ($request->quality_id as $quality_id) {
                    $data[] = array('user_id'=>$user->id,
                                    'quality_id'=> $first == 1 ? current($iterator_qualities_ids)->id : next($iterator_qualities_ids)->id,
                                    "created_at" =>  \Carbon\Carbon::now(), # \Datetime()
                                    "updated_at" => \Carbon\Carbon::now(),  # \Datetime()
                                    );
                    $first = 0;
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
