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
        $pending = PendingCityMerge::find($request->id);

        $city = new CityMerge();
        $city->cityID = $pending->cityID;
        $city->sourceID = $pending->sourceID;
        $city->destinationID = $pending->destinationID;
        $city->allowedID = $pending->allowedID;
        $city->codes = $pending->codes;
        $city->permit = $pending->permit;
        $city->incentives = $pending->incentives;
        $city->moreInfo = $pending->moreInfo;
        $city->user_id = $pending->userID;
        $city->save();

        return redirect()->route('userCityView')->with(['alert' => 'success', 'alertMessage' => ' Submission has been added.']);
    }

    public function addStateMergeSubmit(Request $request) 
    {
        $pending = PendingStateMerge::find($request->id);

        $state = new StateMerge();
        $state->stateID = $pending->stateID;
        $state->sourceID = $pending->sourceID;
        $state->destinationID = $pending->destinationID;
        $state->allowedID = $pending->allowedID;
        $state->codes = $pending->codes;
        $state->permit = $pending->permit;
        $state->incentives = $pending->incentives;
        $state->moreInfo = $pending->moreInfo;
        $state->user_id = $pending->userID;
        $state->save();

        return redirect()->route('userStateView')->with(['alert' => 'success', 'alertMessage' => ' submission has been added.']);
    }

    public function addCountyMergeSubmit(Request $request) 
    {
        $pending = PendingCountyMerge::find($request->id);
        $county = new CountyMerge();
        $county->countyID = $pending->countyID;
        $county->sourceID = $pending->sourceID;
        $county->destinationID = $pending->destinationID;
        $county->allowedID = $pending->allowedID;
        $county->codes = $pending->codes;
        $county->permit = $pending->permit;
        $county->incentives = $pending->incentives;
        $county->moreInfo = $pending->moreInfo;
        $county->user_id = $pending->userID;
        $county->save(['timestamps' => false]);

        $county = PendingCountyMerge::where("id", $request->id)->get()->first();
        $county->delete();
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