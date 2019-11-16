<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\lead;
use App\Models\Building;
use App\Models\user;
use App\Models\Reminder;
use DB;
use Mail;
use App\Models\permission;
class leadController extends Controller
{
    public function agentDailyReport(){
       
        $users=user::all();
	   
	   //  $to="mrashid6649@gmail.com";
		 $to=env("MAIL_USERNAME", "email Not Found");
      $emailFromEnvFile= env("MAIL_USERNAME", "email Not Found");
      $subject="Lead Daily Report";
      
         try{
    
      $done=Mail::send('email.contactUsData', ['users'=>$users], function ($m) use ($subject,$to,$emailFromEnvFile) {
            $m->from($emailFromEnvFile, 'Edenfort');

            $m->to($to)->subject($subject);
      });
	  echo 'Mail Send';
          }catch(\Exception $e)
            {
              echo 'mail not send';
            } 
  	//    return view('email.contactUsData',compact('users'));
   }
  public function addEmailPhone(){
        if(input::get('email')){
            
                $email=lead::where('id',input::get('id'))->pluck('email');
                if($email[0]!=""){$email[0].=','.input::get('email');}else{$email[0]=input::get('email');}
                lead::where('id',input::get('id'))->update(['email'=>$email[0]]);
                return back()->with('msg','<div class="alerta lert-success">Email updated Successfully!</div>');
            
        }else if(input::get('phone')){
            
                $phone=lead::where('id',input::get('id'))->pluck('contact_no');
                $phone[0].=','.input::get('phone');
                lead::where('id',input::get('id'))->update(['contact_no'=>$phone[0]]);
                return back()->with('msg','<div class="alert alert-success">Phone Number updated Successfully!</div>');
         }
    }

     public function insertContactByAjax(){
      try{
       
        $phone=lead::where('id',input::get('leadId'))->pluck('contact_no');
         $phone[0].=','.input::get('contactNo');
                lead::where('id',input::get('leadId'))->update(['contact_no'=>$phone[0]]);

        return 'true';
      }catch(\Exception $e){
      return 'false';
    }
    }
    //bulk update leads
   public function bulkUpdateStatusLeads(Request $r){
    
        $status=$r->status;
        $check_boxes=$r->check_boxes;
        
        $followup_dateoutside=$r->followup_dateoutside;
        $leadViewDateoutside=$r->leadViewDateoutside;
        $folowUp=$r->follow_upoutside;
        $feedbackoutside=$r->feedbackoutside;
       foreach($check_boxes as $key=>$value){
            if(isset($check_boxes[$key])){
                $data=array(
                   'followup_date' => $followup_dateoutside[$key],
                   'view_date_time' => $leadViewDateoutside[$key],
                   'follow_up' => $folowUp[$key],
                   'feedback' => $feedbackoutside[$key],
                   'status' => $status,
                );
               lead::where("id",$check_boxes[$key])->update($data);
              
            }
        }
         return 'true';
    }
  public function insert(Request $r){
	  
       $agents=user::where(['role'=>'3'])->get(); 
   $buildings=Building::distinct('building_name')->get();
	 $sources=lead::distinct('lead_source')->pluck('lead_source');
	 $leads=lead::paginate(25);
  
        $created=lead::create(['submission_date'=>$r->submission_date,'client_name'=>$r->client_name,'contact_no'=>$r->contact_no,'email'=>$r->email,'lead_source'=>$r->source,'area'=>$r->area,'building'=>$r->building,'type'=>$r->type,'priority'=>$r->priority,'rent'=>$r->rent,'buy'=>$r->buy,'view_date_time'=>$r->view_date_time,'move_inn'=>$r->move_inn,'outcome'=>$r->outcome,'followup_date'=>$r->followup_date,'follow_up'=>$r->follow_up,'feedback'=>$r->feedback,'lead_user'=>session('user_name')]);
        
    //reminder insertion if some person add reminder on add Lead Popup folow up or viewdate
    if($r->reminderAddPopupDateInput!=''){
        $dateTime=$r->reminderAddPopupDateInput;
        $description=$r->reminder_descriptionAddPopup;
        $currentUser=session('user_id');
        $reminderName=$r->reminderAddPopupName;
        $addby=strtoupper(session('role'));
        $reminderLeadId=$r->reminderLeadId;
        DB::table('reminders')->insert(['date_time'=>$dateTime,'description'=>$description,'reminder_type'=>$reminderName,'reminder_of'=>'Leads','user_id'=>$currentUser,'add_by'=>$addby,'property_id'=>$reminderLeadId]);
    }
    if($r->reminderAddPopupDateInputViewDate!=''){
        $dateTime=$r->reminderAddPopupDateInputViewDate;
        $description=$r->reminder_descriptionAddPopupViewDate;
        $currentUser=session('user_id');
        $reminderName=$r->reminderAddPopupViewDateName;
        $addby=strtoupper(session('role'));
        $reminderLeadId=$r->reminderLeadId;
        DB::table('reminders')->insert(['date_time'=>$dateTime,'description'=>$description,'reminder_type'=>$reminderName,'reminder_of'=>'Leads','user_id'=>$currentUser,'add_by'=>$addby,'property_id'=>$reminderLeadId]);
    }
    //end reminder
     return Redirect::back();
  }
  
