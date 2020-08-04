<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\submittedProperty;
use DB;
use App\Models\property;
use App\Models\permission;
class submittedPropertyController extends Controller
{
    public function index(Request $r){
   
       $permissions = permission::where("user_id",session("user_id"))->first();

        $access=$r->access;
        $contact_no=$r->contact;
        $conditions = [];
    if(@$_GET['type'])
    {
        $type=$_GET['type'];
        
       
          if(empty($access) and empty($contact_no) )
          {
               if($type=="For Sale" || $type=="For Rent" ) {
                $result=submittedProperty::where('type',$type)->orderBy('updated_at', 'DESC')->paginate(10);
                   }else{
              
      $result=submittedProperty::where('access',$type)->orderBy('updated_at','DESC')->paginate(10);
                   }
     
          }else{
              
               if($type=="For Sale" || $type=="For Rent" ) {
               $result=submittedProperty::where('type',$type)->where('id','!=','0');
   
     
  if(! empty($access)) {
    $result = $result->where('access',$access);
    }
  if(! empty($contact_no)) {
    $result =  $result->where('contact_no', 'LIKE', "%{$contact_no}%");
    }
    $result=$result->orderBy('updated_at','DESC')->paginate(10);
           }else{
     
    $result=submittedProperty::where('access',$type)->where('id','!=','0');
   
     
  if(! empty($access)) {
    $result = $result->where('access',$access);
    }
  if(! empty($contact_no)) {
    $result =  $result->where('contact_no', 'LIKE', "%{$contact_no}%");
    }
    $result=$result->orderBy('updated_at','DESC')->paginate(10);
                   }
                   
              }
        
        
    }else{
        
 if(empty($access) and empty($contact_no) ){
  $result=submittedProperty::orderBy('updated_at','DESC')->paginate(10);
   
}else{
     
    $result=submittedProperty::where('id','!=','0');

  if(! empty($access)) {
    $result = $result->where('access',$access);
    }
  if(! empty($contact_no)) {
    $result =  $result->where('contact_no', 'LIKE', "%{$contact_no}%");
    }
    $result=$result->orderBy('updated_at','DESC')->paginate(10);

}

}//end else of get type

$properties=$result;
    	return view('submittedProperty',compact('properties', 'permissions'));
    }



    public function update(Request $g){
  try{
$id=$g->get('propertyId');
  $unit=$g->get('unit_no');
$Building=$g->get('Building');
$area=$g->get('area');
$LandLord=$g->get('LandLord');
$email=$g->get('email');
$contact_no=$g->get('contact_no');
$Bedroom=$g->get('Bedroom');
$Washroom=$g->get('Washroom');
$Conditions=$g->get('Conditions');
$Area_Sqft=$g->get('Area_Sqft');
$Price=$g->get('Price');
$type=$g->get('type');
  	

    	DB::table('submittedproperties')->where('id',$id)->update(['unit_no'=>$unit,'Building'=>$Building,'area'=>$area,'LandLord'=>$LandLord,'email'=>$email,'contact_no'=>$contact_no,'Bedroom'=>$Bedroom,'Washroom'=>$Washroom,'Conditions'=>$Conditions,'Area_Sqft'=>$Area_Sqft,'Price'=>$Price,'type'=>$type]);
    	return back()->with('msg','Property Updated Successfully!');
      //  print_r($countries);
  }catch(\Exception $e){
     return back()->with('error','Proprty Not Updated!');
    }
    }

public function bulkUpdateSubmittedProperty(Request $r){
    
        //$status=$r->status;
        $check_boxes=$r->check_boxes;
     
        $access=$r->status;
       foreach($check_boxes as $key=>$value){
            if(isset($check_boxes[$key])){
                $data=array(
                   'access' => $access,
                 );
               DB::table('submittedproperties')->where("id",$check_boxes[$key])->update($data);
              
            }
        }//end of changing status

//start of clone a property
   $allcheckRows=[];
   $allproperties=[];
   $a;
   $msg=[];
if($access=="Transferred"){
    
      $pUnit=$r->pUnit; 
      $pLandlord=$r->pLandlord; 
      $pContact=$r->pContact; 
      $pEmail=$r->pEmail; 
      $pBuilding=$r->pBuilding;
      $pArea=$r->pArea; 
      $pCondition=$r->pCondition; 
      $pBedrooms=$r->pBedrooms; 
      $pWashrooms=$r->pWashrooms; 
      $pType=$r->pType; 
      $pArea_Sqft=$r->pArea_Sqft; 
      $pPrice=$r->pPrice; 
  
      foreach($check_boxes as $key=>$value){
            if(isset($check_boxes[$key])){
                
                $allowInsert=property::where('unit_no',$pUnit[$key])->where('Building',$pBuilding[$key])->get();
                
                $data=array(
                  'unit_no'=>$pUnit[$key],'Building'=>$pBuilding[$key],'area'=>$pArea[$key],'LandLord'=>$pLandlord[$key],'email'=>$pEmail[$key],'contact_no'=>$pContact[$key],'Bedroom'=>$pBedrooms[$key],'Washroom'=>$pWashrooms[$key],'Conditions'=>$pCondition[$key],'Area_Sqft'=>$pArea_Sqft[$key],'Price'=>$pPrice[$key],'access'=>$pType[$key]);
                  if($allowInsert->isEmpty()){               
               DB::table('properties')->insert($data);
               
                   }else{
                       $msg[]="Unit# ".$pUnit[$key]." with this ".$pBuilding[$key]."  Already Transferred!";
                       // return back()->with('error',$msg);
                   }
            }
        }
}
     //return tru to ajax success function   
     if(empty($msg)){
       return 'true' ;
}else{ return $msg;}
    }


}
