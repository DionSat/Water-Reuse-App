<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PendingCountyMerge extends CountyMerge
{
    /**
     * Table associated to state model
     */
    protected $table = 'pendingcountymerge';

    use SoftDeletes;
}
