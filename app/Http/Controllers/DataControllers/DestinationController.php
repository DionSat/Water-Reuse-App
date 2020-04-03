<?php

namespace App\Http\Controllers\DataControllers;

use App\CityMerge;
use App\CountyMerge;
use App\StateMerge;
use App\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DestinationController extends Controller
{
    public function allDestinations() {
        $destinations = Destination::all();
        return view("database.destinations", compact('destinations'));
    }

    public function addDestination() {
        return view("database.addDestination");
    }

    public function addDestinationSubmit(Request $request) {
        if (empty($request->destination))
            return redirect()->route('destinationAdd')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a destination name!']);

        $destination = new Destination();
        $destination->destinationName = $request->destination;
        $destination->save();

        return redirect()->route('destinationView')->with(['alert' => 'success', 'alertMessage' => $destination->destinationName . ' has been added.']);
    }

    public function deleteDestination(Request $request)
    {
        $destination = Destination::where("destination_id", $request->destination_id)->get()->first();

        $destinationsInMergeCount = CityMerge::where("destinationID", $request->destination_id)->get()->count();
        $destinationsInMergeCount += CountyMerge::where("destinationID", $request->destination_id)->get()->count();
        $destinationsInMergeCount += StateMerge::where("destinationID", $request->destination_id)->get()->count();

        if($destinationsInMergeCount != 0) {
            $backRoute = route("destinationView");
            $backName  = "Destinations";
            $item = $destination->destinationName;
            $dependantCategory = "water reuse rules";
            $dependantItems = [];

            return view("database.dependencyError", compact('backName', 'backRoute', 'item', 'dependantCategory', 'dependantItems'));
        }

        //If no dependencies, then delete
        $destination->delete();

        return redirect()->route('destinationView')->with(['alert' => 'success', 'alertMessage' => $destination->destinationName . ' has been deleted.']);
    }
}