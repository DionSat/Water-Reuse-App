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

}
