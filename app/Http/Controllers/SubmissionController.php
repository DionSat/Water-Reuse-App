<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Requests;
use Auth;

class SubmissionController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        return view('submission.submission', compact('user'));
    }
}