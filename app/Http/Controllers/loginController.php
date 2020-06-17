<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\role;
use App\Models\Supervision;
use DB;
use Mail;
use Illuminate\Support\Facades\Input;
use App\Models\permission;
class loginController extends Controller
{
    public function CheckLogin(Request $request){
        if(isset($_POST['login'])){
            $user_data=array(
                'Email' =>$request->input('Email'),
                 'Password'=>md5($request->input('Password')),
            );
             $validate_user=DB::table('users')->select('Email','Password',"role","id","status","user_name","First_name")->where($user_data)->first();
             
              //set session for permissions
if(isset($validate_user->id)){
          $permissions=permission::where('user_id',$validate_user->id)->get();
       
          if(!$permissions->isEmpty()){
             
          foreach($permissions as $permission){
             
           session()->put("dashbordView",$permission->dashboardView);
             }
         }
             else{
                session()->put("dashbordView",'0');
             }
           }
             //end of set sessions for permission
             
             if($validate_user){
                if ($validate_user->status==0) {
                    return redirect('/')->with('error','<div class="alert alert-danger">Your Account is Deactivated</div>');
                }
                $role=role::where("Rule_id",$validate_user->role)->pluck('Rule_type');
                if(strtoupper($role[0])==strtoupper("admin")){
                    session()->put("role",$role[0]);
                    session()->put("user_id",$validate_user->id);
                    session()->put("user_name",$validate_user->user_name);
                    session()->put("email",$validate_user->Email);
                    // return redirect('supervision');
                    return redirect('dashboard');
                }else if(strtoupper($role[0])==strtoupper("owner")){
                    session()->put("role",$role[0]);
                    session()->put("user_id",$validate_user->id);
                    session()->put("user_name",$validate_user->user_name);
                    session()->put("email",$validate_user->Email);
                     return redirect('ownerdashboard');
                }else if(strtoupper($role[0])==strtoupper("agent")){
                    session()->put("role",$role[0]);
                    session()->put("user_id",$validate_user->id);
                    session()->put("user_name",$validate_user->user_name);
                    session()->put("email",$validate_user->Email);
                    session()->put("fname",$validate_user->First_name);
                    
                     return redirect('agentdashboard');
                 }else if(strtoupper($role[0])==strtoupper("SuperDuperAdmin")){
                    session()->put("role",$role[0]);
                    session()->put("user_id",$validate_user->id);
                    session()->put("user_name",$validate_user->user_name);
                    session()->put("email",$validate_user->Email);
                    session()->put("fname",$validate_user->First_name);
                    // dd($role[0]);
                     return redirect('dashboard');
                 }else if(strtoupper($role[0])==strtoupper("superAgent")){
                    session()->put("role",$role[0]);
                    session()->put("user_id",$validate_user->id);
                    session()->put("user_name",$validate_user->user_name);
                    session()->put("email",$validate_user->Email);
                    session()->put("fname",$validate_user->First_name);
                    
                     return redirect('dashboard');
                 }else{
                     return redirect('/')->with('error','<div class="alert alert-danger">invalid Email or Password</div>');
                 }
             }else{
                 return redirect('/')->with('error','<div class="alert alert-danger">invalid Email or Password</div>');
             }
         }
    }
    public function logout(){
        session()->forget(["role","user_name","email","user_id"]);
        return redirect("/");
    }
    public function resetPassword(){
        $user = DB::table("users")->where("email",input::get("email"))->first();
        if(!is_null($user)){
            $password = $user->user_name.rand(11111,99999);
            $md5password = md5($password);
            DB::table("users")->where("email",input::get("email"))->update(["Password"=>$md5password]);
            $data = array('name'=>"EdenFort CRM");
            $contactName = 'EdenFort CRM';
            $contactEmail = 'crm@edenfort.ae';
            $contactMessage = 'Your new Password is '.$password;
            $toName = $user->First_name.' '.$user->Last_name;
             $data = array('data'=>$contactMessage);
            Mail::send('mail', $data, function($message) use ($contactEmail, $contactName,$toName)
            {   
                $message->from($contactEmail, $contactName);
                $message->to(input::get("email"), $toName)->subject('Password Reset');
            });
             return back()->with("error",'<div class="alert alert-success">New Password has been sent to your Provided Email Address.</div>');
        }else{
            return back()->with("error",'<div class="alert alert-danger">Email does not exist!</div>');
        }
    }
}
