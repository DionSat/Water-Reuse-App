<?php

namespace App\Http\Controllers;

use App\City;
use App\County;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

Class RegulationController extends Controller{
    public function allStates(){
        $states = State::all();
        return view("userSubmission", compact('states'));
    }

    public function getCountiesInState(Request $request){
        $counties = County::where("fk_state", $request->state_id)->get();
        return response()->json($counties);
    }

    public function getCitiesInCounty(Request $request){
        $cities = City::where("fk_county", $request->county_id)->get();
        return response()->json($cities);
    }
}
