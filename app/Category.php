<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = ['category'];

    protected $appends = ['slug'];

    protected $with = ['ad'];

    public function getslugAttribute()
    {
        $slug = str_slug($this->category);

        return $slug;
    }

    public function ad()
    {
    	return $this->hasMany('App\Ad');
    }
}
