<?php

namespace App\Http\Controllers;

use App\Services\DatabaseHelper;
use Illuminate\Http\Request;
use App\State;
use App\County;
use App\City;
use App\Allowed;
use Illuminate\Support\Facades\Auth;
use App\PendingStateMerge;
use App\PendingCityMerge;
use App\PendingCountyMerge;
use App\StateMerge;
use App\CityMerge;
use App\CountyMerge;
use Route;

class UserSubmissionController extends Controller
{
    public function userSubmissionListPage(){
        $user = Auth::user();
        $userId = $user->id;

        $submissions = PendingStateMerge::withTrashed()->with(['state', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])->where('user_id', $userId)->get();
        $submissions = $submissions->merge(PendingCityMerge::withTrashed()->with(['city', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])->where('user_id', $userId)->get());
        $submissions = $submissions->merge(PendingCountyMerge::withTrashed()->with(['county', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])->where('user_id', $userId)->get());
        $submissions = $submissions->merge(StateMerge::where('user_id', $userId)->with(['state', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])->get());
        $submissions = $submissions->merge(CityMerge::where('user_id', $userId)->with(['city', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])->get());
        $submissions = $submissions->merge(CountyMerge::where('user_id', $userId)->with(['county', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])->get());

        $submissions = $submissions->sortByDesc('updated_at')->paginate(15);

        return view('submission.userSubmissionOverview', compact('user', 'submissions'));
    }

    public function viewSubmission(Request $request){
        $user = Auth::user();
        $type = $request->type;
        $state = $request->state;
        $itemId = $request->itemId;
        $returnItemType = null;
        if(isset($request->returnItemType)){$returnItemType = $request->returnItemType;}
        $returnItemState = null;
        if(isset($request->returnItemState)){$returnItemState = $request->returnItemState;}
        $returnItemId = null;
        if(isset($request->returnItemId)){$returnItemId = $request->returnItemId;}

        if(empty($type) || empty($state) || empty($itemId))
            return back()->with(['alert' => 'danger', 'alertMessage' => 'Error loading the submission.']);

        //Otherwise, get the item from the database
        if($returnItemId == null || $returnItemType == null || $returnItemState == null) {
            $item = DatabaseHelper::getReuseItemByIdStateAndType($type, $state, $itemId);
        }else{
            $item = DatabaseHelper::getReuseItemByIdStateAndType($returnItemType, $returnItemState, $returnItemId);
        }
        $item2 = DatabaseHelper::getSimilarApprovedReuseItem($item);

        $backUrl = $request->back;

        return view('common.generic-reuse-item', compact('user','item','item2', 'type', 'state', 'backUrl'));
    }


    public function submissionEdit(Request $request)
    {
        $states = State::all();
        $user = Auth::user();
        $counties = [];
        $cities = [];
        $type = $request->type;
        $state = $request->state;
        $itemId = $request->itemId;
        $returnItemType = null;
        if(isset($request->returnItemType)){$returnItemType = $request->returnItemType;}
        $returnItemState = null;
        if(isset($request->returnItemState)){$returnItemState = $request->returnItemState;}
        $returnItemId = null;
        if(isset($request->returnItemId)){$returnItemId = $request->returnItemId;}
        $submissionState = -1;
        $submissionCounty = -1;
        $submissionCity = -1;
        $allowed = Allowed::all();
        $backUrl = $request->back;
        $previousBackUrl = $request->previousBack;

        $submission = DatabaseHelper::getReuseItemByIdStateAndType($type, $state, $itemId);

        switch ($type) {
            case 'state':
                $counties = County::where('fk_state', $submission->stateID)->get();
                $submissionState = $submission->stateID;
                break;
            case 'county':
                $counties = County::where('fk_state', $submission->county->state->state_id)->get();
                $cities = City::where('fk_county', $submission->countyID)->get();
                $submissionCounty = $submission->countyID;
                $submissionState = $submission->county->state->state_id;
                break;
            case 'city':
                $submissionCity = $submission->cityID;
                $submissionCounty = $submission->city->county->county_id;
                $submissionState = $submission->city->county->state->state_id;
                $cities = City::where('fk_county', $submission->city->county->county_id)->get();
                $counties = County::where('fk_state', $submission->city->county->state->state_id)->get();
                break;
            default:
                return redirect()->back()->with(['alert' => 'danger', 'alertMessage' => 'Error trying to find the submission.']);
                break;
        }

        if(($submission->user_id !== Auth::user()->id) && Auth::user()->is_admin === false){
            return redirect()->back()->with(['alert' => 'danger', 'alertMessage' => "Please don't try to edit other people's submissions!"]);
        }

        return view('submission.submissionEdit', compact('user', 'submission', 'states', 'counties', 'cities', 'type', 'submissionState', 'submissionCounty', 'submissionCity', 'allowed', 'backUrl', 'previousBackUrl', 'returnItemType', 'returnItemState', 'returnItemId'));
    }

    public function submissionEditSubmit(Request $request) {
        if (empty($request) || (($request->state == -1) == $request->source) == $request->destination)
            return redirect()->route('submissionEdit', ['type' => $request->type, 'itemId' => $request->id, "returnItemId" => $request->returnId])->with(['alert' => 'danger', 'alertMessage' => 'Error trying to update the submission.']);

        try {
            $submission = DatabaseHelper::submissionEditSubmit($request);
            return redirect()->route('viewSubmission', ["type" => $submission->getLocationType(), "state" => $submission->getStatus(), "itemId" => $submission->id, "back" => $request->back, "returnItemType" => $request->returnItemType, "returnItemState" => $request->returnItemState, "returnItemId" => $request->returnItemId])
                                ->with(['alert' => 'success', 'alertMessage' => 'The submission has been updated.']);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteItem(Request $request) {
        $route = Route::current();
        if (empty($request))
            return redirect()->back()->with(['alert' => 'danger', 'alertMessage' => 'Error trying to delete the submission.']);

        $submission = DatabaseHelper::getReuseItemByIdStateAndType($request->type, $request->state, $request->id);

        if(($submission->user_id !== Auth::user()->id) && Auth::user()->is_admin === false){
            return redirect()->back()->with(['alert' => 'danger', 'alertMessage' => "Please don't try to delete other people's submissions!"]);
        }

        DatabaseHelper::deleteItem($request->state, $submission);

        return redirect($request->back)->with(['alert' => 'success', 'alertMessage' => 'The submission has been deleted.']);
    }
}
