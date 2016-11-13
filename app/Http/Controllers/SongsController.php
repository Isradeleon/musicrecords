<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kind;
use App\Song;
use App\Artist;
use App\Album;
use Storage;

class SongsController extends Controller
{
	public function SongsRequest(Request $r){
		if ($r->isMethod('GET')) {
			return view('admin.songs',self::MakeKindsArray())
			->with('songs',Song::where('sourceup',false)->get())
            ->with('count',Song::where('sourceup',false)->get()->count());
		}
        if (!$r->hasFile('song')) {
            return view('admin.songs',self::MakeKindsArray())
            ->with('songs',Song::where('sourceup',false)->get())
            ->with('count',Song::where('sourceup',false)->get()->count())
            ->with('msgs',["You must select the empty files!"]);
        }
        $messages=[];
        $b=false;
        foreach ($r->file('song') as $key => $song) {
            $thesong=Song::find($key);
            $songpath=$thesong->source;
            if (!Storage::disk('publicpath')->exists(dirname($songpath))) {
                Storage::disk('publicpath')
                ->makeDirectory(dirname($songpath));
            }
            if (!Storage::disk('publicpath')->exists($songpath)) {
                Storage::disk('publicpath')
                ->putFileAs(dirname($songpath),$song,basename($songpath));
                $thesong->sourceup=true;
                $thesong->save();
            } else{
                $messages[]="A song called "
                .$thesong->name." already exist!";
                $b=true;
            }
        }
        if (!$b) {
            $messages[]="All files were uploaded successfully!";
        }
        return view('admin.songs',self::MakeKindsArray())
            ->with('songs',Song::where('sourceup',false)->get())
            ->with('count',Song::where('sourceup',false)->get()->count())
            ->with('msgs',$messages);
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
