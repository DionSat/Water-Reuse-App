<?php

namespace App\Http\Controllers;

use App\City;
use App\County;
use App\ReuseNode;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

Class RegulationController extends Controller{
    public function allStates(){
        $states = State::all();
        return view("userSubmission", compact('states'));
    }

    public function getAllSources(){
        return response()->json(ReuseNode::sources());
    }

    public function getAllDestinations() {
        return response()->json(ReuseNode::destinations());
    }

}
