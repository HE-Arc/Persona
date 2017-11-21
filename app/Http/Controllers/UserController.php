<?php

namespace App\Http\Controllers;

use App\User;
use App\Country;
use App\Personality;
use App\FriendRequest;
use App\Quality;
use App\UserQuality;
use App\Http\Requests\UserPost;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\FriendRequestController;

class UserController extends Controller
{
    public function showTest($alias)
    {

        $user = User::where('alias', $alias)->firstOrFail();
        echo '<h1>My personality</h1>';
        echo $user->personality->type;

        echo '<h1>People with the same personality</h1>';
        echo $user->personality->users;

        // dd($user->personality->users);
        // dd($user->personality);

        $auth = Auth::user();
        //dd($user->friendRequestsTo);
        //dd($auth->friendRequestsFrom);
        //dd($auth->friends);


        echo '<h1>My requests to :</h1>';
        foreach ($auth->friendRequestsTo as $fr_user) {
            echo($fr_user->friendRequest->friendship . ' ');
            echo($fr_user->alias . ' ');
            echo($fr_user->friendRequest->created_at . '<br>');
        }

        echo '<h1>My requests from :</h1>';
        foreach ($auth->friendRequestsFrom as $fr_user) {
            echo($fr_user->friendRequest->friendship . ' ');
            echo($fr_user->alias . ' ');
            echo($fr_user->friendRequest->created_at . '<br>');
        }

        echo '<h1>My friends :</h1>';
        foreach ($auth->friends as $fr_user) {
            echo($fr_user->friendRequest->friendship . ' ');
            echo($fr_user->alias . ' ');
            echo($fr_user->friendRequest->created_at . '<br>');
        }

        echo '<h1>My qualities :</h1>';
        foreach ($auth->qualities as $quality) {
            echo($quality->quality . '<br>');
            $tmp_qual = $quality;
        }

        echo '<h1>Users sharing my last quality :</h1>';
        foreach ($tmp_qual->users as $user) {
            echo($user->alias . '<br>');
        }

        dd();


        return view('test');
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

        if($alias == Auth::user()->alias){
            $user = Auth::user();
            $view = 'profile-auth';
        }
        else{
            $view = 'profile-others';
        }

        $nb_friends_personality = collect();
        $nb_friends_quality_name =  collect();

        // Récupère les nom des qualités de l'utilisateur
        $arr_users_qualities = $user->qualities->pluck('quality');

        if($view == 'profile-auth'){

            //Personalités et graphique
            $friend_list = $user->friends;

            // Ajoute les personnalités des amis à la liste
            foreach ($friend_list as $friend){
                $nb_friends_personality->push($friend->personality);
            }

            // Regroupe les personnalités et les compte
            $nb_friends_personality = $nb_friends_personality->groupBy('type')->map(function ($item, $key) {
                return collect($item)->count();
            });

            // -------------------------------------------

            //Qualités et graphique

            // Récupère les amis
            $friend_list = $user->friends;

            // Ajoute les personnalités des amis à la liste
            foreach ($friend_list as $friend){
                $nb_friends_quality_name->push($friend->qualities);
            }

            // Regroupe par qualité et en compte le nombre pour chacune
            $nb_friends_quality_name = $nb_friends_quality_name->flatten()->groupBy('quality')->map(function ($item, $key) {
                return collect($item)->count();
            });
        }


        return view($view, compact('user', 'arr_users_qualities', 'nb_friends_personality', 'nb_friends_quality_name'));
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

            $arr_users_qualities = $user->qualities->pluck('quality')->all();

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
     //UserPost valide la requête avant de continuer
    public function updateFromEdit(UserPost $request, $alias)
    {
        $user = Auth::user();
        $tmp_request = array();
        $tmp_request = $request->all();

        if($user->alias == $alias){
             // this 'fills' the user model with all fields of the Input that are fillable
             $user->fill($tmp_request);
             $user->save();

            //supprime toutes les qulaités de l'utilisateur.
            UserQuality::where('user_id', $user->id)->delete();

            if(!empty($request->quality_id)){

                //récupère tous les id du tableau pour les noms de qualité correspondants
                $qualities_ids = Quality::select('id')->whereIn('quality',$request->quality_id )->get();
                $iterator_qualities_ids = $qualities_ids->getIterator();
                $first = 1; //variable servant à savoir si c'est le premier passage ou non
                $data=array();

                //boucle permettant de remplir le tableau avec les id des qualité et l'id de l'utilisateur
                foreach ($request->quality_id as $quality_id) {
                    $data[] = array('user_id'=>$user->id,
                                    'quality_id'=> $first == 1 ? current($iterator_qualities_ids)->id : next($iterator_qualities_ids)->id, //1er passage on affect current id sinon on prend le prochain
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
