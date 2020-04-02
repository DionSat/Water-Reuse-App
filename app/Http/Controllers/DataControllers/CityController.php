<?php

namespace App\Http\Controllers\DataControllers;

use App\City;
use App\County;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function allCities() {
        $cities = City::with(['county', 'county.state'])->get();
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
        $city->save();

        return redirect()->route('cityView')->with(['alert' => 'success', 'alertMessage' => $city->cityName . ' has been added.']);
    }

    public function deleteCity(Request $request) {
        $city = City::where("city_id", $request->city_id)->get()->first();
        $city->delete();

        return redirect()->route('cityView')->with(['alert' => 'success', 'alertMessage' => $city->cityName . ', ' . $city->county->state->stateName . ' has been deleted.']);
    }
}