<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Kind;
use App\Album;
use App\Artist;
use Auth;

class HomeController extends Controller
{
    public function HomeRequest(Request $r){

    	if ($r->isMethod('GET')) {
    		return view('home', self::MakeKindsArray());
    	}
    	$rules=[
    		"email"=>"required|email|max:100",
    		"password"=>"required|max:120"
    	];
    	$result=Validator::make($r->all(),$rules);
    	if ($result->fails()) {
    		return redirect('/login')
    		->with('errors',$result->messages()->all())
			->withInput($r->except('password'));
    	}
    	$checkemail=User::select('email')
		->where('email','=',$r->input('email'))
		->count();
		if($checkemail==0){
			return redirect('/login')
			->with('errors',['message'=>"You're not registered yet!"])
			->withInput($r->except('password'));
		}
		$checkactive=User::select('active')
		->where('email','=',$r->input('email'))->get()->first()->active;
		if (!$checkactive) {
			return redirect('/login')
			->with('errors',
			['message'=>"Please activate your account!"])
			->withInput($r->except('password'));
		}
		$userData=[
			'email'=>$r->input('email'),
			'password'=>$r->input('password') ];
		if (Auth::attempt($userData)) {
			return redirect('/');;
		}
		return redirect('/login')
		->with('errors',
		['message'=>"Wrong username or password!"])
		->withInput($r->except('password'));
    }

    public function Logout(Request $r){
    	Auth::logout();
    	return redirect('/login');
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