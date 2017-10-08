<?php

namespace App\Http\Controllers;

use App\User;
use App\Country;
use App\Personality;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

//Pour les validations
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function addFriend($alias)
    {
        if($alias != Auth::user()->alias){
            echo ('Ajout de ' . $alias . ' dans vos amis.');
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
