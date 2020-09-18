<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Supervision;
use App\Models\SupervisionCheaque;
use App\Models\SupervisionMaintenance;
use App\Models\SupervisionComplain;
use App\Models\property;
use App\Models\Building;
use App\Models\coldcallingModel;
use Illuminate\Support\Facades\Input;
use DB;
use App\Models\user;
use App\Models\userFiles;
use App\Models\Reminder;
use App\Models\role;
use App\Models\Clicks;
use Session;
use Excel;
use File;
use Mail;
class getAgentsReportsController extends Controller
{
    public function index(){
        $allAegnts=user::select(['id','user_name','First_name','Last_name','Email'])->where(['role'=>3,"status"=>1])->get();
        $content='';
        foreach($allAegnts as $agent){
            $upcoming=coldcallingModel::where(['access'=>'upcoming','user_id'=>$agent->id])->whereDate('updated_at', DB::raw('CURDATE()'))->count();
            $sale=coldcallingModel::where(['access'=>'For Sale','user_id'=>$agent->id])->whereDate('updated_at', DB::raw('CURDATE()'))->count();
            $rent=coldcallingModel::where(['access'=>'For Rent','user_id'=>$agent->id])->whereDate('updated_at', DB::raw('CURDATE()'))->count();
            $investor=coldcallingModel::where(['access'=>'investor','user_id'=>$agent->id])->whereDate('updated_at', DB::raw('CURDATE()'))->count();
            $offplan=coldcallingModel::where(['access'=>'offplan','user_id'=>$agent->id])->whereDate('updated_at', DB::raw('CURDATE()'))->count();
            $checkavailability=coldcallingModel::where(['access'=>'Check Availability','user_id'=>$agent->id])->whereDate('updated_at', DB::raw('CURDATE()'))->count();
            $notinterested=coldcallingModel::where(['access'=>'Not Interested','user_id'=>$agent->id])->whereDate('updated_at', DB::raw('CURDATE()'))->count();
            $interested=coldcallingModel::where(['access'=>'interested','user_id'=>$agent->id])->whereDate('updated_at', DB::raw('CURDATE()'))->count();
            $notanswering=coldcallingModel::where(['access'=>'Not Answering','user_id'=>$agent->id])->whereDate('updated_at', DB::raw('CURDATE()'))->count();
            $switchoff=coldcallingModel::where(['access'=>'Switch Off','user_id'=>$agent->id])->whereDate('updated_at', DB::raw('CURDATE()'))->count();
            $wrongnumber=coldcallingModel::where(['access'=>'Wrong Number','user_id'=>$agent->id])->whereDate('updated_at', DB::raw('CURDATE()'))->count();
            $content .='
                <div class="email-box" style="color:black !important;width:60%;margin:auto;">
                <style>a{color:white !important;}</style>
                    <div class="table-header" style="background-color:#1976D2;color:white;width:93%;padding: 1px 20px;">
                        <h4>Username : <b>'.$agent->user_name.'</b></h4>
                        <h4>Full Name : <b>'.$agent->First_name.' '.$agent->Last_name.'</b></h4>
                        <h4 style="color:white !important;">Email : <b style="color:black !important;background-color:white;border-radius:5px;padding:1px 8px;font-size:12px !important;;">'.$agent->Email.'</b></h4>
                    </div>
                    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;">
                        <tr>
                            <td style="text-align:center;">Upcoming</td>
                            <td style="text-align:center;">'.$upcoming.'</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">For Sale</td>
                            <td style="text-align:center;">'.$sale.'</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">For Rent</td>
                            <td style="text-align:center;">'.$rent.'</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Investor</td>
                            <td style="text-align:center;">'.$investor.'</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Off Plan</td>
                            <td style="text-align:center;">'.$offplan.'</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Check Availability</td>
                            <td style="text-align:center;">'.$checkavailability.'</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Not Interested</td>
                            <td style="text-align:center;">'.$notinterested.'</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Interested</td>
                            <td style="text-align:center;">'.$interested.'</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Not Ansewring</td>
                            <td style="text-align:center;">'.$notanswering.'</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Switch Off</td>
                            <td style="text-align:center;">'.$switchoff.'</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">Wrong Number</td>
                            <td style="text-align:center;">'.$wrongnumber.'</td>
                        </tr>
                    </table>
                </div><br><br><br>
            ';
        }
        $data = array('name'=>"EdenFort CRM");
            $contactName = 'EdenFort CRM';
            $contactEmail = 'crm@edenfort.ae';
            $contactMessage = $content;
             $data = array('name'=>$contactName, 'email'=>$contactEmail, 'data'=>$contactMessage);
            Mail::send('mail', $data, function($message) use ($contactEmail, $contactName)
            {   
                $message->from($contactEmail, $contactName);
                $message->to('wasif@edenfort.ae', 'EdenFort CRM')->subject('Daily Agents Report');
            });
        $description = 'Daily agents report is sent on mail.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Lead Mail','description'=>$description]);
         echo "HTML Email Sent. Check your inbox.";
    } 
}