<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class SearchController extends Controller
{

    public function search ()
    {
        $term = Input::get('search');
    	$results = User::where('alias', 'LIKE', '%'.$term.'%')->get();

        return view('search', compact('results'));
    }
}
