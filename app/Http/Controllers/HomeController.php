<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{

    public function index() {
        return view('homepage');
    }

    // returns the info page
    public function getInfo() {
        return view('info');
    }

    // returns the userSubmission page
    public function getUserSubmission() {
        return view('userSubmission');
    }

    public function welcome() {
        return view('welcome');
    }
}
