<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Get everyone from the User's table in the Database
        // This uses the User.php model to get stuff and structure the data
        $allUsers = User::all();

        //You can also filter stuff like so
        //$test = User::where("name", "Dmitri")->get();


        return view('home', compact("allUsers"));
    }

    // returns the info page
    public function getInfo() {
        return view('info');
    }
}
