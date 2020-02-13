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
use App\Models\permission;
use Session;
use Excel;
use File;
use Mail;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\ColdCallingExport;

use Maatwebsite\Excel\Concerns\WithHeadings;
class adminColdCallingController extends Controller
{

    public function singlePersonColdCalling(Request $request){
        $properties = $request->check_boxes;
        $agents = $request->agents_ids;
        $agents = array_values($agents);
        $properties = array_values($properties);
        foreach($properties as $key => $propertyID){
            coldcallingModel::where("id",$propertyID)->update(["user_id"=>@$agents[$key]]);
        }
        return back()->with("msg","<div class='alert alert-success' style='position: relative;top: -22px;width: 97%;margin: auto;'>ColdCalling Assigned Successfully!</div>");
    }
    public function sentEmails(){
        $message='';
        $check_boxes=input::get('check_boxes');
        foreach($check_boxes as $key=>$value){
            $data = coldcallingModel::where('id',$value)->first();
            
if(!is_null(str_replace(" ","",$data->email)) && str_replace(" ","",$data->email) != "" && str_replace(" ","",$data->email) != " "){
            $message .='
Building : '.$data->Building.' <br> 
Size - '.$data->Area_Sqft.'<br>
Price -'.$data->Price.'<br>
Type- '.$data->type.'<br>
Condition- '.$data->Conditions.'<br><br> 

Agent - '.$data->user->First_name.' '.$data->user->Last_name.'- '.$data->user->Phone.'<br>
EDEN FORT REAL ESTATE
';
$template = DB::table('email_templates')->where('template_name',"coldcalling_and_property_email_template")->first();
$contactMessage = str_replace("{data}",$message,$template->template_date);
$receiverEmail = $data->email;
$data = array('name'=>"EdenFort CRM");
$contactName = 'EdenFort CRM';
$contactEmail = input::get('sending_email');
 $data = array('name'=>$contactName, 'email'=>$contactEmail, 'data'=>$contactMessage);
Mail::send('email', $data, function($message) use ($contactEmail, $contactName,$receiverEmail)
{   
    $message->from($contactEmail, $contactName);
    $message->to('adnanshaukat832@gmail.com', 'EdenFort CRM')->subject('Property Alert');
});
}
        }
        return 'true';
    }
    public function whatsAppMsgs(){
        $message='';
        $check_boxes=input::get('check_boxes');
        foreach($check_boxes as $key=>$value){
            $data = coldcallingModel::where('id',$value)->first();
            $message .='
Building : '.$data->Building.'  
Size - '.$data->Area_Sqft.'
Price -'.$data->Price.'
Type- '.$data->type.'
Condition- '.$data->Conditions.' 

Agent - '.$data->user->First_name.' '.$data->user->Last_name.'- '.$data->user->Phone.'
EDEN FORT REAL ESTATE


';
        }
         echo $message;
    }
        public function whatsAppOwnerMsgs(){
        $message='';
        $check_boxes=input::get('check_boxes');
        foreach($check_boxes as $key=>$value){
            $data = coldcallingModel::where('id',$value)->first();
            $message .='
Owner Name : '.$data->LandLord.'
Owner Email : '.$data->email.'
Owner Phone : '.$data->contact_no.'
Building : '.$data->Building.'  
Size - '.$data->Area_Sqft.'
Price -'.$data->Price.'
Type- '.$data->type.'
Condition- '.$data->Conditions.' 

Agent - '.$data->user->First_name.' '.$data->user->Last_name.'- '.$data->user->Phone.'
EDEN FORT REAL ESTATE


';
        }
         echo $message;
    }
     //Bulk Set Reminder For ColdCalling 
    public function setReminderForColdCalling(Request $r){
        try{
            $wshrm=$r->washroom;
            $condition=$r->Conditions;
            $bedrooms=$r->bedroom;
            $type=$r->type;
            $rStatus=$r->rentedStatus;
            $rPrice=$r->rentedPrice;
            $sStatus=$r->saleStatus;
            $sPrice=$r->salePrice;
            $AreaSqft=$r->Area_Sqft;
            $timedate = date('Y-m-d H:i:s', strtotime(input::get('time_date')));
            $check_boxes=input::get('check_boxes');
            foreach($check_boxes as $key=>$value){
                if(isset($check_boxes[$key])){
                    $result=Reminder::where(["property_id"=>$check_boxes[$key],'reminder_of' => 'COLDCALLING','add_by'=>'ADMIN'])->delete();
                      if(!isset($rStatus[$key])){
                        $rStatus[$key]=NULL;
                      }if(!isset($sStatus[$key])){
                        $sStatus[$key]=NULL;
                      }
                      if(input::get('status') == 'Commercial' || input::get('status') == 'Residential'){
                          $data=array(
                            'Washroom' => $wshrm[$key],
                            'Conditions' => $condition[$key],
                            'Bedroom' => $bedrooms[$key],
                            'type' => $type[$key],
                            'rented_status' => $rStatus[$key],
                            'rented_price' => $rPrice[$key],
                            'sale_status' => $sStatus[$key],
                            'sale_price' => $sPrice[$key],
                            'property_type' => input::get('status'),
                            'Area_Sqft' => $AreaSqft[$key],
                        );
                      }else{
                          $data=array(
                            'Washroom' => $wshrm[$key],
                            'Conditions' => $condition[$key],
                            'Bedroom' => $bedrooms[$key],
                            'type' => $type[$key],
                            'rented_status' => $rStatus[$key],
                            'rented_price' => $rPrice[$key],
                            'sale_status' => $sStatus[$key],
                            'sale_price' => $sPrice[$key],
                            'access' => input::get('status'),
                            'Area_Sqft' => $AreaSqft[$key],
                        );
                      }
                   coldCallingModel::where("id",$check_boxes[$key])->update($data);
                   $row = coldCallingModel::where('id',$check_boxes[$key])->first();
                  
                   $checkPropertyFromPropertyTable = property::where(['Building'=>$row->Building,'unit_no'=>$row->unit_no])->get();
                   if(count($checkPropertyFromPropertyTable) == 0){
                        $row = json_decode(json_encode($row),true);
                        DB::table('properties')->insert($row);  
                   }
                   $reminder= new Reminder();
                   $reminder->property_id=$check_boxes[$key];
                   $reminder->date_time=$timedate;
                   $reminder->description=strip_tags(input::get('description'));
                   $reminder->reminder_type=strip_tags(input::get('status'));
                   $reminder->user_id=session('user_id');
                   $reminder->reminder_of="COLDCALLING";
                   $reminder->save();
                }
            }
                return "true";
            }catch(\Exception $e){
                return '<div class="alert alert-danger" style="font-size: 11px;
        margin-top: 2%;">something went wrong</div>';
            }
        }
    // 
    public function setReminderByRow(Request $r){
        $timedate = date('Y-m-d H:i:s', strtotime(input::get('time_date')));
        Reminder::where(["property_id"=>input::get('property_id'),'reminder_of' => 'COLDCALLING','add_by'=>'ADMIN'])->delete();
         $reminder= new Reminder();
         $reminder->property_id=strip_tags(input::get('property_id'));
         $reminder->date_time=$timedate;
         $reminder->description=strip_tags(input::get('description'));
         $reminder->reminder_type=strip_tags(input::get('access'));
         $reminder->user_id=session('user_id');
         $reminder->reminder_of="COLDCALLING";
         $reminder->save();
         coldCallingModel::where("id",input::get('property_id'))->update(["access" => strip_tags(input::get('access'))]);
         $row = coldCallingModel::where('id',input::get('property_id'))->first();
        
         $checkPropertyFromPropertyTable = property::where(['Building'=>$row->Building,'unit_no'=>$row->unit_no])->get();
         if(count($checkPropertyFromPropertyTable) == 0){
              $row = json_decode(json_encode($row),true);
            DB::table('properties')->insert($row);  
         }
         return 'true';
    }
    // 
    public function updateColdCallingRow(){
         coldCallingModel::where("id",input::get('property_id'))->update(["access" => strip_tags(input::get('access'))]);
         $row = coldCallingModel::where('id',input::get('property_id'))->first();
         $checkPropertyFromPropertyTable = property::where(['Building'=>$row->Building,'unit_no'=>$row->unit_no])->get();
         if(count($checkPropertyFromPropertyTable) == 0){
              $row = json_decode(json_encode($row),true);
              DB::table('properties')->insert($row);  
         }
        return 'true';
    }
    // 
    public function bulkUpdateStatusColdCalling(Request $r){
        $status=$r->status;
        $check_boxes=$r->check_boxes;
        $wshrm=$r->washroom;
        $condition=$r->Conditions;
        $bedrooms=$r->bedroom;
        $type=$r->type;
        $rStatus=$r->rentedStatus;
        $rPrice=$r->rentedPrice;
        $sStatus=$r->saleStatus;
        $sPrice=$r->salePrice;
        $AreaSqft=$r->Area_Sqft;
       foreach($check_boxes as $key=>$value){
            if(isset($check_boxes[$key])){
                if(!isset($rStatus[$key])){
                    $rStatus[$key]=NULL;
                  }if(!isset($sStatus[$key])){
                    $sStatus[$key]=NULL;
                  }
                if(input::get('status') == 'Commercial' || input::get('status') == 'Residential'){
                          $data=array(
                            'Washroom' => $wshrm[$key],
                            'Conditions' => $condition[$key],
                            'Bedroom' => $bedrooms[$key],
                            'type' => $type[$key],
                            'rented_status' => $rStatus[$key],
                            'rented_price' => $rPrice[$key],
                            'sale_status' => $sStatus[$key],
                            'sale_price' => $sPrice[$key],
                            'property_type' => $status,
                            'Area_Sqft' => $AreaSqft[$key],
                        );
                      }else{
                          $data=array(
                            'Washroom' => $wshrm[$key],
                            'Conditions' => $condition[$key],
                            'Bedroom' => $bedrooms[$key],
                            'type' => $type[$key],
                            'rented_status' => $rStatus[$key],
                            'rented_price' => $rPrice[$key],
                            'sale_status' => $sStatus[$key],
                            'sale_price' => $sPrice[$key],
                            'access' => $status,
                            'Area_Sqft' => $AreaSqft[$key],
                        );
                      }
               coldCallingModel::where("id",$check_boxes[$key])->update($data);
               $row = coldCallingModel::where('id',$check_boxes[$key])->first();
              $checkPropertyFromPropertyTable = property::where(['Building'=>$row->Building,'unit_no'=>$row->unit_no])->get();
                 if(count($checkPropertyFromPropertyTable) == 0){
                      $row = json_decode(json_encode($row),true);
                      DB::table('properties')->insert($row);  
                 }
            }
        }
         return 'true';
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
        if(Input::hasFile('tenant_document')){
			$img=Input::File('tenant_document');
            $tenant_document=mt_rand(11111111,99999999).'_document.'.$img->getClientOriginalExtension();
            $img->move(public_path()."/user_attachments",$tenant_document);
		}else{
			$tenant_document=NULL;
		}
		if(Input::hasFile('passport')){
			$img=Input::File('passport');
            $passport=mt_rand(11111111,99999999).'_document.'.$img->getClientOriginalExtension();
            $img->move(public_path()."/user_attachments",$passport);
		}else{
			$passport=NULL;
		}
		if(Input::hasFile('emirates_id')){
			$img=Input::File('emirates_id');
            $emirates_id=mt_rand(11111111,99999999).'_document.'.$img->getClientOriginalExtension();
            $img->move(public_path()."/user_attachments",$emirates_id);
		}else{
			$emirates_id=NULL;
		}
		if(Input::hasFile('visa_doc')){
			$img=Input::File('visa_doc');
            $visa_doc=mt_rand(11111111,99999999).'_document.'.$img->getClientOriginalExtension();
            $img->move(public_path()."/user_attachments",$visa_doc);
		}else{
			$visa_doc=NULL;
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
        $value->save();
        $lastId=DB::getPdo()->lastInsertId();
           $data=array([
                'user_id' => $lastId,
                'file_type' => 'tenant_document',
                'file_name' => $tenant_document,
                ],[
                'user_id' => $lastId,
                'file_type' => 'passport',
                'file_name' => $passport,
                ],
                [
                'user_id' => $lastId,
                'file_type' => 'emirates_id',
                'file_name' => $emirates_id,
                ],
                [
                'user_id' => $lastId,
                'file_type' => 'visa_doc',
                'file_name' => $visa_doc,
                ],
            );
        DB::table('user_files')->insert($data);
        $other_docs_files=array();
        $other_docs=input::file('other_docs');
        if(count($other_docs) > 0){
            $other_docs=array_values($other_docs);
            foreach($other_docs as $key => $tmp_name){
        		$file_tmp =$_FILES['other_docs']['tmp_name'][$key];
        		$img=$_FILES['other_docs']['name'][$key];
        	    $file_name = $key.$_FILES['other_docs']['name'][$key];
        	    $full_name=mt_rand(111111111,999999999).'_'.$file_name;
        	    move_uploaded_file($file_tmp,public_path()."/user_attachments/".$full_name);
        	    $other_docs_files[]=[
                    'user_id' => $lastId,
                    'file_type' => 'other_docs',
                    'file_name' => $full_name,
                    ];
        	}
            DB::table('user_files')->insert($other_docs_files);
        }
        return 'true';
        
    }
     public function coldCalling(Request $request){
      $permissions = permission::where('user_id', session('user_id'))->first();
          $areas=coldcallingModel::distinct('area')->pluck('area');
          $bedrooms=coldcallingModel::distinct('Bedroom')->pluck('Bedroom');   
          $agents=user::where(['role'=>3,"status"=>1])->orWhere(['role'=>1])->get();
          $agentss=user::where(["status"=>1])->whereIn("role",[3,4])->get(["user_name","id"]);
          $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
          $buildings=coldcallingModel::distinct('Building')->pluck('Building');
          $buildingss=Building::all();  
          //  
                $query = coldcallingModel::query();
                if($request->p){
                    $query->where("property_type",$request->p);
                }
                if($request->type){
                    if($request->type=="For Sale" || $request->type=="For Rent" ) {
                        $query->whereIn('access',['ForSale/ForRent',$request->type]);
                    }else{
                        $query->where("access",$request->type);
                    }
                }
                if($request->build){
                    $query->where("Building",$request->build);
                }
                if($request->area){
                    $query->where("area",$request->area);
                }
                if($request->bedroom){
                    $query->where("Bedroom",$request->bedroom);
                }
                if($request->agent){
                    $query->where("user_id",$request->agent);
                }
                if($request->unit){
                    $query->where("unit_no","LIKE",'%'.$request->unit.'%');
                }
                if($request->contact){
                    $query->where("contact_no","LIKE",'%'.$request->contact.'%');
                }
                $result_data = $query->orderBy('updated_at', 'DESC')->paginate(20);
                return view('coldCalling',compact(['result_data','users','agentss','agents','areas','bedrooms','buildings','buildingss','permissions']));
                
        
    }  

    public function coldcallignexport(Request $request) 
    {
        return Excel::download(new ColdCallingExport($request), 'ColdCallings.xlsx');
    //      return [
    //     (new PropertiesExport)->withHeadings(),
    // ];
    }
}