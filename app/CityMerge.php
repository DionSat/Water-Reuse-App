<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CityMerge extends Model
{
    /**
     * Table associated to state model
     */
    protected $table = 'citymerge';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cityID', 'sourceID', 'destinationID', 'allowedID', 'codes', 'permit', 'incentives', 'moreInfo', 'user_id', 'comments', 'location_type'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id','user_id');
    }

    public function city()
    {
        return $this->hasOne('App\City', 'city_id','cityID');
    }

    public function destination()
    {
        return $this->hasOne('App\ReuseNode', 'node_id','destinationID');
    }

    public function allowed()
    {
        return $this->hasOne('App\Allowed', 'allowed_id','allowedID');
    }

    public function source()
    {
        return $this->hasOne('App\ReuseNode', 'node_id','sourceID');
    }

    public function codesObj()
    {
        return $this->hasOne('App\Links', 'link_id','codes');
    }

    public function permitObj()
    {
        return $this->hasOne('App\Links', 'link_id','permit');
    }

    public function incentivesObj()
    {
        return $this->hasOne('App\Links', 'link_id','incentives');
    }

    public function moreInfoObj()
    {
        return $this->hasOne('App\Links', 'link_id','moreInfo');
    }

    public function setLocationAsResidential(){
        $this->location_type = "residential";
        return;
    }

    public function setLocationAsCommercial(){
        $this->location_type = "commercial";
        return;
    }

    public function getTimeSubmittedAsString(){
        $time = new Carbon($this->updated_at);
        return $time->toDayDateTimeString();
    }

    public function getLocationAsString() {
        return $this->city->cityName.", ".$this->city->county->countyName." County, ".$this->city->county->state->stateName;
    }

    public function getLocationType() {
        return "city";
    }

    public function getStatus(){
        if($this->table === "citymerge")
            return "approved";
        else
            return $this->trashed() ? "rejected" : "pending";
    }

    public function getStatusAsString(){
        return ucfirst($this->getStatus());
    }


    public function getStatusAsBadge(){
        $status = $this->getStatus();
        $badgeColor = "warning";

        if($status === "rejected"){
            $badgeColor = "danger";
        }
        elseif ($status === "approved"){
            $badgeColor = "success";
        }

        return "<span class=\"badge badge-".$badgeColor."\"> ".$this->getStatusAsString()."</span>";
    }

}
