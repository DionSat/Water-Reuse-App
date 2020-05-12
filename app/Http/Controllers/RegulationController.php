<?php

namespace App\Http\Controllers;
use App\Services\DatabaseHelper;
use Auth;
use App\Allowed;
use App\ReuseNode;
use App\State;
use Illuminate\Http\Request;
use Throwable;

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
    public function getAllAllowed() {
        return response()->json(Allowed::all());
    }

    public function addRegulationSubmit(Request $request) {
        if (empty($request->newRegList))
            return redirect()->route('regSubmit')->with(['alert' => 'danger', 'alertMessage' => 'You submitted an empty regulation']);

        $regLists = json_decode($request->newRegList, true);

        try {
            return DatabaseHelper::addRegulation($request, $regLists);
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }
}
