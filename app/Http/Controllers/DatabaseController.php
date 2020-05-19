<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{

    public function getDatabasePage(Request $request){
        $cityNumber = DB::table('cities')->count();
        $countyNumber = DB::table('counties')->count();
        $stateNumber = DB::table('states')->count();

        //route() to show routes
        $locationCards = [];
        $locationCards[] = ["title" => "Cities", "subheading" => "Cities in Counties", "count" => $cityNumber, "manageData" => route("cityView"), "addData" => route("cityAdd")];
        $locationCards[] = ["title" => "Counties", "subheading" => "Counties in States", "count" => $countyNumber, "manageData" => route("countyView"), "addData" => route("countyAdd")];
        $locationCards[] = ["title" => "States", "subheading" => "States in the US", "count" => $stateNumber, "manageData" => route("stateView"), "addData" => route("stateAdd")];

        $sources = DB::table('reusenodes')->where("is_source", true)->count();

        $sourcesAndDestinations = [];
        $sourcesAndDestinations[] = ["title" => "Reuse Nodes", "subheading" => "Water Sources, Destinations, and Fixtures ", "count" => $sources, "manageData" => route("reuseNodeView"), "addData" => route("reuseNodeAdd")];

        $linksNumber = DB::table('links')->count();

        $linksAndOther = [];
        $linksAndOther[] = ["title" => "Links", "subheading" => "Water Regulation Links", "count" => $linksNumber, "manageData" => route("linkView"), "addData" => route("linkAdd")];

        $allowedNumber = DB::table('allowed')->count();
        $allowedTypes = [];
        $allowedTypes[] = ["title" => "Allowed?", "subheading" => "Allowed Levels (yes/no/...)", "count" => $allowedNumber, "manageData" => route("allowedView"), "addData" => route("allowedAdd")];

        return view("admin.database", compact('locationCards', 'sourcesAndDestinations', 'linksAndOther', 'allowedTypes')
        );
    }
}
