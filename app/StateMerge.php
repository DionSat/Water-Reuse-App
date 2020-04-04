<?php

namespace App;

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
        'stateID', 'sourceID', 'destinationID', 'allowedID', 'codes', 'permit', 'incentives', 'moreInfo', 'userID'
    ];

    public function state()
    {
        return $this->hasOne('state');
    }
}
