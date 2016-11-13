<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Kind;
use App\Artist;
use App\Album;
use App\Song;
use Excel;

class ExcelController extends Controller
{
	public function ExcelRequest(Request $r){
		if ($r->isMethod('GET')) {
			return view('admin.excel',self::MakeKindsArray());
		}
		$exceldata=Excel::load($r->file('fileup'))->get();

		// Data keys filter
		foreach ($exceldata->toArray() as $data) {
			if (!in_array("name", array_keys($data))||
				!in_array("source", array_keys($data))||
				!in_array("album", array_keys($data))||
				!in_array("artist", array_keys($data))||
				!in_array("kind", array_keys($data))){
				return redirect('/excel')->with('fileError',
        		'Data error!');
			}
		}

		$msgs=[];
		$notexist=[];
		$b=false;
		foreach ($exceldata as $key => $song) {
			$kindcheck=Kind::where('name',
			$song->kind)->count();
			if ($kindcheck>0) {
				$artistcheck=Artist::where('name',
				$song->artist)->count();
				if ($artistcheck>0) {
					$idkind=Kind::where('name',$song->kind)
					->get()->first()->id;
					$idartist=Artist::where('name',$song->artist)
					->get()->first()->id;
					$albumcheck=Album::where('name',$song->album)
					->where('kind_id',$idkind)
					->where('artist_id',$idartist)
					->count();
					if ($albumcheck>0) {
						$idalbum=Album::where('name',$song->album)
						->where('kind_id',$idkind)
						->where('artist_id',$idartist)
						->get()->first()->id;
						$songcheck=Song::where('name',
						$song->name)->where('album_id',$idalbum)->count();
						if($songcheck==0) {
							$nameS=$song->name;
							$nameS=strtolower($nameS);
							$nameS=ucfirst($nameS);
							$newsong=new Song;
							$newsong->name=$nameS;
							$newsong->source=$song->source;
							$newsong->album_id=$idalbum;
							$newsong->sourceup=false;
							$newsong->save();
						}else{
							$msgs[]="A song named ".
							$song->name." is already registered in "
							.$song->album;
							$b=true;
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
			$msgs[]="All songs were uploaded with no problem";
		}
		return redirect('/excel')->with('msgs',$msgs);
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
