<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Report extends Model
{
    protected $fillable = ['reporter_id', 'seller_id', 'report'];

    protected $with = ['reporter', 'reportee'];

    protected $appends = ['reported', 'selfOwned'];

    public function reporter()
    {
        return $this->belongsTo('App\User', 'reporter_id');
    }

    public function reportee()
    {
        return $this->belongsTo('App\User', 'reportee_id');
    }

    public function getreportedAttribute()
    {
        return $this->created_at->format('dS M Y, H:ia');
    }

    public function getselfOwnedAttribute()
    {
        if(Auth::check()){
          return $this->reporter_id === auth()->user()->id;
        }
        return false;
    }
}
