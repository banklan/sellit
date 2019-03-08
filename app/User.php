<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name', 'l_name','email', 'password', 'gender', 'phone_no', 'location', 'city', 'about_me', 'prof_pix', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['Fullname', 'slug'];

    protected $with = ['city'];

    public function ad()
    {
        return $this->hasMany('App\Ad');
    }

    public function service()
    {
        return $this->hasMany('App\ServiceAd');
    }

    public function sellerReview()
    {
        return $this->hasMany('App\SellerReview');
    }

    public function senderChat()
    {
        return $this->hasMany('App\Chat', 'sender_id');
    }

    public function receiverChat()
    {
        return $this->hasMany('App\Chat', 'receiver_id');
    }

    public function getFullnameAttribute()
    {
    	$first = $this->f_name;
    	$last = $this->l_name;
    	$fullname = ucfirst($first).' '.ucfirst($last);
    	return $fullname;
    }

    public function getslugAttribute()
    {
        $slug = str_slug($this->f_name.' '.$this->l_name);

        return $slug;
    }
    
    public function city()
    {
    	return $this->belongsTo('App\City');
    }

    public function rep()
    {
        return $this->hasMany('App\Report');
    }
    public function reporter()
    {
        return $this->hasMany('App\Report');
    }

    public function reportee()
    {
        return $this->hasMany('App\Report');
    }
}
