<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\deal;
use App\Models\user;
use App\Models\Building;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\permission;
use App\Models\Clicks;
class emailTemplateController extends Controller
{
    public function index(){
        $permissions = permission::where('user_id', session('user_id'))->first();

        $templates = DB::table('email_templates')->orderBy('created_at','DESC')->get();

        $description = 'Email template page is visited.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Email Template','description'=>$description]);
        return view('emailTemplate',compact('templates', 'permissions'));
    }
    public function addTemplate(){
        $data = array(
            "template_date" => input::get('template_date'),
            "template_name" => input::get('template_name'),
            "subject" => input::get('subject'),
        );
        DB::table('email_templates')->insert($data);
        $description = 'Email template is created.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Email Template','description'=>$description]);
        return redirect('email-templates')->with('msg','Template Added Successfully!');
    }
    public function editTemplate($id){
        $record = DB::table('email_templates')->where("id",$id)->first();
        $edit = 'SET';

        $description = 'Email template page is edited.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Email Template','description'=>$description]);
        return view('emailTemplate',compact('record','edit'));
    }
    public function updateTemplate($id){
       $data = array(
            "template_date" => input::get('template_date'),
            "subject" => input::get('subject'),
            "template_name" => input::get('template_name'),
        );
        DB::table('email_templates')->where("id",$id)->update($data);
        $description = 'Email template page is updated.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Email Template','description'=>$description]);
        return redirect('email-templates')->with('msg','Template Updated Successfully!');
    }
    public function deleteTemplate($id){
        DB::table('email_templates')->where("id",$id)->delete();

        $description = 'Email template page is deleted.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Email Template','description'=>$description]);
        return redirect('email-templates')->with('msg','Template Deleted Successfully!');
    }
}