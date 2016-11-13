<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artist;
use App\Kind;
use App\Song;
use App\Image;
use App\Album;
use App\Favorite;
use Auth;

class SitesController extends Controller
{
    public function ArtistRequest(Request $r, $kind, $artist){
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

    	$thealbums=Album::where('artist_id',$theartist->id)
        ->where('kind_id',$thekind->id)
        ->get()->count();
    	if ($thealbums==0) {
    		return view('errors.notfound',self::MakeKindsArray());
    	}
        $thealbums=Album::where('artist_id',$theartist->id)
        ->where('kind_id',$thekind->id)->get();
        return view('sites.artist',self::MakeKindsArray())
        ->with('albums',$thealbums)
        ->with('artist',$theartist)
        ->with('thekind',$thekind);
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
