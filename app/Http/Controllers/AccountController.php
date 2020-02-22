<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function view()
    {
        return view('account');
    }

    public function updateAccount(Request $request)
    {
        $newName = $request->inputName;
        $newEmail = $request->inputEmail;
        $newPhone = $request->inputPhone;
        echo $newName;

    }
}
