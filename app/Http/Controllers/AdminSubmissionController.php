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

class AdminSubmissionController extends Controller
{
    
    public function all()
    {
        $stateNumber = PendingStateMerge::all()->count();
        $cityNumber = PendingCityMerge::all()->count();
        $countyNumber = PendingCountyMerge::all()->count();

        $locationCards = [];
        $locationCards[] = ["title" => "State Submissions", "count" => $stateNumber, "view" => route("userStateView")];
        $locationCards[] = ["title" => "County Submissions", "count" => $countyNumber, "view" => route("userCountyView")];
        $locationCards[] = ["title" => "City Submissions", "count" => $cityNumber, "view" => route("userCityView")];

        $user = Auth::user();
        $stateSubmissions = PendingStateMerge::all();
        $citySubmissions = PendingCityMerge::all();
        $countySubmissions = PendingCountyMerge::all();
        return view('adminUserSubmission.userSubmissionOverview', compact('user', 'locationCards', 'stateSubmissions', 'citySubmissions', 'countySubmissions'));
    }

    public function userCity() 
    {
        $user = Auth::user();
        $citySubmissions = PendingCityMerge::with(['user', 'source', 'destination'])->get();
        return view('adminUserSubmission.userCitySubmission', compact('user', 'citySubmissions'));

    }

    public function userState() 
    {
        $user = Auth::user();
        $stateSubmissions = PendingStateMerge::with(['user', 'source', 'destination'])->get();
        return view('adminUserSubmission.userStateSubmission', compact('user', 'stateSubmissions'));
    }

    public function userCounty()
    {
        $user = Auth::user();
        $countySubmissions = PendingCountyMerge::with(['user', 'source', 'destination'])->get();
        return view('adminUserSubmission.userCountySubmission', compact('user', 'countySubmissions'));
    }

    public function userCityView(Request $request) 
    {
        $user = Auth::user();
        $submissions = PendingCityMerge::where('id', $request->itemid)->get();
        return view('adminUserSubmission.userSubmissionItem', compact('user', 'submissions'));
    }

    public function userStateView(Request $request) 
    {
        $user = Auth::user();
        $submissions = PendingStateMerge::where('id', $request->itemid)->get();
        return view('adminUserSubmission.userSubmissionItem', compact('user', 'submissions'));
    }

    public function userCountyView(Request $request) 
    {
        $user = Auth::user();
        $submissions = PendingCountyMerge::where('id', $request->itemid)->get();
        return view('adminUserSubmission.userSubmissionItem', compact('user', 'submissions'));
    }
    
}
