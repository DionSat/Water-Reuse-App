<?php

namespace App\Http\Controllers\DataControllers;

use App\City;
use App\County;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CountyController extends Controller
{
    public function allCounties() {
        $counties = County::with('state')->get();
        return view("database.counties", compact('counties'));
    }

    public function addCounty() {
        $states = State::all();
        return view("database.addCounty", compact( 'states'));
    }

    public function addCountySubmit(Request $request) {
        if (empty($request->county))
            return redirect()->route('countyAdd')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a county name!']);

        $county = new County();
        $county->countyName = $request->county;
        $county->fk_state = $request->state;
        $county->save();

        return redirect()->route('countyView')->with(['alert' => 'success', 'alertMessage' => $county->countyName . ' has been added.']);
    }

    public function deleteCounty(Request $request)
    {
        $county = County::where("county_id", $request->county_id)->get()->first();

        $citiesInState = City::where("fk_county", $request->county_id)->get();
        if($citiesInState->count() != 0) {
            $backRoute = route("countyView");
            $backName  = "Counties";
            $item = $county->countyName." county";
            $dependantCategory = "counties";
            $dependantItems = [];

            foreach ($citiesInState as $city){
                $dependantItems [] = $city->cityName;
            }

            return view("database.dependencyError", compact('backName', 'backRoute', 'item', 'dependantCategory', 'dependantItems'));
        }

        //If no dependencies, then delete
        $county->delete();

        return redirect()->route('countyView')->with(['alert' => 'success', 'alertMessage' => $county->countyName . ', ' . $county->state->stateName . ' has been deleted.']);
    }
}