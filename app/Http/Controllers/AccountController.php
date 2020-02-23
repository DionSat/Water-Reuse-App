<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;
use Auth;
use Hash;

class AccountController extends Controller
{
    public function view()
    {
        return view('account.account');
    }

    public function getUpdatePage()
    {
        return view('account.accountUpdate');
    }

    public function updateAccount(Request $request)
    {
        $validatedData = $request->validate([
            'inputName' => 'bail|nullable|max:255',
            'inputEmail' => 'bail|nullable|max:255',
            'inputAddress' => 'bail|nullable',
            'inputAddress2' => 'bail|nullable',
            'inputCity' => 'bail|nullable',
            'inputState' => 'bail|nullable',
            'inputJob' => 'bail|nullable',
            'inputCompany' => 'bail|nullable',
            'recodeUse' => 'bail|max:255|nullable',
            'inputPhone' => 'bail|nullable|numeric',
            'inputoldPassword1' => 'bail|min:8|max:255|nullable',
            'inputoldPassword2' => 'bail|min:8|max:255|nullable',
            'inputPassword' => 'bail|min:8|max:255|nullable',
        ]);

        $updated = False;
        $pwUpdated = False;
        $user = User::find(Auth::user()->id);

        #update password through user model.
        if (empty($request->inputPasswordOld1) === False) {
            if ($request->inputPasswordOld1 != $request->inputPasswordOld2) {
                return redirect()->back()->with('danger', 'Old passwords do not match. Try again');
            } elseif (Hash::check($request->inputPasswordOld1, Auth::user()->password) === false) {
                return redirect()->back()->with('danger', 'Incorrect password! Try Again.');
            } else {
                $pwUpdated = True;
                $user->password = Hash::make($request->inputPassword);
                $user->save();
            }
        }


        $tableFields = array('name', 'email', 'streetAddress', 'address2',
            'city', 'state', 'zipCode', 'jobTitle', 'company', 'reason', 'phoneNumber');

        $formFields = array('inputName', 'inputEmail', 'inputAddress', 'inputAddress2',
            'inputCity', 'inputState', 'inputZip', 'inputJob', 'inputCompany', 'recodeUse', 'inputPhone');

        # EXAMPLE db use
        # DB::table('users')->update(['email' => $request->inputEmail, 'phoneNumber' => $request->inputPhone]);

        # updates tableFields excluding password
        for ($i = 0; $i < sizeof($tableFields); $i++) {
            $tableField = $tableFields[$i];
            $formFieldElement = $formFields[$i];

            if (Auth::user()->$tableField != $request->$formFieldElement) {
                $formField = $request->$formFieldElement ?? $user->$tableField;
                # through 'db'
                # DB::table('users')->update([$tableField => $formField]);
                $user->$tableField = $formField;
                $user->save();
                if ($updated != True)
                    $updated = True;
            }
        }


        # check if data was updated
        if ($updated === True and $pwUpdated === True)
            return redirect()->back()->with('status', 'Info & password update successful.');
        elseif ($updated === True and $pwUpdated === False)
            return redirect()->back()->with('status', 'Info update successful.');
        elseif ($updated === False and $pwUpdated === True)
            return redirect()->back()->with('status', 'Password update successful.');
        else
            return redirect()->back()->with('nothing', 'Nothing was updated (change a field)');
    }

}
