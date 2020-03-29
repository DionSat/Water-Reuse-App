<?php

namespace App\Http\Controllers\DataControllers;

use App\CityMerge;
use App\CountyMerge;
use App\Source;
use App\StateMerge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SourceController extends Controller
{
    public function allSources() {
        $sources = Source::all();
        return view("database.sources", compact('sources'));
    }

    public function addSource() {
        return view("database.addSource");
    }

    public function addSourceSubmit(Request $request) {
        if (empty($request->source))
            return redirect()->route('sourceAdd')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a source name!']);

        $source = new Source();
        $source->sourceName = $request->source;
        $source->save();

        return redirect()->route('sourceView')->with(['alert' => 'success', 'alertMessage' => $source->sourceName . ' has been added.']);
    }

    public function deleteSource(Request $request)
    {
        $source = Source::where("source_id", $request->source_id)->get()->first();

        $sourcesInMergeCount = CityMerge::where("sourceID", $request->source_id)->get()->count();
        $sourcesInMergeCount += CountyMerge::where("sourceID", $request->source_id)->get()->count();
        $sourcesInMergeCount += StateMerge::where("sourceID", $request->source_id)->get()->count();

        if($sourcesInMergeCount != 0) {
            $backRoute = route("sourceView");
            $backName  = "Sources";
            $item = $source->sourceName;
            $dependantCategory = "water reuse rules";
            $dependantItems = [];

            return view("database.dependencyError", compact('backName', 'backRoute', 'item', 'dependantCategory', 'dependantItems'));
        }

        //If no dependencies, then delete
        $source->delete();

        return redirect()->route('sourceView')->with(['alert' => 'success', 'alertMessage' => $source->sourceName . ' has been deleted.']);
    }
}