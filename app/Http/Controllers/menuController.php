<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class menuController extends Controller
{
       //this controller is not used yet 

    public function index(){
      $owner=User::where(['role'=>'2'])->get();
      $admin=User::where(['role'=>'1',session('user_id')==1])->get();
      $agent=User::where(['role'=>'3'])->get();


       return view('inc.header',compact(['owner','admin','agent']));
    }

}
