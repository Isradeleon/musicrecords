<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Auth;
use Hash;
use Mail;

class RegistrationController extends Controller
{
	public function RegistrationRequest(Request $r){
		if ($r->isMethod('GET')) {
			return view('authentication.registration');
		}
		$rules = [
			"name"=>"required|max:20",
			"lastname"=>"required|max:20",
			"email"=>"required|email|max:100",
			"sex"=>"in:F,M",
			"password"=>"required|max:120",
			"password2"=>"same:password"
		];
		$result = Validator::make($r->all(),$rules);
		if ($result->fails()) {
			return redirect('/registration')
			->with('errors',$result->messages()->all())
			->withInput($r->except('password','password2'));
		}
		$checkemail=User::select('email')
		->where('email','=',$r->input('email'))
		->count();
		if($checkemail>0){
			return redirect('/registration')
			->with('errors',['message'=>'This email is already registered'])
			->withInput($r->except('password','password2'));
		}
		$newuser = new User;
		$newuser->name = $r->input('name');
		$newuser->lastname = $r->input('lastname');
		$newuser->email = $r->input('email');
		$newuser->sex = $r->input('sex');
		$newuser->password = Hash::make($r->input('password'));
		$newuser->remember_token = $r->input('_token');
		$newuser->active = false;
		$newuser->admin = false;
		$newuser->save();
		$maillink="http://musicrecords.local/activate/"
		.$newuser->remember_token."/".$newuser->id;

		Mail::send('emails.mailview', ["link"=> $maillink], 
		function ($m) use ($newuser) {
			$m->from('isramaillaravel@gmail.com', 'MusicRecords!');
			$m->to($newuser->email, "Destiny")
			->subject("Activation");
		});
		return redirect('/login')
		->with('emailreg',$newuser->email)
		->with('msg',["We've sent the activation email to your account!"]);
	}
}
