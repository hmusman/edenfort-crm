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
use App\Models\Clicks;
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
        // dd($properties);
        foreach($properties as $key => $propertyID){
            $user = user::where('id',@$agents[$key])->first();
            // dd($user);
            coldcallingModel::where("id",$propertyID)->update(["user_id"=>@$agents[$key],'update_from'=>'property']);

            $property = coldcallingModel::where("id",$propertyID)->first();
            $description = $property->Building .' with Unit No => '. $property->unit_no .'and Area => '. $property->area .'assigned to '. $user->user_name;
            // dd($user->user_name);
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Assign Property','description'=>$description]);
        }
        return back()->with("msg","Property Assigned Successfully!");
    }

    public function singlePersonBuilding(Request $request){
        $properties = $request->check_boxes;
        $agents = $request->agents_ids;
        $agents = array_values($agents);
        $properties = array_values($properties);
        // dd(@$agents[0]);
        $user = user::where('id',@$agents[0])->first();
        foreach($properties as $key => $propertyID){
            coldcallingModel::where('building',$propertyID)->update(["user_id"=>@$agents[0],'update_from'=>'coldcalling']);

            $property = coldcallingModel::where("id",$propertyID)->first();
            $description = $property->Building .' with Unit No => '. $property->unit_no .'and Area => '. $property->area .'assigned to '. $user->user_name;
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Assign Building','description'=>$description]);
        }
        return back()->with("msg","Coldcalling Assigned Successfully!");
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

            $description = $data->Building .' with Unit No => '. $data->unit_no .' and Area => '. $data->area .' send at email.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Property','description'=>$description]);
        }
        return 'true';
    }
    public function whatsAppMsgsForProperty(){
        $message='';
        $check_boxes=input::get('check_boxes');
        foreach($check_boxes as $key=>$value){
            $data = coldcallingModel::where('id',$value)->first();
            if($data->rented_status == "on"){
              $price = $data->rented_price;
            }else if($data->sale_status == "on"){
              $price = $data->sale_price;
            }else{
              $price = $data->price;
            }
            $message .='
                Building : '.$data->Building.'  
                Size - '.$data->Area_Sqft.'
                Price -'.$price.'
                Bedroom- '.$data->Bedroom.'
                Condition- '.$data->Conditions.' 
                Access- '.$data->access.'

                Agent - '.$data->user->First_name.' '.$data->user->Last_name.'- '.$data->user->Phone.'
                EDEN FORT REAL ESTATE


                ';
            $description = $data->Building .' with Unit No => '. $data->unit_no .' and Area => '. $data->area .' send at whatsapp.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Coldcalling','description'=>$description]);
        }
        echo $message;
    }
        public function whatsAppOwnerMsgsForProperty(){
        $message='';
        $check_boxes=input::get('check_boxes');
        foreach($check_boxes as $key=>$value){
            $data = coldcallingModel::where('id',$value)->first();
            if($data->rented_status == "on"){
              $price = $data->rented_price;
            }else if($data->sale_status == "on"){
              $price = $data->sale_price;
            }else{
              $price = $data->price;
            }
            $message .='
                Owner Name : '.$data->LandLord.'
                Owner Email : '.$data->email.'
                Owner Phone : '.$data->contact_no.'
                Building : '.$data->Building.'  
                Size - '.$data->Area_Sqft.'
                Price -'.$price.'
                Type- '.$data->type.'
                Access- '.$data->access.'
                Condition- '.$data->Conditions.' 

                Agent - '.$data->user->First_name.' '.$data->user->Last_name.'- '.$data->user->Phone.'
                EDEN FORT REAL ESTATE


                ';

            $description = $data->Building .' with Unit No => '. $data->unit_no .' and Area => '. $data->area .' send at whatsapp with owner detail.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Coldcalling','description'=>$description]);
        }
         echo $message;
    }
       public function index(Request $request){
           $permissions = permission::where('user_id', session('user_id'))->first();
                $areas=coldcallingModel::distinct('area')->pluck('area');
                $bedrooms=coldcallingModel::distinct('Bedroom')->pluck('Bedroom');
                $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                $agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND (b.Rule_type='agent' OR b.Rule_type='SuperAgent' OR b.Rule_type='SuperDuperAdmin')");
                // dd($agents);
                 $buildings=Building::all();
                 $agentss=user::where(["status"=>1])->whereIn("role",[3,4,5])->get(["user_name","id"]);
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
                if($request->unit_no){
                    $query->where("unit_no",$request->unit_no);
                }
                if($request->contact_no){
                    $query->where("contact_no", 'LIKE', '%' .$request->contact_no. '%');
                }
                $result_data = $query->orderBy('updated_at', 'DESC')->paginate(25);
                // dd($result_data);
                $reminders = Reminder::orderBy('date_time', 'DESC')->get();
                // dd($reminders);
                $current_date = date('Y-m-d H:i:s');
                // dd($current_date);
                $upcoming = coldcallingModel::where('access','Upcoming')->count();

                $description = 'Property page visited.';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>$description]);
                return view('addproperties',compact(['result_data','users','agents','areas','bedrooms','buildings','permissions','agentss','upcoming','reminders','current_date']));
    }
    public function setReminderForProperty(Request $r){
        // dd( $r-comment);
        try{
            // dd(input::get('time_date'), input::get('description'),input::get('status'),input::get('check_boxes'));
            $timedate = date('Y-m-d H:i:s', strtotime(input::get('time_date')));
            $check_boxes=input::get('check_boxes');
            $comment = $r->comment;
            foreach($check_boxes as $key=>$value){
                if(isset($check_boxes[$key])){
                  $data=array(
                        'access' => input::get('status'),
                        'comment' => $comment[$key],
                        'update_from' => 'property',
                    );
                   coldcallingModel::where("id",$check_boxes[$key])->update($data);
                   $row = coldcallingModel::where("id",$check_boxes[$key])->first();
                   $reminder= new Reminder();
                   $reminder->property_id=$check_boxes[$key];
                   $reminder->date_time=$timedate;
                   $reminder->description=strip_tags(input::get('description'));
                   $reminder->reminder_type=strip_tags(input::get('status'));
                   $reminder->user_id = session('user_id');
                   $reminder->reminder_of="PROPERTY";
                   $reminder->save();

                   $description = 'Set reminder of type '.strip_tags(input::get('status')).' on Building name => '. $row->Building .' with Unit No => '. $row->unit_no .'and Area => '. $row->area;
                   Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Set Property Reminder','description'=>$description]);
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
       $row = coldcallingModel::where("id",$id)->first();
       $deleted= coldcallingModel::where(['id'=>$id])->delete();
       if($deleted){
            $description = 'Property '. $row->Building .' with Unit No => '. $row->unit_no .'and Area => '. $row->area .'is deleted.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Delete Property','description'=>$description]);
            return back()->with('msg','Property deleted.');
           } else{
               return back()->with('error','Something went wrong.');
           }
        
    }
    public function Addproperty(){
        $sale_status=NULL;
        $rented_date=NULL;
        $rented_price=NULL;
        $checkUnitNo=coldcallingModel::where(["unit_no"=>input::get("unit_no"),"Building"=>input::get("building")])->get();
        if(count($checkUnitNo) > 0){
            return back()->with('msg','<div class="alert alert-danger">Unit# already exit against this Building!</div>');
        }
        // $checkDewaNo=coldcallingModel::where(["dewa_no"=>input::get("dewa_no"),"Building"=>input::get("building")])->get();
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
	    	$property=new coldcallingModel();
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
	        $property->update_from='property';
	        $property->save();
	         $property_id = DB::getPdo()->lastInsertId();
             $row = coldcallingModel::where("id",$property_id)->first();
             $description = 'New property '. $row->Building .' with Unit No => '. $row->unit_no .'and Area => '. $row->area .'is added.';
             Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Add New Property','description'=>$description]);
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
               $description = 'Reminder on property '. $row->Building .' with Unit No => '. $row->unit_no .'and Area => '. $row->area .'is added.';
               Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Add New Property','description'=>$description]);
	        }
	        return back()->with('msg','Property Added Successfully!');
    }
    public function EditProperty(){
        
        $permissions = permission::where('user_id', session('user_id'))->first();
        
        $recordID=input::get("record_id");
        
        $result=coldcallingModel::where("id",$recordID)->get();
        
        $result=json_decode(json_encode($result),true);
        
        $buildings=Building::select(["building_name","id"])->distinct('building_name')->get();
        
        $areas=coldcallingModel::select('area')->distinct('area')->orderBy('updated_at', 'DESC')->get();
        
        $bedrooms=coldcallingModel::select('Bedroom')->distinct('Bedroom')->orderBy('updated_at', 'DESC')->get();
        
        $reminders=Reminder::where('property_id',$result[0]['id'])->first();
        $agentss=user::where(["status"=>1])->whereIn("role",[3,4])->get(["user_name","id"]);
        $upcoming = coldcallingModel::where('access','Upcoming')->count();
        $row = coldcallingModel::where("id",$recordID)->first();
        $description = 'Property '. $row->Building .' with Unit No => '. $row->unit_no .'and Area => '. $row->area .'is edited.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Edit Property','description'=>$description]);
        return view("addproperties",["result"=>$result,"Formdisplay"=>"block","Recorddisplay"=>"none",'buildings'=>$buildings,'reminders'=>$reminders,'areas'=>$areas,'bedrooms'=>$bedrooms,'agentss'=>$agentss,'upcoming'=>$upcoming,'permissions'=>$permissions]);
    }
    public function addLandlordEmailPass(){
        if(input::get('email')){
            if(isset($_GET['ref'])){
                $email=coldcallingModel::where('id',input::get('id'))->pluck('email');
                if($email[0]!=""){$email[0].=','.input::get('email');}else{$email[0]=input::get('email');}
                coldcallingModel::where('id',input::get('id'))->update(['email'=>$email[0],'update_from'=>'property']);

                $row = coldcallingModel::where("id",input::get('id'))->first();
                $description = 'Email for property '. $row->Building .' with Unit No => '. $row->unit_no .'and Area => '. $row->area .'is updated.';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Edit Property','description'=>$description]);
                return back()->with('msg','Email updated Successfully!');
            }else{
                $email=coldcallingModel::where('id',input::get('id'))->pluck('email');
                if($email[0]!=""){$email[0].=','.input::get('email');}else{$email[0]=input::get('email');}
                coldcallingModel::where('id',input::get('id'))->update(['email'=>$email[0],'update_from'=>'property']);

                $row = coldcallingModel::where("id",input::get('id'))->first();
                $description = 'Email for property '. $row->Building .' with Unit No => '. $row->unit_no .'and Area => '. $row->area .'is updated.';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Edit Property','description'=>$description]);
                return back()->with('msg','Email updated Successfully!');
            }
        }else if(input::get('phone')){
            if(isset($_GET['ref'])){
                $phone=coldcallingModel::where('id',input::get('id'))->pluck('contact_no');
                $phone[0].=','.input::get('phone');
                coldcallingModel::where('id',input::get('id'))->update(['contact_no'=>$phone[0],'update_from'=>'property']);

                $row = coldcallingModel::where("id",input::get('id'))->first();
                $description = 'Phone for property '. $row->Building .' with Unit No => '. $row->unit_no .'and Area => '. $row->area .'is updated.';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Edit Property','description'=>$description]);
                return back()->with('msg','Phone Number updated Successfully!');
            }else{
                $phone=coldcallingModel::where('id',input::get('id'))->pluck('contact_no');
                $phone[0].=','.input::get('phone');
                coldcallingModel::where('id',input::get('id'))->update(['contact_no'=>$phone[0],'update_from'=>'property']);

                $row = coldcallingModel::where("id",input::get('id'))->first();
                $description = 'Phone for property '. $row->Building .' with Unit No => '. $row->unit_no .'and Area => '. $row->area .'is updated.';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Edit Property','description'=>$description]);
                return back()->with('msg','Phone Number updated Successfully!');
            }
        }
       
    }
      public function bulkUpdateStatusProperty(Request $r){
        $status=$r->status;
        $check_boxes=$r->check_boxes;
        $comment = $r->comment;
       foreach($check_boxes as $key=>$value){
            if(isset($check_boxes[$key])){
                $data=array(
                   'access' => $status,
                   'comment' => $comment[$key],
                   'update_from' => 'property',
                );
               coldcallingModel::where("id",$check_boxes[$key])->update($data);

               $row = coldcallingModel::where("id",$check_boxes[$key])->first();
               $description = 'Property '. $row->Building .' with Unit No => '. $row->unit_no .' and Area => '. $row->area .' updated access => '. $status. '.';
               Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Edit Property','description'=>$description]);
              
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
                    'update_from' => 'property'
                );
                $property_id=input::get("property_id");
                coldcallingModel::where("id",$property_id)->update($data);

                $row = coldcallingModel::where("id",$property_id)->first();
                $description = 'Property '. $row->Building .' with Unit No => '. $row->unit_no .'and Area => '. $row->area .' is updated.';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Update Property','description'=>$description]);
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
                       $row = coldcallingModel::where("id",$property_id)->first();
                       $description = 'Reminder for property '. $row->Building .' with Unit No => '. $row->unit_no .'and Area => '. $row->area .'is  added.';
                       Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Add Property Reminder','description'=>$description]);
        	        }
                return redirect('property')->with('msg','Property updated Successfully');
            }catch (\Exception $e) {
               return redirect('property')->with('error', $e->getMessage());
            }
        }
         else{
                return redirect('property')->with('msg','something went wrong!');
            }
    }

    public function propertydetail($id){
        $data = coldcallingModel::where('id',$id)->first();
        if(session('role') == 'Agent'){
            Reminder::where('property_id',$id)->where(['add_by' => 'AGENT','user_id'=>session('user_id')])->update(["status"=>'viewed']);
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'View Reminder','description'=>'Open reminder']);
        }else if(session('role') == 'Admin'){
            Reminder::where('property_id',$id)->where(['add_by' => 'ADMIN','user_id'=>session('user_id')])->update(["status"=>'viewed']);
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'View Reminder','description'=>'Open reminder']);
        }
        else if(session('role') == 'SuperAgent'){
            Reminder::where('property_id',$id)->where(['add_by' => 'SUPERAGENT','user_id'=>session('user_id')])->update(["status"=>'viewed']);
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'View Reminder','description'=>'Open remidner']);
        }
        $description = 'Property '. $data->Building .' with Unit No => '. $data->unit_no .'and Area => '. $data->area .' viewed from remidner.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'View Reminder','description'=>$description]);
        return view('propertydetail', compact('data'));
    }

    public function propertiesexport(Request $request) 
    {
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>'Export properties']);
        return Excel::download(new PropertiesExport($request), 'properties.xlsx');
    }

}
