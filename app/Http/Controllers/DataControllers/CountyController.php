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
        $counties = County::with('state')->paginate(10);
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
        $county->is_approved = true;
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

    public function getCountiesInState(Request $request){
        $counties = County::where("fk_state", $request->state_id)->get();
        return response()->json($counties);
    }

    public function modify(Request $request) {
        $county = County::where("county_id", $request->county_id)->get()->first();
        return view('database.modifyCounty', compact('county'));
    }

    public function modifyCountySubmit(Request $request) {
        $county = County::where("county_id", $request->county_id)->get()->first();
        if(empty($request->newCountyValue))
            return redirect()->route('modifyCounty', ['county_id' => $county->county_id])->with(['alert' => 'danger', 'alertMessage' => 'Please enter a county name!']);

        $oldCountyName = $county->countyName;
        $county->countyName = $request->newCountyValue;
        $county->save();

        return redirect()->route('countyView')->with(['alert' => 'success', 'alertMessage' => $oldCountyName . ' has been changed to ' . $county->countyName]);
    }

}
