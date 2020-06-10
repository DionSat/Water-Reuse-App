<?php

namespace App\Http\Controllers;

use App\Services\DatabaseHelper;
use App\State;
use App\User;
use Illuminate\Http\Requests;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\PendingStateMerge;
use App\PendingCityMerge;
use App\PendingCountyMerge;
use App\StateMerge;
use App\CityMerge;
use App\CountyMerge;

class AdminSubmissionController extends Controller
{

    public function all()
    {
        $user = Auth::user();

        //pending submissions
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

        //existing (approved) submissions
        $stateMergeSubmissions = StateMerge::all();
        $countyMergeSubmissions = CountyMerge::all();
        $cityMergeSubmissions = CityMerge::all();

        $stateMergeNumber = $stateMergeSubmissions->count();
        $countyMergeNumber = $countyMergeSubmissions->count();
        $cityMergeNumber = $cityMergeSubmissions->count();

        $mergeCards = [];
        $mergeCards[] = ["title" => "State Submissions", "count" => $stateMergeNumber, "view" => route("approvedStateView")];
        $mergeCards[] = ["title" => "County Submissions", "count" => $countyMergeNumber, "view" => route("approvedCountyView")];
        $mergeCards[] = ["title" => "City Submissions", "count" => $cityMergeNumber, "view" => route("approvedCityView")];

        return view('adminUserSubmission.userSubmissionOverview', compact('user', 'locationCards', 'stateSubmissions', 'citySubmissions', 'countySubmissions', 'mergeCards'));
    }

    public function userState()
    {
        $stateSubmissions = PendingStateMerge::with(['user', 'source', 'destination', 'state'])->get()->sortByDesc("created_at")->groupBy('state.stateName');
        //$stateSubmissions = PendingStateMerge::with(['user', 'source', 'destination', 'state'])->paginate(10)->sortByDesc("created_at")->groupBy('state.stateName');
        return view('adminUserSubmission.stateSubmissions', compact('stateSubmissions'));
    }

    public function userCounty()
    {
        $countySubmissions = PendingCountyMerge::with(['user', 'source', 'destination', 'county', 'county.state'])->get()->sortByDesc("created_at")->groupBy('county.countyName');
        //$countySubmissions = PendingCountyMerge::with(['user', 'source', 'destination', 'county', 'county.state'])->get()->sortByDesc("created_at");;
        $countySubmissions = $countySubmissions->mapWithKeys(function ($item, $key) {
            if(!empty($item)){
                $stateName = ", ".$item[0]->county->state->stateName;
            } else {
                $stateName = "";
            }
            return [$key.$stateName => $item];
        });

        return view('adminUserSubmission.countySubmissions', compact('countySubmissions'));
    }

    public function userCity()
    {
        $citySubmissions = PendingCityMerge::with(['user', 'source', 'destination', 'city', 'city.county', 'city.county.state'])->get()->sortByDesc("created_at")->groupBy('city.cityName');;

        $citySubmissions = $citySubmissions->mapWithKeys(function ($item, $key) {
            if(!empty($item)){
                $stateName = ", ".$item[0]->city->county->state->stateName;
                $countyName = ", ".$item[0]->city->county->countyName." County";
            } else {
                $stateName = "";
                $countyName = "";
            }
            return [$key.$countyName.$stateName => $item];
        });

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

    public function approvedStateView(Request $request)
    {
        $stateSubmissions = StateMerge::with(['user', 'source', 'destination', 'state'])->get()->sortByDesc("created_at")->groupBy('state.stateName');
        return view('adminUserSubmission.approvedStateSubmissions', compact('stateSubmissions'));
    }

    public function approvedCountyView(Request $request)
    {
        $countySubmissions = CountyMerge::with(['user', 'source', 'destination', 'county', 'county.state'])->get()->sortByDesc("created_at")->groupBy('county.countyName');
        $countySubmissions = $countySubmissions->mapWithKeys(function ($item, $key) {
            if(!empty($item)){
                $stateName = ", ".$item[0]->county->state->stateName;
            } else {
                $stateName = "";
            }
            return [$key.$stateName => $item];
        });

        return view('adminUserSubmission.approvedCountySubmissions', compact('countySubmissions'));
    }

    public function approvedCityView(Request $request)
    {
        $citySubmissions = CityMerge::with(['user', 'source', 'destination', 'city', 'city.county', 'city.county.state'])->get()->sortByDesc("created_at")->groupBy('city.cityName');;

        $citySubmissions = $citySubmissions->mapWithKeys(function ($item, $key) {
            if(!empty($item)){
                $stateName = ", ".$item[0]->city->county->state->stateName;
                $countyName = ", ".$item[0]->city->county->countyName." County";
            } else {
                $stateName = "";
                $countyName = "";
            }
            return [$key.$countyName.$stateName => $item];
        });

        return view('adminUserSubmission.approvedCitySubmissions', compact('citySubmissions'));
    }

}
