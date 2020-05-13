<?php

namespace App\Http\Controllers;

use App\Services\DatabaseHelper;
use Illuminate\Http\Request;
use App\PendingStateMerge;
use App\PendingCityMerge;
use App\PendingCountyMerge;
use Exception;

class MergeController extends Controller
{
    public $timestamps = true;
    const DB_ERROR_MSG = "A database error occurred, and the reuse item was not approved. The detailed error is: <br>";

    public function addCityMergeSubmit(Request $request)
    {
        try {
            DatabaseHelper::addCityMergeSubmit($request);
            return redirect()->route('userCityView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been approved.']);
        } catch (Exception $e) {
            $errorMsg = MergeController::DB_ERROR_MSG.$e->getMessage();
            return redirect()->route('userStateView')->with(['alert' => 'danger', 'alertMessage' => $errorMsg]);        }
    }

    public function addStateMergeSubmit(Request $request)
    {
        try {
            DatabaseHelper::addStateMergeSubmit($request);
            return redirect()->route('userStateView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been approved.']);
        } catch (Exception $e) {
            $errorMsg = MergeController::DB_ERROR_MSG.$e->getMessage();
            return redirect()->route('userStateView')->with(['alert' => 'danger', 'alertMessage' => $errorMsg]);
        }
    }

    public function addCountyMergeSubmit(Request $request)
    {
        try {
            DatabaseHelper::addCountyMergeSubmit($request);
            return redirect()->route('userCountyView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been approved.']);
        } catch (Exception $e) {
            $errorMsg = MergeController::DB_ERROR_MSG.$e->getMessage();
            return redirect()->route('userStateView')->with(['alert' => 'danger', 'alertMessage' => $errorMsg]);        }
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
