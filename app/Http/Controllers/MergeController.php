<?php

namespace App\Http\Controllers;

use App\Services\DatabaseHelper;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Requests;
use App\PendingStateMerge;
use App\PendingCityMerge;
use App\PendingCountyMerge;

class MergeController extends Controller
{
    public $timestamps = true;

    public function addCityMergeSubmit(Request $request)
    {
        try {
            DatabaseHelper::addCityMergeSubmit($request);
            return redirect()->route('userCityView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been approved.']);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function addStateMergeSubmit(Request $request)
    {
        try {
            DatabaseHelper::addStateMergeSubmit($request);
            return redirect()->route('userStateView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been approved.']);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function addCountyMergeSubmit(Request $request)
    {
        try {
            DatabaseHelper::addCountyMergeSubmit($request);
            return redirect()->route('userCountyView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been approved.']);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function deleteCityMerge(Request $request)
    {
        $city = PendingCityMerge::where("id", $request->id)->get()->first();
        $city->delete();

        return redirect()->route('userCityView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been deleted.']);
    }

    public function deleteStateMerge(Request $request)
    {
        $state = PendingStateMerge::where("id", $request->id)->get()->first();
        $state->delete();

        return redirect()->route('userStateView')->with(['alert' => 'success', 'alertMessage' =>'The submission has been deleted.']);
    }

    public function deleteCountyMerge(Request $request)
    {
        $county = PendingCountyMerge::where("id", $request->id)->get()->first();
        $county->delete();

        return redirect()->route('userCountyView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been deleted.']);
    }
}
