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

    // Define the one to many on source_id to the fields in the merge tables
}
