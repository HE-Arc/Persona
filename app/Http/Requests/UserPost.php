<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = Auth::user();

        // Règles lors du premier enregistrement de l'utilisateur.
        $rules = [
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'alias' => 'string|max:20|unique:users', //TODO : Vérification disponibilité dynamique
            'email' => 'string|email|max:255|unique:users',
            'country_id' => 'required|exists:countries,id',
            'personality_id' => 'required|exists:personalities,id',
            'gender' => ['required', Rule::in(['m', 'f'])],
            'birthday' => 'required|date',
            'quality_id' => 'exists:qualities,quality|max:8'
        ];

        //Règles modifié si l'utilisateur existe déjà et modifie ses informations.
        //Dans ce cas alias et email correspondants à l'ID est ignoré.
        if(!empty($user)){
            $rules['alias'] = 'string|max:20|unique:users,alias,'.$user->id;
            $rules['email'] = 'string|email|max:255|unique:users,email,'.$user->id;
        }

        return $rules;
    }
}
