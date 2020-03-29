<?php

namespace App\Http\Controllers\DataControllers;

use App\County;
use App\Source;
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
        if (empty($request->Source))
            return redirect()->route('SourceAdd')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a Source name!']);

        $Source = new Source();
        $Source->SourceName = $request->Source;
        $Source->save();

        return redirect()->route('SourceView')->with(['alert' => 'success', 'alertMessage' => $Source->SourceName . ' has been added.']);
    }

    public function deleteSource(Request $request)
    {
        $Source = Source::where("Source_id", $request->Source_id)->get()->first();
        $countiesInSource = County::where("fk_Source", $request->Source_id)->get();
        if($countiesInSource->count() != 0) {
            $backRoute = route("SourceView");
            $backName  = "Sources";
            $item = $Source->SourceName;
            $dependantCategory = "counties";
            $dependantItems = [];
            foreach ($countiesInSource as $county){
                $dependantItems [] = $county->countyName;
            }

            return view("database.dependencyError", compact('backName', 'backRoute', 'item', 'dependantCategory', 'dependantItems'));
        }

        //If no dependencies, then delete
        $Source->delete();

        return redirect()->route('SourceView')->with(['alert' => 'success', 'alertMessage' => $Source->SourceName . ' has been deleted.']);
    }
}