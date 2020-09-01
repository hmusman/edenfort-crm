<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
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
use Session;
use Excel;
use File;
use Mail;
class agentsReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agents:reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Agents Reports has been sent to Admin Via Email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         // Reminder::where('property_id',22729)->delete();
         // return;
       $allAegnts=user::select(['id','user_name','First_name','Last_name','Email'])->where('role',3)->get();
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
                <div class="email-box" style="margin-bottom:20px;">
                    <p>Username : <b>'.$agent->user_name.'</b></p>
                    <p>Full Name : <b>'.$agent->First_name.' '.$agent->Last_name.'</b></p>
                    <p>Email : <b>'.$agent->Email.'</b></p>
                    <table class="table table-bordered">
                        <tr>
                            <td>Upcoming</td>
                            <td>'.$upcoming.'</td>
                        </tr>
                        <tr>
                            <td>For Sale</td>
                            <td>'.$sale.'</td>
                        </tr>
                        <tr>
                            <td>For Rent</td>
                            <td>'.$rent.'</td>
                        </tr>
                        <tr>
                            <td>Investor</td>
                            <td>'.$investor.'</td>
                        </tr>
                        <tr>
                            <td>Off Plan</td>
                            <td>'.$offplan.'</td>
                        </tr>
                        <tr>
                            <td>Check Availability</td>
                            <td>'.$checkavailability.'</td>
                        </tr>
                        <tr>
                            <td>Not Interested</td>
                            <td>'.$notinterested.'</td>
                        </tr>
                        <tr>
                            <td>Interested</td>
                            <td>'.$interested.'</td>
                        </tr>
                        <tr>
                            <td>Not Ansewring</td>
                            <td>'.$notanswering.'</td>
                        </tr>
                        <tr>
                            <td>Switch Off</td>
                            <td>'.$switchoff.'</td>
                        </tr>
                        <tr>
                            <td>Wrong Number</td>
                            <td>'.$wrongnumber.'</td>
                        </tr>
                    </table>
                </div>
            ';
        }
        $data = array('name'=>"EdenFort CRM");
            $contactName = 'EdenFort CRM';
            $contactEmail = 'fat32aa@gmail.com';
            $contactMessage = $content;
             $data = array('name'=>$contactName, 'email'=>$contactEmail, 'data'=>$contactMessage);
            Mail::send('mail', $data, function($message) use ($contactEmail, $contactName)
            {   
                $message->from($contactEmail, $contactName);
                $message->to('fat32aa@gmail.com', 'AbdulRehman')->subject('Daily Agents Report');
            });
        //  echo "HTML Email Sent. Check your inbox.";
    }
}
