<?php

namespace App\Services;

use App\City;
use App\County;
use App\State;
use App\CityMerge;
use App\CountyMerge;
use App\StateMerge;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\PendingCityMerge;
use App\PendingCountyMerge;
use App\PendingStateMerge;
use App\Links;
use App\ReuseNode;
use Exception;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\DB;

class DatabaseHelper
{

    public static function getAllPendingSubmissions()
    {
        $mergedSubmissions = PendingStateMerge::all();
        $mergedSubmissions = $mergedSubmissions->merge(PendingCityMerge::all());
        $mergedSubmissions = $mergedSubmissions->merge(PendingCountyMerge::all());

        return $mergedSubmissions;
    }

    public static function getCountOfAllPendingSubmissions()
    {
        $mergedSubmissionCount = DB::table('pendingcitymerge')->where('deleted_at', null)->count();
        $mergedSubmissionCount += DB::table('pendingcountymerge')->where('deleted_at', null)->count();
        $mergedSubmissionCount += DB::table('pendingstatemerge')->where('deleted_at', null)->count();

        return $mergedSubmissionCount;
    }

    public static function getAllApprovedSubmissions()
    {
        $mergedSubmissions = StateMerge::all();
        $mergedSubmissions = $mergedSubmissions->merge(CityMerge::all());
        $mergedSubmissions = $mergedSubmissions->merge(CountyMerge::all());

        return $mergedSubmissions;
    }

    public static function getCountOfAllApprovedSubmissions()
    {
        $mergedSubmissionCount = DB::table('citymerge')->count();
        $mergedSubmissionCount += DB::table('countymerge')->count();
        $mergedSubmissionCount += DB::table('statemerge')->count();

        return $mergedSubmissionCount;
    }

    public static function getAllSubmissionsForCurrentUser()
    {
        $userId = Auth::user()->id;

        $mergedSubmissions = PendingStateMerge::withTrashed()->with(['state', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])->where('user_id', $userId)->get();
        $mergedSubmissions = $mergedSubmissions->merge(PendingCityMerge::withTrashed()->with(['city', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])->where('user_id', $userId)->get());
        $mergedSubmissions = $mergedSubmissions->merge(PendingCountyMerge::withTrashed()->with(['county', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])->where('user_id', $userId)->get());
        $mergedSubmissions = $mergedSubmissions->merge(StateMerge::where('user_id', $userId)->with(['state', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])->get());
        $mergedSubmissions = $mergedSubmissions->merge(CityMerge::where('user_id', $userId)->with(['city', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])->get());
        $mergedSubmissions = $mergedSubmissions->merge(CountyMerge::where('user_id', $userId)->with(['county', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])->get());

        return $mergedSubmissions->sortByDesc("created_at");
    }


