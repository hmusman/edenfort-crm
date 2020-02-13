<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supervision;
use App\Models\SupervisionCheaque;
use App\Models\SupervisionMaintenance;
use App\Models\SupervisionComplain;
use App\Models\property;
use App\Models\coldcallingModel;
use Illuminate\Support\Facades\Input;
use DB;
use Mail;
use App\Models\user;
use App\Models\role;
use App\Models\Reminder;
use App\Models\Building;
use App\Models\permission;
use App\Exports\PropertiesExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
class adminPropertyController extends Controller
{
    public function singlePersonProperty(Request $request){
        $properties = $request->check_boxes;
        $agents = $request->agents_ids;
        $agents = array_values($agents);
        $properties = array_values($properties);
        foreach($properties as $key => $propertyID){
            property::where("id",$propertyID)->update(["user_id"=>@$agents[$key]]);
        }
        return back()->with("msg","<div class='alert alert-success' style='position: relative;top: -22px;width: 97%;margin: auto;'>Property Assigned Successfully!</div>");
    }

    public function sentEmails(){
        $message='';
        $check_boxes=input::get('check_boxes');
        foreach($check_boxes as $key=>$value){
            $data = property::where('id',$value)->first();
if(!is_null(str_replace(" ","",$data->email)) && str_replace(" ","",$data->email) != "" && str_replace(" ","",$data->email) != " "){
            $message .='
Building : '.$data->Building.' <br> 
Size - '.$data->Area_Sqft.'<br>
Price -'.$data->Price.'<br>
Type- '.$data->type.'<br>
Condition- '.$data->Conditions.'<br><br> 

Agent - '.$data->user->First_name.' '.$data->user->Last_name.'- '.$data->user->Phone.'
EDEN FORT REAL ESTATE<br><br><br>
';
$receiverEmail = $data->email;
$data = array('name'=>"EdenFort CRM");
$contactName = 'EdenFort CRM';
$contactEmail = input::get('sending_email');
$template = DB::table('email_templates')->where('template_name',"coldcalling_and_property_email_template")->first();
$contactMessage = str_replace("{data}",$message,$template->template_date);
 $data = array('name'=>$contactName, 'email'=>$contactEmail, 'data'=>$contactMessage);
Mail::send('email', $data, function($message) use ($contactEmail, $contactName,$receiverEmail)
{   
    $message->from(str_replace(" ","",$contactEmail), $contactName);
    $message->to(str_replace(" ","",$receiverEmail), 'EdenFort CRM')->subject('Property Alert');
});
}
        }
        return 'true';
    }
    public function whatsAppMsgsForProperty(){
        $message='';
        $check_boxes=input::get('check_boxes');
        foreach($check_boxes as $key=>$value){
            $data = property::where('id',$value)->first();
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
        public function whatsAppOwnerMsgsForProperty(){
        $message='';
        $check_boxes=input::get('check_boxes');
        foreach($check_boxes as $key=>$value){
            $data = property::where('id',$value)->first();
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
       public function index(Request $request){
           $permissions = permission::where('user_id', session('user_id'))->first();
                $areas=property::distinct('area')->pluck('area');
                $bedrooms=property::distinct('Bedroom')->pluck('Bedroom');
                $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                $agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
                 $buildings=Building::all();
                 $agentss=user::where(["status"=>1])->whereIn("role",[3,4])->get(["user_name","id"]);
                //  
                $query = property::query();
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
                if($request->unit_no){
                    $query->where("unit_no",$request->unit_no);
                }
                $result_data = $query->orderBy('updated_at', 'DESC')->paginate(20);
                return view('addproperties',compact(['result_data','users','agents','areas','bedrooms','buildings','permissions','agentss']));
    }
    public function setReminderForProperty(Request $r){
        try{
            $timedate = date('Y-m-d H:i:s', strtotime(input::get('time_date')));
            $check_boxes=input::get('check_boxes');
            foreach($check_boxes as $key=>$value){
                if(isset($check_boxes[$key])){
                  $data=array(
                        'access' => input::get('status'),
                    );
                   property::where("id",$check_boxes[$key])->update($data);
                   $reminder= new Reminder();
                   $reminder->property_id=$check_boxes[$key];
                   $reminder->date_time=$timedate;
                   $reminder->description=strip_tags(input::get('description'));
                   $reminder->reminder_type=strip_tags(input::get('status'));
                   $reminder->user_id = session('user_id');
                   $reminder->reminder_of="PROPERTY";
                   $reminder->save();
                }
            }
                return "true";
            }catch(\Exception $e){
                return '<div class="alert alert-danger" style="font-size: 11px;
        margin-top: 2%;">something went wrong</div>';
            }
        }
        //delete Property
    public function DeleteProperty($id){
  
       $deleted= property::where(['id'=>$id])->delete();
       if($deleted){
            return back()->with('msg','<div class="alert alert-warning">Property  deleted.</div>');
           } else{
               return back()->with('msg','<div class="alert alert-warning"> Something went wrong</div
               >');
           }
        
    }
    public function Addproperty(){
        $sale_status=NULL;
        $rented_date=NULL;
        $rented_price=NULL;
        $checkUnitNo=property::where(["unit_no"=>input::get("unit_no"),"Building"=>input::get("building")])->get();
        if(count($checkUnitNo) > 0){
            return back()->with('msg','<div class="alert alert-danger">Unit# already exit against this Building!</div>');
        }
        // $checkDewaNo=property::where(["dewa_no"=>input::get("dewa_no"),"Building"=>input::get("building")])->get();
        // if(count($checkDewaNo) > 0){
        //     return back()->with('msg','<div class="alert alert-danger">Dewa# already exit against this Building!</div>');
        // }
        if(input::get('sale_status')){
            $sale_status=input::get('sale_status');
            if(input::get('rented_date')){
                $rented_date=input::get('rented_date');
                $rented_price=input::get('rented_price'); 
            }
        }
          $unit=input::get("unit_no");
          $building=input::get("building");
    	    $email=array_filter(input::get("email"));
            $contact_no=array_filter(input::get("contact_no"));
	    	$property=new property();
			$property->unit_no=input::get("unit_no");
            $property->dewa_no=input::get("dewa_no");
	        $property->LandLord=input::get("LandLord");
			$property->Building=input::get("building");
	        $property->area=input::get("area");
	        $property->Bedroom=input::get("Bedroom");
            $property->Washroom=input::get("Washroom");
            $property->Conditions=input::get("Conditions");
	        $property->email=implode(",",$email);
	        $property->contact_no=implode(",",$contact_no);
	        $property->access=strtoupper(input::get("access"));
	        $property->Price=input::get("Price");
	        $property->Area_Sqft=input::get("Area_Sqft");
	        $property->comment=input::get("comment");
            $property->property_type=input::get("property_type");
	        $property->add_by=session("user_id");
	        $property->user_id=session("user_id");
            $property->property_status='edenfort_property';
	        $property->sale_status=$sale_status;
	        $property->rented_date=$rented_date;
	        $property->rented_price=$rented_price;
	        $property->save();
	         $property_id = DB::getPdo()->lastInsertId();
	        if(input::get('add_property_date_time')){
	            $data=array(
	                'property_id' => $property_id,
                    'reminder_of' => 'PROPERTY',
	                'reminder_type'=>input::get('add_property_reminder_type'),
	                'date_time'=>date('Y-m-d H:i:s', strtotime(input::get('add_property_date_time'))),
	                'description'=>input::get('add_property_reminder_description'),
	                'user_id' => session('user_id'),
	                'reminder_of' => "PROPERTY",
	           );
	           DB::table('reminders')->insert($data);
	        }
	        return back()->with('msg','<div class="alert alert-success">Property Added Successfully!</div>');
    }
    public function EditProperty(){
    	$recordID=input::get("record_id");
        $result=property::where("id",$recordID)->get();
        $result=json_decode(json_encode($result),true);
    	$buildings=Building::select(["building_name","id"])->get();
        $areas=property::select('area')->orderBy('updated_at', 'DESC')->get();
        $bedrooms=property::select('Bedroom')->orderBy('updated_at', 'DESC')->get();
    	$reminders=Reminder::where('property_id',$result[0]['id'])->first();
        $agentss=user::where(["status"=>1])->whereIn("role",[3,4])->get(["user_name","id"]);
        return view("addproperties",["result"=>$result,"Formdisplay"=>"block","Recorddisplay"=>"none",'buildings'=>$buildings,'reminders'=>$reminders,'areas'=>$areas,'bedrooms'=>$bedrooms,'agentss'=>$agentss]);
    }
    public function addLandlordEmailPass(){
        if(input::get('email')){
            if(isset($_GET['ref'])){
                $email=coldcallingModel::where('id',input::get('id'))->pluck('email');
                if($email[0]!=""){$email[0].=','.input::get('email');}else{$email[0]=input::get('email');}
                coldcallingModel::where('id',input::get('id'))->update(['email'=>$email[0]]);
                return back()->with('msg','<div class="alert alert-success">Email updated Successfully!</div>');
            }else{
                $email=property::where('id',input::get('id'))->pluck('email');
                if($email[0]!=""){$email[0].=','.input::get('email');}else{$email[0]=input::get('email');}
                property::where('id',input::get('id'))->update(['email'=>$email[0]]);
                return back()->with('msg','<div class="alert alert-success">Email updated Successfully!</div>');
            }
        }else if(input::get('phone')){
            if(isset($_GET['ref'])){
                $phone=coldcallingModel::where('id',input::get('id'))->pluck('contact_no');
                $phone[0].=','.input::get('phone');
                coldcallingModel::where('id',input::get('id'))->update(['contact_no'=>$phone[0]]);
                return back()->with('msg','<div class="alert alert-success">Phone Number updated Successfully!</div>');
            }else{
                $phone=property::where('id',input::get('id'))->pluck('contact_no');
                $phone[0].=','.input::get('phone');
                property::where('id',input::get('id'))->update(['contact_no'=>$phone[0]]);
                return back()->with('msg','<div class="alert alert-success">Phone Number updated Successfully!</div>');
            }
        }
       
    }
      public function bulkUpdateStatusProperty(Request $r){
        $status=$r->status;
        $check_boxes=$r->check_boxes;
       foreach($check_boxes as $key=>$value){
            if(isset($check_boxes[$key])){
                $data=array(
                   'access' => $status,
                );
               property::where("id",$check_boxes[$key])->update($data);
              
            }
        }
         return 'true';
    }
    public function UpdateProperty(){
        if(isset($_POST['add_property'])){
            try{
                  $sale_status=NULL;
                    $rented_date=NULL;
                    $rented_price=NULL;
                    if(input::get('sale_status')){
                        $sale_status=input::get('sale_status');
                        if(input::get('rented_date')){
                            $rented_date=input::get('rented_date');
                            $rented_price=input::get('rented_price'); 
                        }
                    }
                $email=array_filter(input::get("email"));
                $contact_no=array_filter(input::get("contact_no"));
                $data=array(
    				'unit_no'=>input::get("unit_no"),
                    'dewa_no'=>input::get("dewa_no"),
    		        'LandLord'=>input::get("LandLord"),
    				'Building'=>input::get("building"),
    		        'area'=>input::get("area"),
    		        'Bedroom'=>input::get("Bedroom"),
                    'Washroom'=>input::get("Washroom"),
                    'Conditions'=>input::get("Conditions"),
    		        'email'=>implode(",",$email),
    		        'contact_no'=>implode(",",$contact_no),
    		        'access'=>input::get("access"),
    		        'Price'=>input::get("Price"),
    		        'Area_Sqft'=>input::get("Area_Sqft"),
    		        'comment'=>input::get("comment"),
    		         'sale_status'=>$sale_status,
        	        'rented_date'=>$rented_date,
        	        'rented_price'=>$rented_price,
                );
                $property_id=input::get("property_id");
                property::where("id",$property_id)->update($data);
                Reminder::where('property_id',$property_id)->delete();
                if(input::get('add_property_date_time')){
        	            $data=array(
                            'property_id' => $property_id,
                            'reminder_of' => 'PROPERTY',
        	                'unit_no' => input::get("unit_no"),
        	                'reminder_type'=>input::get('add_property_reminder_type'),
        	                'date_time'=>input::get('add_property_date_time'),
        	                'user_id' => session('user_id'),
        	                'description'=>input::get('add_property_reminder_description'),
        	           );
        	           DB::table('reminders')->insert($data);
        	        }
                return redirect('property')->with('msg','<div class="alert alert-success">Record updated Successfully</div>');
            }catch (\Exception $e) {
               return redirect('property')->with('msg','<div class="alert alert-danger">'.$e->getMessage().'</div>');
            }
        }
         else{
                return redirect('property')->with('msg','<div class="alert alert-danger">something went wrong!</div>');
            }
    }

    public function propertydetail($id){
        $data = property::where('id',$id)->first();
        if(session('role') == 'Agent'){
            Reminder::where('property_id',$id)->where(['add_by' => 'AGENT','user_id'=>session('user_id')])->update(["status"=>'viewed']);
        }else if(session('role') == 'Admin'){
            Reminder::where('property_id',$id)->where(['add_by' => 'ADMIN','user_id'=>session('user_id')])->update(["status"=>'viewed']);
        }
        else if(session('role') == 'SuperAgent'){
            Reminder::where('property_id',$id)->where(['add_by' => 'SUPERAGENT','user_id'=>session('user_id')])->update(["status"=>'viewed']);
        }
        return view('propertydetail', compact('data'));
    }

    public function propertiesexport(Request $request) 
    {
        return Excel::download(new PropertiesExport($request), 'properties.xlsx');
    //      return [
    //     (new PropertiesExport)->withHeadings(),
    // ];
    }

}
