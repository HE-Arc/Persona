<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    /**
    * Search bar.
    *
    */
    public function search ()
    {
        $term = Input::get('search');
    	$results = User::where('alias', 'LIKE', '%'.$term.'%')->get();

        return view('search', compact('results'));
    }

    /**
    * Autocomplete for search bar.
    *
    */
    public function autocomplete()
    {
        $term = request('term');
        $results = User::where('alias', 'LIKE', '%'.$term.'%')->get(['alias as label']);

        // TODO : Fais le job mais un peu dégueu...
        $results_array = [];
        foreach ($results as $result) {
            $array = ["label" => $result["label"], "url" => route('profile', $result["label"])];
            array_push($results_array, $array);
        }

        return response()->json($results_array);
    }
}
