<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * Table associated to county model
     */
    protected $table = 'cities';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'city_id';

    /**
     * Do not have eloquent create created_at and updated_at columns
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cityName'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];
    /**
     * One to one relationship for a county to a state. Each county has 1 state
     */
    public function county()
    {
        return $this->hasOne('App\County', 'county_id','fk_county');
    }

    public function cityMerge()
    {
        return $this->hasMany('CityMerge');
    }
}
