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
        'countyName'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * One to one relationship for a county to a state. Each county has 1 state
     */
    public function state()
    {
        return $this->hasOne('App\State', 'state_id','fk_state');
    }

    public function cities()
    {
        return $this->hasMany('city');
    }

    public function countyMerge()
    {
        return $this->hasMany('CountyMerge');
    }
}
