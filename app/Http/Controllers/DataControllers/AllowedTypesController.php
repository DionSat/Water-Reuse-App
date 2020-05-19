<?php

namespace App\Http\Controllers\DataControllers;

use App\Allowed;
use App\CityMerge;
use App\CountyMerge;
use App\ReuseNode;
use App\StateMerge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AllowedTypesController extends Controller
{
    public function allAllowedTypes() {
        $types = Allowed::all();
        return view("database.allowed", compact('types'));
    }

    public function addAllowedType() {
        return view("database.addAllowed");
    }

    public function addAllowedTypeSubmit(Request $request) {
        if (empty($request->allowedText))
            return redirect()->route('allowedAdd')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a name!']);

        $allowed = new Allowed();
        $allowed->allowedText = $request->allowedText;
        $allowed->save();

        return redirect()->route('allowedView')->with(['alert' => 'success', 'alertMessage' => $allowed->allowedText . ' has been added.']);
    }

    public function deleteAllowedType(Request $request)
    {
        $allowed = Allowed::where("allowed_id", $request->allowed_id)->get()->first();

        $allowedInMergeCount = CityMerge::where("allowedID", $request->allowed_id)->get()->count();
        $allowedInMergeCount += CountyMerge::where("allowedID", $request->allowed_id)->get()->count();
        $allowedInMergeCount += StateMerge::where("allowedID", $request->allowed_id)->get()->count();

        if($allowedInMergeCount != 0) {
            $backRoute = route("allowedView");
            $backName  = "Allowed Types";
            $item = $allowed->allowedText;
            $dependantCategory = "water reuse rules";
            $dependantItems = [];

            return view("database.dependencyError", compact('backName', 'backRoute', 'item', 'dependantCategory', 'dependantItems'));
        }

        //If no dependencies, then delete
        $allowed->delete();

        return redirect()->route('allowedView')->with(['alert' => 'success', 'alertMessage' => $allowed->allowedText . ' has been deleted.']);
    }

    public function modify(Request $request) {
        $allowed = Allowed::where("allowed_id", $request->allowed_id)->get()->first();
        return view('database.modifyAllowed', compact('allowed'));
    }

    public function modifyAllowedSubmit(Request $request) {
        $allowed = Allowed::where("allowed_id", $request->allowed_id)->get()->first();
        if(empty($request->newValue))
            return redirect()->route('modifyAllowed')->with(['alert' => 'danger', 'alertMessage' => 'Please enter new allowed text!']);

        $oldValue = $allowed->allowedText;

        $allowed->allowedText = $request->newValue;
        $allowed->save();

        if($oldValue === $allowed->allowedText)
            return redirect()->route('allowedView')->with(['alert' => 'success', 'alertMessage' => 'The node '.$allowed->allowedText.' has been updated.']);
        else
            return redirect()->route('allowedView')->with(['alert' => 'success', 'alertMessage' => $oldValue . ' has been changed to ' . $allowed->allowedText . ' & values have been updated.']);
    }
}
