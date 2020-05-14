<?php

namespace App\Services;

use App\CityMerge;
use App\CountyMerge;
use App\StateMerge;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\PendingCityMerge;
use App\PendingCountyMerge;
use App\PendingStateMerge;
use App\Links;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class DatabaseHelper {


    public static function getAllSubmissionsForCurrentUser(){
        $userId = Auth::user()->id;

        $mergedSubmissions = PendingStateMerge::withTrashed()->where('user_id', $userId)->get();
        $mergedSubmissions = $mergedSubmissions->merge(PendingCityMerge::withTrashed()->where('user_id', $userId)->get());
        $mergedSubmissions = $mergedSubmissions->merge(PendingCountyMerge::withTrashed()->where('user_id', $userId)->get());
        $mergedSubmissions = $mergedSubmissions->merge(StateMerge::where('user_id', $userId)->get());
        $mergedSubmissions = $mergedSubmissions->merge(CityMerge::where('user_id', $userId)->get());
        $mergedSubmissions = $mergedSubmissions->merge(CountyMerge::where('user_id', $userId)->get());

        return $mergedSubmissions->sortByDesc("created_at");
    }


    public static function getReuseItemByIdStateAndType($type, $state, $itemId) {
        $item = null;
        if($state === "pending"){
            switch ($type){
                case "city":
                    $item = PendingCityMerge::find($itemId);
                    break;
                case "county":
                    $item = PendingCountyMerge::find($itemId);
                    break;
                case "state":
                    $item = PendingStateMerge::find($itemId);
                    break;
                default:
                    $item = null;
            }
        } else {
            switch ($type){
                case "city":
                    $item = CityMerge::find($itemId);
                    break;
                case "county":
                    $item = CountyMerge::find($itemId);
                    break;
                case "state":
                    $item = StateMerge::find($itemId);
                    break;
                default:
                    $item = null;
            }
        }

        return $item;
    }


    public static function addRegulation(Request $request, $regLists) {
        $regArea = "";
        $mergeTable = null;
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
                return "A API error occurred.";
            }
        }

        return $regArea;
    }

    public static function addCityMergeSubmit(Request $request)
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

        $submissionType = $request->submissionType;
        $submissionState = $request->submissionState;
        $itemId = $request->id;

        $submission = DatabaseHelper::getReuseItemByIdStateAndType($submissionType, $submissionState, $itemId);

        //        var_dump($submission);
        //        var_dump($submissionState);
        //        var_dump($submissionType);
        //        return;

        //If we need to re-create the submission
        if($submissionState !== "approved") {
            switch ($submissionType) {
                case 'state':
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
                case 'county':
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
                case 'city':
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
                    throw new Exception('Location type not defined properly. Please try again.');
            }
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
