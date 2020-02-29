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
     * Do not have eloquent create created_at and updated_at columns
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'linkText'
    ];

    // Define the one to many on link id to the fields in the merge tables
}
