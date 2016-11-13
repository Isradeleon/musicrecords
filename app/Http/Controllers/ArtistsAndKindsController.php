<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Kind;
use App\Image;
use App\Album;
use App\Artist;
use Validator;
use Storage;

class ArtistsAndKindsController extends Controller
{
    public function MusicRequest(Request $r){
    	return view('admin.artistsandkinds',self::MakeKindsArray())
    	->with('kindscount',Kind::get()->count())
    	->with('artistscount',Artist::get()->count())
    	->with('artists',Artist::get());
    }

    public function NewImage(Request $r){
        if (!$r->hasFile('image')) {
            return back()
            ->with('msg','You must select the new image!');
        }
        $kind=Kind::where('id',$r->kind)->get()->first();
        $artist=Artist::where('id',$r->artist)->get()->first();
        $path='/'.'files/'.$kind->name.'/'
        .$artist->name.'/'.$r->albumname.'/'.'images'.'/';
        if (!Storage::disk('publicpath')->exists($path)) {
            Storage::disk('publicpath')->makeDirectory($path);
        }
        $img=new Image;
        $img->album_id=$r->album;
        $img->sourceup=false;
        $img->save();
        $name='img'.$img->id.'.jpg';
        Storage::disk('publicpath')
        ->putFileAs($path,$r->file('image'),$name);
        $img->source=$path.$name;
        $img->sourceup=true;
        $img->save();
        return back()
        ->with('msg','Image uploaded!');
    }

    public function MakeKind(Request $r){
    	$rules=['newkind'=>'required|max:30'];
    	$result=Validator::make($r->all(),$rules);
    	if ($result->fails()) {
    		return redirect('/music')
    		->with('msgs',$result->messages()->all());
    	}
    	$kindcheck=Kind::where('name',
		$r->input('newkind'))->count();
		if ($kindcheck>0) {
			return redirect('/music')
    		->with('msgs',["That music kind already exists!"]);
		}
        $nameS=$r->input('newkind');
        $nameS=strtolower($nameS);
        $nameS=ucfirst($nameS);
		$newkind=new Kind;
		$newkind->name=$nameS;
		$newkind->save();
		Storage::disk('publicpath')
		->makeDirectory('files/'.$newkind->name);
		return redirect('/music')
    	->with('msgs',["Music kind registered successfully! :)"]);
    }

    public function MakeArtist(Request $r){
    	$rules=['newartist'=>'required|max:30'];
    	$result=Validator::make($r->all(),$rules);
    	if ($result->fails()) {
    		return redirect('/music')
    		->with('msgs2',$result->messages()->all());
    	}
    	$checkartist=Artist::where('name',
		$r->input('newartist'))->count();
		if ($checkartist>0) {
			return redirect('/music')
    		->with('msgs2',["That artist already exists!"]);
		}
        $nameS=$r->input('newartist');
        $nameS=strtolower($nameS);
        $nameS=ucfirst($nameS);
		$newartist=new Artist;
		$newartist->name=$nameS;
		$newartist->save();
		return redirect('/music')
    	->with('msgs2',["New artist registered successfully! :D"]);
    }

    public function MakeAlbum(Request $r){
    	$rules=['newalbum'=>'required|max:30'];
    	$result=Validator::make($r->all(),$rules);
    	if ($result->fails()) {
    		return redirect('/music')
    		->with('msgs3',$result->messages()->all());
    	}
    	if (!$r->hasFile('image')) {
    		return redirect('/music')
    		->with('msgs3',['You must select one image for the album!']);
    	}
    	$checkalbum=Album::where('name',
		$r->input('newalbum'))->where('artist_id',$r->artist)->count();
		if ($checkalbum>0) {
			return redirect('/music')
    		->with('msg3',
    		["That artist already has an album called like that!"]);
		}
        $nameS=$r->input('newalbum');
        $nameS=strtolower($nameS);
        $nameS=ucfirst($nameS);
		$newalbum=new Album;
		$newalbum->name=$nameS;
		$newalbum->artist_id=$r->artist;
		$newalbum->kind_id=$r->kind;
		$newalbum->save();

		$kind=Kind::where('id',$r->kind)->get()->first();
		$artist=Artist::where('id',$r->artist)->get()->first();
		$path='/'.'files/'.$kind->name.'/'
		.$artist->name.'/'.$r->newalbum.'/'.'images'.'/';
		if (!Storage::disk('publicpath')->exists($path)) {
			Storage::disk('publicpath')->makeDirectory($path);
		}
        $img=new Image;
        $img->album_id=$newalbum->id;
        $img->sourceup=false;
        $img->save();
        $name='img'.$img->id.'.jpg';
        Storage::disk('publicpath')
        ->putFileAs($path,$r->file('image'),$name);
        $img->source=$path.$name;
        $img->sourceup=true;
        $img->save();
		return redirect('/music')
    		->with('msgs3',
    		["Album saved successfully! :')"]);
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


    public function DeleteAlbum(Request $r){
        $thealbum=Album::find($r->album);
        $thedirname='/files'.'/'.$thealbum->kind->name.'/'
        .$thealbum->artist->name.'/'.$thealbum->name;
        if (Storage::disk('publicpath')->exists($thedirname)) {
            Storage::disk('publicpath')->deleteDirectory($thedirname);
        }
        if ($thealbum->images->count()>0) {
            foreach ($thealbum->images as $image) {
                $image->delete();
            }
        }
        if ($thealbum->songs->count()>0) {
            foreach ($thealbum->songs as $song) {
                if ($song->favorites->count()>0) {
                    foreach ($song->favorites as $favorite) {
                        $favorite->delete();
                    }
                }
                $song->delete();
            }
        }
        $theartist=$thealbum->artist;
        $theartistpath='/files'.'/'.$thealbum->kind->name.'/'
        .$thealbum->artist->name;
        $thealbum->delete();
        if ($theartist->albums->count()==0) {
            Storage::disk('publicpath')->deleteDirectory($theartistpath);
        }
    }
}
