<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::post('/','HomeController@HomeRequest');
Route::get('/','HomeController@HomeRequest')
->middleware('authen');

//Admin routes
Route::match(['GET','POST'],'/excel','ExcelController@ExcelRequest')
->middleware('forexc');
Route::match(['GET','POST'],'/excel2','Excel2Controller@ExcelNewRequest')
->middleware('authen','isadmin');
Route::match(['GET','POST'],'/songs','SongsController@SongsRequest')
->middleware('authen','isadmin');
Route::get('/music',
'ArtistsAndKindsController@MusicRequest')
->middleware('authen','isadmin');
Route::post('/music/makekind',
'ArtistsAndKindsController@MakeKind')
->middleware('authen','isadmin');
Route::post('/music/makeartist',
'ArtistsAndKindsController@MakeArtist')
->middleware('authen','isadmin');
Route::post('/music/makealbum',
'ArtistsAndKindsController@MakeAlbum')
->middleware('authen','isadmin');
Route::post('/newimage','ArtistsAndKindsController@NewImage')
->middleware('authen','isadmin');
Route::match(['GET','POST'],'/stadistics',
	'ChartsController@ChartsRequest')
->middleware('authen','isadmin');
Route::post('/deletealbum',
'ArtistsAndKindsController@DeleteAlbum')
->middleware('authen','isadmin');

Route::get('/deleteak','DeleteAAController@DeleteRequest')
->middleware('authen','isadmin');
Route::post('/deleteartist','DeleteAAController@DeleteArtist')
->middleware('authen','isadmin');
Route::post('/deletekind','DeleteAAController@DeleteKind')
->middleware('authen','isadmin');


// Login route
Route::get('/login', function() {
    return view('authentication.login');
})->middleware('logmid');
Route::get('logout','HomeController@Logout');

Route::match(['GET','POST'],
'/registration','RegistrationController@RegistrationRequest')
->middleware('logmid');

Route::get('/music/{kind}/{artist}','SitesController@ArtistRequest')
->middleware('authen');

Route::get('/music/{kind}/{artist}/{album}','AlbumsController@AlbumsRequest')
->middleware('authen');

Route::post('/addfavorite','FavoritesController@AddFavorite')
->middleware('authen');

Route::post('/quitfavorite','FavoritesController@QuitFavorite')
->middleware('authen');

Route::get('/favorites','FavoritesController@FavoritesRequest')
->middleware('authen');

Route::get('activate/{t}/{id}','ActivateController@ActivateRequest');
