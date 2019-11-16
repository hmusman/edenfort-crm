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
class emailTemplateController extends Controller
{
    public function index(){
        $templates = DB::table('email_templates')->orderBy('created_at','DESC')->get();
        return view('emailTemplate',compact('templates'));
    }
    public function addTemplate(){
        $data = array(
            "template_date" => input::get('template_date'),
            "template_name" => input::get('template_name'),
            "subject" => input::get('subject'),
        );
        DB::table('email_templates')->insert($data);
        return redirect('email-templates')->with('msg','<div class="alert alert-success">Template Added Successfully!</div>');
    }
    public function editTemplate($id){
        $record = DB::table('email_templates')->where("id",$id)->first();
        $edit = 'SET';
        return view('emailTemplate',compact('record','edit'));
    }
    public function updateTemplate($id){
       $data = array(
            "template_date" => input::get('template_date'),
            "subject" => input::get('subject'),
            "template_name" => input::get('template_name'),
        );
        DB::table('email_templates')->where("id",$id)->update($data);
        return redirect('email-templates')->with('msg','<div class="alert alert-success">Template Updated Successfully!</div>');
    }
    public function deleteTemplate($id){
        DB::table('email_templates')->where("id",$id)->delete();
        return redirect('email-templates')->with('msg','<div class="alert alert-success">Template Deleted Successfully!</div>');
    }
}