<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdDesc extends Model
{
    protected $fillable = [
        'ad_id', 'description',
    ];

    public function ad()
    {
    	return $this->belongsTo('App\Ad');
    }
}
