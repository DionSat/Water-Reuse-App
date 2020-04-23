<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Requests;
use App\State;
use App\County;
use App\City;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\PendingStateMerge;
use App\PendingCityMerge;
use App\PendingCountyMerge;
use App\StateMerge;
use App\CityMerge;
use App\CountyMerge;

class SubmissionController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $stateSubmissions = PendingStateMerge::where('userID', $user->id)->get();
        $citySubmissions = PendingCityMerge::where('userID', $user->id)->get();
        $countySubmissions = PendingCountyMerge::where('userID', $user->id)->get();
        $stateApproved = StateMerge::where('user_id', $user->id)->get();
        $cityApproved = CityMerge::where('user_id', $user->id)->get();
        $countyApproved = CountyMerge::where('user_id', $user->id)->get();
        return view('submission.submission', compact('user', 'stateSubmissions', 'citySubmissions', 'countySubmissions', 'stateApproved', 'cityApproved', 'countyApproved'));
    }

    public function pendingState(Request $request)
    {
        $user = Auth::user();
        $submissions = PendingStateMerge::where('id', $request->itemId)->get();
        return view('submission.submissionItem', compact('user','submissions'));
    }

    public function pendingCity(Request $request)
    {
        $user = Auth::user();
        $submissions = PendingCityMerge::where('id', $request->itemId)->get();
        return view('submission.submissionItem', compact('user','submissions'));
    }

    public function pendingCounty(Request $request)
    {
        $user = Auth::user();
        $submissions = PendingCountyMerge::where('id', $request->itemId)->get();
        return view('submission.submissionItem', compact('user','submissions'));
    }
    public function state(Request $request)
    {
        $user = Auth::user();
        $approved = StateMerge::where('id', $request->itemId)->get();
        return view('submission.approvedItem', compact('user','approved'));
    }

    public function city(Request $request)
    {
        $user = Auth::user();
        $approved = CityMerge::where('id', $request->itemId)->get();
        return view('submission.approvedItem', compact('user','approved'));
    }

    public function county(Request $request)
    {
        $user = Auth::user();
        $approved = CountyMerge::where('id', $request->itemId)->get();
        return view('submission.approvedItem', compact('user','approved'));
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

        switch ($request->type) {
            case 'State':
                $submission = PendingStateMerge::where('id', $request->itemId)->get()->first();
                $submissionState = $submission;
                break;
            case 'County':
                $submission = PendingCountyMerge::where('id', $request->itemId)->get()->first();
                $cities = City::where('fk_county', $submission->countyID)->get();
                $submissionCounty = $submission->countyID;
                $submissionState = State::where('state_id', $submission->state()->state_id)->get()->first();
                break;
            case 'City':
                $submission = PendingCityMerge::where('id', $request->itemId)->get()->first();
                $submissionCity = $submission->cityID;
                $submissionCounty = County::where('county_id', $submission->county()->county_id)->get()->first();
                $submissionState = State::where('state_id', $submissionCounty->state()->state_id)->get()->first();
                $cities = City::where('fk_county', $submissionCounty->countyID)->get();
                $submissionCounty = $submissionCounty->countyID;
                break;
            default:
                # Send to error page?
                break;
        }

        $counties = County::where('fk_state', $submissionState->stateID)->get();

        return view('submission.submissionEdit', compact('user', 'submission', 'states', 'counties', 'cities', 'type', 'submissionState', 'submissionCounty', 'submissionCity'));
    }

    public function submissionEditSubmit(Request $request) {
        if (empty($request) || (($request->state == -1) == $request->source) == $request->destination)
            return redirect()->route('submissionEdit', ['type' => $request->type, 'itemId' => $request->id])->with(['alert' => 'danger', 'alertMessage' => 'Error trying to update the submission.']);

        if(!$request->city)
            $request->city = -1;

        $userID = -1; 

        switch ($request->type) {
            case 'State':
                $submission = PendingStateMerge::where('id', $request->id)->get()->first();
                $userID = $submission->userID;
                if($request->county > -1 && $request->city > -1){
                    $submission = new PendingCityMerge();
                    $submission->cityID = $request->city;
                }else if($request->county > -1){
                    $submission = new PendingCountyMerge();
                    $submission->countyID = $request->county;
                }else{
                    $submission->stateID = $request->state;
                }
                break;
            case 'County':
                $submission = PendingCountyMerge::where('id', $request->id)->get()->first();
                $userID = $submission->userID;
                if($request->county == -1){
                    $submission = new PendingStateMerge();
                    $submission->StateID = $request->State;
                }else if($request->city > -1){
                    $submission = new PendingCityMerge();
                    $submission->cityID = $request->city;
                }else{    
                    $submission->countyID = $request->county;
                }
                break;
            case 'City':
                $submission = PendingCityMerge::where('id', $request->id)->get()->first();
                $userID = $submission->userID;
                if($request->county == -1){
                    $submission = new PendingStateMerge();
                    $submission->StateID = $request->State;
                }else if($request->city == -1){
                    $submission = new PendingCountyMerge();
                    $submission->countyID = $request->county;
                }else{
                    $submission->cityID = $request->city;
                }
                break;
            default:
                return redirect()->route('submissionEdit', ['type' => $request->type, 'itemId' => $request->id])->with(['alert' => 'danger', 'alertMessage' => 'Error trying to update the submission.']);
                break;
        }
        $submission->allowedID = 5;
        $submission->sourceID = 1;
        $submission->destinationID = 1;
        $submission->codesObj()->linkText = $request->codes;
        $submission->permitObj()->linkText = $request->permit;
        $submission->incentivesObj()->linkText = $request->incentives;
        $submission->moreInfoObj()->linkText = $request->moreInfo;
        $submission->userID = $userID;
        //$submission->save();

        return redirect()->route('submission')->with(['alert' => 'success', 'alertMessage' => $submission->destinationID . ' has been updated.']);
    }
}