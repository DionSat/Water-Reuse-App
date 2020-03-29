<?php

namespace App\Http\Controllers\DataControllers;

use App\County;
use App\Destination;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DestinationController extends Controller
{
    //TODO - Implement this controller fully

    public function allDestinations() {
        $destinations = Destination::all();
        return view("database.destinations", compact('destinations'));
    }


}