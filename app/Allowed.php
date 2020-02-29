<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allowed extends Model
{
    /**
     * Table associated to county model
     */
    protected $table = 'allowed';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'allowed_id';

    /**
     * Do not have eloquent create created_at and updated_at columns
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'allowedText'
    ];
}
