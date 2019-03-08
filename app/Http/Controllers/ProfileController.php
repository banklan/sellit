<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use App\City;
use App\User;
use App\Report;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getReports', 'getCities']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request, [
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required|numeric',
            'location' => 'required|max:50',
            'city' => 'required',
            'about' => 'required|max:500',
        ]); 

        $profile = User::findOrFail(Auth::id());

        $profile->update([
        	$profile->f_name = $request->f_name,
        	$profile->l_name = $request->l_name,
        	$profile->phone_no = $request->phone,
        	$profile->location = $request->location,
        	$profile->city_id = $request->city,
        	$profile->about_me = $request->about
        ]);

         return response()->json($profile, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCities()
    {
    	$cities = City::orderBy('name', 'ASC')->get();

    	return response()->json($cities, 200);
    }

    public function updateProfPix(Request $request)
    {
        $user = Auth::user();
        //dd($request->all());
        $pic = $request->picture;
        $OriginalName = $pic->getClientOriginalName();
        $exp_name = explode('.', $OriginalName); 
        $ext = $pic->getClientOriginalExtension();
        $rand = mt_rand(10000, 999999);

        $filename = $user->f_name.$rand.".".$ext;

                  //store in public folder
        $file_loc = public_path('images/profile_pix/'.$filename);

                //store normal images
        if(in_array($ext, ['jpeg', 'jpg', 'png', 'gif'])){
            
            // remove/unlink old one fom server
            if($user->prof_pix !== null){
                $old = $user->prof_pix;
                $oldpix = public_path('images/profile_pix/'.$old);
                if(file_exists($oldpix)){
                    unlink($oldpix);
                }
            }

            //replace with new picture
            $upload = Image::make($pic)->resize(400, 320, function($constraint){
                $constraint->aspectRatio();
            });

            $upload->sharpen(6)->save($file_loc);
        }

        //check if picture exist and remove old one 
        if($user->prof_pix){
            $old_pix = $user->prof_pix;
        }

        $user->update([
            $user->prof_pix = $filename
        ]);

        return response()->json($filename, 201);
    }

    public function getMyFlags()
    {
        $me = Auth::id();

        $flags = Report::where('reporter_id', $me)->latest()->get();

        return response()->json($flags, 201);
    }
}
