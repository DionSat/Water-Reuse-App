<?php

namespace App\Http\Controllers\DataControllers;

use App\County;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class StateController extends Controller
{
    public function allStates() {
        $states = State::all();
        return view("database.states", compact('states'));
    }

    public function addState() {
        return view("database.addState");
    }

    public function addStateSubmit(Request $request) {
        if (empty($request->state))
            return redirect()->route('stateAdd')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a state name!']);

        $state = new State();
        $state->stateName = $request->state;
        $state->save();

        return redirect()->route('stateView')->with(['alert' => 'success', 'alertMessage' => $state->stateName . ' has been added.']);
    }

    public function deleteState(Request $request)
    {
        $state = State::where("state_id", $request->state_id)->get()->first();
        $countiesInState = County::where("fk_state", $request->state_id)->get();
        if($countiesInState->count() != 0) {
            $backRoute = route("stateView");
            $backName  = "States";
            $item = $state->stateName;
            $dependantCategory = "counties";
            $dependantItems = [];
            foreach ($countiesInState as $county){
                $dependantItems [] = $county->countyName;
            }

            return view("database.dependencyError", compact('backName', 'backRoute', 'item', 'dependantCategory', 'dependantItems'));
        }

        //If no dependencies, then delete
        $state->delete();

        return redirect()->route('stateView')->with(['alert' => 'success', 'alertMessage' => $state->stateName . ' has been deleted.']);
    }

    public function getAllStates(){
        return response()->json(State::all());
    }

    public function modify(Request $request) {
        $state = State::where("state_id", $request->state_id)->get()->first();
        return view('database.modifyState', compact('state'));
    }

    public function modifyStateSubmit(Request $request) {
        $state = State::where("state_id", $request->state_id)->get()->first();
        if(empty($request->newStateValue))
            return redirect()->route('modifyState', ['state_id' => $state->state_id])->with(['alert' => 'danger', 'alertMessage' => 'Please enter a state name!']);

        $oldStateName = $state->stateName;
        $state->stateName = $request->newStateValue;
        $state->save();

        return redirect()->route('stateView')->with(['alert' => 'success', 'alertMessage' => $oldStateName . ' has been changed to ' . $state->stateName]);
    }
}
