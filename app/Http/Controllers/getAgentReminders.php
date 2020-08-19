<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Supervision;
use App\Models\SupervisionCheaque;
use App\Models\SupervisionMaintenance;
use App\Models\SupervisionComplain;
use App\Models\property;
use App\Models\lead;
use App\Models\Building;
use App\Models\coldcallingModel;
use Illuminate\Support\Facades\Input;
use DB;
use App\Models\user;
use App\Models\deal;
use App\Models\userFiles;
use App\Models\Reminder;
use App\Models\role;
use Session;
use Excel;
use File;
use Mail;
class getAgentReminders extends Controller
{
     public function index(){
        $mytime = \Carbon\Carbon::now();
        $date=$mytime->format('Y-m-d G:i:s');
        $result=Reminder::where('date_time','<=',$date)->where("email_notification",null)->get();
        $message='';
        foreach($result as $key=>$value){
            if(@$value->user->Email){
                $agentEmail = $value->user->Email;
                $data = coldcallingModel::where('id',$value->property_id)->first();
                if(isset($data) && !is_null($data->email)){
                    $message ='<h3>Reminder Alert</h3><a href="'.url("get-reminder-record").'?property_id='.$value->property_id.'&ref='.$value->reminder_of.'&active='.$value->add_by.'">See Reminder</a>';
                    $contactMessage = $message;
                    $data = array('data'=>$contactMessage);
                    // Mail::send('reminder-email', $data, function($message) use ($agentEmail)
                    // {   
                    //     $message->from('adnan@youcanbuyindubai.com', 'EdenFort CRM');
                    //     $message->to($agentEmail, 'EdenFort CRM')->subject('Reminder Alert');
                    // });
                }
               // Reminder::where("id",$value->id)->update(["email_notification"=>1]);     
            }
            
        }
    }
   
}