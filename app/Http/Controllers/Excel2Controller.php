<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Kind;
use App\Artist;
use App\Album;
use App\Song;
use Excel;
use Storage;

class Excel2Controller extends Controller
{
    public function ExcelNewRequest(Request $r){
    	if ($r->isMethod('GET')) {
			return view('admin.excel2',self::MakeKindsArray());
		}
		if (!$r->hasFile('fileup')) {
			return redirect('/excel2')
			->with('fileError','You must select the file!');
		}
		$exceldata=Excel::load($r->file('fileup'))->get();

		// Data keys filter
		foreach ($exceldata->toArray() as $data) {
			if (!in_array("name", array_keys($data))||
				!in_array("album", array_keys($data))||
				!in_array("artist", array_keys($data))||
				!in_array("kind", array_keys($data))){
				return redirect('/excel2')->with('fileError',
        		'Data error with the columns 
        		or the number of sheets!');
			}
		}

		$msgs=[];
		$notexist=[];
		$b=false;
		$c=false;
		//song = each row in $exceldata
		foreach ($exceldata as $key => $song) {
			$kindcheck=Kind::where('name',
			$song->kind)->count();
			if ($kindcheck>0) {
				$artistcheck=Artist::where('name',
				$song->artist)->count();
				if ($artistcheck>0) {
					$thekind=Kind::where('name',$song->kind)
					->get()->first();
					$theartist=Artist::where('name',$song->artist)
					->get()->first();
					$albumcheck=Album::where('name',$song->album)
					->where('kind_id',$thekind->id)
					->where('artist_id',$theartist->id)
					->count();
					if ($albumcheck>0) {
						$thealbum=Album::where('name',$song->album)
						->where('kind_id',$thekind->id)
						->where('artist_id',$theartist->id)
						->get()->first();
						$songcheck=Song::where('name',
						$song->name)->where('album_id',$thealbum->id)
						->count();
						if($songcheck==0) {
							$nameS=$song->name;
							$nameS=strtolower($nameS);
							$nameS=ucfirst($nameS);
							$newsong=new Song;
							$newsong->name=$nameS;
							$path='/'.'files/'.$thekind->name.'/'
        					.$theartist->name.'/'.$thealbum->name.'/'
        					.'songs'.'/';
        					if (!Storage::disk('publicpath')
        						->exists($path)) {
            						Storage::disk('publicpath')
            						->makeDirectory($path);
        					}
        					$source=$path.$newsong->name.'.mp3';
							$newsong->source=$source;
							$newsong->album_id=$thealbum->id;
							$newsong->sourceup=false;
							$newsong->save();
							$c=true;
						}else{
							if (!in_array('songsno',$notexist)) {
								$msgs[]="There're songs that already exist 
								in its corresponding album!";
								$notexist[]='songsno';
								$b=true;
							}
						}
					}else{
						if (!in_array(
						$song->album.$song->kind.$song->artist, 
						$notexist)) {
							$msgs[]="There isn't an album called ".
							$song->album." from the kind ".$song->kind
							.", from the artist ".$song->artist."!";
							$notexist[]=
							$song->album.$song->kind.$song->artist;
							$b=true;
						}
					}
				}else{
					if(!in_array($song->artist,$notexist)){
						$msgs[]="Artist: ".
						$song->artist." is not registered";
						$notexist[]=$song->artist;
						$b=true;
					}
				}
			}else{
				if(!in_array($song->kind,$notexist)){
					$msgs[]="Kind of Music: ".
					$song->kind." is not registered";
					$notexist[]=$song->kind;
					$b=true;
				}
			}
		}
		if (!$b) {
			$msgs[]="All songs were uploaded with no problem :D";
		}
		if (!$c) {
			$msgs[]="We couldn't register any song!";
		}
		return redirect('/excel2')->with('msgs',$msgs);
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
