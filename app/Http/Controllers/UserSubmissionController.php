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

class UserSubmissionController extends Controller
{
    
    public function all()
    {
        $stateNumber = PendingStateMerge::all()->count();
        $cityNumber = PendingCityMerge::all()->count();
        $countyNumber = PendingCountyMerge::all()->count();

        $locationCards = [];
        $locationCards[] = ["title" => "States", "count" => $stateNumber, "view" => route("userStateView")];
        $locationCards[] = ["title" => "Cities", "count" => $cityNumber, "view" => route("userCityView")];
        $locationCards[] = ["title" => "Counties", "count" => $countyNumber, "view" => route("userCountyView")];

        $user = Auth::user();
        $stateSubmissions = PendingStateMerge::all();
        $citySubmissions = PendingCityMerge::all();
        $countySubmissions = PendingCountyMerge::all();
        return view('userSubmission.userSubmission', compact('user', 'locationCards', 'stateSubmissions', 'citySubmissions', 'countySubmissions'));
    }

    public function userCity() 
    {
        $user = Auth::user();
        $citySubmissions = PendingCityMerge::all();
        return view('userSubmission.userCitySubmission', compact('user', 'citySubmissions'));

    }

    public function userState() 
    {
        $user = Auth::user();
        $stateSubmissions = PendingStateMerge::all();
        return view('userSubmission.userStateSubmission', compact('user', 'stateSubmissions'));
    }

    public function userCounty()
    {
        $user = Auth::user();
        $countySubmissions = PendingCountyMerge::all();
        return view('userSubmission.userCountySubmission', compact('user', 'countySubmissions'));
    }

    public function userCityView(Request $request) 
    {
        $user = Auth::user();
        $submissions = PendingCityMerge::where('id', $request->itemid)->get();
        return view('userSubmission.userSubmissionItem', compact('user', 'submissions'));
    }

    public function userStateView(Request $request) 
    {
        $user = Auth::user();
        $submissions = PendingStateMerge::where('id', $request->itemid)->get();
        return view('userSubmission.userSubmissionItem', compact('user', 'submissions'));
    }

    public function userCountyView(Request $request) 
    {
        $user = Auth::user();
        $submissions = PendingCountyMerge::where('id', $request->itemid)->get();
        return view('userSubmission.userSubmissionItem', compact('user', 'submissions'));
    }
}