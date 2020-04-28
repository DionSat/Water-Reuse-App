<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Requests;
use App\State;
use App\County;
use App\City;
use App\Allowed;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\PendingStateMerge;
use App\PendingCityMerge;
use App\PendingCountyMerge;
use App\StateMerge;
use App\CityMerge;
use App\CountyMerge;
use Route;

class SubmissionController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $stateSubmissions = PendingStateMerge::withTrashed()->where('user_id', $user->id)->get();
        $citySubmissions = PendingCityMerge::withTrashed()->where('user_id', $user->id)->get();
        $countySubmissions = PendingCountyMerge::withTrashed()->where('user_id', $user->id)->get();
        $stateApproved = StateMerge::where('user_id', $user->id)->get();
        $cityApproved = CityMerge::where('user_id', $user->id)->get();
        $countyApproved = CountyMerge::where('user_id', $user->id)->get();
        return view('submission.submission', compact('user', 'stateSubmissions', 'citySubmissions', 'countySubmissions', 'stateApproved', 'cityApproved', 'countyApproved'));
    }

    //views of submission that are still pending
    public function pendingState(Request $request)
    {
        $user = Auth::user();
        $submissions = PendingStateMerge::where('id', $request->itemId)->get();
        $type = "State";
        return view('submission.submissionItem', compact('user','submissions','type'));
    }

    public function pendingCity(Request $request)
    {
        $user = Auth::user();
        $submissions = PendingCityMerge::where('id', $request->itemId)->get();
        $type = 'City';
        return view('submission.submissionItem', compact('user','submissions','type'));
    }

    public function pendingCounty(Request $request)
    {
        $user = Auth::user();
        $submissions = PendingCountyMerge::where('id', $request->itemId)->get();
        $type = 'County';
        return view('submission.submissionItem', compact('user','submissions','type'));
    }

    //view of submission that have been aproved
    public function state(Request $request)
    {
        $user = Auth::user();
        $submissions = StateMerge::where('id', $request->itemId)->get();
        return view('submission.submissionItem', compact('user','submissions'));
    }

    public function city(Request $request)
    {
        $user = Auth::user();
        $submissions = CityMerge::where('id', $request->itemId)->get();
        return view('submission.submissionItem', compact('user','submissions'));
    }

    public function county(Request $request)
    {
        $user = Auth::user();
        $submissions = CountyMerge::where('id', $request->itemId)->get();
        return view('submission.submissionItem', compact('user','submissions'));
    }

    public function submissionEdit(Request $request) 
    {
        $states = State::all();
        $user = Auth::user();
        $counties = [];
        $cities = [];
        $type = $request->type;
        $submissionState = -1;
        $submissionCounty = -1;
        $submissionCity = -1;
        $allowed = Allowed::all();

        switch ($request->type) {
            case 'State':
                $submission = PendingStateMerge::where('id', $request->itemId)->get()->first();
                $counties = County::where('fk_state', $submission->stateID)->get();
                $submissionState = $submission->stateID;
                break;
            case 'County':
                $submission = PendingCountyMerge::where('id', $request->itemId)->get()->first();
                $counties = County::where('fk_state', $submission->county->state->state_id)->get();
                $cities = City::where('fk_county', $submission->countyID)->get();
                $submissionCounty = $submission->countyID;
                $submissionState = $submission->county->state->state_id;
                break;
            case 'City':
                $submission = PendingCityMerge::where('id', $request->itemId)->get()->first();
                $submissionCity = $submission->cityID;
                $submissionCounty = $submission->city->county->county_id;
                $submissionState = $submission->city->county->state->state_id;
                $cities = City::where('fk_county', $submission->city->county->county_id)->get();
                $counties = County::where('fk_state', $submission->city->county->state->state_id)->get();
                break;
            default:
                return redirect()->route('submission')->with(['alert' => 'danger', 'alertMessage' => 'Error trying to update the submission.']);
                break;
        }

        return view('submission.submissionEdit', compact('user', 'submission', 'states', 'counties', 'cities', 'type', 'submissionState', 'submissionCounty', 'submissionCity', 'allowed'));
    }

    public function submissionEditSubmit(Request $request) {
        if (empty($request) || (($request->state == -1) == $request->source) == $request->destination)
            return redirect()->route('submissionEdit', ['type' => $request->type, 'itemId' => $request->id])->with(['alert' => 'danger', 'alertMessage' => 'Error trying to update the submission.']);

        if(!$request->city)
            $request->city = -1;

        switch ($request->type) {
            case 'State':
                $submission = PendingStateMerge::where('id', $request->id)->get()->first();
                $submissionInfo = $submission->toArray();
                if($request->county > -1 && $request->city > -1){
                    $submission->forceDelete();
                    $submission = new PendingCityMerge($submissionInfo);
                    $submission->cityID = $request->city;
                }else if($request->county > -1){
                    $submission->forceDelete();
                    $submission = new PendingCountyMerge($submissionInfo);
                    $submission->countyID = $request->county;
                }else{
                    $submission->stateID = $request->state;
                }
                break;
            case 'County':
                $submission = PendingCountyMerge::where('id', $request->id)->get()->first();
                $submissionInfo = $submission->toArray();
                if($request->county == -1){
                    $submission->forceDelete();
                    $submission = new PendingStateMerge($submissionInfo);
                    $submission->StateID = $request->State;
                }else if($request->city > -1){
                    $submission->forceDelete();
                    $submission = new PendingCityMerge($submissionInfo);
                    $submission->cityID = $request->city;
                }else{    
                    $submission->countyID = $request->county;
                }
                break;
            case 'City':
                $submission = PendingCityMerge::where('id', $request->id)->get()->first();
                $submissionInfo = $submission->toArray();
                if($request->county == -1){
                    $submission->forceDelete();
                    $submission = new PendingStateMerge($submissionInfo);
                    $submission->StateID = $request->State;
                }else if($request->city == -1){
                    $submission->forceDelete();
                    $submission = new PendingCountyMerge($submissionInfo);
                    $submission->countyID = $request->county;
                }else{
                    $submission->cityID = $request->city;
                }
                break;
            default:
                return redirect()->route('submissionEdit', ['type' => $request->type, 'itemId' => $request->id])->with(['alert' => 'danger', 'alertMessage' => 'Error trying to update the submission.']);
                break;
        }
        $submission->allowedID = $request->allowed;
        $submission->sourceID = $request->source;
        $submission->destinationID = $request->destination;
        $codes = $submission->codesObj()->first();
        $codes->linkText = $request->codes;
        $codes->save();
        $permit = $submission->permitObj()->first();
        $permit->linkText = $request->permit;
        $permit->save();
        $incentives = $submission->incentivesObj()->first();
        $incentives->linkText = $request->incentives;
        $incentives->save();
        $moreInfo = $submission->moreInfoObj()->first();
        $moreInfo->linkText = $request->moreInfo;
        $moreInfo->save();
        $submission->save();

        return redirect()->route('submission')->with(['alert' => 'success', 'alertMessage' => 'The submission has been updated.']);
    }

    public function deleteUnapproved(Request $request) {
        $route = Route::current();
        if (empty($request))
            return redirect()->route($route->getName())->with(['alert' => 'danger', 'alertMessage' => 'Error trying to delete the submission.']);

        switch ($request->type) {
            case 'State':
                $submission = PendingStateMerge::where('id', $request->id)->get()->first();
                break;
            case 'County':
                $submission = PendingCountyMerge::where('id', $request->id)->get()->first();
                
                break;
            case 'City':
                $submission = PendingCityMerge::where('id', $request->id)->get()->first();
                
                
                break;
            default:
                return redirect()->route($route->getName())->with(['alert' => 'danger', 'alertMessage' => 'Error trying to delete the submission.']);
                break;
        }
        $submission->forceDelete();
        return redirect()->route($route->getName())->with(['alert' => 'success', 'alertMessage' => 'The submission has been deleted.']);
    }
}
