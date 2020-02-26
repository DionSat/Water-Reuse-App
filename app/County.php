<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    /**
     * Table associated to county model
     */
    protected $table = 'counties';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'county_id';

    /**
     * Do not have eloquent create created_at and updated_at columns
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'stateName'
    ];

    /**
     * One to one relationship for a county to a state. Each county has 1 state
     */
    public function state()
    {
        return $this->hasOne('state');
    }
}
