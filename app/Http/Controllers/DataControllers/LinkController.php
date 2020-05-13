<?php

namespace App\Http\Controllers\DataControllers;

use App\CityMerge;
use App\CountyMerge;
use App\Services\LinkCheckerService;
use App\StateMerge;
use App\Links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LinkController extends Controller
{
    public function allLinks(Request $request) {
        $links = null;
        $brokenLinkCount = Links::where("status", "broken")->count();
        $page = ($request->type === "broken") ? "broken" : "regular";

        if($page === "broken"){
            $links = Links::where("status", "broken")->paginate(10);
        } else {
            $links = Links::orderBy('link_id')->paginate(10);
        }

        return view("database.links", compact('links', 'brokenLinkCount', 'page'));
    }

    public function checkLinkStatus(Request $request){
        $newLinkStatus = LinkCheckerService::checkAndUpdateLinkStatusById($request->link_id, true);
        return redirect()->back()->with(['alert' => 'success', 'alertMessage' =>  ' The link status is: '.$newLinkStatus]);
    }

    //API method that is called every time a user clicks on a link
    public function checkLinkStatusAPI(Request $request){
        LinkCheckerService::checkAndUpdateLinkStatusById($request->link_id, false);
        return "True";
    }

    public function addLink() {
        return view("database.addLink");
    }

    public function addLinkSubmit(Request $request) {
        if (empty($request->link) || empty($request->name))
            return redirect()->route('linkAdd')->with(['alert' => 'danger', 'alertMessage' => 'Please enter a link name & URL!']);

        $link = new Links();
        $link->linkText = $request->link;
        $link->name = $request->name;
        $link->status = "valid";

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

        if(empty($request->newLinkName) || empty($request->newLinkText))
            return redirect()->route('modifyLink', ['link_id' => $link->link_id])->with(['alert' => 'danger', 'alertMessage' => 'Please enter a link name & URL']);

        $statusArray = array("valid", "broken", "unknown");
        if(!(in_array($request->newLinkStatus, $statusArray)))
            return redirect()->route('modifyLink', ['link_id' => $link->link_id])->with(['alert' => 'danger', 'alertMessage' => 'Please enter a link status']);


        $link->name = $request->newLinkName;
        $link->linkText = $request->newLinkText;
        $link->status = $request->newLinkStatus;
        $link->save();

        return redirect()->route('linkView')->with(['alert' => 'success', 'alertMessage' => 'Link has been successfully updated.']);
    }
}
