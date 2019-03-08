<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    // protected $with = ['cat'];

    protected $fillable = [
        'user_id', 'category_id', 'title', 'price',
    ];

    protected $with =['user', 'adDescr', 'adPic'];

    protected $appends = ['selfOwned'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function adDescr()
    {
    	return $this->hasMany('App\AdDesc');
    }

    public function adPic()
    {
    	return $this->hasMany('App\AdPic');
    }

    public function getselfOwnedAttribute()
    {
    	if(auth()->user()){
           return $this->user_id == auth()->user()->id; 
       }
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

}
