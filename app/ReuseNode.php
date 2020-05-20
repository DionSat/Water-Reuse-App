<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReuseNode extends Model
{
    /**
     * Table associated to state model
     */
    protected $table = 'reusenodes';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'node_id';

    /**
     * Do not have eloquent create created_at and updated_at columns
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'node_name', 'is_source', 'is_destination', 'is_fixture'
    ];

    protected $casts = [
        'is_source' => 'boolean',
        'is_destination' => 'boolean',
        'is_fixture' => 'boolean',
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

    public static function sources() {
        return self::where("is_source", true)->get();
    }

    public static function destinations() {
        return self::where("is_destination", true)->get();
    }

    public static function fixtures() {
        return self::where("is_fixture", true)->get();
    }
}
