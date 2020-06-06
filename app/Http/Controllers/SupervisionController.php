<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Supervision;
use App\Models\SupervisionCheaque;
use App\Models\SupervisionMaintenance;
use App\Models\SupervisionComplain;
use App\Models\property;
use App\Models\Building;
use App\Models\lead;
use App\Models\coldcallingModel;
use Illuminate\Support\Facades\Input;
use DB;
use App\Models\user;
use App\Models\userFiles;
use App\Models\Reminder;
use App\Models\role;
use App\Models\deal;
use Session;
use Excel;
use File;
use DateTime;
use Carbon\Carbon;
use App\Models\permission;
class SupervisionController extends Controller
{
        public function dashboard(){
                $contracts=Supervision::count();
                $properties=property::count();
                $coldCallings=coldCallingModel::count();
                $coldCallingsSuperAgent=coldCallingModel::where('user_id',session('user_id'))->count();        
                $owners=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                $owners=count($owners);
                $agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
                $agents=count($agents);
                $admins=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='admin'");
                $admins=count($admins);
                $users = user::all();
                $users = count($users);
                $rent=property::where(['access'=>'For Rent','property_status'=>'edenfort_property'])->count();
                $upcoming=property::where(['access'=>'UPCOMING','property_status'=>'edenfort_property'])->get();
                $sale=property::where(['access'=>'For Sale','property_status'=>'edenfort_property'])->count();
                $buildings=Building::count();
               
                $leads=lead::count();
   
   
          //testing
                 $todayDate = Carbon::today()->subDays(30);
                // dd($todayDate);
      $currentMonthLeads = lead::where('created_at', '>=', date($todayDate))->count();
               // dd($currentMonthLeads);
       //start of agent report

        $allusers = user::where('role',3)->where("status",1)->get();     
   //end tesing
     //Graph for countng updated_at columns according to date, property status
             $cDate=Date('Y-m-d');
           $first = date('Y-m-d', strtotime($cDate. ' -6 days'));
         $firstDay=property::whereDate('updated_at', '=', $first)->count();
     //Graph secound line for cold-calling property status;
       $firstCold=coldCallingModel::whereDate('updated_at', '=', $first)->count();
       
           //2nd day in graph
            $second = date('Y-m-d', strtotime($cDate. ' -5 days'));
         $secondDay=property::whereDate('updated_at', '=', $second)->count();

    
     //Graph secound line for cold-calling second day;
       $secondCold=coldCallingModel::whereDate('updated_at', '=', $second)->count();
     // //3rd day in graph
            $third = date('Y-m-d', strtotime($cDate. ' -4 days'));
         $thirdDay=property::whereDate('updated_at', '=', $third)->count();
    //Graph secound line cold-calling
       $thirdCold=coldCallingModel::whereDate('updated_at', '=', $third)->count();
    
            $four = date('Y-m-d', strtotime($cDate. ' -3 days'));
         $fourDay=property::whereDate('updated_at', '=', $four)->count();    //Graph secound line cold-calling
       $fourCold=coldCallingModel::whereDate('updated_at', '=', $four)->count();
    
              $five = date('Y-m-d', strtotime($cDate. ' -2 days'));
         $fiveDay=property::whereDate('updated_at', '=', $five)->count();
     //Graph secound line cold-calling
       $fiveCold=coldCallingModel::whereDate('updated_at', '=', $five)->count();      
    
               $six = date('Y-m-d', strtotime($cDate. ' -1 days'));
         $sixDay=property::whereDate('updated_at', '=', $six)->count();
     //Graph secound line cold-calling
       $sixCold=coldCallingModel::whereDate('updated_at', '=', $six)->count();
    
       $current = date('Y-m-d', strtotime($cDate. ' -0 days'));
         $currentDay=property::whereDate('updated_at', '=', $current)->count();
     //Graph secound line cold-calling
       $currentCold=coldCallingModel::whereDate('updated_at', '=', $current)->count();
    
      //latest 24 hour's agent activites
           $cDateTime=date('Y-m-d H:i:s');
       $activity = date('Y-m-d H:i:s', strtotime($cDateTime. '-24 hours'));
          $totalAgentActivity=property::whereDate('updated_at', '>=', $activity)->latest()->count();
       
         $permissions = permission::where('user_id', session('user_id'))->first();
    $todayDate = new DateTime('today');
    $datetime = new DateTime('tomorrow');
    $reminders = Reminder::whereDate("date_time",$datetime->format('Y-m-d'))->orWhereDate("date_time",$todayDate->format('Y-m-d'))->get();
    $remSummery = DB::table('reminders')->join('users', 'users.id','=','reminders.user_id')->select('property_id','user_name','reminder_of','reminder_type','date_time', 'description','reason','add_by')->where('reminders.status','disable')->whereDate('date_time','>',Carbon::now()->subDays(30))->get();
    $currentDate = Carbon::now()->format('Y-m-d');
    // dd($currentDate);
    $futureDate = Carbon::now()->addMonths(3)->format('Y-m-d');
    $deals = DB::table('deals')->select('deals.id as dealId', 'deals.contract_start_date as cStart','deals.deal_start_date as dStart', 'deals.contract_end_date as cEnd', 'deals.referenceNo as refNo', 'deals.client_name as cName', 'deals.property_type as pType', 'deals.broker_name as broker', 'deals.unit_no as unit', 'deals.contanct_no as contact', 'deals.building as build', 'deals.dealStatus as dStatus', 'users.First_name as fName', 'users.Last_name as lName')->join('users', 'users.id', '=', 'deals.agent_name')->whereBetween('deals.contract_end_date', array($currentDate, $futureDate))->orderBy('deals.contract_end_date', 'ASC')->get();

    // DB::select('SELECT d.id as dealId, d.contract_start_date as cStart, d.contract_end_date as cEnd, d.referenceNo as refNo, d.client_name as cName, d.property_type as pType, d.building as build, d.dealStatus as dStatus, u.First_name, u.Last_name from deals d, users u where d.agent_name = u.id and d.contract_end_date between '+$currentDate+' and '+$futureDate+' ORDER By d.contract_end_date ASC');
    // deal::whereBetween('contract_end_date', array($currentDate, $futureDate))->orderBy('contract_end_date', 'ASC')->get();
    // dd($deals);
    $latestProperties = property::whereDate("created_at",$todayDate->format('Y-m-d'))->get();
    $latestLeads = lead::whereDate("created_at",$todayDate->format('Y-m-d'))->get();
     return view('dashboard',compact(['contracts','users','properties','agents','owners','admins','buildings','leads','rent','sale','upcoming',
                'firstDay','secondDay','thirdDay','fourDay','fiveDay','sixDay','currentDay','firstCold','secondCold','thirdCold','fourCold','fiveCold','sixCold','currentCold','totalAgentActivity','coldCallings','allusers','permissions','coldCallingsSuperAgent',"reminders","latestProperties","latestLeads",'remSummery','deals','currentDate']));
    }
    public function Supervision(){
       $result_data=Supervision::all();
         $permissions = permission::where('user_id', session('user_id'))->first();
        $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
         $buildings=Building::all();
        return view('supervision',compact(['result_data','users','buildings','permissions']));
    }
    public function AddSupervison(Request $request){
    	if(isset($_POST['add_supervison'])){
            $result=Supervision::where('unit_no',input::get("unit_no"))->get();
                if(count($result) > 0){
                   return back()->with('msg','<div class="alert alert-danger">unit No already exist!</div>'); 
                }
    		if(Input::hasFile('contract_attachment')){
    			$img=Input::File('contract_attachment');
	            $file_name=mt_rand(11111111,99999999).'_Contract.'.$img->getClientOriginalExtension();
	            $img->move(public_path()."/contract_attachments",$file_name);
    		}else{
    			$file_name=NULL;
    		}
    		if(Input::hasFile('supervision_contract_attachment')){
    			$img=Input::File('supervision_contract_attachment');
	            $file_name2=mt_rand(11111111,99999999).'_Contract.'.$img->getClientOriginalExtension();
	            $img->move(public_path()."/contract_attachments",$file_name2);
    		}else{
    			$file_name2=NULL;
    		}
    		$supervison=new Supervision();
    		$supervison->unit_no=input::get("unit_no");
            $supervison->assigned_user=input::get("assigned_user");
    		$supervison->Building=input::get("building");
            $supervison->area=input::get("area");
            $supervison->Bedroom=input::get("Bedroom");
            $supervison->Washroom=input::get("Washroom");
            $supervison->Conditions=input::get("Conditions");
            $supervison->security_deposit_amount=input::get("security_deposit_amount");
    		$supervison->LandLord_account=input::get("landlord_account");
    		$supervison->contract_start_date=input::get("contract_start_date");
    		$supervison->contract_end_date=input::get("contract_end_date");
    		$supervison->supervision_contract_start_date=input::get("supervision_contract_start_date");
    		$supervison->supervision_contract_end_date=input::get("supervision_contract_end_date");
            $supervison->LandLord_phone_number=input::get("landlord_phone_number");
            $supervison->LandLord_email=input::get("landlord_email");
            $supervison->maintenance_amount=input::get("maintenance_amount");
            $supervison->access=input::get("access");
    		$supervison->contract_attachment=$file_name;
    		$supervison->supervision_contract_attachment=$file_name2;
    		$supervison->tenant_name=input::get("tenant_name");
    		$supervison->tenant_number=input::get("tenant_number");
    		$supervison->tenant_email=input::get("tenant_email");
    		$supervison->save();
    		$supervision_id=DB::getPdo()->lastInsertId();
            $documents_files=array();
            $documents=input::file('documents');
            $documentsNames=input::get('document_name');
            if(count($documents) > 0){
                $documents=array_values($documents);
                foreach($documents as $key => $tmp_name){
                    $file_tmp =$_FILES['documents']['tmp_name'][$key];
                    $img=$_FILES['documents']['name'][$key];
                    $file_name = $key.$_FILES['documents']['name'][$key];
                    $full_name=mt_rand(111111111,999999999).'_'.$file_name;
                    move_uploaded_file($file_tmp,public_path()."/user_attachments/".$full_name);
                    $documents_files[]=[
                        'supervision_id' => $supervision_id,
                        'file_type' => $documentsNames[$key],
                        'file_name' => $full_name,
                        'document_type' => 'TENANT',
                        ];
                }
                DB::table('user_files')->insert($documents_files);
            }
    		$cheque_attach_file=array();
    		if(Input::hasFile('Cheque_attach_file')){
    			foreach($_FILES['Cheque_attach_file']['tmp_name'] as $key => $tmp_name){
    				$file_tmp =$_FILES['Cheque_attach_file']['tmp_name'][$key];
    				$img=$_FILES['Cheque_attach_file']['name'][$key];
				    $file_name = $key.$_FILES['Cheque_attach_file']['name'][$key];
				    $full_name=mt_rand(111111111,999999999).'_'.$file_name;
				    move_uploaded_file($file_tmp,public_path()."/Cheque_attachment_files/".$full_name);
				    $cheque_attach_file[]=$full_name;
				}
    		}
    		$cheque_number=input::get("Cheque_number");
    		$cheque_date=input::get("Cheque_date");
    		$cheque_deposit_date=input::get("Cheque_deposit_date");
            $Cheque_amount=input::get("Cheque_amount");
    		foreach ($cheque_number as $key => $value) {
    			if(!isset($cheque_attach_file[$key])){
    				$cheque_attach_file[$key]=NULL;
    			}
    			$cheque_Array[]=[
    				"supervision_id"=>$supervision_id,
    				"cheque_number"=>$cheque_number[$key],
    				"cheque_date"=>$cheque_date[$key],
    				"cheque_deposit_date"=>$cheque_deposit_date[$key],
    				"cheque_attach_file"=>$cheque_attach_file[$key],
                    "Cheque_amount"=>$Cheque_amount[$key],
    			];
    		}
    		$maintenance_attach_file=array();
    		if(Input::hasFile('maintenance_attach_file')){
    			foreach($_FILES['maintenance_attach_file']['tmp_name'] as $key => $tmp_name){
    				$file_tmp =$_FILES['maintenance_attach_file']['tmp_name'][$key];
    				$img=$_FILES['maintenance_attach_file']['name'][$key];
				    $file_name = $key.$_FILES['maintenance_attach_file']['name'][$key];
				    $full_name=mt_rand(111111111,999999999).'_'.$file_name;
				    move_uploaded_file($file_tmp,public_path()."/maintenance_attach_files/".$full_name);
				    $maintenance_attach_file[]=$full_name;
				}
    		}
    		$maintenance_date=input::get("maintenance_date");
    		$maintenance_description=input::get("maintenance_description");
    		$maintenance_AED=input::get("maintenance_AED");
            foreach ($maintenance_date as $key => $value) {
    			if(!isset($maintenance_attach_file[$key])){
    				$maintenance_attach_file[$key]=NULL;
    			}
    			$maintenance_Array[]=[
    				"supervision_id"=>$supervision_id,
    				"maintenance_date"=>$maintenance_date[$key],
    				"maintenance_description"=>$maintenance_description[$key],
    				"maintenance_AED"=>$maintenance_AED[$key],"maintenance_attach_file"=>$maintenance_attach_file[$key],
    			];
    		}
    		SupervisionCheaque::insert($cheque_Array);
    		SupervisionMaintenance::insert($maintenance_Array);
    		return redirect("/supervision")->with("msg","<div class='alert alert-success'>Data Addedd Successfully</div>");
    	}else{
    		return redirect("/supervision")->with("msg","<div class='alert alert-danger'>Something Went Wrong</div>");
    	}
    }
    public function SupervisionBulkActions(){
        $check_boxes=input::get("check_boxes");
        $updated_access=input::get("updated_access");
        $action=input::get("action");
        foreach($check_boxes as $key=>$value){
            if($action=='Update'){
                if(isset($check_boxes[$key])){
                  Supervision::where("id",$check_boxes[$key])->update(["access"=>$updated_access[$key]]);
                    $message='<div class="alert alert-success">Record Updated Successfully</div>';  
                }
            }else if($action=='Delete'){
                if(isset($check_boxes[$key])){
                  Supervision::where("id",$check_boxes[$key])->delete();
                  $message='<div class="alert alert-success">Record Deleted Successfully</div>';  
                }
            }
        }
        if(isset($message)){
            return redirect('supervision')->with('msg',$message);
        }else{
             return redirect('supervision');
        }
    }
    public function EditSupervision(){
        $recordID=input::get("record_id");
        $action=input::get("action");
        $result=supervision::where("id",$recordID)->get();
        $documents=userFiles::where('supervision_id',$recordID)->get();
        $result=json_decode(json_encode($result),true);
        $maintenanceRecord=SupervisionMaintenance::where("supervision_id",$recordID)->get();
        $complainRecord=SupervisionComplain::where("supervision_id",$recordID)->get();
        $cheaqueRecord=SupervisionCheaque::where("supervision_id",$recordID)->get();
        $owners=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
         $total = DB::table('supervisionmaintenances')->where('supervision_id',$recordID)->sum('maintenance_AED');
        $total=json_decode(json_encode($total),true);
        $buildings=Building::all();
        $permissions = permission::where('user_id', session('user_id'))->first();
        return view("supervision",["buildings"=>$buildings,"result"=>$result,"maintenanceRecord"=>$maintenanceRecord,"complainRecord"=>$complainRecord,"cheaqueRecord"=>$cheaqueRecord,"Formdisplay"=>"block","Recorddisplay"=>"none","total"=>$total,'users'=>$owners,'documents' => $documents,"permissions"=>$permissions]);
    }
    public function UpdateSupervision(){
        if(isset($_POST['add_supervison'])){
            $data=array(
                "unit_no"=>input::get("unit_no"),
                "assigned_user"=>input::get("assigned_user"),
                "Building"=>input::get("building"),
                "area"=>input::get("area"),
                "Bedroom"=>input::get("Bedroom"),
                "Washroom"=>input::get("Washroom"),
                "Conditions"=>input::get("Conditions"),
                "LandLord_account"=>input::get("landlord_account"),
                "LandLord_phone_number"=>input::get("landlord_phone_number"),
                "LandLord_email"=>input::get("landlord_email"),
                "access"=>input::get("access"),
                "tenant_name"=>input::get("tenant_name"),
                "tenant_number"=>input::get("tenant_number"),
                "tenant_email"=>input::get("tenant_email"),
            );
            $supervision_id=input::get("supervision_id");
            supervision::where("id",$supervision_id)->update($data);
            $documents_files=array();
            $documents=input::file('documents');
            $documentsNames=input::get('document_name');
            if(count($documents) > 0){
                $documents=array_values($documents);
                foreach($documents as $key => $tmp_name){
                    $file_tmp =$_FILES['documents']['tmp_name'][$key];
                    $img=$_FILES['documents']['name'][$key];
                    $file_name = $key.$_FILES['documents']['name'][$key];
                    $full_name=mt_rand(111111111,999999999).'_'.$file_name;
                    move_uploaded_file($file_tmp,public_path()."/user_attachments/".$full_name);
                    $documents_files[]=[
                        'supervision_id' => $supervision_id,
                        'file_type' => $documentsNames[$key],
                        'file_name' => $full_name,
                        'document_type' => 'TENANT',
                        ];
                }
                DB::table('user_files')->insert($documents_files);
            }
            if(input::get("Cheque_number")){
                $cheque_attach_file=array();
                if(Input::hasFile('Cheque_attach_file')){
                    foreach($_FILES['Cheque_attach_file']['tmp_name'] as $key => $tmp_name){
                        $file_tmp =$_FILES['Cheque_attach_file']['tmp_name'][$key];
                        $img=$_FILES['Cheque_attach_file']['name'][$key];
                        $file_name = $key.$_FILES['Cheque_attach_file']['name'][$key];
                        $full_name=mt_rand(111111111,999999999).'_'.$file_name;
                        move_uploaded_file($file_tmp,public_path()."/Cheque_attachment_files/".$full_name);
                        $cheque_attach_file[]=$full_name;
                    }
                }
                $cheque_number=input::get("Cheque_number");
                $cheque_date=input::get("Cheque_date");
                $cheque_deposit_date=input::get("Cheque_deposit_date");
                $Cheque_amount=input::get("Cheque_amount");
                foreach ($cheque_number as $key => $value) {
                    if(!isset($cheque_attach_file[$key])){
                        $cheque_attach_file[$key]=NULL;
                    }
                    $cheque_Array[]=[
                        "supervision_id"=>$supervision_id,
                        "cheque_number"=>$cheque_number[$key],
                        "cheque_date"=>$cheque_date[$key],
                        "cheque_deposit_date"=>$cheque_deposit_date[$key],
                        "cheque_attach_file"=>$cheque_attach_file[$key],
                        "Cheque_amount"=>$Cheque_amount[$key],
                    ];
                }
                SupervisionCheaque::insert($cheque_Array);
            }
            if(input::get("maintenance_date")){
                $maintenance_attach_file=array();
                if(Input::hasFile('maintenance_attach_file')){
                    foreach($_FILES['maintenance_attach_file']['tmp_name'] as $key => $tmp_name){
                        $file_tmp =$_FILES['maintenance_attach_file']['tmp_name'][$key];
                        $img=$_FILES['maintenance_attach_file']['name'][$key];
                        $file_name = $key.$_FILES['maintenance_attach_file']['name'][$key];
                        $full_name=mt_rand(111111111,999999999).'_'.$file_name;
                        move_uploaded_file($file_tmp,public_path()."/maintenance_attach_files/".$full_name);
                        $maintenance_attach_file[]=$full_name;
                    }
                }
                $maintenance_date=input::get("maintenance_date");
                $maintenance_description=input::get("maintenance_description");
                $maintenance_AED=input::get("maintenance_AED");
                $maintenance_type=input::get("maintenance_type");
                foreach ($maintenance_date as $key => $value) {
                    if(!isset($maintenance_attach_file[$key])){
                        $maintenance_attach_file[$key]=NULL;
                    }
                    $maintenance_Array[]=[
                        "supervision_id"=>$supervision_id,
                        "maintenance_date"=>$maintenance_date[$key],
                        "maintenance_description"=>$maintenance_description[$key],
                        "maintenance_AED"=>$maintenance_AED[$key],
                        "maintenance_type"=>$maintenance_type[$key],
                        "maintenance_attach_file"=>$maintenance_attach_file[$key],
                    ];
                }
                 SupervisionMaintenance::insert($maintenance_Array);
            }
            return redirect("/supervision")->with("msg","<div class='alert alert-success'>Data Updated Successfully</div>");
        }else{
            return redirect("/supervision")->with("msg","<div class='alert alert-danger'>Something Went Wrong</div>");
        }
    }
   public function getallReminder(){
        $mytime = \Carbon\Carbon::now();
        $date=$mytime->format('Y-m-d G:i').':00';
        $result=Reminder::where('status','viewed')->get();
        return json_decode(json_encode($result),true);
    }
     public function getReminders(){
        $mytime = \Carbon\Carbon::now();
        $date=$mytime->format('Y-m-d G:i').':00';
        $result=Reminder::where('date_time','<=',$date)->get();
        foreach ($result as $key => $value) {
            $currentDate = strtotime($date);
            $futureDate = $currentDate+(60*5);
            $formatDate = date("Y-m-d G:i:s", $futureDate);
            Reminder::where('id',$value->id)->update(['date_time'=>$formatDate,"status"=>'viewed']);
        }
        return json_decode(json_encode($result),true);
    }
    // 
    public function addOwnerByAjax(Request $request){
      $record=User::where("user_name",$request->input('user_name'))->get();
      $email=User::where("email",$request->input('Email'))->get();
      if(count($record) > 0){
        return 'username already exist';
      }else if(count($email) > 0){
        return 'Email already exist';
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
        $value->role='2';
        $value->Email=$email;
        $value->Phone=$request->input('Phone');
        $value->Password=md5($request->input('Password'));
        $value->IBAN=$request->input('IBAN');
        $value->account_number=$request->input('account_number');
        $value->bank_name=$request->input('bank_name');
        $value->swift_code=$request->input('swift_code');
        $value->save();
        $lastId=DB::getPdo()->lastInsertId();
        if(input::file('documents')){
            $documents_files=array();
            $documents=input::file('documents');
            $documentsNames=input::get('document_name');
            if(count($documents) > 0){
                $documents=array_values($documents);
                foreach($documents as $key => $tmp_name){
            		$file_tmp =$_FILES['documents']['tmp_name'][$key];
            		$img=$_FILES['documents']['name'][$key];
            	    $file_name = $key.$_FILES['documents']['name'][$key];
            	    $full_name=mt_rand(111111111,999999999).'_'.$file_name;
            	    move_uploaded_file($file_tmp,public_path()."/user_attachments/".$full_name);
            	    $documents_files[]=[
                        'user_id' => $lastId,
                        'file_type' => $documentsNames[$key],
                        'file_name' => $full_name,
                        'document_type' => 'USER',
                        ];
            	}
                DB::table('user_files')->insert($documents_files);
            }
        }
        return 'true';
        
    }
}
