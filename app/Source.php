<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    /**
     * Table associated to state model
     */
    protected $table = 'sources';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'source_id';

    /**
     * Do not have eloquent create created_at and updated_at columns
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'sourceName'
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
