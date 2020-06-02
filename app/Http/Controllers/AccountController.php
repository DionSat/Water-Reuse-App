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
        $user = Auth::user();
        return view('account.accountUpdate', compact('user'));
    }

    public function getPasswordPage()
    {
        return view('account.password');
    }

    public function changePassword(Request $request)
    {
        $updated = False;

        $user = User::find(Auth::user()->id);

        #update password through user model.
        if ($request->newPW != $request->newPW2)
            return redirect()->back()->with('danger', 'New passwords do not match. Try again');
        elseif (Hash::check($request->oldPW, Auth::user()->password) === false)
            return redirect()->back()->with('danger', 'Incorrect password, try again.');
        else {
            $updated = True;
            $user->password = Hash::make($request->newPW);
            $user->save();
        }

        if ($updated === True)
            return redirect('/account')->with('status', 'Password change successful.');
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

        $user = User::find(Auth::user()->id);

        $tableFields = array('name', 'email', 'streetAddress', 'address2',
            'city', 'state', 'zipCode', 'jobTitle', 'company', 'reason', 'phoneNumber');

        $formFields = array('inputName', 'inputEmail', 'inputAddress', 'inputAddress2',
            'inputCity', 'inputState', 'inputZip', 'inputJob', 'inputCompany', 'recodeUse', 'inputPhone');
        # DB::table('users')->update(['email' => $request->inputEmail, 'phoneNumber' => $request->inputPhone]);

        # updates tableFields
        for ($i = 0; $i < sizeof($tableFields); $i++) {
            $tableField = $tableFields[$i];
            $formFieldElement = $formFields[$i];

            if($user->$tableField != $request->$formFieldElement) {
                $user->$tableField = $request->$formFieldElement;
            }
        }

        if ($request->contact === 'true')
            $user->can_contact = true;
        else
            $user->can_contact = false;

        $user->save();
        return redirect('/account')->with('status', 'Info update successful.');
    }
}
