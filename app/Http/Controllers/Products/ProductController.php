<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Image;
use App\Category;
use App\Ad;
use App\AdDesc;
use App\AdPic;


class ProductController extends Controller
{
    
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function getCategories()
    {
    	$cats = Category::all();

    	return response()->json($cats, 200);
    }
    
    public function postAd(Request $request)
    {
        $me = Auth::id();
        $this->validate($request, [
            'title' => 'required|max:45',
            'cat' => 'required',
            'price' => 'required|numeric',
        ]); 

        $ad = new Ad;
        $ad->user_id = $me;
        $ad->category_id = $request->cat;
        $ad->title = $request->title;
        $ad->price = $request->price * 100;
        $ad->save();

        if($ad){
            foreach($request->descr as $descr){
                $this->validate($request, [
                    'descr' => 'required|max:300'
                ]);

                $det = new AdDesc;
                $det->ad_id = $ad->id;
                $det->description = $descr;
                $det->save();
            }

            if($request->pics){
                foreach ($request->pics as $pic) {
                    $this->validate($request, [
                        'pic' => 'mime:jpeg,jpg,png,gif|size:5000'
                    ]);

                    $OriginalName = $pic->getClientOriginalName();
                    $exp_name = explode('.', $OriginalName); 
                    $ext = $pic->getClientOriginalExtension();
                    $rand = mt_rand(010000, 999999);

                    if(strlen($exp_name[0]) > 3){
                        $subname = substr($exp_name[0], 0, 3);
                    }else{
                        $subname = $exp_name[0];
                    }

                    $filename = $subname.$rand.".".$ext;

                      //store in public folder
                    $file_loc = public_path('/images/products/flexes/'.$filename);
                    $thumbnail_loc = public_path('/images/products/thumbnails/'.$filename);

                     //store normal images
                    if(in_array($ext, ['jpeg', 'jpg', 'png', 'gif'])){
                        $upload = Image::make($pic)->resize(450, 350, function($constraint){
                            $constraint->aspectRatio();
                        });

                        $upload->sharpen(7)->save($file_loc);

                        //store thumbnail
                        Image::make($pic)->resize(180, 130)->save($thumbnail_loc);
                    }
                
                    //send to db
                    $ad_pic = new AdPic;
                    $ad_pic->ad_id = $ad->id;
                    $ad_pic->picture = $filename;

                    $ad_pic->save();
                }
            }
        }
        return response()->json($ad, 200);
    }

    public function getAds()
    {
        $ads = Ad::latest()->get();

        return response()->json($ads, 200);
    }

    public function getAdDetails($id)
    {
        $ad = Ad::findOrFail($id);

        return response()->json($ad, 200);
    }

    public function getMyAds()
    {
        $me = Auth::id();

        $myAds = Ad::where('user_id', $me)->latest()->get();

        return response()->json($myAds, 200);
    }

    public function searchForProduct(Request $request)
    {
        $this->validate($request,  [
            'prod' => 'required|min:2|max:200'
        ]);

        $item = $request->prod;
        $loc = $request->loc;

        // if location was chosen
        if($loc !== ''){
            $result = Ad::where('title', 'LIKE', "%".$item."%")->whereHas('user', function($q) use ($loc){
            $q->where('city_id', 'LIKE', "%".$loc."%");
            })->get();

            return response()->json($result, 200);
        }else{
            $result = Ad::where('title', 'LIKE', "%".$item."%")->get();

            return response()->json($result, 200);
        }
        
    }

    public function getCategory($id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category, 200);
    }

    
}
