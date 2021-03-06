<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\property;
use App\Models\Building;
use Illuminate\Support\Facades\Input;
use DB;
use App\Models\user;
use App\Models\Reminder;
use App\Models\permission;
use App\Models\role;

class buildingController extends Controller
{
    public function index(){
    $permissions = permission::where('user_id', session('user_id'))->first();

    	$value=Building::all();
    	$agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
    	return view('addBuildings',compact(['value','agents','permissions']));
    }
    public function insertBuilding(){
    	try{
	    	$building=new Building();
	    	$building->building_name=input::get('building_name');
	    	$building->assigned_agent=input::get('assigned_agent');
	    	$building->Save();
	    	return redirect("buildings")->with('msg','<div class="alert alert-success">Building Successfully added!</div>');
    	}catch(\Exception $e){
			return redirect("buildings")->with('msg','<div class="alert alert-danger">Building already exist!</div>');
		}
    }
    public function insertBuildingByAjax(){
    	try{
	    	$building=new Building();
	    	$building->building_name=input::get('buldingName');
	    	$building->Save();
	    	return 'true';
    	}catch(\Exception $e){
			return 'false';
		}
    }
    public function deleteBuilding(){
    	if(isset($_GET['action'])=='delete' && isset($_GET['id'])){
	    	Building::where('id',input::get('id'))->delete();
	    	return redirect("buildings")->with('msg','<div class="alert alert-success">Building Deleted Successfully !</div>');
	    }else{
	    	return redirect("buildings")->with('msg','<div class="alert alert-danger">Something went wrong!!</div>');
	    }
    }
    public function editBuilding(){
    	$agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
    	if(isset($_GET['action'])=='delete' && isset($_GET['id'])){
			$record=Building::where('id',input::get('id'))->first();
			return view("addBuildings",["record"=>$record,"Formdisplay"=>"block","Recorddisplay"=>"none",'agents'=>$agents]);
	    }else{
	    	return redirect("buildings")->with('msg','<div class="alert alert-danger">Something went wrong!!</div>');
	    }
    }
    public function updateBuilding(){
	    if(isset($_GET['id'])){
	    		$date=array(
		    		'building_name'=>input::get('building_name'),
		    		'assigned_agent'=>input::get('assigned_agent'),
	    		);
	    		Building::where('id',input::get('id'))->update($date);
				$building=new Building();
				 $data=array(
                "property_status"=>"coldCalling"
              );
              property::where('Building',$date['building_name'])->update($data);
	    		return redirect("buildings")->with('msg','<div class="alert alert-success">Building Updated Successfully!</div>');
			
	    }else{
	    	return redirect("buildings")->with('msg','<div class="alert alert-danger">Something went wrong!!</div>');
	    }
	}
}
