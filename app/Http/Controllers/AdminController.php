<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;

class AdminController extends Controller
{
    public function getBasicAdminPage()
    {
        $allUsers = User::all();
        $allUserCount = User::all()->count();
        $user = Auth::user();
        $canEmailCount = User::where('can_contact', true)->count();
        $userAndEmail = [];
        $userAndEmail[] = ["title" => "All Users", "count" => $allUserCount, "view" => route("getUsers")];
        $userAndEmail[] = ["title" => "Users Emails", "count" => $canEmailCount, "view" => route("viewEmail")];
        if ($user->is_admin === false)
            abort(404);
        else
            return view("admin.dashboard", compact('userAndEmail', 'allUsers'));
    }

    public function viewEmail()
    {
        $allUsers = User::all();
        $all = User::orderBy('id')->paginate(6, ['*'], 'users');
        $user = Auth::user();
        $canEmail = array();
        $canBeEmailed = User::where('can_contact', true)->orderBy('id')->paginate(6, ['*'], 'contactable');

        foreach($allUsers as $users){
            if($users->can_contact === true)
                array_push($canEmail, $users->email);
        }
        if ($user->is_admin === false)
            abort(404);
        else
            return view("admin.viewEmail", compact('canEmail', 'allUsers', 'all', 'canBeEmailed'));
    }

    public function getUsers()
    {
        $allUsers = User::orderBy('id')->paginate(10);//->sortBy("id");
        $user = Auth::user();
        $userListHome = true;


        if ($user->is_admin === false)
            abort(404);
        else
            return view("admin.adminUpdate", compact('allUsers', 'userListHome'));
    }

    public function searchUsers(Request $request)
    {
        $searchInput = $request->search;
        $searchInput = '%'.$searchInput.'%';

        $allUsers = User::where('name', 'ILIKE',$searchInput)
            ->orWhere('email','ILIKE',$searchInput)
            ->orWhere('streetAddress','ILIKE',$searchInput)
            ->orWhere('city','ILIKE',$searchInput)
            ->orWhere('state','ILIKE',$searchInput)
            ->orWhere('company','ILIKE',$searchInput)
            ->orWhere('jobTitle','ILIKE',$searchInput)
            ->orderBy('id')
            ->paginate(10);

        //var_dump($users->toArray());
        $user = Auth::user();
        $userListHome = false;


        if ($user->is_admin === false)
            abort(404);
        else
            return view("admin.adminUpdate", compact('allUsers','userListHome'));
    }

    public function updateUserAccess(Request $request)
    {
        $updated = false;
        $userId = $request->userId;
        $userToModify = User::find($userId);
        if ($userToModify->is_admin === false) {
            $userToModify->is_admin = true;
        } else {
            $userToModify->is_admin = false;
        }
        $updated = true;
        $userToModify->save();

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
