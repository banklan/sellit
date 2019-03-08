<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Chat extends Model
{
    protected $fillable = [
        'sender_id', 'receiver_id','message',
    ];

    protected $with = ['receiver', 'sender'];

    protected $appends = ['selfOwned', 'time', 'posted', 'postedToday'];

    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User', 'receiver_id');
    }

    public function getselfOwnedAttribute()
    {
    	return $this->sender_id === auth()->user()->id;
    }

    public function gettimeAttribute()
    {
    	return $this->created_at->format('h:i A');
    }

    public function getpostedAttribute()
    {
    	//check message date
    	$postedDate = $this->created_at->format('Y-m-d');
    	//check todays date
    	$today = \Carbon\Carbon::now()->format('Y-m-d'); 
    	//check yesterday's date
    	$yesterday = \Carbon\Carbon::yesterday()->format('Y-m-d');
    	// compare message date to today asd yesterday
    	if($postedDate == $today){
    		return "Today";
    	}elseif($postedDate == $yesterday){
    		return "Yesterday";
    	}else{
    		return "Old";
    	}
    }

    public function getpostedTodayAttribute()
    {
    	//check message date
    	$postedDate = $this->created_at->format('Y-m-d');
    	//check todays date
    	$today = \Carbon\Carbon::now()->format('Y-m-d'); 
    	//check yesterday's date
    	if($postedDate == $today){
    		return true;
    	}else{
    		return false;
    	}
    }
}
