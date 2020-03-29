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
        $locationCards[] = ["title" => "Cities", "subheading" => "Cities in Counties", "count" => $cityNumber, "manageData" => route("cityView"), "addData" => route("cityAdd")];
        $locationCards[] = ["title" => "Counties", "subheading" => "Counties in States", "count" => $countyNumber, "manageData" => route("countyView"), "addData" => route("countyAdd")];
        $locationCards[] = ["title" => "States", "subheading" => "States in the US", "count" => $stateNumber, "manageData" => route("stateView"), "addData" => route("stateAdd")];

        $sources = DB::table('sources')->count();
        $destinations = DB::table('destinations')->count();

        $sourcesAndDestinations = [];
        $sourcesAndDestinations[] = ["title" => "Sources", "subheading" => "Water Sources", "count" => $sources, "manageData" => route("sourceView"), "addData" => route("sourceAdd")];
        $sourcesAndDestinations[] = ["title" => "Destinations", "subheading" => "Water Destinations", "count" => $destinations, "manageData" => route("destinationView"), "addData" => route("destinationAdd")];

        $linksNumber = DB::table('links')->count();

        $linksAndOther = [];
        $linksAndOther[] = ["title" => "Links", "subheading" => "Water Regulation Links", "count" => $linksNumber, "manageData" => route("linkView"), "addData" => route("linkAdd")];

        return view("admin.database", compact('locationCards', 'sourcesAndDestinations', 'linksAndOther')
        );
    }
}
