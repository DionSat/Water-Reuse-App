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
        'countyID', 'sourceID', 'destinationID', 'allowedID', 'codes', 'permit', 'incentives', 'moreInfo'
    ];

    public function county()
    {
        return $this->hasOne('county');
    }
}
