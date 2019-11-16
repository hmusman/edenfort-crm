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
use App\Models\lead;
use Session;
use Excel;
use File;
use Mail;
class getAgentLeadsReport extends Controller
{
    public function index(){
        $allAegnts=user::select(['id','user_name','First_name','Last_name','Email'])->where(['role'=>3,"status"=>1])->get();
        $content='';
        foreach($allAegnts as $agent){
            $counter = 1;
            $leads=lead::where(['lead_user'=>$agent->user_name])->whereDate('updated_at', DB::raw('CURDATE()'))->get();
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
                            <th style="text-align:center;">sno</td>
                            <th style="text-align:center;">Client</td>
                            <th style="text-align:center;">Contact</td>
                            <th style="text-align:center;">Date</td>
                            <th style="text-align:center;">Follow Up</td>
                        </tr>';
                if(count($leads) > 0){        
                    foreach($leads as $lead){
                        $followUpLogs =""; 
                        foreach($lead->getLeadRecord as $leadd){
                            $followUpLogs .= date('d-m-Y',strtotime($leadd->created_at)).'<br>'.$leadd->description;
                        }
                               $content .='
                               <tr>
                                    <td style="text-align:center;">'.$counter++.'</td>
                                    <td style="text-align:center;">'.$lead->client_name.'</td>
                                    <td style="text-align:center;">'.$lead->contact_no.'</td>
                                    <td style="text-align:center;">'.$lead->submission_date.'</td>
                                    <td style="text-align:center;">'.$followUpLogs.'</td>
                                </tr>
                    ';
                    }
                    $content .='</table>
                        </div><br><br><br>';
                }else{
                   $content .='
                               <tr>
                                    <td style="text-align:center;" colspan="6">No Date Found!</td>
                              </tr></table>
                        </div><br><br><br>'; 
                }
        }
        $data = array('name'=>"EdenFort CRM");
            $contactName = 'EdenFort CRM';
            $contactEmail = 'crm@edenfort.ae';
            $contactMessage = $content;
             $data = array('name'=>$contactName, 'email'=>$contactEmail, 'data'=>$contactMessage);
            Mail::send('mail', $data, function($message) use ($contactEmail, $contactName)
            {   
                $message->from($contactEmail, $contactName);
                $message->to('wasif@edenfort.ae', 'EdenFort CRM')->subject('Daily Agents Leads Report');
            });
         echo "HTML Email Sent. Check your inbox.";
    } 
}