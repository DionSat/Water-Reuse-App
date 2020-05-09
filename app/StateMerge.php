<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StateMerge extends Model
{
    /**
     * Table associated to state model
     */
    protected $table = 'statemerge';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'stateID', 'sourceID', 'destinationID', 'allowedID', 'codes', 'permit', 'incentives', 'moreInfo', 'user_id', 'comments'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id','user_id');
    }

    public function state()
    {
        return $this->hasOne('App\State', 'state_id','stateID');
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

    public function getTimeSubmittedAsString(){
        $time = new Carbon($this->updated_at);
        return $time->toDayDateTimeString();
    }
}