 //update lead form
 public function update(Request $r)
    {   $agents=user::where(['role'=>'3'])->get(); 
    $buildings=Building::distinct('building_name')->get();
	 $sources=lead::distinct('lead_source')->pluck('lead_source');
	  $leads=lead::paginate(25);
      
	  
        $update=['client_name'=>$r->client_name,'area'=>$r->area,'building'=>$r->building,'type'=>$r->type,'priority'=>$r->priority,'rent'=>$r->rent,'buy'=>$r->buy,'view_date_time'=>$r->leadViewDate,'move_inn'=>$r->move_inn,'outcome'=>$r->outcome,'followup_date'=>$r->followup_date,'follow_up'=>$r->follow_up,'feedback'=>$r->feedback,'lead_user'=>session('user_name')];
     lead::where(['id'=>$r->leadEditId])->update($update);
     return Redirect::back();
  }

  public function agentLeads(){
     // dd(str_replace(session('user_name')));
    // dd(session('user_name'));
    //  $string = str_replace(' ','',$u); 
    // dd($string);
    $u=session('fname');
       $leads=lead::where('lead_user', 'LIKE', "%{$u}%")->get();
 
      return view('leads',['leads'=>$leads]);
  }

  public function assignLead(Request $r){
    $agents=user::where(['role'=>'3'])->get(); 
    $buildings=Building::distinct('building_name')->get();
	 $sources=lead::distinct('lead_source')->pluck('lead_source');
	
     $leads=lead::paginate(25);
  
  
    // dd($r->assignedLeadId,$r->assignedAgent); 
      $update=lead::where(['id'=>$r->assignedLeadId])->update(['lead_user'=>$r->assignedAgent]); 
     
    
	return Redirect::back();
	 
  }
  
