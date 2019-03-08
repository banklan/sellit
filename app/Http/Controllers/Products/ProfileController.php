<?php

namespace App\Http\Controllers\products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Ad;

class ProfileController extends Controller
{
    public function getProfile($id)
    {
    	$user = User::findOrFail($id);

    	return response()->json($user, 200);
    }

    public function getSellerAds($id)
    {
    	$ads = Ad::where('user_id', $id)->latest()->get();

    	return response()->json($ads, 200);
    }

}
