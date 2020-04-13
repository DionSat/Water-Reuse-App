<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\CityMerge;
use App\CountyMerge;
use App\StateMerge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\PendingStateMerge;
use App\PendingCityMerge;
use App\PendingCountyMerge;

class MergeController extends Controller
{
    public $timestamps = true;
    
    public function addCityMergeSubmit(Request $request) 
    {

        $city = new CityMerge();
        $city->cityID = $request->city;
        $city->sourceID = $request->city;
        $city->destinationID = $request->city;
        $city->allowedID = $request->city;
        $city->codes = $request->city;
        $city->permit = $request->city;
        $city->incentives = $request->city;
        $city->moreInfo = $request->city;
        $city->userID = $request->city;
        $city->save();

        return redirect()->route('userCityView')->with(['alert' => 'success', 'alertMessage' => ' Submission has been added.']);
    }

    public function addStateMergeSubmit(Request $request) 
    {

        $state = new StateMerge();
        $state->stateID = $request->state;
        $state->sourceID = $request->state;
        $state->destinationID = $request->state;
        $state->allowedID = $request->state;
        $state->codes = $request->state;
        $state->permit = $request->state;
        $state->incentives = $request->state;
        $state->moreInfo = $request->state;
        $state->userID = $request->state;
        $state->save(['timestamps' => false]);

        return redirect()->route('userStateView')->with(['alert' => 'success', 'alertMessage' => ' submission has been added.']);
    }

    public function addCountyMergeSubmit(Request $request) 
    {

        $county = new CountyMerge();
        $county->countyID = $request->county;
        $county->sourceID = $request->county;
        $county->destinationID = $request->county;
        $county->allowedID = $request->county;
        $county->codes = $request->county;
        $county->permit = $request->county;
        $county->incentives = $request->county;
        $county->moreInfo = $request->county;
        $county->userID = $request->county;
        $county->save(['timestamps' => false]);

        return redirect()->route('userCountyView')->with(['alert' => 'success', 'alertMessage' => ' submission has been added.']);
    }

    public function deleteCityMerge(Request $request)
    {
        $city = PendingCityMerge::where("id", $request->id)->get()->first();
        $city->delete();

        return redirect()->route('userCityView')->with(['alert' => 'success', 'alertMessage' => ' submission has been deleted.']);
    }
    
    public function deleteStateMerge(Request $request)
    {
        $state = PendingStateMerge::where("id", $request->id)->get()->first();
        $state->delete();

        return redirect()->route('userStateView')->with(['alert' => 'success', 'alertMessage' =>' submission has been deleted.']);
    }

    public function deleteCountyMerge(Request $request)
    {
        $county = PendingCountyMerge::where("id", $request->id)->get()->first();
        $county->delete();

        return redirect()->route('userCountyView')->with(['alert' => 'success', 'alertMessage' => ' submission has been deleted.']);
    }
}