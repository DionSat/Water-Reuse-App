<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Requests;
use Auth;
use App\PendingStateMerge;
use App\PendingCityMerge;
use App\PendingCountyMerge;

class SubmissionController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $stateSubmissions = PendingStateMerge::where('userID', $user->id)->get();
        $citySubmissions = PendingCityMerge::where('userID', $user->id)->get();
        $countySubmissions = PendingCountyMerge::where('userID', $user->id)->get();
        return view('submission.submission', compact('user', 'stateSubmissions', 'citySubmissions', 'countySubmissions'));
    }
}