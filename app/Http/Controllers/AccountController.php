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
        $user = Auth::user();
        return view('account.account', compact('user'));
    }

    public function getUpdatePage()
    {
        return view('account.accountUpdate');
    }

    public function getPasswordPage()
    {
        return view('account.password');
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'inputoldPassword1' => 'bail|min:8|max:255',
            'inputoldPassword2' => 'bail|min:8|max:255',
            'inputPassword' => 'bail|min:8|max:255',
            'inputPassword2' => 'bail|min:8|max:255',
        ]);
        $updated = False;

        $user = User::find(Auth::user()->id);

        #update password through user model.
        if (empty($request->inputPasswordOld1) === False) {
            if ($request->inputPasswordOld1 != $request->inputPasswordOld2)
                return redirect()->back()->with('danger', 'Old passwords do not match. Try again');
            elseif (Hash::check($request->inputPasswordOld1, Auth::user()->password) === false)
                return redirect()->back()->with('danger', 'Incorrect password! Try Again.');
            elseif ($request->newPW != $request->newPW2)
                return redirect()->back()->with('danger', 'New passwords do not match. Try again');
            else {
                $updated = True;
                $user->password = Hash::make($request->newPW);
                $user->save();
            }
        }

        if ($updated === True)
            return redirect()->back()->with('status', 'Password change successful.');
        else
            return redirect()->back()->with('nothing', 'Nothing was updated');

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
        ]);

        $updated = False;
        $user = User::find(Auth::user()->id);

        $tableFields = array('name', 'email', 'streetAddress', 'address2',
            'city', 'state', 'zipCode', 'jobTitle', 'company', 'reason', 'phoneNumber', 'canContact');

        $formFields = array('inputName', 'inputEmail', 'inputAddress', 'inputAddress2',
            'inputCity', 'inputState', 'inputZip', 'inputJob', 'inputCompany', 'recodeUse', 'inputPhone', 'contact');
        # EXAMPLE db use
        # DB::table('users')->update(['email' => $request->inputEmail, 'phoneNumber' => $request->inputPhone]);

        # updates tableFields
        for ($i = 0; $i < sizeof($tableFields); $i++) {
            $tableField = $tableFields[$i];
            $formFieldElement = $formFields[$i];

            if (Auth::user()->$tableField != $request->$formFieldElement) {
                $formField = $request->$formFieldElement ?? $user->$tableField;
                # through 'db'
                # DB::table('users')->update([$tableField => $formField]);
                $user->$tableField = $formField;
                if ($updated != True)
                    $updated = True;
            }
        }

        if ($updated === True) {
            $user->save();
            return redirect('/account')->with('status', 'Info update successful.');
        } else
            return redirect()->back()->with('nothing', 'Nothing was updated. ');
    }
}
