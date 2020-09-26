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
use App\Models\lead;
use Illuminate\Support\Facades\Input;
use DB;
use Mail;
use App\Models\user;
use App\Models\Clicks;
use App\Models\Reminder;
use App\Models\role;
use App\Models\permission;
use DateTime;
class agentPropertyController extends Controller
{
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

            $description = $data->Building .' with Unit No => '. $data->unit_no .' and Area => '. $data->area .' send at whatsapp.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>$description]);
        }
        return 'true';
    }
     public function index(){
        $permissions = permission::where('user_id', session('user_id'))->first();
        
        $coldCallings=coldCallingModel::where('user_id',session('user_id'))->count();
        $properties=coldcallingModel::where('user_id',session('user_id'))->count();
        
        $properties_rent=coldcallingModel::where('user_id',session('user_id'))->where('access','for rent')->count();
        // dd($properties_rent);
        $properties_sale=coldcallingModel::where('user_id',session('user_id'))->where('access','for sale')->count();
        // dd($properties_sale);
        
        $fname=session('user_name');
        $leads=lead::where('lead_user',$fname)->count();
   
     //Graph for countng updated_at columns according to date, property status
             $cDate=Date('Y-m-d');
           $first = date('Y-m-d', strtotime($cDate. ' -6 days'));
            $firstDayName = date('D', strtotime($cDate. ' -6 days'));
         $firstDay=coldcallingModel::whereDate('updated_at', '=', $first)->where('user_id',session('user_id'))->where('update_from','property')->count();
     //Graph secound line for cold-calling property status;
       $firstCold=coldCallingModel::whereDate('updated_at', '=', $first)->where('user_id',session('user_id'))->where('update_from','coldcalling')->count();
            $second = date('Y-m-d', strtotime($cDate. ' -5 days'));
            $secondDayName = date('D', strtotime($cDate. ' -5 days'));
         $secondDay=coldcallingModel::whereDate('updated_at', '=', $second)->where('user_id',session('user_id'))->where('update_from','property')->count();
    
     //Graph secound line for cold-calling second day;
       $secondCold=coldCallingModel::whereDate('updated_at', '=', $second)->where('user_id',session('user_id'))->where('update_from','coldcalling')->count();
     // //3rd day in graph
            $third = date('Y-m-d', strtotime($cDate. ' -4 days'));
             $thirdDayName = date('D', strtotime($cDate. ' -4 days'));
         $thirdDay=coldcallingModel::whereDate('updated_at', '=', $third)->where('user_id',session('user_id'))->where('update_from','property')->count();
    //Graph secound line cold-calling
       $thirdCold=coldCallingModel::whereDate('updated_at', '=', $third)->where('user_id',session('user_id'))->where('update_from','coldcalling')->count();
            $four = date('Y-m-d', strtotime($cDate. ' -3 days'));
            $fourDayName = date('D', strtotime($cDate. ' -3 days'));
         $fourDay=coldcallingModel::whereDate('updated_at', '=', $four)->where('user_id',session('user_id'))->where('update_from','property')->count();
    //Graph secound line cold-calling
       $fourCold=coldCallingModel::whereDate('updated_at', '=', $four)->where('user_id',session('user_id'))->where('update_from','coldcalling')->count();
              $five = date('Y-m-d', strtotime($cDate. ' -2 days'));
               $fiveDayName = date('D', strtotime($cDate. ' -2 days'));
         $fiveDay=coldcallingModel::whereDate('updated_at', '=', $five)->where('user_id',session('user_id'))->where('update_from','property')->count();
     //Graph secound line cold-calling
       $fiveCold=coldCallingModel::whereDate('updated_at', '=', $five)->where('user_id',session('user_id'))->where('update_from','coldcalling')->count();
    
               $six = date('Y-m-d', strtotime($cDate. ' -1 days'));
               $sixDayName = date('D', strtotime($cDate. ' -1 days'));
         $sixDay=coldcallingModel::whereDate('updated_at', '=', $six)->where('user_id',session('user_id'))->where('update_from','property')->count();
           // $sixDay=count($sixDay);
     //Graph secound line cold-calling
       $sixCold=coldCallingModel::whereDate('updated_at', '=', $six)->where('user_id',session('user_id'))->where('update_from','coldcalling')->count();
       $current = date('Y-m-d', strtotime($cDate. ' -0 days'));
       $currentDayName = date('D', strtotime($cDate. ' -0 days'));
         $currentDay=coldcallingModel::whereDate('updated_at', '=', $current)->where('user_id',session('user_id'))->where('update_from','property')->count();
       $currentCold=coldCallingModel::whereDate('updated_at', '=', $current)->where('user_id',session('user_id'))->where('update_from','coldcalling')->count();
       $cDateTime=date('Y-m-d H:i:s');
       $activity = date('Y-m-d H:i:s', strtotime($cDateTime. '-24 hours'));
          $agentActivity=coldcallingModel::whereDate('updated_at', '>=', $activity)->latest()->count();
        $todayDate = new DateTime('today');

        $datetime = new DateTime('tomorrow');
          
        $reminders = Reminder::where('user_id',session('user_id'))
         ->where(function($q) {
            $todayDate = new DateTime('today');
            $datetime = new DateTime('tomorrow');
             $q->whereDate("date_time",$datetime->format('Y-m-d'))
               ->orWhereDate("date_time",$todayDate->format('Y-m-d'));
         })->get();
    // $reminders = Reminder::where('user_id',session('user_id'))->whereDate("date_time",$datetime->format('Y-m-d'))->orWhereDate("date_time",$todayDate->format('Y-m-d'),'user_id',session('user_id'))->get();
    // dd($reminders);
    $latestProperties = coldcallingModel::whereDate("created_at",$todayDate->format('Y-m-d'))->where('user_id',session('user_id'))->get();
    $latestLeads = lead::whereDate("created_at",$todayDate->format('Y-m-d'))->where('lead_user',$fname)->get();

    $description = 'Dashboard page visited.';
    Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>$description]);
	return view('agentDashboard',compact(['properties','leads',
                'firstDay','secondDay','thirdDay','fourDay','fiveDay','sixDay','currentDay','firstCold','secondCold','thirdCold','fourCold','fiveCold','sixCold','currentCold','coldCallings','permissions',"reminders","latestProperties","latestLeads","firstDayName","secondDayName","thirdDayName","fourDayName","fiveDayName","sixDayName","currentDayName","properties_rent","properties_sale"]));
    }
    public function allAddedProperties(Request $request){
        
        //permission 
          $permissions = permission::where('user_id', session('user_id'))->first();
          //end permission
         $areas=coldcallingModel::where('user_id',session('user_id'))->distinct('area')->pluck('area');
         $bedrooms=coldcallingModel::distinct('Bedroom')->pluck('Bedroom');
    	 $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
    	 $agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
         $buildings=coldcallingModel::where('user_id',session('user_id'))->distinct('Building')->pluck('Building');
         $allBuildings=Building::select("building_name")->orderBy("building_name","ASC")->get();
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
                    $query->where("bedroom",$request->bedroom);
                }
                if($request->unit_no){
                    $query->where("unit_no",$request->unit_no);
                }
                $result_data = $query->where(['user_id'=>session('user_id')])->orderBy('updated_at', 'DESC')->paginate(20);
                $Recorddisplay = 'block'; $Formdisplay = 'none';
                $reminders = Reminder::orderBy('date_time', 'DESC')->get();
                // dd($reminders);
                $current_date = date('Y-m-d H:i:s');
                // dd($current_date);

                $description = 'Properties page visited';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>$description]);
                return view('agentProperties',compact(['result_data','users','agents','areas','bedrooms','buildings','allBuildings','permissions','Recorddisplay', 'Formdisplay','reminders','current_date']));
            
    }
   
    public function filterAgentProperties(){
        if(isset($_GET['type'])){
            if($_GET['type']=='sale'){
                 $properties=Building::where('assigned_agent',session('user_name'))->pluck('building_name');
               $result_data=coldcallingModel::where(['access'=>'For Sale','property_status'=>'edenfort_property','add_by'=>session('user_id')])->get();
                $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                $agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
                 $buildings=Building::all();
                 $allPropertiesArea = coldcallingModel::all();

                 $description = 'Sale Properties page visited';
                 Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>$description]);
                return view('agentProperties',compact(['result_data','users','agents','buildings','allPropertiesArea']));
            }else if($_GET['type']=='rent'){
                 $properties=Building::where('assigned_agent',session('user_name'))->pluck('building_name');
                $result_data=coldcallingModel::where(['access'=>'For Rent','property_status'=>'edenfort_property','add_by'=>session('user_id')])->get();
                $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                $agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
                 $buildings=Building::all();
                 $allPropertiesArea = coldcallingModel::all();

                $description = 'Rent Properties page visited';
                 Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>$description]);
                return view('agentProperties',compact(['result_data','users','agents','buildings','allPropertiesArea']));
            }
            else if($_GET['type']=='upcoming'){
                 $properties=Building::where('assigned_agent',session('user_name'))->pluck('building_name');
                $result_data=coldcallingModel::where(['access'=>'upcoming','property_status'=>'edenfort_property','add_by'=>session('user_id')])->get();
                $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
                $agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
                 $buildings=Building::all();
                 $allPropertiesArea = coldcallingModel::all();

                  $description = 'Upcoming Properties page visited';
                 Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>$description]);
                return view('agentProperties',compact(['result_data','users','agents','buildings','allPropertiesArea']));
            }
        }else{
                 $buildings=Building::all();
                $properties=Building::where('assigned_agent',session('user_name'))->pluck('building_name');
                 $result_data=coldcallingModel::where(["property_status"=>'edenfort_property','add_by'=>session('user_id')])->get();
                $agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
                $allPropertiesArea = coldcallingModel::all();

                 $description = 'Properties page visited';
                 Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>$description]);
                return view('agentProperties',compact(['result_data','buildings','agents','allPropertiesArea']));
            }
    }
    public function bulkUpdateStatusProperty(Request $r){
        $status=$r->status;
        $check_boxes=$r->check_boxes;
        $comment = $r->comment;
       foreach($check_boxes as $key=>$value){
           $data = coldcallingModel::where("id",$check_boxes[$key])->first();
            if(isset($check_boxes[$key])){
                $data=array(
                   'access' => $status,
                   'comment' => $comment[$key],
                   'update_from' => 'property',
                );
               coldcallingModel::where("id",$check_boxes[$key])->update($data);
              
            }

            $description = 'Status and access updated for property => '.$data->Building. ', Unit No => '.$data->unit_no. ', Area => '.$data->area;
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>$description]);
        }
         return 'true';
    }
     public function setReminderForProperty(Request $r){
        try{
            $timedate = date('Y-m-d H:i:s', strtotime(input::get('time_date')));
            $check_boxes=input::get('check_boxes');
            $comment = $r->comment;
            foreach($check_boxes as $key=>$value){
                $data = coldcallingModel::where("id",$check_boxes[$key])->first();
                if(isset($check_boxes[$key])){
                  $data=array(
                        'access' => input::get('status'),
                        'comment' => $comment[$key],
                        'update_from' => 'property',

                    );
                   coldcallingModel::where("id",$check_boxes[$key])->update($data);
                   $reminder= new Reminder();
                   $reminder->property_id=$check_boxes[$key];
                   $reminder->date_time=$timedate;
                   $reminder->description=strip_tags(input::get('description'));
                   $reminder->reminder_type=strip_tags(input::get('status'));
                   $reminder->reminder_of="PROPERTY";
                   $reminder->add_by="AGENT";
                   $reminder->user_id=session('user_id');
                   $reminder->save();
                }
                $description = 'Set remidner for property => '.$data->Building. ', Unit No => '.$data->unit_no. ', Area => '.$data->area;
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>$description]);
            }
                return "true";
            }catch(\Exception $e){
                return '<div class="alert alert-danger" style="font-size: 11px;
        margin-top: 2%;">something went wrong</div>';
            }
        }
  public function Addproperty(){
        $sale_status=NULL;
        $rented_date=NULL;
        $rented_price=NULL;
        // $checkUnitNo=coldcallingModel::where(["unit_no"=>input::get("unit_no"),"Building"=>input::get("building")])->get();
        // if(count($checkUnitNo) > 0){
        //     return back()->with('error','Unit# already exit against this Building!');
        // }
        // $checkdewaNo=coldcallingModel::where(["dewa_no"=>input::get("dewa_no"),"Building"=>input::get("building")])->get();
        // if(count($checkdewaNo) > 0){
        //     return back()->with('msg','<div class="alert alert-danger">Dewa# already exit against this Building!</div>');
        // }
        if(input::get('sale_status')){
            $sale_status=input::get('sale_status');
            if(input::get('rented_date')){
                $rented_date=input::get('rented_date');
                $rented_price=input::get('rented_price'); 
            }
        }
    	if(isset($_POST['add_property'])){
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
	        $property->property_type=input::get("property_type");
	        $property->comment=input::get("comment");
	        $property->add_by=session('user_id');
	        $property->user_id=session('user_id');
	        $property->sale_status=$sale_status;
	        $property->rented_date=$rented_date;
            $property->rented_price=$rented_price;
	        $property->update_from='property';
	        $property->save();
            
            $description = 'New property => '.input::get("building").',Unit No => '.input::get("unit_no").', Area => '.input::get("area").' is added.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>$description]);
	        $id = DB::getPdo()->lastInsertId();
	        if(input::get('add_property_date_time')){
	            $data=array(
	                'property_id' => $id,
	                'reminder_type'=>input::get('add_property_reminder_type'),
	                'date_time'=>date('Y-m-d H:i:s', strtotime(input::get('add_property_date_time'))),
	                'description'=>input::get('add_property_reminder_description'),
	                'add_by'=>'AGENT',
	                'reminder_of' => "PROPERTY",
	                'user_id' => session('user_id'),
	           );
	           DB::table('reminders')->insert($data);
               $description = 'Reminder added for '.input::get("building").',Unit No => '.input::get("unit_no").', Area => '.input::get("area");
               Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Properties','description'=>$description]);
	        }
	        return redirect("allAddedProperties")->with('msg','Property Added Successfully!');
	    }else{
	    	return redirect("allAddedProperties")->with('error','something went wrong');
	    }
    }
       public function agentBuildings(){
           //permission 
          $permissions = permission::where('user_id', session('user_id'))->first();
          
          //end permission
    	$result_data=Building::where('assigned_agent',session('user_name'))->get();
        $building=Building::where('user_id',session('user_id'))->get();

         $description = 'Building page visited.';
         Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Buildings','description'=>$description]);
        return view('agentBuildings',['result_data'=>$result_data,'building'=>$building,'permissions'=>$permissions]);
    }
     public function viewAgentProperties(){
    	$result_data=coldcallingModel::where('Building',Input::get('name'))->get();
        
        return view('agentBuildings',['result_data'=>$result_data,'heading'=>'Properties']);

    }
    public function agentProperties(){
        $agent_id = $_GET['agentId'];
        $properties =coldcallingModel::where('add_by',$agent_id)->get();
        $properties = json_encode($properties, true);
        $description = 'Get agent properties.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'properties','description'=>$description]);
        return $properties;
        
    }
    public function buildingProperties(){

        $building_name = $_GET['building_name'];
        $properties =coldcallingModel::where(['Building'=>$building_name,'property_status'=>'edenfort_property'])->get();
        $properties = json_encode($properties, true);
        return $properties;

    }
    public function bedProperties(){

        $bedroom = $_GET['bed_id'];
        $properties =coldcallingModel::where(['Bedroom'=>$bedroom,'property_status'=>'edenfort_property'])->get();
        $properties = json_encode($properties, true);
        return $properties;

    }
    public function areaProperties(){

        $area = $_GET['area'];
        $properties =coldcallingModel::where(['area'=>$area,'property_status'=>'edenfort_property'])->get();
        $properties = json_encode($properties, true);
        return $properties;

    }
    
    public function insert_agentBuilding(){
	    	$building=new Building();
	    	$building->building_name=input::get('building_name');
            $name=input::get('building_name');
	    	$building->user_id=session('user_id');
            $building_name=DB::select("select building_name from buildings where building_name='$name'");
             if(count($building_name) > 0)
             {
             return redirect("agent-buildings")->with('error','Building already exist!');
             }
             else{
            $building->save();     
            $building=DB::table('buildings')->where('user_id',session('user_id'))->get();
            $description = 'New building => '.input::get('building_name').' is added.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Buildings','description'=>$description]);
            return redirect("agent-buildings")->with('msg','Building Successfully added!');
             }
     }
     
     public function deleteBuilding(){
    	if(isset($_GET['action'])=='delete' && isset($_GET['id'])){
	    	Building::where('id',input::get('id'))->delete();
            $description = 'Building deleted.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Buildings','description'=>$description]);
	    	return redirect("agent-buildings")->with('msg','Building Deleted Successfully!');
	    }else{
	    	return redirect("agent-buildings")->with('error','Something went wrong!');
	    }
    }
    
    public function editBuilding($id){
    	$agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
			$record=Building::where('id',$id)->first();

            $description = 'Building => '.$record->building_name.' is edited.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Buildings','description'=>$description]);
			return view("editagentBuildings",["record"=>$record]);
	   
    }
    public function assignAgent(Request $request){
    $permissions = permission::where('user_id', session('user_id'))->first();

    $agents=user::whereIn('role',[3,5])->get();
    $building=coldcallingModel::distinct('Building')->pluck('Building');
    
       if($request->building!='' and $request->agent!='')
        {
              $value=coldcallingModel::select('Building','id','user_id')->groupBy('Building')->orderBy(\DB::raw('count(Building)'), 'DESC')->where('Building', 'LIKE',"%$request->building%")->where(['user_id'=>$request->agent])->paginate(50);
       }else if($request->agent!='')
        {
              $value=coldcallingModel::select('Building','id','user_id')->groupBy('Building')->orderBy(\DB::raw('count(Building)'), 'DESC')->where(['user_id'=>$request->agent])->paginate(50);
       }else if($request->building!='')
        {
              $value=coldcallingModel::select('Building','id','user_id')->groupBy('Building')->orderBy(\DB::raw('count(Building)'), 'DESC')->where('Building', 'LIKE',"%$request->building%")->paginate(50);
       }else
       {
          $value=coldcallingModel::select('Building','id','user_id')->groupBy('Building')->orderBy(\DB::raw('count(Building)'), 'DESC')->paginate(50);
       }
        
        $description = 'Assign coldcalling page is visited.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Assign Coldcalling','description'=>$description]);
        
    	return view('assignAgent',compact(['value','agents','building','permissions']));
    }
    
    public function insertbuildingAssign(){
      
    	try{
	    	$building=new Building();
	    	$building->building_name=input::get('building_name');
	    	$building->assigned_agent=input::get('assigned_agent');
	    	$building->Save();
            $description = 'new building name => '.input::get('building_name').', assigned agent => '.input::get('assigned_agent').' added.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Buildings','description'=>$description]);
	    	return redirect("assignAgent")->with('msg','Building Successfully added!');
    	}catch(\Exception $e){
			return redirect("assignAgent")->with('error','Building already exist!');
		}
    }
    public function updateBuilding($id){
		$data=array(
    		'building_name'=>input::get('building_name'),
		);
		Building::where('id',$id)->update($data);

        $description = 'Building => '.input::get('building_name').' is updated.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Buildings','description'=>$description]);
		return redirect("agent-buildings")->with('msg','Building Updated Successfully!');
	}
    
    public function deleteBuildingAssign(){
    	if(isset($_GET['action'])=='delete' && isset($_GET['id'])){
	    	coldcallingModel::where('Building',input::get('id'))->delete();

            $description = 'Building Deleted.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Assign Agent','description'=>$description]);
	    	return redirect("assignAgent")->with('msg','Building Deleted Successfully!');
	    }else{
	    	return redirect("assignAgent")->with('error','Something went wrong!');
	    }
    }
    
    public function editBuildingAssign(){
    // 	$agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
    	//$agents=users::all()->user()->where(['role'=>'3'])->get();
    $agents=user::all();
    	/*/foreach($agents as $agent){
    	dd($agent->user->id);
    	}*/
    	if(isset($_GET['action'])=='delete' && isset($_GET['id'])){
		/*	$record=Building::where('id',input::get('id'))->first();*/
			 $record=coldcallingModel::where('id',input::get('id'))->first();

             $description = 'Building name => '.$record->Building.' is edited.';
             Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Assign Agent','description'=>$description]);
			return view("assignAgent",["record"=>$record,"Formdisplay"=>"block","Recorddisplay"=>"none",'agents'=>$agents]);
	    }else{
	    	return redirect("assignAgent")->with('error','Something went wrong!!');
	    }
    }
    
    public function updateBuildingAssign(){
	    if(isset($_GET['name'])){
	    		$date=array(
		    	//	'building_name'=>input::get('building_name'),
		    		'user_id'=>input::get('assigned_agent'),
                    'update_from' => 'property'
	    		);
	   // 		Building::where('id',input::get('id'))->update($date);
	    		coldcallingModel::where('Building',input::get('name'))->update($date);
			//	$building=new Building();
			//	 $data=array(
              //  "property_status"=>"coldCalling"
             // );
              //	coldcallingModel::where('Building',$date['building_name'])->update($data);
                $description = 'Building name => '.input::get('name').' is updated.';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Assign Agent','description'=>$description]);
	    		return redirect("assignAgent")->with('msg','Building Updated Successfully!');
			
	    }else{
	    	return redirect("assignAgent")->with('error','Something went wrong!!');
	    }
	}
	
	public function agentSidePropertyFilters(){
        if(isset($_GET['filters'])){
            $buildings=Building::all();
                $properties=Building::where('assigned_agent',session('user_name'))->pluck('building_name');
                $agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
                $allPropertiesArea = coldcallingModel::all();
                $building=input::get('building');
                $Bedroom=input::get('Bedroom');
                $area=input::get('area');
           $result_data=coldcallingModel::where(["area"=>input::get('area'),'Building'=>input::get('building'),'Bedroom'=>input::get('Bedroom'),'add_by'=>session('user_id')])->get();
           $description = 'Search for property Building => '.$building.', bedrooms => '.$Bedroom.'and area => '.$area;
           Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
           return view('agentAddProperty',compact(['result_data','buildings','agents','allPropertiesArea','building','Bedroom','area']));
        }else{
            return back();
        }
    }
    
    public function agentColdCallingSidePropertyFilters(){
        if(isset($_GET['filters'])){
            $buildings=Building::where('assigned_agent',session('user_name'))->get();
                $properties=Building::where('assigned_agent',session('user_name'))->pluck('building_name');
                $agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
                $allPropertiesArea = coldcallingModel::all();
                $building=input::get('building');
                $Bedroom=input::get('Bedroom');
                $area=input::get('area');
           $result_data=coldcallingModel::where(["area"=>input::get('area'),'Building'=>input::get('building'),'Bedroom'=>input::get('Bedroom'),'property_status'=>'cold_calling'])->get();
           $description = 'Search for property Building => '.$building.', bedrooms => '.$Bedroom.'and area => '.$area;
           Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Coldcalling','description'=>$description]);
           return view('agentcoldcalling',compact(['result_data','buildings','agents','allPropertiesArea','building','Bedroom','area']));
        }else{
            return back();
        }
    }

    public function agentProperty(){
        $properties=Building::where('assigned_agent',session('user_name'))->pluck('building_name');
        $result_data=coldcallingModel::where(["property_status"=>'edenfort_property','add_by'=>session('user_id')])->get();

        $description = 'View agent property.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
        return view('agentProperties',compact(['result_data','property']));
    } 
    public function getAgentReminderRecord(){
        $result_data=coldcallingModel::where("unit_no",input::get('unit_no'))->get();
         $property='Properties';
         $description = 'View agent remidner record.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
        return view('agentProperties',compact(['result_data','property']));
    }
    public function rentProperty(){
       $properties=Building::where('assigned_agent',session('user_name'))->pluck('building_name');
        $result_data=coldcallingModel::where(['access'=>'For Rent','property_status'=>'edenfort_property','add_by'=>session('user_id')])->get();
         $property='For Rent Properties';
         $description = 'View agent rent properties.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
        return view('agentProperties',compact(['result_data','property']));
    }
    public function upcomingProperty(){
      $properties=Building::where('assigned_agent',session('user_name'))->pluck('building_name');
       $result_data=coldcallingModel::where(['access'=>'Upcoming','property_status'=>'edenfort_property','add_by'=>session('user_id'),'add_by'=>session('user_id')])->get();
   
        $property='Upcoming Properties';
         $typeOfProperty="upcoming";
         $description = 'View agent upcoming property.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
        return view('agentProperties',compact(['result_data','property','typeOfProperty']));
    }
      public function saleProperty(){
       $properties=Building::where('assigned_agent',session('user_name'))->pluck('building_name');
       $result_data=coldcallingModel::where(['access'=>'For Sale','property_status'=>'edenfort_property','add_by'=>session('user_id')])->get();
        $property='For Sale Properties';
        $sale_status="SALE";
        $description = 'Get agent sale property.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
        return view('agentProperties',compact(['result_data','property','sale_status']));
    }
    public function addLandlordEmailPass(){
        if(input::get('email')){
            if(isset($_GET['ref'])){
                $email=coldcallingModel::where('id',input::get('id'))->pluck('email');
                $email[0].=','.input::get('email');
                coldcallingModel::where('id',input::get('id'))->update(['email'=>$email[0],'update_from'=>'property']);

                $description = 'Update landloard email.';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
                return back()->with('msg','Email updated Successfully!');
            }else{
                $email=coldcallingModel::where('id',input::get('id'))->pluck('email');
                $email[0].=','.input::get('email');
                coldcallingModel::where('id',input::get('id'))->update(['email'=>$email[0],'update_from'=>'property']);
                $description = 'Update landloard email.';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
                return back()->with('msg','Email updated Successfully!');
            }
        }else if(input::get('phone')){
            if(isset($_GET['ref'])){
                $phone=coldcallingModel::where('id',input::get('id'))->pluck('contact_no');
                $phone[0].=','.input::get('phone');
                coldcallingModel::where('id',input::get('id'))->update(['contact_no'=>$phone[0],'update_from'=>'property']);
                $description = 'Update landloard contact no.';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
                return back()->with('msg','Phone Number updated Successfully!');
            }else{
                $phone=coldcallingModel::where('id',input::get('id'))->pluck('contact_no');
                $phone[0].=','.input::get('phone');
                coldcallingModel::where('id',input::get('id'))->update(['contact_no'=>$phone[0],'update_from'=>'property']);
                $description = 'Update landloard contact no.';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
                return back()->with('msg','Phone Number updated Successfully!');
            }
        }
       
    }
    
    public function coldCalling(Request $request){
        //$buildings=Building::where('assigned_agent',session('user_name'))->get();
        $allPropertiesArea = coldcallingModel::all();
        $properties=Building::where('assigned_agent',session('user_name'))->pluck('building_name');
      $areas=coldcallingModel::distinct('area')->pluck('area');
              $bedrooms=coldcallingModel::distinct('Bedroom')->pluck('Bedroom');
              
            $agents=user::where(['role'=>3])->get();
            $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
           $buildings=coldcallingModel::distinct('Building')->where('user_id',session('user_id'))->pluck('Building');
  
       if(isset($_GET['type'])){
           // SALE
            if($_GET['type']=='sale'){
                $result_data=coldcallingModel::where(['access'=>'For Sale','user_id'=>session('user_id')])->paginate(25);
                return view('agentcoldcalling',compact(['result_data','users','agents','areas','bedrooms','buildings']));
            }
            // RENT
            else if($_GET['type']=='rent'){
               
                $result_data=coldcallingModel::where(['access'=>'For Rent','user_id'=>session('user_id')])->paginate(25);
                return view('agentcoldcalling',compact(['result_data','users','agents','areas','bedrooms','buildings']));
            }
            // UPCOMING
            else if($_GET['type']=='upcoming'){
                $result_data=coldcallingModel::where(['access'=>'UPCOMING','user_id'=>session('user_id')])->paginate(25);
                return view('agentcoldcalling',compact(['result_data','users','agents','areas','bedrooms','buildings']));
            }
            // PENDING
            else if($_GET['type']=='pending'){
                $result_data=coldcallingModel::where(['access'=>'pending','user_id'=>session('user_id')])->paginate(25);
                return view('agentcoldcalling',compact(['result_data','users','agents','areas','bedrooms','buildings']));
            }
            // INVESTOR
            else if($_GET['type']=='investor'){
                $result_data=coldcallingModel::where(['access'=>'investor','user_id'=>session('user_id')])->paginate(25);
                return view('agentcoldcalling',compact(['result_data','users','agents','areas','bedrooms','buildings']));
            }
            // CHECK OFF PLAN
            else if($_GET['type']=='offplan'){
                $result_data=coldcallingModel::where(['access'=>'off plan','user_id'=>session('user_id')])->paginate(25);
                return view('agentcoldcalling',compact(['result_data','users','agents','areas','bedrooms','buildings']));
            }
            // CHECK AVAILIBILITY
            else if($_GET['type']=='checkavailability'){
                $result_data=coldcallingModel::where(['access'=>'Check Availability','user_id'=>session('user_id')])->paginate(25);
                return view('agentcoldcalling',compact(['result_data','users','agents','areas','bedrooms','buildings']));
            }
            // IF SEARCH BUTTON IS CLICKED
        }
           if($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!=''){
           $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->paginate(25);
            }
            elseif($request->build!='' and $request->area!='' and $request->agent!=''){
           $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->paginate(25);
            }
            elseif($request->build!=''  and $request->bedroom!='' and $request->agent!=''){
           $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->paginate(25);
            }
            elseif($request->area!='' and $request->bedroom!='' and $request->agent!=''){
           $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->paginate(25);
            }
            elseif($request->build!='' and $request->agent!=''){
           $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->paginate(25);
            }
            else if($request->area!=''and $request->agent!=''){
           $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->paginate(25);
            }
            elseif( $request->bedroom!='' and $request->agent!=''){
           $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->paginate(25);
            }
            elseif($request->build!='' and $request->area!='' and $request->bedroom!=''){
           $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->paginate(25);
            }
            elseif($request->build!='' and $request->area!=''){
           $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->paginate(25);
            }
            elseif($request->build!='' and $request->bedroom!=''){
           $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->paginate(25);
            }
            elseif($request->area!='' and $request->bedroom!=''){
           $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->paginate(25);
            }
            elseif($request->build!=''){
                  $result_data=coldcallingModel::where(['Building'=>$request->build])->paginate(25);
             
             }elseif($request->area!=''){
     
                 $result_data=coldcallingModel::where(['area'=>$request->area])->paginate(25);
             }elseif($request->bedroom!=''){
                  $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where("property_status",'cold_calling')->paginate(25);
             }elseif($request->agent!=''){
//dd($request->agent);
              $result_data=coldcallingModel::where(['user_id'=>$request->agent])->paginate(25);
               
             }else{

              $result_data= coldcallingModel::where('user_id',session('user_id'))->paginate(25);
           } 
        $description = 'Coldcalling page visited.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
        return view('agentcoldcalling',compact('result_data','allPropertiesArea','buildings','areas','bedrooms','agents'));
    }
    
     public function EditProperty(){
    	$recordID=input::get("record_id");
        $action=input::get("action");
        $result=coldcallingModel::where("id",$recordID)->get();
        $result=json_decode(json_encode($result),true);
        $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
    	$agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
    	$buildings=Building::all();
        $allBuildings=Building::all();
    	$areas=coldcallingModel::distinct('area')->orderBy('updated_at', 'DESC')->get();
    	$bedrooms=coldcallingModel::distinct('Bedroom')->orderBy('updated_at', 'DESC')->get();
    	$permissions = permission::where('user_id', session('user_id'))->first();
    	$reminders=Reminder::where('property_id',$result[0]['id'])->first();

        $description = 'Property => '.$result[0]['Building'].', unit_no => '.$result[0]['unit_no'].', area => '.$result[0]['area'].' is edited.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
        return view("agentProperties",["result"=>$result,"Formdisplay"=>"block","Recorddisplay"=>"none",'users'=>$users,'agents'=>$agents,'buildings'=>$buildings,'areas'=>$areas,'bedrooms'=>$bedrooms,'reminders'=>$reminders,'allBuildings'=>$allBuildings,"permissions"=>$permissions]);
    }
    
    public function PropertyBulkActionsByAgent(){
        $check_boxes=input::get("check_boxes");
        $updated_access=input::get("updated_access"); 
        // print_r($updated_access);
        // return;
        $action=input::get("action");
        foreach($updated_access as $key=>$value){
            if($action=='Update'){
                if(isset($check_boxes[$key])){
                    if(strtoupper($updated_access[$key])==strtoupper('call back') || strtoupper($updated_access[$key])==strtoupper('upcoming') || strtoupper($updated_access[$key])==strtoupper('intrested') || strtoupper($updated_access[$key])==strtoupper('not answering')){
                         $message='<div class="alert alert-danger">Please Set Reminder for this Access!</div>';
                    }else{
                        if(strtoupper($updated_access[$key])==strtoupper('For Rent') || strtoupper($updated_access[$key])==strtoupper('For Sale')){
                            $unit_no=coldcallingModel::where("id",$check_boxes[$key])->pluck('unit_no');
                            Reminder::where('unit_no',$unit_no[0])->delete();

                            coldcallingModel::where("id",$check_boxes[$key])->update(["access"=>$updated_access[$key],"property_status"=>'edenfort_property',"add_by"=>session("user_id"),'update_from'=>'property']);

                            $description = 'Property with id => '.$check_boxes[$key].', update status => '.$updated_access[$key];
                            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
                           
                       }else{
                            coldcallingModel::where("id",$check_boxes[$key])->update(["access"=>$updated_access[$key],'update_from'=>'property']);
                            $description = 'Property with id => '.$check_boxes[$key].', update status => '.$updated_access[$key];
                            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
                       }
                       $message='Record Updated Successfully';
                     }  
                }
            }else if($action=='Delete'){
                if(isset($check_boxes[$key])){
                    $unit_no=coldcallingModel::where("id",$check_boxes[$key])->pluck('unit_no');
                    Reminder::where('unit_no',$unit_no[0])->delete();
                    if(isset($_GET['ref'])){
                        if(strtoupper($_GET['ref'])==strtoupper('coldcalling')){
                            coldcallingModel::where("id",$check_boxes[$key])->delete();
                            $description = 'Property with id => '.$check_boxes[$key].' is deleted.';
                            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
                        }
                        }else{
                            $check=coldcallingModel::where(["id"=>$check_boxes[$key],'add_by'=>session('user_id')])->delete();
                            if(!$check){
                                return back()->with('error','You Cannot Delete this Property');
                            }else{
                                $description = 'Property with id => '.$check_boxes[$key].' is deleted.';
                                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
                            }
                        }
                        $message='Record Deleted Successfully';  
                }
            }
        }
        if(isset($message)){
            return back()->with('msg',$message);
        }else{
             return back();
        }
    }
    
     public function updatePropertyByAgent(){
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
        	        'property_type'=>input::get("property_type"),
        	        'rented_price'=>$rented_price,
                    'update_from' => 'property',
                );
                $property_id=input::get("property_id");
                coldcallingModel::where("id",$property_id)->update($data);
                $description = 'Property with unit_no => '.input::get("unit_no").', building => '.input::get("building").', area => '.input::get("area").' is updated.';
                Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
                Reminder::where('property_id',input::get('id'))->delete();
                if(input::get('add_property_date_time')){
        	            $data=array(
        	                'property_id' => $property_id,
        	                'reminder_type'=>input::get('add_property_reminder_type'),
        	                'date_time'=>input::get('add_property_date_time'),
        	                'reminder_of'=>'PROPERTY',
        	                'add_by'=>'AGENT',
        	                'user_id' => session('user_id'),
        	                'description'=>input::get('add_property_reminder_description'),
        	           );
        	           DB::table('reminders')->insert($data);
                        $description = 'Reminder set for property with unit_no => '.input::get("unit_no").', building => '.input::get("building").', area => '.input::get("area").' is updated.';
                        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
        	        }
               return redirect("allAddedProperties")->with('msg','Record updated Successfully');
            }catch (\Exception $e) {
                return redirect("allAddedProperties")->with('error',$e->getMessage());
            }
        }
         else{
                return redirect("allAddedProperties")->with('error','something went wrong!');
            }
    }
    public function whatsAppMsgsForProperty(){
        $message='';
        $check_boxes=input::get('check_boxes');
        foreach($check_boxes as $key=>$value){
            $data = coldcallingModel::where('id',$value)->first();
            $message .='
                Building : '.$data->Building.'  
                Size - '.$data->Area_Sqft.'
                Price -'.$data->sale_price.'
                Type- '.$data->type.'
                Condition- '.$data->Conditions.' 

                Agent - '.$data->user->First_name.' '.$data->user->Last_name.'- '.$data->user->Phone.'
                EDEN FORT REAL ESTATE


                ';

            $description = 'Property with unit_no => '.$data->unit_no.', building => '.$data->Building.', area => '.$data->area.' sent on whatsapp.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
        }
         echo $message;
    }
        public function whatsAppOwnerMsgsForProperty(){
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

            $description = 'Property with unit_no => '.$data->unit_no.', building => '.$data->Building.', area => '.$data->area.' sent on whatsapp with owner information.';
            Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Agent Property','description'=>$description]);
        }
         echo $message;
    }
}
