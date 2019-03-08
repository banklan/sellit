<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceAd extends Model
{
    protected $fillable = [
        'user_id', 'service_category_id', 'title', 'price',
    ];

    protected $with = ['user', 'serviceDescr', 'serviceAdPic'];

    protected $appends = ['slug', 'selfOwned'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function serviceDescr()
    {
    	return $this->hasMany('App\ServiceAdDesc');
    }

    public function serviceAdPic()
    {
    	return $this->hasMany('App\ServiceAdPic');
    }

    public function getslugAttribute()
    {
        $slug = str_slug($this->title);

        return $slug;
    }

    public function getselfOwnedAttribute()
    {
        if(auth()->user()){
           return $this->user_id == auth()->user()->id; 
       }
    }
}
