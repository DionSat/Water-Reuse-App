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
        $stateSubmissions = PendingStateMerge::withTrashed()->where('userID', $user->id)->get();
        $citySubmissions = PendingCityMerge::withTrashed()->where('userID', $user->id)->get();
        $countySubmissions = PendingCountyMerge::withTrashed()->where('userID', $user->id)->get();
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

}