    public function index(Request $request){
    $permissions = permission::where('user_id', session('user_id'))->first();
    $agents=user::where(['role'=>3])->get();
    $buildings=Building::distinct('building_name')->get();
    $sources=lead::distinct('lead_source')->pluck('lead_source');
	$dbName=DB::getDatabaseName();
	$upcomingLeadId = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'leads'");
    $findBuilding=$request->build;
    $findSource=$request->source;
    $findAgent=$request->agent;
    $findContact=$request->contact;
    $lead=lead::all();
    $rem=Reminder::all();
    $lists = [];
    foreach($rem as $l){
        if($l->lead['id']){
            $lists[]=$l->lead['id'];
        }
    }
    // QUERY START FROM HERE
    $query = lead::query();
    if($request->type){
        $type=$request->type;
        if($type=="Reminder"){
            $query->whereIn('id', $lists);
        }else{
            $query->where('type',$type);
        }
    }
    if($request->priority){
        $priority=$request->priority;
        $query->where('priority',$priority);
    }
    if($request->build){
        $query->where("Building",$request->build);
    }
     if($request->source){
        $query->where("subject",$request->source);
    }
    if($request->agent){
        $agent = $request->agent;
        $agent = strtolower(str_replace(" ","%",$agent));
        $query->where("lead_user",'LIKE',"%{$agent}%");
        
    }
    if($request->contact){
        $query->where('contact_no', 'LIKE', "%{$request->contact}%");
    }
    $leads = $query->orderBy('created_at','DESC')->paginate(25);
    return view('agentLeadReport',['leads'=>$leads,'buildings'=>$buildings,'agents'=>$agents,'sources'=>$sources,'upcomingLeadId'=>$upcomingLeadId,'permissions'=>$permissions]);
    
    
    // if(isset($_GET['type'])){
    //  $type=$request->type;
    //  $priority=$request->priority;
    //      if($request->build!='' and $request->source!='' and $request->contact!='' and $request->agent!=''){
             
    //           if($request->priority!='') {
    //   $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //           } else{
    //             if($request->priority!='') {
    //             $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //             }else{
    //                  $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //             }
    //           }
    //     }
    //     elseif($request->build!='' and $request->source!='' and $request->agent!=''){
            
    //          if($request->priority!='') {
    //   $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //          }else{
                 
    //               if($request->priority!='') {
    //          $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where(['lead_user'=>$request->agent])->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25); 
    //               }else{
    //                   $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);    
    //               }
    //          }
             
    //     }
    //     elseif($request->build!=''  and $request->contact!='' and $request->agent!=''){
    //          if($request->priority!='') {
    //   $leads=lead::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //          }else{
                 
    //               if($request->priority!='') {
    //               $leads=lead::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //               }else{
    //                      $leads=lead::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //               }
    //          }
    //     }
    //     elseif($request->source!='' and $request->contact!='' and $request->agent!=''){
            
    //         if($request->priority!='') {
    //   $leads=lead::where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //         }else{
                
    //             if($request->priority!='') {
    //             $leads=lead::where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //             }else{
    //                  $leads=lead::where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //             }
    //         }
       
    //     }
    //     elseif($request->build!='' and $request->agent!=''){
            
    //         if($request->priority!='') {
    //   $leads=lead::where(['Building'=>$request->build])->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //         }else{
                
    //             if($request->priority!='') {
    //               $leads=lead::where(['Building'=>$request->build])->where(['lead_user'=>$request->agent])->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //             }else{
    //                 $leads=lead::where(['Building'=>$request->build])->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //             }
    //         }
       
    //     }
    //     else if($request->source!=''and $request->agent!=''){
            
    //          if($request->priority!='') {
    //   $leads=lead::where(['subject'=>$request->source])->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //          }else{
                 
    //               if($type=="Reminder"){
    //              $leads=lead::where(['subject'=>$request->source])->where(['lead_user'=>$request->agent])->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //               }else{
    //                   $leads=lead::where(['subject'=>$request->source])->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //               }
    //          }
       
    //     }
    //     elseif( $request->contact!='' and $request->agent!=''){
            
    //         if($request->priority!='') {
    //   $leads=lead::where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //         }else{
                
    //              if($type=="Reminder"){
    //              $leads=lead::where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //              }else{
    //                   $leads=lead::where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //              }
    //         }
       
    //     }
    //     elseif($request->build!='' and $request->source!='' and $request->contact!=''){
            
    //          if($request->priority!='') {
    //   $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //          }else{
                 
    //               if($type=="Reminder"){
    //              $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //               }else{
    //                   $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //               }
    //          }
       
    //     }
    //     elseif($request->build!='' and $request->source!=''){
            
    //         if($request->priority!='') {
    //   $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //         }else{
    //              if($type=="Reminder"){
    //             $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //              }else{
    //                   $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //              }
    //         }
         
    //     }
    //     elseif($request->build!='' and $request->contact!=''){
            
    //         if($request->priority!='') {
    //   $leads=lead::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //         }else{
                
    //             if($type=="Reminder"){
    //               $leads=lead::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //             }else{
    //                  $leads=lead::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //             }
    //         }
       
    //     }
    //     elseif($request->source!='' and $request->contact!=''){
            
    //          if($request->priority!='') {
    //   $leads=lead::where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //          }else{
                 
    //               if($type=="Reminder"){
    //              $leads=lead::where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //               }else{
    //                   $leads=lead::where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //               }
    //          }
       
    //     }
    //     elseif($request->build!=''){
            
    //           if($request->priority!='') {
    //           $leads=lead::where(['Building'=>$request->build])->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //           }else{
                  
    //               if($type=="Reminder"){
    //                 $leads=lead::where(['Building'=>$request->build])->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //               }else{
    //             $leads=lead::where(['Building'=>$request->build])->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //               }
                    
    //           }
              
    //      }elseif($request->source!=''){
             
    //           if($request->priority!='') {
    //          $leads=lead::where(['subject'=>$request->source])->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //           }else{
                  
    //               if($type=="Reminder"){
    //       $leads=lead::where(['subject'=>$request->source])->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //               }else{
    //                     $leads=lead::where(['subject'=>$request->source])->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //               }
    //           }
              
    //      }elseif($request->contact!=''){
             
    //          if($request->priority!='') {
    //   $leads=lead::where('contact_no', 'LIKE', "%{$request->contact}%")->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //          }else{
                 
    //              if($type=="Reminder"){
    //              $leads=lead::where('contact_no', 'LIKE', "%{$request->contact}%")->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //              }else{
    //                  $leads=lead::where('contact_no', 'LIKE', "%{$request->contact}%")->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //              }
    //          }
             
    //      }elseif($request->agent!=''){
             
    //           if($request->priority!='') {
    //       $leads=lead::where(['lead_user'=>$request->agent])->where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //           }else{
                  
    //               if($type=="Reminder"){
    //               $leads=lead::where(['lead_user'=>$request->agent])->whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
    //               }else{
    //                      $leads=lead::where(['lead_user'=>$request->agent])->where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25);
    //               }
    //           }
    //      }else{
          
    //         if($request->priority!='') {
    //           $leads=lead::where('type',$type)->where('priority',$priority)->orderBy('updated_at','DESC')->paginate(25);
    //             }else{
                    
                      
    //               	if($type=="Reminder"){
    
    //             $leads=lead::whereIn('id', $lists)->orderBy('updated_at','DESC')->paginate(25);
               
    //               	}else{
    //               	   $leads=lead::where('type',$type)->where('priority','')->orderBy('updated_at','DESC')->paginate(25); 
    //               	}
                  	
    //                  }
    // 		}
    // }
    // else
    // {
    //  if($request->build!='' and $request->source!='' and $request->contact!='' and $request->agent!=''){
    //   $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //     }
    //     elseif($request->build!='' and $request->source!='' and $request->agent!=''){
    //   $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where(['lead_user'=>$request->agent])->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //     }
    //     elseif($request->build!=''  and $request->contact!='' and $request->agent!=''){
    //   $leads=lead::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //     }
    //     elseif($request->source!='' and $request->contact!='' and $request->agent!=''){
    //   $leads=lead::where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //     }
    //     elseif($request->build!='' and $request->agent!=''){
    //   $leads=lead::where(['Building'=>$request->build])->where(['lead_user'=>$request->agent])->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //     }
    //     else if($request->source!=''and $request->agent!=''){
    //   $leads=lead::where(['subject'=>$request->source])->where(['lead_user'=>$request->agent])->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //     }
    //     elseif( $request->contact!='' and $request->agent!=''){
    //   $leads=lead::where('contact_no', 'LIKE', "%{$request->contact}%")->where(['lead_user'=>$request->agent])->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //     }
    //     elseif($request->build!='' and $request->source!='' and $request->contact!=''){
    //   $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //     }
    //     elseif($request->build!='' and $request->source!=''){
    //   $leads=lead::where(['Building'=>$request->build])->where(['subject'=>$request->source])->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //     }
    //     elseif($request->build!='' and $request->contact!=''){
    //   $leads=lead::where(['Building'=>$request->build])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //     }
    //     elseif($request->source!='' and $request->contact!=''){
    //   $leads=lead::where(['subject'=>$request->source])->where('contact_no', 'LIKE', "%{$request->contact}%")->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //     }
    //     elseif($request->build!=''){
    //           $leads=lead::where(['Building'=>$request->build])->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //      }elseif($request->source!=''){
    //          $leads=lead::where(['subject'=>$request->source])->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //      }elseif($request->contact!=''){
    //           $leads=lead::where('contact_no', 'LIKE', "%{$request->contact}%")->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //      }elseif($request->agent!=''){
    //       $leads=lead::where(['lead_user'=>$request->agent])->whereNotIn('id',$lists)->orderBy('updated_at','DESC')->paginate(25);
    //         //  dd($request->agent);
    //      }else{
         
    // $leads=lead::whereNotIn('id',$lists)->orderBy('updated_at','DESC')->orderBy('updated_at','DESC')->paginate(25);
    
    // }
    // }
    
  }
}
