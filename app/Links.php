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

    public function getSelfAsHttpLink(){
        if(substr( $this->linkText, 0, 7 ) === "http://" || substr( $this->linkText, 0, 8 ) === "https://"){
            return $this->linkText;
        } else {
            //Return string with http:// appended
            return "http://".$this->linkText;
        }
    }

    public function checkSelfIfValidAutomatic(){
        $reqResult = "";
        //Check if the link was updated (checked) more than 14 days ago
        if($this->getCreatedAtAsCarbon() < Carbon::now()->subDays(14)){
            $reqResult = LinkCheckerService::checkIfLinkIsValid($this->linkText);
            $this->status = $reqResult["status"];
            $this->touch(); //Update timestamp if no change
            $this->save();
        }
        return $reqResult;
    }

    public function checkSelfIfValid(){
        $reqResult = LinkCheckerService::checkIfLinkIsValid($this->linkText);
        $this->status = $reqResult["status"];
        $this->save();
        $this->touch(); //Update timestamp if no change
        return $reqResult;
    }

    public function getTimeCheckedAsString(){
        $time = new Carbon($this->updated_at);
        return $time->toDayDateTimeString();
    }
}

