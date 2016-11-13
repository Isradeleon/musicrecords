<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Kind;
use App\Album;
use App\Artist;
use App\Song;
use App\Favorite;

class ChartsController extends Controller
{
    public function ChartsRequest(Request $r){
    	if ($r->isMethod('get')) {
    		return view('admin.stadistics',self::MakeKindsArray())
            ->with('kindswithf',self::MakeKindsForFavorites())
            ->with('favoritescount',Favorite::get()->count());
    	}
    	return self::MakeStadistics();
    }

    private function MakeKindsForFavorites(){
        $kinds=[];
        foreach (Favorite::get() as $key => $favorite) {
            if (!in_array($favorite->song->album->kind,$kinds)) {
                $kinds[]=$favorite->song->album->kind;
            }
    	}
        return $kinds;
    }

    private function MakeStadistics(){
        $kinds=self::MakeKindsForFavorites();
        $response=[];
        foreach ($kinds as $key => $kind) {
            $response[$key]["id"]=$kind->id;
            foreach (Favorite::get()->groupBy('song_id') as $k2 => $song) {
                $thesong=Song::where('id',$k2)->get()->first();
                if ($thesong->album->kind->id==$kind->id) {
                    $response[$key]["data"][]=count($song);
                    $response[$key]["categories"][]=
                    $thesong->name.' <br>Artist: '.$thesong->album->artist->name;
                }
            }
        }
        return $response;
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
}
