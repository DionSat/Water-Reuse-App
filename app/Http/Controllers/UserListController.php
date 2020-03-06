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

    public function viewUser(Request $req){
        $user = User::where("id", $req->user_id)->first();
        return view("admin.viewuser", compact("user"));
    }
}
