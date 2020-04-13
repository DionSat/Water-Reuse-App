<?php

namespace App\Http\Controllers;

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
        $stateSubmissions = PendingStateMerge::where('id', $request->itemId)->get();
        return view('submission.stateSubmissionItem', compact('user','stateSubmissions'));
    }

    public function pendingCity(Request $request)
    {
        $user = Auth::user();
        $citySubmissions = PendingCityMerge::where('id', $request->itemId)->get();
        return view('submission.citySubmissionItem', compact('user','citySubmissions'));
    }

    public function pendingCounty(Request $request)
    {
        $user = Auth::user();
        $countySubmissions = PendingCountyMerge::where('id', $request->itemId)->get();
        return view('submission.countySubmissionItem', compact('user','countySubmissions'));
    }
    public function state(Request $request)
    {
        $user = Auth::user();
        $stateApproved = StateMerge::where('id', $request->itemId)->get();
        return view('submission.stateSubmissionItem', compact('user','stateApproved'));
    }

    public function city(Request $request)
    {
        $user = Auth::user();
        $cityApproved = CityMerge::where('id', $request->itemId)->get();
        return view('submission.citySubmissionItem', compact('user','cityApproved'));
    }

    public function county(Request $request)
    {
        $user = Auth::user();
        $countyApproved = CountyMerge::where('id', $request->itemId)->get();
        return view('submission.countySubmissionItem', compact('user','countyApproved'));
    }
}