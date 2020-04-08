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
        $canEmail = array();

        foreach($allUsers as $users){
            if($users->can_contact === true)
                array_push($canEmail, $users->email);
        }
        if ($user->is_admin === false)
            abort(404);
        else
            return view("admin.dashboard", compact('allUsers', 'canEmail'));
    }

    public function getUsers()
    {
        $allUsers = User::all()->sortBy("id");
        $user = Auth::user();


        if ($user->is_admin === false)
            abort(404);
        else
            return view("admin.adminUpdate", compact('allUsers'));
    }

    public function updateUserAccess(Request $request)
    {
        $updated = false;
        $userIds = $request['userId'];

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

        if ($updated === true)
            return redirect()->back()->with('status', 'Admins updated.');
        else
            return redirect()->back()->with('nothing', 'No update');
    }

    public function viewUser(Request $req){
        $user = User::where("id", $req->user_id)->first();
        return view("admin.viewUser", compact("user"));
    }
}
