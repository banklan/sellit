<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerReview extends Model
{
    public $fillable = ['reviewer_id', 'seller_id', 'review'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
