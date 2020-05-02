<?php

namespace App\Http\Controllers;

use App\State;
use App\StateMerge;
use App\CountyMerge;
use App\CityMerge;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function mainPage(){
        
        $states = State::all();
        return view("search.searchpage", compact('states'));
    }


    public function handleSubmit(Request $request){
        $countySubmissions = new Collection();
        $citySubmissions = new Collection();

        $statesSubmissions = StateMerge::with(['state', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])
                                        ->where("stateID", $request->state_id)->get();
        if($request->county_id != -1){
            $countySubmissions = CountyMerge::with(['county', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])
                ->where("countyID", $request->county_id)->get();
        }

        if($request->city_id != -1) {
            $citySubmissions = CityMerge::with(['city', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])
                ->where("cityID", $request->city_id)->get();
        }

        $allSubmissions = $statesSubmissions->merge($countySubmissions)->merge($citySubmissions);

        return view("search.searchresults", compact('allSubmissions'));
    }
}
