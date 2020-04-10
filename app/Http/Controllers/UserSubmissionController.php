<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Requests;
use Auth;
use App\City;
use App\County;
use App\Destination;
use App\Source;
use App\State;
use App\Links;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\PendingStateMerge;
use App\PendingCityMerge;
use App\PendingCountyMerge;

class UserSubmissionController extends Controller
{
    
    public function all()
    {
        $user = Auth::user();
        //getting access to database in state merge table as a collection()
        $stateSubmissions = PendingStateMerge::all();
        $citySubmissions = PendingCityMerge::all();
        $countySubmissions = PendingCountyMerge::all();
        return view('userSubmission.userSubmissionItem', compact('user', 'stateSubmissions', 'citySubmissions', 'countySubmissions'));
    }
}