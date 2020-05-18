<?php

namespace App\Http\Controllers;

use App\ScheduledEmails;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function scheduledEmailView(){

        // Get all admins and scheduled emails
        $adminUsers = User::where('is_admin', true)->orderBy('id')->get();
        $currentScheduledEmails = ScheduledEmails::all();

        return view("admin.viewScheduledEmail", compact('adminUsers', 'currentScheduledEmails'));
    }

    // Add a new scheduled email
    public function scheduledEmailSubmit(Request $request){

        if($request->req_type === "add"){
            //Check if user is already in the table
            if(ScheduledEmails::where("user_id", $request->user_id)->get()->count() > 0)
                return redirect()->back()->with(['alert' => 'danger', 'alertMessage' => 'This user already has a scheduled email. Please delete the already scheduled email first.']);

            $newScheduledEmail = new ScheduledEmails();
            $newScheduledEmail->user_id = $request->user_id;
            $newScheduledEmail->send_interval = $request->email_frequency;
            $newScheduledEmail->last_sent = Carbon::now()->subDay(); //Set to now minus one day
            $newScheduledEmail->save();
            return redirect()->back()->with(['alert' => 'success', 'alertMessage' => 'Scheduled email added.']);
        } else {
            //Removing a scheduled email
            $userEmail = ScheduledEmails::find($request->item_id);
            $userEmail->delete();
            return redirect()->back()->with(['alert' => 'success', 'alertMessage' => 'Scheduled email was deleted.']);
        }

    }


    public function getBasicAdminPage()
    {
        $cityNumber = DB::table('cities')->count();
        $countyNumber = DB::table('counties')->count();
        $stateNumber = DB::table('states')->count();

        //route() to show routes
        $locationCards = [];
        $locationCards[] = ["title" => "Cities", "subheading" => "Cities in Counties", "count" => $cityNumber, "manageData" => route("cityView"), "addData" => route("cityAdd")];
        $locationCards[] = ["title" => "Counties", "subheading" => "Counties in States", "count" => $countyNumber, "manageData" => route("countyView"), "addData" => route("countyAdd")];
        $locationCards[] = ["title" => "States", "subheading" => "States in the US", "count" => $stateNumber, "manageData" => route("stateView"), "addData" => route("stateAdd")];

        $sources = DB::table('reusenodes')->count();

        $sourcesAndDestinations = [];
        $sourcesAndDestinations[] = ["title" => "Reuse Nodes", "subheading" => "Water Sources, Destinations, and Fixtures ", "count" => $sources, "manageData" => route("reuseNodeView"), "addData" => route("reuseNodeAdd")];

        $linksNumber = DB::table('links')->count();

        $linksAndOther = [];
        $linksAndOther[] = ["title" => "Links", "subheading" => "Water Regulation Links", "count" => $linksNumber, "manageData" => route("linkView"), "addData" => route("linkAdd")];

        $allUsers = User::all();
        $allUserCount = User::all()->count();
        $user = Auth::user();
        $canEmailCount = User::where('can_contact', true)->count();
        $usersToEmail = ScheduledEmails::all()->count();
        $userAndEmail = [];
        $userAndEmail[] = ["title" => "All Users", "count" => $allUserCount, "view" => route("getUsers")];
        $userAndCanEmail[] = ["title" => "All User Emails", "count" => $canEmailCount, "view" => route("viewEmail")];
        $userAndCanEmail[] = ["title" => "Scheduled Emails", "count" => $usersToEmail, "view" => route("scheduledEmails")];

        if ($user->is_admin === false)
            abort(404);
        else
            return view("admin.dashboard", compact('userAndEmail', 'userAndCanEmail', 'allUsers', 'locationCards', 'sourcesAndDestinations', 'linksAndOther'));
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
