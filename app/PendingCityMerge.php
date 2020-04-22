<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PendingCityMerge extends CityMerge
{
    /**
     * Table associated to state model
     */
    protected $table = 'pendingcitymerge';

    use SoftDeletes;
}
