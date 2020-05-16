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
        if($state === "pending" || $state === "rejected"){
            switch ($type){
                case "city":
                    $item = PendingCityMerge::withTrashed()->find($itemId);
                    break;
                case "county":
                    $item = PendingCountyMerge::withTrashed()->find($itemId);
                    break;
                case "state":
                    $item = PendingStateMerge::withTrashed()->find($itemId);
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

        $newLocationId = -1;
        $newLocation = "";

        if($request->city > -1){
            $newLocationId = $request->city;
            $newLocation = "city";
        }
        elseif ($request->county > -1){
            $newLocationId = $request->county;
            $newLocation = "county";
        }
        else {
            $newLocationId = $request->state;
            $newLocation = "state";
        }

        $submission = self::moveReuseItemBetweenMergeTables($submissionType, $submissionState, $itemId, $newLocation, $newLocationId);

        $submission->allowedID = $request->allowed;
        $submission->sourceID = $request->source;
        $submission->destinationID = $request->destination;

        // Update all the links
        self::updateReuseItemLinks($request, $submission);

        $submission->comments = $request->comments;

        try {
            $submission->save();
        } catch (Throwable $e) {
            throw new Exception('Error saving updated submission to DB. Contact an administrator.');
        }

        return $submission;
    }


    // We trust that the new location Id matches the $type (city / county / state)
    public static function createNewReuseItemFromOtherItem($state, $type, $newItemLocationId, $oldItem) {

        //Make the new item
        if($state === "pending"){
            switch ($type){
                case "city":
                    $item = new PendingCityMerge();
                    $item->cityID = $newItemLocationId;
                    break;
                case "county":
                    $item = new PendingCountyMerge();
                    $item->countyID = $newItemLocationId;
                    break;
                case "state":
                    $item = new PendingStateMerge();
                    $item->stateID = $newItemLocationId;
                    break;
                default:
                    $item = null;
            }
        } else {
            switch ($type){
                case "city":
                    $item = new CityMerge();
                    $item->cityID = $newItemLocationId;
                    break;
                case "county":
                    $item = new CountyMerge();
                    $item->countyID = $newItemLocationId;
                    break;
                case "state":
                    $item = new StateMerge();
                    $item->stateID = $newItemLocationId;
                    break;
                default:
                    $item = null;
            }
        }

        //Copy over all the old information
        $item->sourceID = $oldItem->sourceID;
        $item->destinationID = $oldItem->destinationID;
        $item->allowedID = $oldItem->allowedID;
        $item->codes = $oldItem->codes;
        $item->permit = $oldItem->permit;
        $item->incentives = $oldItem->incentives;
        $item->moreInfo = $oldItem->moreInfo;
        $item->user_id = $oldItem->user_id;
        $item->comments = $oldItem->comments;

        return $item;
    }



    //Returns the new item as a object
    public static function moveReuseItemBetweenMergeTables($type, $state, $itemId, $locationToMoveItemTo, $newLocationId)
    {
        //Find the item
        $oldItem = DatabaseHelper::getReuseItemByIdStateAndType($type, $state, $itemId);

        //Make a new item in the right table
        $item = DatabaseHelper::createNewReuseItemFromOtherItem($state, $locationToMoveItemTo, $newLocationId, $oldItem);

        self::deleteItem($state, $oldItem);


        return $item;
    }

    /**
     * @param Request $request
     * @param $submission
     */
    private static function updateReuseItemLinks(Request $request, $submission): void
    {
        $holdingVar = Links::where('linkText', $request->codes)->get();
        if (count($holdingVar) > 0) {
            $submission->codes = $holdingVar->first()->link_id;
        } else if ($request->codes !== "") {
            $codes = new Links();
            $codes->linkText = $request->codes;
            $codes->save();
            $submission->codes = $codes->link_id;
        } else {
            $submission->codes = null;
        }

        $holdingVar = Links::where('linkText', $request->permit)->get();
        if (count($holdingVar) > 0) {
            $submission->permit = $holdingVar->first()->link_id;
        } else if ($request->permit !== "") {
            $codes = new Links();
            $codes->linkText = $request->permit;
            $codes->save();
            $submission->permit = $codes->link_id;
        } else {
            $submission->permit = null;
        }

        $holdingVar = Links::where('linkText', $request->incentives)->get();
        if (count($holdingVar) > 0) {
            $submission->incentives = $holdingVar->first()->link_id;
        } else if ($request->incentives !== "") {
            $codes = new Links();
            $codes->linkText = $request->incentives;
            $codes->save();
            $submission->incentives = $codes->link_id;
        } else {
            $submission->incentives = null;
        }

        $holdingVar = Links::where('linkText', $request->moreInfo)->get();
        if (count($holdingVar) > 0) {
            $submission->moreInfo = $holdingVar->first()->link_id;
        } else if ($request->moreInfo !== "") {
            $codes = new Links();
            $codes->linkText = $request->moreInfo;
            $codes->save();
            $submission->moreInfo = $codes->link_id;
        } else {
            $submission->moreInfo = null;
        }
    }

    /**
     * @param $state
     * @param $item
     */
    public static function deleteItem($state, $item): void
    {
        //Delete the old item
        if ($state === "pending" || $state === "rejected")
            $item->forceDelete();
        else
            $item->delete();
    }
}
