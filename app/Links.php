<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    /**
     * Table associated to state model
     */
    protected $table = 'links';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'link_id';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'linkText', 'status', 'name', 'updated_at',
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
    }}
