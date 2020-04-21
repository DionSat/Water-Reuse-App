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
        $user = Auth::user();
        switch ($request->type) {
            case 'State':
                $submissions = PendingCountyMerge::where('id', $request->itemid)->get();
                break;
            case 'County':
                $submissions = PendingCountyMerge::where('id', $request->itemId)->get();
                break;
            case 'City':
                $submissions = PendingCityMerge::where('id', $request->itemId)->get();
                break;
            default:
                # Send to error page?
                break;
        }

        return view('submission.submissionEdit', compact('user', 'submissions'));
    }
}