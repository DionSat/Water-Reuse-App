<?php

namespace App\Http\Controllers;

use App\City;
use App\County;
use App\Destination;
use App\Source;
use App\State;
use App\Links;
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
        $locationCards[] = ["title" => "Cities", "subheading" => "Cities, under Counties", "count" => $cityNumber, "manageData" => route("cityView"), "addData" => route("cityAdd")];
        $locationCards[] = ["title" => "Counties", "subheading" => "Counties under States", "count" => $countyNumber, "manageData" => route("countyView"), "addData" => route("countyAdd")];
        $locationCards[] = ["title" => "States", "subheading" => "States in the US", "count" => $stateNumber, "manageData" => "manageData", "addData" => "addLink"];

        $sources = DB::table('sources')->count();
        $destinations = DB::table('destinations')->count();

        $sourcesAndDestinations = [];
        $sourcesAndDestinations[] = ["title" => "Sources", "subheading" => "Water Sources", "count" => $sources, "manageData" => "manageData", "addData" => "addLink"];
        $sourcesAndDestinations[] = ["title" => "Destinations", "subheading" => "Water Destinations", "count" => $destinations, "manageData" => "manageData", "addData" => "addLink"];

        $linksNumber = DB::table('links')->count();

        $linksAndOther = [];
        $linksAndOther[] = ["title" => "Links", "subheading" => "Water Regulation Links", "count" => $linksNumber, "manageData" => "manageData", "addData" => "addLink"];

        return view("admin.database", compact('locationCards', 'sourcesAndDestinations', 'linksAndOther')
        );
    }
}
