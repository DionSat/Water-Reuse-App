<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountyMerge extends Model
{
    /**
     * Table associated to state model
     */
    protected $table = 'countymerge';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'countyID', 'sourceID', 'destinationID', 'allowedID', 'codes', 'permit', 'incentives', 'moreInfo', 'user_id', 'comments'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id','user_id');
    }

    public function county()
    {
        return $this->hasOne('App\County', 'county_id','countyID');
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
}
