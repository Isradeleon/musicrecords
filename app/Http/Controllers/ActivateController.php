<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ActivateController extends Controller
{
    public function ActivateRequest(Request $r,$t,$id){
    	$checkuser=User::where('id',$id)->get()->count();
    	if ($checkuser==0) {
    		return redirect('/');
    	}
    	$checkstate=User::select('active')
    	->where('id',$id)->get()->first()->active;
    	if ($checkstate) {
    		return redirect('/');
    	}
    	$checktoken=User::select('remember_token')
    	->where('id',$id)->get()->count();
    	if ($checktoken==0) {
    		return redirect('/');
    	}
    	$e=User::select('email')->where('id',$id)->get()->first()->email;
    	$updateduser=User::where('id',$id)->get()->first();
    	$updateduser->active=true;
    	$updateduser->save();
    	return redirect('/login')->with('emailreg',$e)->with('msg',["Your account has been activated! please login!"]);
    }
}
