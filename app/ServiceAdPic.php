<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceAdPic extends Model
{
	protected $fillable = [
        'service_ad_id', 'picture',
    ];

    public function service()
    {
    	return $this->belongsTo('App\ServiceAd');
    }
}
