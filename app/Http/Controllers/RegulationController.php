<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\PendingCityMerge;
use App\StateMerge;
use App\PendingCountyMerge;
use App\PendingStateMerge;
use App\Links;
use Illuminate\Support\Facades\DB;
use App\City;
use App\Allowed;
use App\County;
use App\ReuseNode;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

Class RegulationController extends Controller{
    public function allStates(){
        $states = State::all();
        return view("userSubmission", compact('states'));
    }

    public function getAllSources(){
        return response()->json(ReuseNode::sources());
    }

    public function getAllDestinations() {
        return response()->json(ReuseNode::destinations());
    }
    public function getAllAllowed() {
        return response()->json(Allowed::all());
    }

    public function addRegulationSubmit(Request $request) {
        if (empty($request->newRegList))
            return redirect()->route('regSubmit')->with(['alert' => 'danger', 'alertMessage' => 'You submitted an empty regulation']);

        $regLists = json_decode($request->newRegList, true);
        $regArea = "";

        //There is only a State
        if($regLists[0]['$county'] == '' || $regLists[0]['$county'] == 'Choose...')
        {
            foreach($regLists as $regList)
            {

                $codesLink = new Links();
                $codesLink->linkText = $regList['$codesLink'];
                $codesLink->save();

                $permitLink = new Links();
                $permitLink->linkText = $regList['$permitLink'];
                $permitLink->save();

                $insentivesLink = new Links();
                $insentivesLink->linkText = $regList['$insentivesLink'];
                $insentivesLink->save();

                $moreInfoLink = new Links();
                $moreInfoLink->linkText = $regList['$moreInfoLink'];
                $moreInfoLink->save();

                $state = new PendingStateMerge();
                $state->delete();
                $state = new PendingStateMerge();
                $state->stateID = $regList['$stateId'];
                $state->sourceID = $regList['$sourceId'];
                $state->destinationID = $regList['$destinationId'];
                $state->allowedID = $regList['$isPermitted'];
                $state->codes = $codesLink->link_id;
                $state->permit = $permitLink->link_id;
                $state->incentives = $insentivesLink->link_id;
                $state->moreInfo = $moreInfoLink->link_id;
                $state->user_id = Auth::user()->id;
                if($state->save() == false)
                {
                    $codesLink->delete();
                    $permitLink->delete();
                    $insentivesLink->delete();
                    $moreInfoLink->delete();
                }
            }
            $regArea = $regLists[0]['$state'];
        }
        //There is a State and a County
        else if($regLists[0]['$city'] == '' || $regLists[0]['$city'] == 'Choose...')
        {
            foreach($regLists as $regList)
            {
                $codesLink = new Links();
                $codesLink->linkText = $regList['$codesLink'];
                $codesLink->save();

                $permitLink = new Links();
                $permitLink->linkText = $regList['$permitLink'];
                $permitLink->save();

                $insentivesLink = new Links();
                $insentivesLink->linkText = $regList['$insentivesLink'];
                $insentivesLink->save();

                $moreInfoLink = new Links();
                $moreInfoLink->linkText = $regList['$moreInfoLink'];
                $moreInfoLink->save();

                $countyMerge = new PendingCountyMerge();
                $countyMerge->countyID = $regList['$countyId'];
                $countyMerge->sourceID = $regList['$sourceId'];
                $countyMerge->destinationID = $regList['$destinationId'];
                $countyMerge->allowedID = $regList['$isPermitted'];
                $countyMerge->codes = $codesLink->link_id;
                $countyMerge->permit = $permitLink->link_id;
                $countyMerge->incentives = $insentivesLink->link_id;
                $countyMerge->moreInfo = $moreInfoLink->link_id;
                $countyMerge->user_id = Auth::user()->id;
                $countyMerge->save();
            }
            $regArea = $regLists[0]['$county'];
        }
        //There is a city. The code will not call the post unless there is at
        //least a State selected, so this assumes there will always be a state.
        else{
            foreach($regLists as $regList)
            {
                $codesLink = new Links();
                $codesLink->linkText = $regList['$codesLink'];
                $codesLink->save();

                $permitLink = new Links();
                $permitLink->linkText = $regList['$permitLink'];
                $permitLink->save();

                $insentivesLink = new Links();
                $insentivesLink->linkText = $regList['$insentivesLink'];
                $insentivesLink->save();

                $moreInfoLink = new Links();
                $moreInfoLink->linkText = $regList['$moreInfoLink'];
                $moreInfoLink->save();

                $cityMerge = new PendingCityMerge();
                $cityMerge->cityID = $regList['$cityId'];
                $cityMerge->sourceID = $regList['$sourceId'];
                $cityMerge->destinationID = $regList['$destinationId'];
                $cityMerge->allowedID = $regList['$isPermitted'];
                $cityMerge->codes = $codesLink->link_id;
                $cityMerge->permit = $permitLink->link_id;
                $cityMerge->incentives = $insentivesLink->link_id;
                $cityMerge->moreInfo = $moreInfoLink->link_id;
                $cityMerge->user_id = Auth::user()->id;
                $cityMerge->save();
            }
            $regArea = $regLists[0]['$city'];
        }

        return $regArea;
    }
}
