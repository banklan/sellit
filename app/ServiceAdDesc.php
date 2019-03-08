<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceAdDesc extends Model
{
    protected $fillable = [
        'service_ad_id', 'description',
    ];

    public function service()
    {
    	return $this->belongsTo('App\ServiceAd');
    }
}
