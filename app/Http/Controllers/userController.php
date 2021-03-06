<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Models\user;
use App\Models\role;
use App\Models\permission;
use App\Models\Supervision;
use DB;
class userController extends Controller
{
  // public function checkUsername(Request $request){
  //   $record=User::where("user_name",$request->input('user_name'))->get();
  //     if(count($record) > 0){
  //       echo "true";
  //     }
  // }
    public function owners(Request $request){
    $permissions = permission::where('user_id', session('user_id'))->first();

          $Role=role::all();
          $value=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
          return view('user',["Role"=>$Role,"value"=>$value,'heading'=>'owners', 'permissions'=>$permissions]);
    }
    public function agents(Request $request){
    $permissions = permission::where('user_id', session('user_id'))->first();

          $Role=role::all();
          $value=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='Agent'");
          return view('user',["Role"=>$Role,"value"=>$value,'heading'=>'agents', 'permissions'=>$permissions]);
    }
     public function admins(Request $request){
    $permissions = permission::where('user_id', session('user_id'))->first();

          $Role=role::all();
          $value=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='admin'");
          return view('user',["Role"=>$Role,"value"=>$value,'heading'=>'admins', 'permissions'=>$permissions]);
    }
    public function insertUser(Request $request){
      $route=$request->input('user');
      $record=User::where("user_name",$request->input('user_name'))->get();
      $email=User::where("email",$request->input('Email'))->get();
      if(count($record) > 0){
        return redirect("$route")->with("msg","<div class='alert alert-danger'>username already exist</div>");
      }else if(count($email) > 0){
        return redirect("$route")->with("msg","<div class='alert alert-danger'>Email already exist</div>");
      }else{
          $user_name=$request->input('user_name');
          $email=$request->input('Email');
      }
        $value=new User();
        $value->user_name=$user_name;
        $value->First_name=$request->input('First_name');
        $value->Last_name=$request->input('Last_Name');
        $value->Gender=$request->input('Gender');
        $value->birth_date=$request->input('birth_date');
        $value->role=$request->input('role');
        $value->Email=$email;
        $value->Phone=$request->input('Phone');
        $value->Password=md5($request->input('Password'));
        $value->save();
        $lastID = DB::getPdo()->lastInsertId();
        DB::table("permissions")->insert(['user_id'=>$lastID,"dashboardView"=>1]);
        return redirect("$route")->with("msg","<div class='alert alert-success'>Data Addedd Successfully</div>");
    }
    public function EditUser($id,Request $request){
      $record=user::find($id);
      $Role=role::all();
      $user=$request->input('user');
      return view('user',compact(['record','Role','user']));
    }
    public function updateUser($id,Request $request){
      $route=$request->input('user');
      if($request->input('username')!=$request->input('user_name') || $request->input('user_email')!=$request->input('Email') ){
        if($request->input('username')!=$request->input('user_name')){
          $record=User::where("user_name",$request->input('user_name'))->get();
          if(count($record) > 0){
            return redirect("".$route."/$id?action=edit&user=".$route)->with("msg","<div class='alert alert-danger'>username already exist</div>");
          }else{
             $user_name=$request->input('user_name');
          }
        }else{
              $user_name=$request->input('user_name');
          }
        if($request->input('user_email')!=$request->input('Email')){
          $email=User::where("email",$request->input('Email'))->get();
          if(count($email) > 0){
            return redirect("".$route."/$id?action=edit")->with("msg","<div class='alert alert-danger'>Email already exist</div>");
          }else{
            $email=$request->input('Email');
          }
        }
        else{
          $email=$request->input('Email');
        }
        
           //password changing
         $checkPassword=user::where('id',$id)->get();
         foreach ($checkPassword as $c) {
           $v=$c->Password;
         }
       
        if($v==$request->input('Password')){
           $pass=$request->input('Password');
         }else
           {
          $pass=md5($request->input('Password'));
           }
        //end of password changin, assing to variable 
        
         $edit=array(
          'user_name'=>$user_name,
           'First_name'=>$request->input('First_name'),
           'Last_name'=>$request->input('Last_Name'),
           'Gender'=>$request->input('Gender'),
           'birth_date'=>$request->input('birth_date'),
           'role'=>$request->input('role'),
           'Email'=>$email,
           'Phone'=>$request->input('Phone'),
           'Password'=>$pass,
           'status'=>$request->input('status'),
         );
         user::where('id',$id)->update($edit);
         return redirect(''.$route.'')->with("msg","<div class='alert alert-success'>Data Updated Successfully</div>");
      }else{
          
              //password changing
         $checkPassword=user::where('id',$id)->get();
         foreach ($checkPassword as $c) {
           $v=$c->Password;
         }
       
        if($v==$request->input('Password')){
           $pass=$request->input('Password');
         }else
           {
          $pass=md5($request->input('Password'));
           }
        //end of password changin, assing to variable 
      
        $edit=array(
          'user_name'=>$request->input('user_name'),
           'First_name'=>$request->input('First_name'),
           'Last_name'=>$request->input('Last_Name'),
           'Gender'=>$request->input('Gender'),
           'birth_date'=>$request->input('birth_date'),
           'role'=>$request->input('role'),
           'Email'=>$request->input('Email'),
           'Phone'=>$request->input('Phone'),
           'Password'=>$pass,
           'status'=>$request->input('status'),
         );
         user::where('id',$id)->update($edit);
         return redirect(''.$route.'')->with("msg","<div class='alert alert-success'>Data Updated Successfully</div>");
      }
  }
  public function changePassword(){
       if(isset($_POST['changePassword'])){
          $currentPassword=user::where(["id"=>session('user_id'),"Password"=>md5(input::get('currentPassword'))])->get();
          if(count($currentPassword) > 0){
            user::where("id",session('user_id'))->update(["Password"=>md5(input::get('newPassword'))]);
            session()->put('user_password',md5(input::get('newPassword')));
            return redirect("/")->with("success","Password Change Successfully!");
          }else{
            return redirect("/")->with("error","Current Password incorrect!");
          }
       }else{
          return back();
       }
    }
}
