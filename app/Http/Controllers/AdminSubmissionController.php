<?php

namespace App\Http\Controllers;

use App\State;
use App\User;
use Illuminate\Http\Requests;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\PendingStateMerge;
use App\PendingCityMerge;
use App\PendingCountyMerge;

class AdminSubmissionController extends Controller
{
    
    public function all()
    {
        $user = Auth::user();
        $stateSubmissions = PendingStateMerge::all();
        $countySubmissions = PendingCountyMerge::all();
        $citySubmissions = PendingCityMerge::all();

        $stateNumber = $stateSubmissions->count();
        $countyNumber = $countySubmissions->count();
        $cityNumber = $citySubmissions->count();

        $locationCards = [];
        $locationCards[] = ["title" => "State Submissions", "count" => $stateNumber, "view" => route("userStateView")];
        $locationCards[] = ["title" => "County Submissions", "count" => $countyNumber, "view" => route("userCountyView")];
        $locationCards[] = ["title" => "City Submissions", "count" => $cityNumber, "view" => route("userCityView")];

        return view('adminUserSubmission.userSubmissionOverview', compact('user', 'locationCards', 'stateSubmissions', 'citySubmissions', 'countySubmissions'));
    }

    public function userState()
    {
        $stateSubmissions = PendingStateMerge::with(['user', 'source', 'destination', 'state'])->get()->sortByDesc("created_at")->groupBy('state.stateName');

        return view('adminUserSubmission.stateSubmissions', compact('stateSubmissions'));
    }

    public function userCounty()
    {
        $countySubmissions = PendingCountyMerge::with(['user', 'source', 'destination', 'county'])->get()->sortByDesc("created_at")->groupBy('county.countyName');;
        return view('adminUserSubmission.countySubmissions', compact('countySubmissions'));
    }

    public function userCity()
    {
        $citySubmissions = PendingCityMerge::with(['user', 'source', 'destination', 'city'])->get()->sortByDesc("created_at")->groupBy('city.cityName');;
        return view('adminUserSubmission.citySubmissions', compact('citySubmissions'));
    }

    public function userStateView(Request $request)
    {
        $submissions = PendingStateMerge::where('id', $request->itemid)->get();
        return view('adminUserSubmission.userSubmissionItem', compact( 'submissions'));
    }

    public function userCountyView(Request $request)
    {
        $submissions = PendingCountyMerge::where('id', $request->itemid)->get();
        return view('adminUserSubmission.userSubmissionItem', compact('submissions'));
    }

    public function userCityView(Request $request) 
    {
        $submissions = PendingCityMerge::where('id', $request->itemid)->get();
        return view('adminUserSubmission.userSubmissionItem', compact( 'submissions'));
    }

}
