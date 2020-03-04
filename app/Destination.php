<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    /**
     * Table associated to state model
     */
    protected $table = 'destinations';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'destination_id';

    /**
     * Do not have eloquent create created_at and updated_at columns
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'destinationName'
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
}
