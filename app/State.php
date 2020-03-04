<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * Table associated to state model
     */
    protected $table = 'states';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'state_id';

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

    public function counties()
    {
        return $this->hasMany('county');
    }

    public function stateMerge()
    {
        return $this->hasMany('StateMerge');
    }
}
