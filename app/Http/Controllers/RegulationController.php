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
        $mergeTable;
        foreach($regLists as $regList)
        {
            //There is only a State
            if($regLists[0]['$county'] == '' || $regLists[0]['$county'] == 'Choose...')
            {
                $mergeTable = new PendingStateMerge();
                $mergeTable->stateID = $regList['$stateId'];
                $regArea = $regLists[0]['$state'];
            }
            //There is a State and a County
            else if($regLists[0]['$city'] == '' || $regLists[0]['$city'] == 'Choose...')
            {
                $mergeTable = new PendingCountyMerge();
                $mergeTable->countyID = $regList['$countyId'];
                $regArea = $regLists[0]['$county'];
            }
            //There is a city. The code will not call the post unless there is at
            //least a State selected, so this assumes there will always be a state.
            else{
                $mergeTable = new PendingCityMerge();
                $mergeTable->cityID = $regList['$cityId'];
                $regArea = $regLists[0]['$city'];
            }

            $codesLink = new Links();
            $permitLink = new Links();
            $incentivesLink = new Links();
            $moreInfoLink = new Links();


            $codesLink->linkText = $regList['$codesLink'];
            $codesLink->save();
            $mergeTable->codes = $codesLink->link_id;

            $permitLink->linkText = $regList['$permitLink'];
            $permitLink->save();
            $mergeTable->permit = $permitLink->link_id;

            $incentivesLink->linkText = $regList['$incentivesLink'];
            $incentivesLink->save();
            $mergeTable->incentives = $incentivesLink->link_id;

            $moreInfoLink->linkText = $regList['$moreInfoLink'];
            $moreInfoLink->save();
            $mergeTable->moreInfo = $moreInfoLink->link_id;

            $mergeTable->sourceID = $regList['$sourceId'];
            $mergeTable->destinationID = $regList['$destinationId'];
            $mergeTable->allowedID = $regList['$isPermitted'];
            $mergeTable->user_id = Auth::user()->id;
            if($mergeTable->save() == false)
            {
                $codesLink->delete();
                $permitLink->delete();
                $incentivesLink->delete();
                $moreInfoLink->delete();
            }
        }

        return $regArea;
    }
}
