<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
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
