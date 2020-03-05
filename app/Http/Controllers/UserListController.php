<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{

    public function userList(){
        $allUsers = User::all();
        return view("admin.userlist", compact("allUsers"));
    }
}
