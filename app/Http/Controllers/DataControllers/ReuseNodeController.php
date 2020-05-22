<?php

namespace App\Http\Controllers\DataControllers;

use App\CityMerge;
use App\CountyMerge;
use App\ReuseNode;
use App\StateMerge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ReuseNodeController extends Controller
{
    public function allReuseNodes() {
        //$nodes = ReuseNode::paginate(10);
        $nodes = ReuseNode::all();
        return view("database.reuseNodes", compact('nodes'));
    }

    public function addReuseNode() {
        return view("database.addReuseNode");
    }

    public function addReuseNodeSubmit(Request $request) {
        if (empty($request->source))
            return redirect()->route('reuseNodeAdd')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a source/destination/fixture name!']);

        $source = new ReuseNode();
        $source->node_name = $request->source;
        $source->is_source = $request->boolean('is_source');
        $source->is_destination = $request->boolean('is_destination');
        $source->is_fixture = $request->boolean('is_fixture');
        $source->save();

        return redirect()->route('reuseNodeView')->with(['alert' => 'success', 'alertMessage' => $source->node_name . ' has been added.']);
    }

    public function deleteReuseNode(Request $request)
    {
        $node = ReuseNode::where("node_id", $request->node_id)->get()->first();

        $sourcesInMergeCount = CityMerge::where("sourceID", $request->node_id)->get()->count();
        $sourcesInMergeCount += CountyMerge::where("sourceID", $request->node_id)->get()->count();
        $sourcesInMergeCount += StateMerge::where("sourceID", $request->node_id)->get()->count();

        if($sourcesInMergeCount != 0) {
            $backRoute = route("sourceView");
            $backName  = "Sources";
            $item = $node->node_name;
            $dependantCategory = "water reuse rules";
            $dependantItems = [];

            return view("database.dependencyError", compact('backName', 'backRoute', 'item', 'dependantCategory', 'dependantItems'));
        }

        //If no dependencies, then delete
        $node->delete();

        return redirect()->route('reuseNodeView')->with(['alert' => 'success', 'alertMessage' => $node->node_name . ' has been deleted.']);
    }

    public function modify(Request $request) {
        $node = ReuseNode::where("node_id", $request->node_id)->get()->first();
        return view('database.modifyReuseNode', compact('node'));
    }

    public function modifyReuseNodeSubmit(Request $request) {
        $node = ReuseNode::where("node_id", $request->node_id)->get()->first();
        if(empty($request->newValue))
            return redirect()->route('modifyReuseNode')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a source/destination/fixture name!']);

        $oldValue = $node->node_name;

        $node->node_name = $request->newValue;
        $node->is_source = $request->boolean('is_source');
        $node->is_destination = $request->boolean('is_destination');
        $node->is_fixture = $request->boolean('is_fixture');
        $node->save();

        if($oldValue === $node->node_name)
            return redirect()->route('reuseNodeView')->with(['alert' => 'success', 'alertMessage' => 'The node '.$node->node_name.' has been updated.']);
        else
            return redirect()->route('reuseNodeView')->with(['alert' => 'success', 'alertMessage' => $oldValue . ' has been changed to ' . $node->node_name . ' & values have been updated.']);
    }
}
