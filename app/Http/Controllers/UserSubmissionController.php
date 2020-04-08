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

class UserSubmissionController extends Controller
{
    public function basicPage()
    {
        $user = Auth::user();
        return view('userSubmission.userSubmission', compact('user'));
    }
}