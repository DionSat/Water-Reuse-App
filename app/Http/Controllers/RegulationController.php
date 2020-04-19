<?php

namespace App\Http\Controllers;

use App\City;
use App\County;
use App\State;
use App\Source;
use App\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

Class RegulationController extends Controller{
    public function allStates(){
        $states = State::all();
        return view("userSubmission", compact('states'));
    }

    public function getAllSources(){
        return response()->json(Source::all());
    }

    public function getAllDestinations() {
        return response()->json(Destination::all());
    }
    public function addRegulationSubmit(Request $request) {
        if (empty($request->newRegList))
            return redirect()->route('regSubmit')->with(['alert' => 'danger', 'alertMessage' => 'You submitted an empty regulation']);

        // $source = new Source();
        // $source->sourceName = $request->source;
        // $source->save();

        return redirect()->route('regSubmit')->with(['alert' => 'success', 'alertMessage' => $request . ' has been added.']);
    }
}
