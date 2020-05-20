<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ScheduledEmails extends Model
{
    /**
     * Table associated to state model
     */
    protected $table = 'scheduled_emails';

    /**
     * Primary key associated with table
     */
    protected $primaryKey = 'id';

    /**
     * Do not have eloquent create created_at and updated_at columns
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id', 'send_interval', 'last_sent'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function getUserEmail(){
        return $this->user->email;
    }

    public function getLastSentAsCarbon(){
        return new Carbon($this->last_sent);
    }

    public function timeToSendAgain(){
        if(Carbon::now()->addMinutes(5) > $this->getLastSentAsCarbon()->addMinutes($this->getSendIntervalInMinutes()))
            return true;
        else
            return false;
    }

    public function getSendIntervalInMinutes() {
        return $this->send_interval * 1440; // send_interval stored in days, 1440 minutes per day
    }

}
