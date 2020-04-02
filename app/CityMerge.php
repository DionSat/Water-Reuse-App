<?php

namespace App;

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
        'cityID', 'sourceID', 'destinationID', 'allowedID', 'codes', 'permit', 'incentives', 'moreInfo'
    ];

    public function city()
    {
        return $this->hasOne('city');
    }
}