    public static function getReuseItemByIdStateAndType($type, $state, $itemId)
    {
        $item = null;
        if ($state === "pending" || $state === "rejected") {
            switch ($type) {
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
            switch ($type) {
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


    public static function addRegulation(Request $request, $regLists)
    {
        $regArea = "";
        $mergeTable = null;
        $isNew = false;
        $isNewCounty = false;
        $isNewCity = false;
        $isNewState = false;

        //check to see if it's a new area
        if ($regLists[0]['$countyId'] == -1) {
            $isNew = true;
        }

        foreach ($regLists as $regList) {
            //need to add a new area
            if ($isNew) {
                $stateCheck = State::where("state_id", $regLists[0]['$stateId'])->get()->first();
                $countyCheck = County::where("countyName", $regLists[0]['$county'])->get()->first();
                $cityCheck = City::where("cityName", $regLists[0]['$city'])->get()->first();

                if (!$countyCheck && $regLists[0]['$county'] != "") {
                    $county = new County();
                    $county->countyName = $regLists[0]['$county'];
                    $county->fk_state = $stateCheck->state_id;
                    try {
                        $county->save();
                    } catch (Throwable $e1) {
                        return "County Already Exists, or There Was an Error on Loading New Area";
                    }

                    $mergeTable = new PendingCountyMerge();
                    $mergeTable->countyID = $county->county_id;
                    $regArea = $regLists[0]['$county'];
                    $regLists[0]['$countyId'] = $county->county_id;
                    $isNewCounty = true;
                    $isNewState = false;
                    $countyCheck = $county;
                }
                if (!$cityCheck && $regLists[0]['$city'] != "") {
                    $city = new City();
                    $city->cityName = $regLists[0]['$city'];
                    $city->fk_county = $countyCheck->county_id;
                    try {
                        $city->save();
                    } catch (Throwable $e2) {
                        return "City Already Exists, or There Was an Error on Loading New Area";
                    }
                    $mergeTable = new PendingCityMerge();
                    $mergeTable->cityID = $city->city_id;
                    $regArea = $regLists[0]['$city'];
                    $regLists[0]['$cityId'] = $city->city_id;
                    $isNewCity = true;
                    $isNewState = false;
                    $isNewCounty = false;
                }
            } //There is only a State
            else if ($regLists[0]['$county'] == 'Choose...' || $isNewState || $regLists[0]['$county'] == '') {
                $mergeTable = new PendingStateMerge();
                $regArea = $regLists[0]['$state'];
                $mergeTable->stateID = $regLists[0]['$stateId'];
            } //There is a State and a County
            else if ($regLists[0]['$city'] == 'Choose...' || $isNewCounty || $regLists[0]['$city'] == '') {
                $mergeTable = new PendingCountyMerge();
                $mergeTable->countyID = $regLists[0]['$countyId'];
                $regArea = $regLists[0]['$county'];
            }
            //There is a city. The code will not call the post unless there is at
            //least a State selected, so this assumes there will always be a state.
            else if ($regLists[0]['$city'] != 'Choose...' || $isNewCity || $regLists[0]['$city'] != '') {
                $mergeTable = new PendingCityMerge();
                $mergeTable->cityID = $regLists[0]['$cityId'];
                $regArea = $regLists[0]['$city'];
            }

            list($codesLink, $permitLink, $incentivesLink, $moreInfoLink) = self::setLinksForNewRegulation($regList, $mergeTable);

            $mergeTable->sourceID = $regList['$sourceId'];
            $mergeTable->allowedID = $regList['$isPermitted'];
            $mergeTable->user_id = Auth::user()->id;
            $mergeTable->location_type = $regList['$locationType'];
            $mergeTable->comments = $regList['$comments'];

            try {
                foreach ($regList['$destinationId'] as $destination) {
                    $mergeTableToSave = clone $mergeTable;
                    $mergeTableToSave->destinationID = $destination;
                    if ($mergeTableToSave->save() == false) {
                        $codesLink->delete();
                        $permitLink->delete();
                        $incentivesLink->delete();
                        $moreInfoLink->delete();
                    }
                }
            } catch (Exception $exception) {
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

        //grabs the existing city submission w/ pending source id and destination
        $cityMerge = CityMerge::where([
            ['sourceID', '=', $pending->sourceID],
            ['destinationID', '=', $pending->destinationID],
        ])->get();

        //if cityMerge is populated, then this submission already exists. Block approval
        if (count($cityMerge) > 0) {
            $source = ReuseNode::where("node_id", $pending->sourceID)->get()->first();
            $destination = ReuseNode::where("node_id", $pending->destinationID)->get()->first();
            throw new Exception("The city '$cityToApprove->stateName' already has a submission with the source
                '$source->node_name' and destination '$destination->node_name'.
                To replace the existing submission, delete the existing submission and approve the new one. ");
        }

        if ($cityToApprove) {
            if (!$cityToApprove->is_approved) {
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
        $city->location_type = $pending->location_type;


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

        //grabs the existing state submission w/ pending source id and destination
        $stateMerge = StateMerge::where([
            ['sourceID', '=', $pending->sourceID],
            ['destinationID', '=', $pending->destinationID],
        ])->get();

        //if stateMerge is populated, then this submission already exists. Block approval
        if (count($stateMerge) > 0) {
            $source = ReuseNode::where("node_id", $pending->sourceID)->get()->first();
            $destination = ReuseNode::where("node_id", $pending->destinationID)->get()->first();
            //throw new Exception("$stateMerge");
            throw new Exception("The state '$stateToApprove->stateName' already has a submission with the source
                '$source->node_name' and destination '$destination->node_name'.
                To replace the existing submission, delete the existing submission and approve the new one. ");
        }


        if ($stateToApprove) {
            if (!$stateToApprove->is_approved) {
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
        $state->location_type = $pending->location_type;

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

        //grabs the existing county submission w/ pending source id and destination
        $countyMerge = CountyMerge::where([
            ['sourceID', '=', $pending->sourceID],
            ['destinationID', '=', $pending->destinationID],
        ])->get();

        //if countyMerge is populated, then this submission already exists. Block approval
        if (count($countyMerge) > 0) {
            $source = ReuseNode::where("node_id", $pending->sourceID)->get()->first();
            $destination = ReuseNode::where("node_id", $pending->destinationID)->get()->first();
            throw new Exception("The county '$countyToApprove->stateName' already has a submission with the source
                '$source->node_name' and destination '$destination->node_name'.
                To replace the existing submission, delete the existing submission and approve the new one. ");
        }

        if ($countyToApprove) {
            if (!$countyToApprove->is_approved) {
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
        $county->location_type = $pending->location_type;

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

        if ($request->city > -1) {
            $newLocationId = $request->city;
            $newLocation = "city";
        } elseif ($request->county > -1) {
            $newLocationId = $request->county;
            $newLocation = "county";
        } else {
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
            throw $e;
        }

        return $submission;
    }


    // We trust that the new location Id matches the $type (city / county / state)
    public static function createNewReuseItemFromOtherItem($state, $type, $newItemLocationId, $oldItem)
    {

        //Make the new item
        if ($state === "pending") {
            switch ($type) {
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
            switch ($type) {
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
        try {
            //Find the item
            $oldItem = DatabaseHelper::getReuseItemByIdStateAndType($type, $state, $itemId);

            //Make a new item in the right table
            $item = DatabaseHelper::createNewReuseItemFromOtherItem($state, $locationToMoveItemTo, $newLocationId, $oldItem);
            self::deleteItem($state, $oldItem);
            return $item;
        } catch (Exception $err) {
            throw new Exception(err);
        }

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
        } else if ($request->codes !== null) {
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
        } else if ($request->permit !== null) {
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
        } else if ($request->incentives !== null) {
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
        } else if ($request->moreInfo !== null) {
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

    /**
     * @param $regList
     * @param $mergeTable
     * @return array
     */
    public static function setLinksForNewRegulation($regList, $mergeTable): array
    {
        $codesLink = new Links();
        $permitLink = new Links();
        $incentivesLink = new Links();
        $moreInfoLink = new Links();

        if (strlen(trim($regList['$codesLink'])) == 0) {
            $mergeTable->codes = null;
        } else {
            $holdingVar = Links::where('linkText', $regList['$codesLink'])->get();
            if (count($holdingVar) > 0) {
                $codesLink = Links::where('linkText', $regList['$codesLink'])->get()->first();
            } else {
                $codesLink->name = $regList['$codesTitle'];
                $codesLink->linkText = $regList['$codesLink'];
                $codesLink->save();
            }
            $mergeTable->codes = $codesLink->link_id;
        }

        if (strlen(trim($regList['$permitLink'])) == 0) {
            $mergeTable->permit = null;
        } else {
            $holdingVar = Links::where('linkText', $regList['$permitLink'])->get();
            if (count($holdingVar) > 0) {
                $permitLink = Links::where('linkText', $regList['$permitLink'])->get()->first();

            } else {
                $permitLink->name = $regList['$permitsTitle'];
                $permitLink->linkText = $regList['$permitLink'];
                $permitLink->save();
            }
            $mergeTable->permit = $permitLink->link_id;
        }

        if (strlen(trim($regList['$incentivesLink'])) == 0) {
            $mergeTable->incentives = null;
        } else {
            $holdingVar = Links::where('linkText', $regList['$incentivesLink'])->get();
            if (count($holdingVar) > 0) {
                $incentivesLink = Links::where('linkText', $regList['$incentivesLink'])->get()->first();
            } else {
                $incentivesLink->name = $regList['$incentivesTitle'];
                $incentivesLink->linkText = $regList['$incentivesLink'];
                $incentivesLink->save();
            }
            $mergeTable->incentives = $incentivesLink->link_id;
        }

        if (strlen(trim($regList['$moreInfoLink'])) == 0) {
            $mergeTable->moreInfo = null;
        } else {
            $holdingVar = Links::where('linkText', $regList['$moreInfoLink'])->get();
            if (count($holdingVar) > 0) {
                $moreInfoLink = Links::where('linkText', $regList['$moreInfoLink'])->get()->first();

            } else {
                $moreInfoLink->name = $regList['$moreInfoTitle'];
                $moreInfoLink->linkText = $regList['$moreInfoLink'];
                $moreInfoLink->save();
            }
            $mergeTable->moreInfo = $moreInfoLink->link_id;
        }

        return array($codesLink, $permitLink, $incentivesLink, $moreInfoLink);
    }
}
