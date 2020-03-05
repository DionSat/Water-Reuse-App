<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{

    public function userList(){
        $emails=array();
        $canEmail=array();
        $allUsers = User::all();
        return view("admin.userlist", compact("allUsers","emails","canEmail"));
    }

    public function viewUser($username){
        $user = User::where("name", username)->get();
        return view("admin.viewuser", compact("user"));
    }
}
