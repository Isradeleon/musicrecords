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

class DeleteAAController extends Controller
{
	public function DeleteRequest(Request $r){
		return view('admin.delete',self::MakeKindsArray())
		->with('theartists',Artist::get())
		->with('thekinds',Kind::get());
	}

	public function DeleteKind(Request $r){
		$thekind=Kind::find($r->idkind);
		$path='/files'.'/'.$thekind->name;
		if (Storage::disk('publicpath')->exists($path)) {
			Storage::disk('publicpath')->deleteDirectory($path);
		}
		if ($thekind->albums->count()>0) {
			foreach ($thekind->albums as $album) {
				if ($album->songs->count()>0) {
					foreach ($album->songs as $song) {
						if ($song->favorites->count()>0) {
							foreach ($song->favorites as $favorite) {
								$favorite->delete();
							}
						}
						$song->delete();
					}
					$album->delete();
				}
				if ($album->images->count()>0) {
					foreach ($album->images as $image) {
						$image->delete();
					}
				}
			}
		}
		$thekind->delete();
		return redirect('/deleteak')
		->with('msgs',['Kind was deleted successfully!']);
	}

	public function DeleteArtist(Request $r){
		$theartist=Artist::find($r->idartist);
		if ($theartist->albums->count()>0) {
			$kinds=[];
			foreach ($theartist->albums as $album) {
				if (!in_array($album->kind,$kinds)) {
					$kinds[]=$album->kind;
				}
			}
			foreach ($kinds as $kind) {
				$thedirname='/files'.'/'.$kind->name.'/'
        		.$theartist->name;
        		if (Storage::disk('publicpath')->exists($thedirname)) {
		            Storage::disk('publicpath')
		            ->deleteDirectory($thedirname);
		        }
			}
			foreach ($theartist->albums as $album) {
		        if ($album->images->count()>0) {
		            foreach ($album->images as $image) {
		                $image->delete();
		            }
		        }
		        if ($album->songs->count()>0) {
		            foreach ($album->songs as $song) {
		                if ($song->favorites->count()>0) {
		                    foreach ($song->favorites as $favorite) {
		                        $favorite->delete();
		                    }
		                }
		                $song->delete();
		            }
		        }
		        $album->delete();
			}
		}
		$theartist->delete();
		return redirect('/deleteak')
		->with('msgs2',['Artist was deleted successfully!']);
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
