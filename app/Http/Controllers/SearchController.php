<?php

namespace App\Http\Controllers;

use App\City;
use App\County;
use App\Links;
use App\ReuseNode;
use App\State;
use App\StateMerge;
use App\CountyMerge;
use App\CityMerge;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Services\LinkCheckerService;

class SearchController extends Controller
{
    public function mainPage(){
        
        $states = State::all()->sortBy("stateName");
        return view("search.searchpage", compact('states'));
    }


    public function handleSubmit(Request $request){
        $countyRules = new Collection();
        $cityRules = new Collection();
        $state = State::find($request->state_id);
        $county = null;
        $city = null;
        $lowestLevel = "state";

        $stateRules = StateMerge::with(['state', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])
                                        ->where("stateID", $request->state_id)->where("location_type", $request->searchType)->get();
        if(isset($request->county_id)){
            $countyRules = CountyMerge::with(['county', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])
                ->where("countyID", $request->county_id)->get();
            $lowestLevel = "county";
            $county = County::find($request->county_id);
        }

        if(isset($request->city_id)) {
            $cityRules = CityMerge::with(['city', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])
                ->where("cityID", $request->city_id)->get();
            $lowestLevel = "city";
            $city = City::find($request->city_id);
        }

        // Get all the sources and destinations
        $sources = ReuseNode::sources()->sortBy("node_name");
        $destinations = ReuseNode::destinations()->sortBy("node_name");
        $type = $request->searchType === "residential" ? "Residential" : "Commercial";

        return view("search.searchresults", compact('stateRules', 'countyRules', 'cityRules', 'lowestLevel', 'city', 'county', 'state', 'sources', 'destinations', 'type'));
    }
}
