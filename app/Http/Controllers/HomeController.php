<?php

namespace App\Http\Controllers;
use App\PendingStateMerge;
use App\PendingCityMerge;
use App\PendingCountyMerge;
use App\StateMerge;
use App\CityMerge;
use App\CountyMerge;
use Auth;

class HomeController extends Controller
{

    public function index() {
        return view('homepage');
    }

    // returns the info page
    public function getInfo() {
        return view('info');
    }

    // returns the userSubmission page
    public function getUserSubmission() {
        return view('userSubmission');
    }

    public function overview() {
        $user = Auth::user();
        $pendingState = PendingStateMerge::with(['user', 'source', 'destination'])->where('user_id', $user->id)->get()->count();
        $pendingCity = PendingCityMerge::with(['user', 'source', 'destination'])->where('user_id', $user->id)->get()->count();
        $pendingCounty = PendingCountyMerge::with(['user', 'source', 'destination'])->where('user_id', $user->id)->get()->count();

        $rejectedState = PendingStateMerge::onlyTrashed()->with(['user', 'source', 'destination'])->where('user_id', $user->id)->get()->count();
        $rejectedCity = PendingCityMerge::onlyTrashed()->with(['user', 'source', 'destination'])->where('user_id', $user->id)->get()->count();
        $rejectedCounty = PendingCountyMerge::onlyTrashed()->with(['user', 'source', 'destination'])->where('user_id', $user->id)->get()->count();

        $stateApproved = StateMerge::where('user_id', $user->id)->with(['user', 'source', 'destination'])->get()->count();
        $cityApproved = CityMerge::where('user_id', $user->id)->with(['user', 'source', 'destination'])->get()->count();
        $countyApproved = CountyMerge::where('user_id', $user->id)->with(['user', 'source', 'destination'])->get()->count();

        $pending = $pendingState + $pendingCity + $pendingCounty;
        $rejected = $rejectedCity + $rejectedCounty + $rejectedState;
        $approved = $stateApproved + $cityApproved + $countyApproved;

        return view('welcome', compact('pending', 'rejected', 'approved'));
    }
}
