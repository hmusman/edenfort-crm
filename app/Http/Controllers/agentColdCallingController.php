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
use Session;
use Excel;
use File;
use Mail;
use App\Models\permission;
class agentColdCallingController extends Controller
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
        }
        return 'true';
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
            $comment=$r->comment;
            $timedate = date('Y-m-d H:i:s', strtotime(input::get('time_date')));
            $check_boxes=input::get('check_boxes');
            foreach($check_boxes as $key=>$value){
                if(isset($check_boxes[$key])){
                    $result=Reminder::where(["property_id"=>$check_boxes[$key],'reminder_of' => 'COLDCALLING','add_by' => 'AGENT'])->delete();
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
                            'comment' => $comment[$key],
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
                            'comment' => $comment[$key],
                        );
                      }
                   coldCallingModel::where("id",$check_boxes[$key])->update($data);
                   $row = coldCallingModel::where('id',$check_boxes[$key])->first();
                   $row = json_decode(json_encode($row),true);
                   unset($row['updated_at']);
                   unset($row['id']);
                   unset($row['access']);
                   $checkProperty=property::where($row)->delete();
                   $row['access']=strip_tags(input::get('status'));
                   DB::table('properties')->insert($row);
                   $reminder= new Reminder();
                   $reminder->property_id=$check_boxes[$key];
                   $reminder->date_time=$timedate;
                   $reminder->description=strip_tags(input::get('description'));
                   $reminder->reminder_type=strip_tags(input::get('status'));
                   $reminder->reminder_of="COLDCALLING";
                   $reminder->add_by="AGENT";
                   $reminder->user_id=session('user_id');
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
        Reminder::where(["property_id"=>input::get('property_id'),'reminder_of' => 'COLDCALLING','add_by' => 'AGENT'])->delete();
         $reminder= new Reminder();
         $reminder->property_id=strip_tags(input::get('property_id'));
         $reminder->date_time=$timedate;
         $reminder->description=strip_tags(input::get('description'));
         $reminder->reminder_type=strip_tags(input::get('access'));
         $reminder->reminder_of="COLDCALLING";
         $reminder->add_by="AGENT";
         $reminder->user_id=session('user_id');
         $reminder->save();
         coldCallingModel::where("id",input::get('property_id'))->update(["access" => strip_tags(input::get('access'))]);
         $row = coldCallingModel::where('id',input::get('property_id'))->first();
         $row = json_decode(json_encode($row),true);
         unset($row['updated_at']);
         unset($row['id']);
         unset($row['access']);
         $checkProperty=property::where($row)->delete();
         $row['access']=strip_tags(input::get('access'));
         DB::table('properties')->insert($row);
         return 'true';
    }
    // 
    public function updateColdCallingRow(){
         coldCallingModel::where("id",input::get('property_id'))->update(["access" => strip_tags(input::get('access'))]);
         $row = coldCallingModel::where('id',input::get('property_id'))->first();
         $row = json_decode(json_encode($row),true);
         unset($row['updated_at']);
         unset($row['id']);
         unset($row['access']);
         $checkProperty=property::where($row)->delete();
         $row['access']=strip_tags(input::get('access'));
         DB::table('properties')->insert($row);
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
        $comment=$r->comment;
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
                            'property_type' => input::get('status'),
                            'Area_Sqft' => $AreaSqft[$key],
                            'comment' => $comment[$key],
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
                            'comment' => $comment[$key],
                        );
                      }
               coldCallingModel::where("id",$check_boxes[$key])->update($data);
               $row = coldCallingModel::where('id',$check_boxes[$key])->first();
               $row = json_decode(json_encode($row),true);
               unset($row['updated_at']);
               unset($row['id']);
               unset($row['access']);
               $checkProperty=property::where($row)->delete();
               $row['access']=$status;
               DB::table('properties')->insert($row);
            }
        }
         return 'true';
    }
    // 
     public function index(Request $request){
         //permission 
          $permissions = permission::where('user_id', session('user_id'))->first();
          $buildingss = coldcallingModel::distinct('Building')->pluck('Building');
		  
		  
	  $areas=coldcallingModel::distinct('area')->pluck('area');
          $bedrooms=coldcallingModel::distinct('Bedroom')->pluck('Bedroom');   
          $agents=user::where(['role'=>3])->orWhere(['role'=>1])->get();
          $users=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
          $currentUser=session('user_id');
          $buildings=coldcallingModel::distinct('Building')->where(['user_id'=>$currentUser])->pluck('Building');
          

if(isset($_GET['p'])){

if(isset($_GET['type']))
      {
   $type=$_GET['type'];
    
       if($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''  ){
           
            if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''  ){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}


}elseif($request->build!='' and $request->area!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
   $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
            $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }

}elseif($request->area!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
     $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
            $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }

}elseif($request->area!='' and $request->bedroom!='' and $request->unit!='' and $request->contact!=''){
    
        if($request->type=="For Sale" || $request->type=="For Rent" ) {
  $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
        }else{
        
            $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
        }
        

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
   $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
          $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!=''){
    
      if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
   $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
         $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }

}elseif($request->build!='' and $request->bedroom!='' and $request->unit!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!='' and $request->contact!=''){
    
      if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->unit!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
   $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
    }else{
         $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
    }

}elseif($request->build!='' and $request->area!='' and $request->agent!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
     $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);

}
}elseif($request->build!='' and $request->area!='' and $request->agent!='' and $request->unit!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
   $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
          $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->unit!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!=''){
    
      if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->agent!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->bedroom!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->bedroom!='' and $request->agent!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->bedroom!='' and $request->agent!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->unit!='' and $request->contact!=''){
   
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->agent!='' and $request->contact!=''){
    
      if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}


}elseif($request->area!='' and $request->agent!='' and $request->unit!=''){
    
      if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->bedroom!='' and $request->contact!=''){
    
      if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->bedroom!='' and $request->unit!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->agent!='' and $request->contact!=''){
    
      if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->agent!='' and $request->unit!=''){
    
      if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!='' and $request->unit!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->agent!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->bedroom!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->agent!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->agent!='' and $request->unit!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
    $result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->bedroom!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
     $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
    }else{
        $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
    }

}elseif($request->bedroom!='' and $request->unit!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->bedroom!='' and $request->agent!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->agent!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->bedroom!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
     $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
         $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }

}elseif($request->build!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
       $result_data=coldcallingModel::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
    }else{
        $result_data=coldcallingModel::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
    }

}elseif($request->build!='' and $request->unit!=''){
    
      if($request->type=="For Sale" || $request->type=="For Rent" ) {
  $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
      }else{
          $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
      }

}elseif($request->build!='' and $request->agent!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!=''){
    
        if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
 $result_data=coldcallingModel::where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
    }else{
         $result_data=coldcallingModel::where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
    }

}elseif($request->unit!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
    $result_data=coldcallingModel::where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
          $result_data=coldcallingModel::where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }
 
}elseif($request->agent!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
 $result_data=coldcallingModel::where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
          $result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }
 
}elseif($request->bedroom!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
 $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
          $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }
 
}elseif($request->area!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
      $result_data=coldcallingModel::where(['area'=>$request->area])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
         $result_data=coldcallingModel::where(['area'=>$request->area])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
     }
 
}elseif($request->build!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

}else{
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::whereIn('access',['ForSale/ForRent',$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    
    $result_data=coldcallingModel::where(['access'=>$request->type])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->paginate(25);
}

} 
    
        }else{
        //end of type, property tabs like rent,sale etc, with
            
         // start of all properties tab, with property type commercial or residential
                    if($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''  ){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''  ){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
   $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
     $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->unit!='' and $request->contact!=''){
  $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->contact!=''){
   $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
   $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->unit!='' and $request->contact!=''){
   $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->agent!='' and $request->contact!=''){
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->contact!=''){
   $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->agent!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->contact!=''){
     $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!=''){
     $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->contact!=''){
       $result_data=coldcallingModel::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->unit!=''){
  $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->contact!=''){
 $result_data=coldcallingModel::where('contact_no', 'LIKE', "%{$request->contact}%")->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->unit!=''){
    $result_data=coldcallingModel::where(['unit_no'=>$request->unit])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);
 
}elseif($request->agent!=''){
 $result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);
 
}elseif($request->bedroom!=''){
 $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);
 
}elseif($request->area!=''){
      $result_data=coldcallingModel::where(['area'=>$request->area])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);
 
}elseif($request->build!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}else{
$result_data=coldcallingModel::where(['property_type'=>$_GET['p']])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}    

         }//end of else,search for all properties tab, with property type commercial or residential 

}else{
  //if property type not clicked as Commercial or Residential
       //starting of type   
  if(isset($_GET['type']))
      {
   $type=$_GET['type'];
    //start of search for all property with tabs, rent,sale,etc


     
          if($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''  ){
              
               if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''  ){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->unit!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
   $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
           $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
     }

}elseif($request->area!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
         $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
     }

}elseif($request->area!='' and $request->bedroom!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
   $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
         $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
     }

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
  $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
     }else{
          $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
     }

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);;
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
    
      if($request->type=="For Sale" || $request->type=="For Rent" ) {
   $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
      }else{
          $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
      }

}elseif($request->build!='' and $request->bedroom!='' and $request->unit!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->unit!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }else{
          $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }

}elseif($request->build!='' and $request->area!='' and $request->agent!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
     $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }else{ $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
        
    }

}elseif($request->build!='' and $request->area!='' and $request->agent!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}
}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
   $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }else{
         $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->agent!='' and $request->unit!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->bedroom!='' and $request->unit!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->bedroom!='' and $request->agent!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->bedroom!='' and $request->agent!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->unit!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->agent!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->agent!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->bedroom!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->bedroom!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->unit!='' and $request->contact!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->agent!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->agent!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!=''){
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);

}else{$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);}

}elseif($request->build!='' and $request->area!='' and $request->contact!=''){
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
  $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->unit!=''){
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->agent!=''){
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!='' and $request->bedroom!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->unit!='' and $request->contact!=''){
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->agent!='' and $request->contact!=''){
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}
}elseif($request->agent!='' and $request->unit!=''){
    
       if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->bedroom!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
    $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }else{
        $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }

}elseif($request->bedroom!='' and $request->unit!=''){
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->bedroom!='' and $request->agent!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->contact!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
 }else{
     $result_data=coldcallingModel::where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
 }

}elseif($request->area!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}else{
    $result_data=coldcallingModel::where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->area!='' and $request->agent!=''){
    
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
 }else{
     $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
 }

}elseif($request->area!='' and $request->bedroom!=''){
  
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
       
    }else{$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);}

}elseif($request->build!='' and $request->contact!=''){
     if($request->type=="For Sale" || $request->type=="For Rent" ) {
     $result_data=coldcallingModel::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    } else{
         $result_data=coldcallingModel::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
     }

}elseif($request->build!='' and $request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
      $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }else{
         $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }

}elseif($request->build!='' and $request->agent!=''){
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);}
   else{$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);}

}elseif($request->build!='' and $request->bedroom!=''){
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);}else{
    $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
}

}elseif($request->build!='' and $request->area!=''){
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);}else{
  $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);  
  }

}elseif($request->contact!=''){
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
 $result_data=coldcallingModel::where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }else{
      $result_data=coldcallingModel::where('contact_no', 'LIKE', "%{$request->contact}%")->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
 }

}elseif($request->unit!=''){
    
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
    $result_data=coldcallingModel::where(['unit_no'=>$request->unit])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);}else{
         $result_data=coldcallingModel::where(['unit_no'=>$request->unit])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }
 
}elseif($request->agent!=''){
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
 $result_data=coldcallingModel::where(['user_id'=>$request->agent])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);}else{ 
     $result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);}
 
}elseif($request->bedroom!=''){
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
 $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);}else{
     $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
 }
 
}elseif($request->area!=''){
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
      $result_data=coldcallingModel::where(['area'=>$request->area])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);}else{
          $result_data=coldcallingModel::where(['area'=>$request->area])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
      }
 
}elseif($request->build!=''){
    if($request->type=="For Sale" || $request->type=="For Rent" ) {
        $result_data=coldcallingModel::where(['Building'=>$request->build])->whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }else{
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
    }
    
}else{
  if($request->type=="For Sale" || $request->type=="For Rent" ) {
  $result_data=coldcallingModel::whereIn('access',['ForSale/ForRent',$request->type])->where(['user_id'=>$currentUser])->paginate(25);
      
  }else{
     
  $result_data=coldcallingModel::where(['access'=>$request->type])->where(['user_id'=>$currentUser])->paginate(25);
  
   }
}


    
        }else{
            //end of type, 
          //start of search for all property
          if($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''  ){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''  ){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->agent!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->agent!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->bedroom!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!='' and $request->bedroom!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->unit!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['unit_no'=>$request->unit])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->agent!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['user_id'=>$request->agent])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->agent!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->contact!=''){
  $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->bedroom!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$request->agent])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->contact!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->unit!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$request->agent])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->area!='' and $request->bedroom!=''){
$result_data=coldcallingModel::where(['area'=>$request->area])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->contact!=''){
  $result_data=coldcallingModel::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->unit!=''){
  $result_data=coldcallingModel::where(['Building'=>$request->build])->where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->agent!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$request->agent])->where(['user_id'=>$currentUser])->paginate(25);

}elseif($request->build!='' and $request->bedroom!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->build!='' and $request->area!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['area'=>$request->area])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->contact!=''){
 $result_data=coldcallingModel::where('contact_no', 'LIKE', "%{$request->contact}%")->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}elseif($request->unit!=''){
 $result_data=coldcallingModel::where(['unit_no'=>$request->unit])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);
 
}elseif($request->agent!=''){
 $result_data=coldcallingModel::where(['user_id'=>$request->agent])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);
 
}elseif($request->bedroom!=''){
 $result_data=coldcallingModel::where(['Bedroom'=>$request->bedroom])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);
 
}elseif($request->area!=''){
 $result_data=coldcallingModel::where(['area'=>$request->area])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);
 
}elseif($request->build!=''){
$result_data=coldcallingModel::where(['Building'=>$request->build])->where(['user_id'=>$currentUser])->where('access', null)->paginate(25);

}else{
$result_data=coldcallingModel::where('access', null)->where(['user_id'=>$currentUser])->paginate(25);

}

         } //end Else of type

      }//end Else of proprty as Commercial or Residential    
        
        
       return view('agentcoldcalling',compact(['result_data','users','agents','areas','bedrooms','buildings','buildingss','permissions']));

  

        
    }  
}