<?php

namespace App\Http\Controllers\DataControllers;

use App\CityMerge;
use App\CountyMerge;
use App\StateMerge;
use App\Links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LinkController extends Controller
{
    public function allLinks() {
        $links = Links::all();
        return view("database.links", compact('links'));
    }

    public function addLink() {
        return view("database.addLink");
    }

    public function addLinkSubmit(Request $request) {
        if (empty($request->link))
            return redirect()->route('linkAdd')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a link name!']);

        $link = new Links();
        $link->linkText = $request->link;

        $link->save();

        return redirect()->route('linkView')->with(['alert' => 'success', 'alertMessage' => $link->linkText . ' has been added.']);
    }

    public function deleteLink(Request $request)
    {
        $link = Links::where("link_id", $request->link_id)->get()->first();

        $linksInMergeCount = CityMerge::where("codes", $request->link_id)
                                        ->orWhere("permit", $request->link_id)
                                        ->orWhere("incentives", $request->link_id)
                                        ->orWhere("moreInfo", $request->link_id)->get()->count();

        $linksInMergeCount += CountyMerge::where("codes", $request->link_id)
                                        ->orWhere("permit", $request->link_id)
                                        ->orWhere("incentives", $request->link_id)
                                        ->orWhere("moreInfo", $request->link_id)->get()->count();

        $linksInMergeCount += StateMerge::where("codes", $request->link_id)
                                        ->orWhere("permit", $request->link_id)
                                        ->orWhere("incentives", $request->link_id)
                                        ->orWhere("moreInfo", $request->link_id)->get()->count();

        if($linksInMergeCount != 0) {
            $backRoute = route("linkView");
            $backName  = "Links";
            $item = $link->linkText;
            $dependantCategory = "water reuse links";
            $dependantItems = [];

            return view("database.dependencyError", compact('backName', 'backRoute', 'item', 'dependantCategory', 'dependantItems'));
        }

        //If no dependencies, then delete
        $link->delete();

        return redirect()->route('linkView')->with(['alert' => 'success', 'alertMessage' => $link->linkText . ' has been deleted.']);
    }


    public function modify(Request $request) {
        $link = Links::where("link_id", $request->link_id)->get()->first();
        return view('database.modifyLink', compact('link'));
    }
    public function modifyLinkSubmit(Request $request) {
       $link = Links::where("link_id", $request->link_id)->get()->first();

        if(empty($request->newLinkValue))
            return redirect()->route('modifyLink', ['link_id' => $link->link_id])->with(['alert' => 'danger', 'alertMessage' => 'Please enter a link']);

        $oldLink = $link->linkText;

        $link->linkText = $request->newLinkValue;
        $link->save();

        return redirect()->route('linkView')->with(['alert' => 'success', 'alertMessage' => $oldLink . ' has been changed to ' . $link->linkText]);
    }
}
