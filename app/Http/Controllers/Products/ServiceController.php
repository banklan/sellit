<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use Image;
use App\ServiceAd;
use App\ServiceAdDesc;
use App\ServiceAdPic;

class ServiceController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getUserServices', 'getServices', 'getServiceDetails', 'searchForService']]);
    }

    public function getServiceCategories()
    {
        $cats = ServiceCategory::all();

        return response()->json($cats, 200);
    }

   public function postServices(Request $request)
    {
        $me = Auth::id();
        $this->validate($request, [
            'title' => 'required|max:45',
            'cat' => 'required',
            'price' => 'required|numeric',
        ]); 

        $serv = new ServiceAd;
        $serv->user_id = $me;
        $serv->service_category_id = $request->cat;
        $serv->title = $request->title;
        $serv->price = $request->price * 100;
        $serv->save();

        if($serv){
            foreach($request->descr as $descr){
                $this->validate($request, [
                    'descr' => 'required|max:300'
                ]);

                $det = new ServiceAdDesc;
                $det->service_ad_id = $serv->id;
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
                    $file_loc = public_path('/images/service/flexes/'.$filename);
                    $thumbnail_loc = public_path('/images/service/thumbnails/'.$filename);

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
                    $ad_pic = new ServiceAdPic;
                    $ad_pic->service_ad_id = $serv->id;
                    $ad_pic->picture = $filename;

                    $ad_pic->save();
                }
            }
        }
        return response()->json($serv, 200);
    }

    public function getServices()
    {
    	$services = ServiceAd::latest()->get();

    	return response()->json($services, 200);
    }

    public function getServiceDetails($id)
    {
    	$ad = ServiceAd::findOrFail($id);

    	return response()->json($ad, 200); 
    }

    public function getUserServices($id)
    {
    	$ads = ServiceAd::where('user_id', $id)->latest()->get();

    	return response()->json($ads, 200);
    }

    public function getMyServices()
    {
        $me = Auth::id();

        $services = ServiceAd::where('user_id', $me)->latest()->get();

        return response()->json($services, 200);
    }

    public function searchForService(Request $request)
    {
        $this->validate($request,  [
            'service' => 'required|min:2|max:200'
        ]);

        $item = $request->service;

        $result = ServiceAd::where('title', 'LIKE', "%".$item."%")
                            ->orWhereHas('user', function($q) use ($item){
                                $q->where('f_name', 'LIKE', "%".$item."%") 
                                  ->orWhere('l_name', 'LIKE', "%".$item."%");;
                            })
                            ->orWhereHas('serviceDescr', function($q) use ($item){
                                $q->where('description', 'LIKE', "%".$item."%");
                            })
                            ->get();

        return response()->json($result, 200);
    }

}
