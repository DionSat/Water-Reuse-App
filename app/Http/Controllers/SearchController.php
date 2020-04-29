<?php

namespace App\Http\Controllers;

use App\State;
use App\StateMerge;
use App\CountyMerge;
use App\CityMerge;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function mainPage(){
        
        $states = State::all();
        return view("search.searchpage", compact('states'));
    }


    public function handleSubmit(Request $request){

        $statesSubmissions = StateMerge::where("stateID", $request->state_id)->get();
        $countySubmissions = CountyMerge::where("countyID", $request->county_id)->get();
        $citySubmissions = CityMerge::where("cityID", $request->city_id)->get();
        //var_dump($statesSubmissions->toArray());
        //var_dump($countySubmissions->toArray());
        //var_dump($statesSubmissions->toArray());
        $allSubmissions = $statesSubmissions->merge($countySubmissions)->merge($citySubmissions);
        //var_dump($allSubmissions->toArray());
        return view("search.searchresults", compact('allSubmissions'));
    }
}
