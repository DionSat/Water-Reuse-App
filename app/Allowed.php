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

    public function getAllowedTextBadge(){
        $badgeColor = "secondary";
        if($this->allowedText === "Yes"){
            $badgeColor = "success";
        }
        elseif ($this->allowedText === "No"){
            $badgeColor = "danger";
        }
        elseif ($this->allowedText === "Maybe"){
            $badgeColor = "warning";
        }
        return "<span class=\"badge badge-".$badgeColor."\"> ".$this->allowedText."</span>";
    }
}
