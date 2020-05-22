<?php

namespace App\Http\Controllers\DataControllers;

use App\City;
use App\County;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function allCities() {
        $cities = City::with(['county', 'county.state'])->paginate(10);
        //$cities = DB::table('cities')->paginate(10);
        return view("database.cities", compact('cities'));
    }

    public function addCity() {
        $counties = County::all();
        $states = State::all();
        return view("database.addCity", compact('counties', 'states'));
    }

    public function addCitySubmit(Request $request) {
        if (empty($request->city))
            return redirect()->route('cityAdd')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a city name!']);

        $city = new City();
        $city->cityName = $request->city;
        $city->fk_county = $request->county;
        $city->is_approved = true;
        $city->save();

        return redirect()->route('cityView')->with(['alert' => 'success', 'alertMessage' => $city->cityName . ' has been added.']);
    }

    public function deleteCity(Request $request) {
        $city = City::where("city_id", $request->city_id)->get()->first();
        $city->delete();

        return redirect()->route('cityView')->with(['alert' => 'success', 'alertMessage' => $city->cityName . ', ' . $city->county->state->stateName . ' has been deleted.']);
    }

    public function getCitiesInCounty(Request $request){
        $cities = City::where("fk_county", $request->county_id)->get();
        return response()->json($cities);
    }

    public function modify(Request $request) {
        $city = City::where("city_id", $request->city_id)->get()->first();
        return view('database.modifyCity', compact('city'));
    }

    public function modifyCitySubmit(Request $request) {
        $city = City::where("city_id", $request->city_id)->get()->first();
        if(empty($request->newCityValue))
            return redirect()->route('modifyCity', ['city_id' => $city->city_id])->with(['alert' => 'danger', 'alertMessage' => 'Please enter a city name!']);

        $oldCityName = $city->cityName;
        $city->cityName = $request->newCityValue;
        $city->save();

        return redirect()->route('cityView')->with(['alert' => 'success', 'alertMessage' => $oldCityName . ' has been changed to ' . $city->cityName]);
    }
}
