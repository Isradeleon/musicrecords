<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Kind;
use App\Image;
use App\Album;
use App\Favorite;
use App\Artist;
use Auth;

class AlbumsController extends Controller
{
    public function AlbumsRequest(Request $r, $kind, $artist, $album){
    	$thekind=Kind::where('name',$kind)->get()->count();
        if ($thekind==0) {
            return view('errors.notfound',self::MakeKindsArray());
        }
        $thekind=Kind::where('name',$kind)->get()->first();

        $theartist=Artist::where('name',$artist)->get()->count();
        if ($theartist==0) {
            return view('errors.notfound',self::MakeKindsArray());
        }
        $theartist=Artist::where('name',$artist)->get()->first();

        $thealbum=Album::where('artist_id',$theartist->id)
        ->where('kind_id',$thekind->id)
        ->where('name',$album)
        ->get()->count();
        if ($thealbum==0) {
        	return view('errors.notfound',self::MakeKindsArray());
        }
        $thealbum=Album::where('artist_id',$theartist->id)
        ->where('kind_id',$thekind->id)
        ->where('name',$album)
        ->get()->first();

        return view('sites.album',self::MakeKindsArray())
        ->with('album',$thealbum)
        ->with('favorites',self::MakeFavoritesArray());
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

    private function MakeFavoritesArray(){
    	$favorites=[];
    	foreach (Favorite::where('user_id',Auth::user()->id)->get() as $key => $favorite) {
    		$favorites[]=$favorite->song_id;
    	}
    	return $favorites;
    }
}
