<?php

namespace App\Http\Controllers\DataControllers;

use App\CityMerge;
use App\CountyMerge;
use App\ReuseNode;
use App\StateMerge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DestinationController extends Controller
{
    public function allDestinations() {
        $destinations = ReuseNode::destinations();
        return view("database.destinations", compact('destinations'));
    }

    public function addDestination() {
        return view("database.addDestination");
    }

    public function addDestinationSubmit(Request $request) {
        if (empty($request->destination))
            return redirect()->route('destinationAdd')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a destination name!']);

        $destination = new ReuseNode();
        $destination->node_name = $request->destination;
        $destination->is_source = false;
        $destination->is_destination = true;
        $destination->is_fixture = false;
        $destination->save();

        return redirect()->route('destinationView')->with(['alert' => 'success', 'alertMessage' => $destination->node_name . ' has been added.']);
    }

    public function deleteDestination(Request $request)
    {
        $destination = ReuseNode::where("node_id", $request->node_id)->get()->first();

        $destinationsInMergeCount = CityMerge::where("destinationID", $request->node_id)->get()->count();
        $destinationsInMergeCount += CountyMerge::where("destinationID", $request->node_id)->get()->count();
        $destinationsInMergeCount += StateMerge::where("destinationID", $request->node_id)->get()->count();

        if($destinationsInMergeCount != 0) {
            $backRoute = route("destinationView");
            $backName  = "Destinations";
            $item = $destination->node_name;
            $dependantCategory = "water reuse rules";
            $dependantItems = [];

            return view("database.dependencyError", compact('backName', 'backRoute', 'item', 'dependantCategory', 'dependantItems'));
        }

        //If no dependencies, then delete
        $destination->delete();

        return redirect()->route('destinationView')->with(['alert' => 'success', 'alertMessage' => $destination->node_name . ' has been deleted.']);
    }
}