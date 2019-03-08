<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WelcomeController@index');
Route::get('/ad/{id}/{slug}', 'WelcomeController@index');
Route::get('/seller/{id}/{slug}', 'WelcomeController@index');
Route::get('/seller/{id}/{slug}/all_ads', 'WelcomeController@index');
Route::get('/create_ad', 'WelcomeController@index')->name('post_ad')->middleware('auth');
Route::get('/create_service_ad', 'WelcomeController@index')->middleware('auth');
Route::get('/choose_ad_type', 'WelcomeController@index')->name('choose_ad_type')->middleware('auth');
Route::get('/chat/{id}', 'WelcomeController@index')->middleware('auth');
Route::get('/services', 'WelcomeController@index')->name('services');
Route::get('/service_ad/{id}/{slug}', 'WelcomeController@index');
// Route::get('/profile/{id}/{slug}', 'WelcomeController@index')->name('profile')->middleware('auth');
Route::get('/profile', 'WelcomeController@index')->name('profile')->middleware('auth');
Route::get('/my_ads', 'WelcomeController@index')->name('my_ads')->middleware('auth');
Route::get('/my_flags', 'WelcomeController@index')->name('my_flags')->middleware('auth');
Route::get('/search_result', 'WelcomeController@index');
Route::get('/service_search_result', 'WelcomeController@index');
Route::get('/category/{id}/{category}', 'WelcomeController@index');
Route::get('/testing', 'WelcomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'HomeController@test');
Route::get('/getcategories', 'Products\ProductController@getCategories');
Route::get('/getcategory/{id}', 'Products\ProductController@getCategory');

Route::get('/getservicecategories', 'Products\ServiceController@getServiceCategories');
Route::post('/post_services', 'Products\ServiceController@postServices');

Route::get('/getprofile/{id}', 'Products\ProfileController@getProfile');
Route::get('/getuserads/{id}', 'Products\ProfileController@getSellerAds');

Route::get('/getuser/{id}', 'ChatController@getUser');
Route::post('/postmsg/{id}', 'ChatController@postMsg');
Route::get('/fetchchats/{id}', 'ChatController@fetchChat');


Route::post('/post_ad', 'Products\ProductController@postAd')->middleware('auth');
Route::get('/getads', 'Products\ProductController@getAds');
Route::get('/getaddetails/{id}', 'Products\ProductController@getAdDetails');
Route::get('/getmyads', 'Products\ProductController@getMyAds')->middleware('auth');
Route::post('/product_search', 'Products\ProductController@searchForProduct');
// Route::post('/search_prod', 'Products\ProductController@SearchProd');

Route::post('/api/postmsg/{receiver}', 'ChatNewController@sendChat')->middleware('auth');
Route::get('/api/getservices', 'products\ServiceController@getServices');
Route::get('/api/getservicedetails/{id}', 'products\ServiceController@getServiceDetails');
Route::get('/api/getuserservices/{id}', 'products\ServiceController@getUserServices');
Route::get('/api/getmyownservices', 'products\ServiceController@getMyServices')->middleware('auth');
Route::post('/service_search', 'Products\ServiceController@searchForService');


Route::patch('/updateprofile/{id}', 'ProfileController@update')->middleware('auth');
Route::get('/getcities', 'ProfileController@getCities');
Route::post('/updateprofilepix', 'ProfileController@updateProfPix')->middleware('auth');
Route::get('/api/getmyflags', 'ProfileController@getMyFlags')->middleware('auth');

Route::post('/reportseller/{id}', 'SellerReportController@reportSeller')->middleware('auth');
Route::get('/getreports/{id}', 'SellerReportController@getReports');
Route::delete('/delreport/{id}', 'SellerReportController@destroy');
Route::post('/update_report/{id}', 'SellerReportController@update');




