<?php

namespace App\Services;
use App\City;
use App\County;
use App\State;
use App\CityMerge;
use App\CountyMerge;
use App\StateMerge;
use Illuminate\Support\Facades\Auth;
use App\PendingCityMerge;
use App\PendingCountyMerge;
use App\PendingStateMerge;
use App\Links;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class DatabaseHelper {

    public static function addRegulation(Request $request, $regLists) {
        $regArea = "";
        $mergeTable = null;
        $isNew = false;
        $isNewCounty = false;
        $isNewCity = false;
        $isNewState = false;

        //check to see if it's a new area
        if($regLists[0]['$stateId'] == -1)
        {
            $isNew = true;
        }

        foreach($regLists as $regList)
        {
            //need to add a new area
            if($isNew)
            {
                if($regLists[0]['$stateId'] == -1)
                {
                    $stateCheck =  State::where("stateName", $regLists[0]['$state'])->get()->first();
                    $countyCheck = County::where("countyName", $regLists[0]['$county'])->get()->first();
                    $cityCheck = City::where("cityName", $regLists[0]['$city'])->get()->first();

                    if(!$stateCheck && $regLists[0]['$state'] != "")
                    {
                        $state = new State();
                        $state->stateName = $regLists[0]['$state'];
                        try {
                            $state->save();
                        } catch(Throwable $e) {
                            return "State Already Exists, or There Was an Error on Loading New Area";
                        }
                            $mergeTable = new PendingStateMerge();
                            $mergeTable->stateID= $state->state_id;
                            $regArea = $regLists[0]['$state'];
                            $regLists[0]['$stateId'] = $state->state_id;
                            $isNewState = true;
                            $isNew = false;
                            $stateCheck = $state;
                    }
                    if(!$countyCheck && $regLists[0]['$county'] != ""){
                        $county = new County();
                        $county->countyName = $regLists[0]['$county'];
                        $county->fk_state = $stateCheck->state_id;
                        try {
                            $county->save();
                        }
                        catch(Throwable $e1){
                            return "County Already Exists, or There Was an Error on Loading New Area";
                        }

                            $mergeTable = new PendingCountyMerge();
                            $mergeTable->countyID = $county->county_id;
                            $regArea = $regLists[0]['$county'];
                            $regLists[0]['$countyId'] = $county->county_id;
                            $isNewCounty = true;
                            $isNewState = false;
                            $isNew = false;
                            $countyCheck = $county;
                    }
                    if(!$cityCheck && $regLists[0]['$city'] != "")
                    {
                        $city = new City();
                        $city->cityName = $regLists[0]['$city'];
                        $city->fk_county = $countyCheck->county_id;
                        try{
                            $city->save();
                        }
                        catch(Throwable $e2)
                        {
                            return "City Already Exists, or There Was an Error on Loading New Area";
                        }
                        $mergeTable = new PendingCityMerge();
                        $mergeTable->cityID= $city->city_id;
                        $regArea = $regLists[0]['$city'];
                        $regLists[0]['$cityId'] = $city->city_id;
                        $isNewCity = true;
                        $isNewState = false;
                        $isNewCounty = false;
                        $isNew = false;
                    }
                }
            }
            //There is only a State
            else if($regLists[0]['$county'] == 'Choose...' || $isNewState || $regLists[0]['$county'] == '')
            {
                $mergeTable = new PendingStateMerge();
                $regArea = $regLists[0]['$state'];
                $mergeTable->stateID = $regLists[0]['$stateId'];
            }
            //There is a State and a County
            else if($regLists[0]['$city'] == 'Choose...' || $isNewCounty || $regLists[0]['$city'] == '')
            {
                $mergeTable = new PendingCountyMerge();
                $mergeTable->countyID = $regLists[0]['$countyId'];
                $regArea = $regLists[0]['$county'];
            }
            //There is a city. The code will not call the post unless there is at
            //least a State selected, so this assumes there will always be a state.
            else if($regLists[0]['$city'] != 'Choose...' || $isNewCity || $regLists[0]['$city'] != ''){
                $mergeTable = new PendingCityMerge();
                $mergeTable->cityID = $regLists[0]['$cityId'];
                $regArea = $regLists[0]['$city'];
            }

            $codesLink = new Links();
            $permitLink = new Links();
            $incentivesLink = new Links();
            $moreInfoLink = new Links();

            $holdingVar = Links::where('linkText', $regList['$codesLink'])->get();
            if(count($holdingVar) > 0){
                $codesLink = Links::where('linkText', $regList['$codesLink'])->get()->first();
            }else{
                $codesLink->linkText = $regList['$codesLink'];
                $codesLink->save();
            }
            $mergeTable->codes = $codesLink->link_id;

            $holdingVar = Links::where('linkText', $regList['$permitLink'])->get();
            if(count($holdingVar) > 0){
                $permitLink = Links::where('linkText', $regList['$permitLink'])->get()->first();

            }else{
                $permitLink->linkText = $regList['$permitLink'];
                $permitLink->save();
            }
            $mergeTable->permit = $permitLink->link_id;

            $holdingVar = Links::where('linkText', $regList['$incentivesLink'])->get();
            if(count($holdingVar) > 0){
                $incentivesLink = Links::where('linkText', $regList['$incentivesLink'])->get()->first();
            }else{
                $incentivesLink->linkText = $regList['$incentivesLink'];
                $incentivesLink->save();
            }
            $mergeTable->incentives = $incentivesLink->link_id;

            $holdingVar = Links::where('linkText', $regList['$moreInfoLink'])->get();
            if(count($holdingVar) > 0) {
                $moreInfoLink = Links::where('linkText', $regList['$moreInfoLink'])->get()->first();

            }else{
                $moreInfoLink->linkText = $regList['$moreInfoLink'];
                $moreInfoLink->save();
            }
            $mergeTable->moreInfo = $moreInfoLink->link_id;

            $mergeTable->sourceID = $regList['$sourceId'];
            $mergeTable->destinationID = $regList['$destinationId'];
            $mergeTable->allowedID = $regList['$isPermitted'];
            $mergeTable->user_id = Auth::user()->id;
            $mergeTable->comments = $regList['$comments'];
            try {
                if($mergeTable->save() == false)
                {
                    $codesLink->delete();
                    $permitLink->delete();
                    $incentivesLink->delete();
                    $moreInfoLink->delete();
                }
            } catch (Exception $exception){
                return $exception->getMessage();// return "A API error occurred.";
            }
        }

        return $regArea;
    }

    public static function addCityMergeSubmit(Request $request)
    {
        $pending = PendingCityMerge::find($request->id);


        $city = new CityMerge();
        $cityToApprove = City::where("city_id", $pending->cityID)->get()->first();
        if($cityToApprove)
        {
            if(!$cityToApprove->is_approved)
            {
                $cityToApprove->is_approved = true;
                $cityToApprove->save();
            }
        }
        $city->cityID = $pending->cityID;
        $city->sourceID = $pending->sourceID;
        $city->destinationID = $pending->destinationID;
        $city->allowedID = $pending->allowedID;
        $city->codes = $pending->codes;
        $city->permit = $pending->permit;
        $city->incentives = $pending->incentives;
        $city->moreInfo = $pending->moreInfo;
        $city->user_id = $pending->user_id;
        $city->comments = $pending->comments;


        try {
            $city->save();
            $pending->forceDelete();
            return;
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function addStateMergeSubmit(Request $request)
    {
        $pending = PendingStateMerge::find($request->id);

        $state = new StateMerge();
        $stateToApprove = State::where("state_id", $pending->stateID)->get()->first();
        if($stateToApprove)
        {
            if(!$stateToApprove->is_approved)
            {
                $stateToApprove->is_approved = true;
                $stateToApprove->save();
            }
        }

        $state->stateID = $pending->stateID;
        $state->sourceID = $pending->sourceID;
        $state->destinationID = $pending->destinationID;
        $state->allowedID = $pending->allowedID;
        $state->codes = $pending->codes;
        $state->permit = $pending->permit;
        $state->incentives = $pending->incentives;
        $state->moreInfo = $pending->moreInfo;
        $state->user_id = $pending->user_id;
        $state->comments = $pending->comments;

        try {
            $state->save();
            $pending->forceDelete();
            return;
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function addCountyMergeSubmit(Request $request)
    {
        $pending = PendingCountyMerge::find($request->id);
        $county = new CountyMerge();
        $countyToApprove = County::where("county_id", $pending->countyID)->get()->first();
        if($countyToApprove)
        {
            if(!$countyToApprove->is_approved)
            {
                $countyToApprove->is_approved = true;
                $countyToApprove->save();
            }
        }
        $county->countyID = $pending->countyID;
        $county->sourceID = $pending->sourceID;
        $county->destinationID = $pending->destinationID;
        $county->allowedID = $pending->allowedID;
        $county->codes = $pending->codes;
        $county->permit = $pending->permit;
        $county->incentives = $pending->incentives;
        $county->moreInfo = $pending->moreInfo;
        $county->user_id = $pending->user_id;
        $county->comments = $pending->comments;

        try {
            $county->save();
            $pending->forceDelete();
            return;
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function submissionEditSubmit(Request $request)
    {
        if (!$request->city)
            $request->city = -1;

        switch ($request->type) {
            case 'State':
                $submission = PendingStateMerge::where('id', $request->id)->withTrashed()->get()->first();
                $submissionInfo = $submission->toArray();
                $submission->forceDelete();
                if($request->county > -1 && $request->city > -1){
                    $submission = new PendingCityMerge($submissionInfo);
                    $submission->cityID = $request->city;
                }else if($request->county > -1){
                    $submission = new PendingCountyMerge($submissionInfo);
                    $submission->countyID = $request->county;
                }else{
                    $submission = new PendingStateMerge($submissionInfo);
                    $submission->stateID = $request->state;
                }
                break;
            case 'County':
                $submission = PendingCountyMerge::where('id', $request->id)->withTrashed()->get()->first();
                $submissionInfo = $submission->toArray();
                $submission->forceDelete();
                if($request->county == -1){
                    $submission = new PendingStateMerge($submissionInfo);
                    $submission->StateID = $request->State;
                }else if($request->city > -1){
                    $submission = new PendingCityMerge($submissionInfo);
                    $submission->cityID = $request->city;
                }else{
                    $submission = new PendingCountyMerge($submissionInfo);
                    $submission->countyID = $request->county;
                }
                break;
            case 'City':
                $submission = PendingCityMerge::where('id', $request->id)->withTrashed()->get()->first();
                $submissionInfo = $submission->toArray();
                $submission->forceDelete();
                if($request->county == -1){
                    $submission = new PendingStateMerge($submissionInfo);
                    $submission->StateID = $request->State;
                }else if($request->city == -1){
                    $submission = new PendingCountyMerge($submissionInfo);
                    $submission->countyID = $request->county;
                }else{
                    $submission = new PendingCityMerge($submissionInfo);
                    $submission->cityID = $request->city;
                }
                break;
            default:
                throw new Exception('Issue updating submission, please contact an administrator.');
        }
        $submission->allowedID = $request->allowed;
        $submission->sourceID = $request->source;
        $submission->destinationID = $request->destination;

        $holdingVar = Links::where('linkText', $request->codes)->get();
        if (count($holdingVar) > 0) {
            $submission->codes = Links::where('linkText', $request->codes)->get()->first()->link_id;
        } else {
            $codes = new Links();
            $codes->linkText = $request->codes;
            $codes->save();
            $submission->codes = $codes->link_id;
        }

        $holdingVar = Links::where('linkText', $request->permit)->get();
        if (count($holdingVar) > 0) {
            $submission->permit = Links::where('linkText', $request->permit)->get()->first()->link_id;
        } else {
            $permit = new Links();
            $permit->linkText = $request->permit;
            $permit->save();
            $submission->permit = $permit->link_id;
        }

        $holdingVar = Links::where('linkText', $request->incentives)->get();
        if (count($holdingVar) > 0) {
            $submission->incentives = Links::where('linkText', $request->incentives)->get()->first()->link_id;
        } else {
            $incentives = new Links();
            $incentives->linkText = $request->incentives;
            $incentives->save();
            $submission->incentives = $incentives->link_id;
        }

        $holdingVar = Links::where('linkText', $request->moreInfo)->get();
        if (count($holdingVar) > 0) {
            $submission->moreInfo = Links::where('linkText', $request->moreInfo)->get()->first()->link_id;
        } else {
            $moreInfo = new Links();
            $moreInfo->linkText = $request->moreInfo;
            $moreInfo->save();
            $submission->moreInfo = $moreInfo->link_id;
        }

        try {
            $submission->save();
        } catch (Throwable $e) {
            throw new Exception('Error saving updated submission to DB. Contact an administrator.');
        }
    }
}
