<?php

namespace App;

use App\Services\LinkCheckerService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    /**
     * Table associated to state model
     */
    protected $table = 'links';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'link_id';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'linkText', 'status', 'name', 'created_at', 'updated_at'
    ];

    public function stateMerge()
    {
        return $this->hasMany('StateMerge');
    }

    public function countyMerge()
    {
        return $this->hasMany('CountyMerge');
    }

    public function cityMerge()
    {
        return $this->hasMany('CityMerge');
    }

    public function getCreatedAtAsCarbon() {
        return new Carbon($this->created_at);
    }
    public function getStatusTextBadge(){
        $badgeColor = "warning";
        $statusText = "Unknown";

        if($this->status === "valid"){
            $badgeColor = "success";
            $statusText = "Valid";
        }
        elseif ($this->status === "broken"){
            $badgeColor = "danger";
            $statusText = "Broken";
        }

        return "<span class=\"badge badge-".$badgeColor."\"> ".$statusText."</span>";
    }

    public function checkSelfIfValidAutomatic(){
        //Check if the link was updated (checked) more than 14 days ago
        if($this->getCreatedAtAsCarbon() < Carbon::now()->subDays(14)){
            $this->status = LinkCheckerService::checkIfLinkIsValid($this->linkText);
            $this->touch(); //Update timestamp if no change
            $this->save();
        }
        return $this->status;
    }

    public function checkSelfIfValid(){
        $this->status = LinkCheckerService::checkIfLinkIsValid($this->linkText);
        $this->save();
        $this->touch(); //Update timestamp if no change
        return $this->status;
    }

    public function getTimeCheckedAsString(){
        $time = new Carbon($this->updated_at);
        return $time->toDayDateTimeString();
    }
}

