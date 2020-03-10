<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getBasicAdminPage()
    {
        $allUsers = User::all();
        $user = Auth::user();
        if ($user->is_admin === false)
            abort(404);
        else
            return view("admin.dashboard", compact('allUsers'));
    }

    public function getUsers()
    {
        $allUsers = User::all();
        $user = Auth::user();

        if ($user->is_admin === false)
            abort(404);
        else
            return view("admin.adminUpdate", compact('allUsers'));
    }

    public function updateUserAccess(Request $request)
    {
        $user = Auth::user();

        if ($user->is_admin === false)
            abort(404);
        else {
            $userIds = $request['userId'];
            $updated = false;
            if (empty($userIds))
                return redirect()->back()->with('nothing', 'No admins selected');
            else {
                foreach ($userIds as $userId) {
                    $userToModify = User::find($userId);
                    if ($userToModify->is_admin === false) {
                        $userToModify->is_admin = true;
                    } else {
                        $userToModify->is_admin = false;
                    }
                    $updated = true;
                    $userToModify->save();
                }
            }
        }

        /*
                if ($user->is_admin === false)
                    abort(404);
                else {
                    $userId = $request->userId;
                    $userToModify = User::find($userId);
                    if ($userToModify->is_admin === false) {
                        $isAdmin = true;
                        $userToModify->is_admin = true;
                    } else
                        $userToModify->is_admin = false;
                    $userToModify->save();
                }

        */
        if ($updated === true)
            return redirect()->back()->with('status', 'Admins updated.');
        else
            return redirect()->back()->with('nothing', 'No update');
    }

    public function updateAdminInformation(Request $request)
    {

        //Here we can extract information from the request variable
        $name = $request->name;
        $int1 = $request->integer1 ?? 0;
        $int2 = $request->integer2 ?? 0;

        // The ?? operator checks if the first operand e.g. ($request->integer1) is null, if it is it returns the second operand (0)
        // We could not do this check, but it's usually safer to assume nothing about what kind of input you might get

        //Now we can do some math with this
        $sum = $int1 + $int2;

        //We could also do a database call here, call other functions in this controller, etc...
        $sum = $this->addTwoInts($int1, $int2);

        return view("admin.dashboardSubmit", compact("name", "int1", "int2", "sum"));
    }

    private function addTwoInts($int1, $int2)
    {
        return $int1 + $int2;
    }

    public function updateAdminRedirect(Request $request)
    {
        //You can do stuff here as well, but I'm just going to extract the variable and add two pipes around it

        $someInfo = $request->info;
        $someInfo = "|" . $someInfo . "|";

        return redirect()->back()->with('alert', 'success')->with('alertMessage', "You entered: " . $someInfo);
    }
}
