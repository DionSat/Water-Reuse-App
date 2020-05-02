<?php

namespace App\Http\Controllers;


class GraphicController extends Controller
{
    // returns the info page
    public function getGraphic() {
        return view('search.graphicalResults');
    }
}
