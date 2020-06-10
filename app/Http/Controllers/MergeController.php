<?php

namespace App\Http\Controllers;
use App\City;
use App\County;
use App\State;
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
    function on_error($num, $str, $file, $line) {
        print "Encountered error $num in $file, line $line: $str\n";
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
        $cityIdBuffer = $city->cityID;
        $city->delete();

        // if(!$request->is_approved)
        // {
        //     $city = City::where("city_id", $cityIdBuffer)->get()->first();
        //     try{
        //         $city->delete();
        //     }
        //     catch(Throwable $e) {
        //         return redirect()->route('userCityView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been deleted, but the unapproved city was not deleted do to dependency issues. Please try to delete it from the admin dashboard']);
        //     }
        // }

        return redirect()->route('userCityView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been deleted.']);
    }

    public function deleteStateMerge(Request $request)
    {
        $state = PendingStateMerge::where("id", $request->id)->get()->first();
        $stateIdBuffer = $state->stateID;
        $stateToDelete = State::where("state_id", $stateIdBuffer)->get()->first();
        $state->delete();

        // if(!$stateToDelete->is_approved)
        // {
        //     $countiesInState = County::where("fk_state", $stateIdBuffer)->get();
        //     if($countiesInState->count() != 0) {
        //         $backRoute = route("stateView");
        //         $backName  = "States";
        //         $item = $stateToDelete->stateName;
        //         $dependantCategory = "counties";
        //         $dependantItems = [];
        //         foreach ($countiesInState as $county){
        //             $dependantItems [] = $county->countyName;
        //         }

        //         return redirect()->route('userStateView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been deleted, but the unapproved State was not deleted do to dependency issues. Please try to delete it from the admin dashboard']);
        //     }

        //     //If no dependencies, then delete
        //     try{
        //         $stateToDelete->delete();
        //     }
        //     catch(Throwable $e) {
        //         return redirect()->route('userStateView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been deleted, but the unapproved State was not deleted do to dependency issues. Please try to delete it from the admin dashboard']);
        //     }

        // }

        return redirect()->route('userStateView')->with(['alert' => 'success', 'alertMessage' =>'The submission has been deleted.']);
    }

    public function deleteCountyMerge(Request $request)
    {
        $county = PendingCountyMerge::where("id", $request->id)->get()->first();
        $countyBufferId = $county->countyID;
        $county->delete();
        // $countyToDelete = County::where("county_id", $countyBufferId)->get()->first();
        // if(!$countyToDelete->is_approved)
        // {
        //     $citiesInState = City::where("fk_county", $countyBufferId)->get();
        //     if($citiesInState->count() != 0) {
        //         $backRoute = route("countyView");
        //         $backName  = "Counties";
        //         $item = $countyToDelete->countyName." county";
        //         $dependantCategory = "counties";
        //         $dependantItems = [];

        //         foreach ($citiesInState as $city){
        //             $dependantItems [] = $city->cityName;
        //         }

        //         return redirect()->route('userCountyView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been deleted, but the unapproved County was not deleted do to dependency issues. Please try to delete it from the admin dashboard']);
        //     }

        //     //If no dependencies, then delete
        //     try{
        //         $countyToDelete->delete();
        //     }
        //     catch(Throwable $e) {
        //         return redirect()->route('userCountyView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been deleted, but the unapproved County was not deleted do to dependency issues. Please try to delete it from the admin dashboard']);
        //     }
        // }

        return redirect()->route('userCountyView')->with(['alert' => 'success', 'alertMessage' => 'The submission has been deleted.']);
    }
}
