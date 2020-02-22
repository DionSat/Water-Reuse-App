<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;
use Auth;

class AccountController extends Controller
{
    public function view()
    {
        return view('account');
    }

    public function updateAccount(Request $request)
    {
        $tableFields = array('name', 'email', 'streetAddress', 'address2',
            'city', 'state', 'zipCode', 'jobTitle', 'company', 'reason', 'phoneNumber');

        $formFields = array('inputName', 'inputEmail', 'inputAddress', 'inputAddress2',
            'inputCity', 'inputState', 'inputZip', 'inputJob', 'inputCompany', 'recodeUse','inputPhone');

        # EXAMPLE
        # DB::table('users')->update(['email' => $request->inputEmail, 'phoneNumber' => $request->inputPhone]);

        # updates tableFields excluding password
        for ($i = 0; $i < sizeof($tableFields); $i++) {
            $tableField = $tableFields[$i];
            $formFieldElement = $formFields[$i];
            $formField = $request->$formFieldElement ?? Auth::user()->$tableField;
            echo "Updating the table element ".$tableField." with ".$formField;
            DB::table('users')->update([$tableField => $formField]);
        }

        #only throwing success right now.. change later.
        return redirect()->back()->with('alert', 'success')->with('alertMessage', 'Update Successful');
    }

}
