<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdPic extends Model
{
    protected $fillable = [
        'ad_id', 'picture',
    ];

    public function ad()
    {
    	return $this->belongsTo('App\Ad');
    }
}
