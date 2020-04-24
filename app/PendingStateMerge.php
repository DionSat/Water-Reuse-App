<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendingStateMerge extends StateMerge
{
    /**
     * Table associated to state model
     */
    protected $table = 'pendingstatemerge';

    use SoftDeletes;
}
