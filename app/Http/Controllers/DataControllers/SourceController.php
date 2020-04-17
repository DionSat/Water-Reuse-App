<?php

namespace App\Http\Controllers\DataControllers;

use App\CityMerge;
use App\CountyMerge;
use App\ReuseNode;
use App\StateMerge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SourceController extends Controller
{
    public function allSources() {
        $sources = ReuseNode::sources();
        return view("database.sources", compact('sources'));
    }

    public function addSource() {
        return view("database.addSource");
    }

    public function addSourceSubmit(Request $request) {
        if (empty($request->source))
            return redirect()->route('sourceAdd')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a source name!']);

        $source = new ReuseNode();
        $source->node_name = $request->source;
        $source->is_source = true;
        $source->is_destination = false;
        $source->is_fixture = false;
        $source->save();

        return redirect()->route('sourceView')->with(['alert' => 'success', 'alertMessage' => $source->node_name . ' has been added.']);
    }

    public function deleteSource(Request $request)
    {
        $source = ReuseNode::where("node_id", $request->node_id)->get()->first();

        $sourcesInMergeCount = CityMerge::where("sourceID", $request->node_id)->get()->count();
        $sourcesInMergeCount += CountyMerge::where("sourceID", $request->node_id)->get()->count();
        $sourcesInMergeCount += StateMerge::where("sourceID", $request->node_id)->get()->count();

        if($sourcesInMergeCount != 0) {
            $backRoute = route("sourceView");
            $backName  = "Sources";
            $item = $source->node_name;
            $dependantCategory = "water reuse rules";
            $dependantItems = [];

            return view("database.dependencyError", compact('backName', 'backRoute', 'item', 'dependantCategory', 'dependantItems'));
        }

        //If no dependencies, then delete
        $source->delete();

        return redirect()->route('sourceView')->with(['alert' => 'success', 'alertMessage' => $source->node_name . ' has been deleted.']);
    }
}