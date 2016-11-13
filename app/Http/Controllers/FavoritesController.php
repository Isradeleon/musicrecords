<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use App\Song;
use App\Kind;
use App\Artist;
use App\Album;
use Auth;

class FavoritesController extends Controller
{
	public function FavoritesRequest(Request $r){
		return view('sites.favorites',self::MakeKindsArray())
		->with('images',self::MakeImages());

		return view('sites.favorites',self::MakeKindsArray())
		->with('songs',self::MakeFavoriteSongs()["favsongs"])
		->with('favscount',self::MakeFavoriteSongs()["favscount"])
		->with('imgcount',self::MakeFavoriteSongs()["imgcount"])
		->with('images',self::MakeFavoriteSongs()["images"])
		->with('realfavs',self::MakeFavoriteSongs()["realfavs"]);
	}

	private function MakeImages(){
		$images=[];
		foreach (Auth::user()->favorites as $key => $favorite) {
			$img=$favorite->song->album->images->first();
			if (!in_array($img, $images)) {
				$images[]=$img;
			}
		}
		return $images;
	}

	public function MakeFavoriteSongs(){
		$favorites=Favorite::where('user',Auth::user()->id)->get();
		$favsongs=[];
		$imgs=[];
		$im=0;
		foreach ($favorites as $favorite) {
			$favsongs[]=Song::where('id',$favorite->song)->get()->first();
			$imgs[]=Song::select('imgsource')->where('id',$favorite->song)
			->where('imgup',true)->get()->first();
			$im+=Song::select('imgsource')->where('id',$favorite->song)
			->where('imgup',true)->get()->count();
		}
		$c=Favorite::where('user',Auth::user()->id)->get()->count();
		return [
		"realfavs"=>$favorites,
		"favsongs"=>$favsongs,
		"images"=>$imgs,
		"imgcount"=>$im,
		"favscount"=>$c
		];
	}

    private function MakeKindsArray(){
        $Array = [
            "kinds"=>Kind::get()
        ];
        foreach ($Array["kinds"] as $key => $kind) {
            $albums=Album::where('kind_id',$kind->id)
            ->get();
            $kind->numberOfAlbums=$albums->count();
            $artists=[];
            foreach ($albums as $key => $album) {
                if (!in_array($album->artist, $artists)) {
                	$artists[]=$album->artist;
                }
            }
            $kind->artists = $artists;
        }
        return $Array;
    }

    public function AddFavorite(Request $r){
    	$newfavorite = new Favorite;
    	$newfavorite->user_id=$r->user;
    	$newfavorite->song_id=$r->song;
    	$newfavorite->save();
    }

    public function QuitFavorite(Request $r){
    	Favorite::find($r->favorite)->delete();
    }
}
