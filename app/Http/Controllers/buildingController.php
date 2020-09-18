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
use App\Models\Clicks;
use App\Models\coldcallingModel;

class buildingController extends Controller
{
    public function index(){
    $permissions = permission::where('user_id', session('user_id'))->first();

    	$value=Building::orderBy('created_at', 'DESC')->get();
    	$agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");

    	$description = 'Building page visited.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Backups','description'=>$description]);
    	return view('addBuildings',compact(['value','agents','permissions']));
    }
    public function insertBuilding(){
    	try{
	    	$building=new Building();
	    	$building->building_name=input::get('building_name');
	    	$building->assigned_agent=input::get('assigned_agent');
	    	$building->Save();
	    	$description = 'new building => '.input::get('building_name').' added.';
        	Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Buildings','description'=>$description]);
	    	return redirect("buildings")->with('msg','Building Successfully added!');
    	}catch(\Exception $e){
			return redirect("buildings")->with('error','Building already exist!');
		}
    }
    public function insertBuildingByAjax(){
    	try{
	    	$building=new Building();
	    	$building->building_name=input::get('buldingName');
	    	$building->Save();
	    	$description = 'new building => '.input::get('buldingName').' added.';
        	Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Buildings','description'=>$description]);
	    	return 'true';
    	}catch(\Exception $e){
			return 'false';
		}
    }
    public function deleteBuilding(){
    	if(isset($_GET['action'])=='delete' && isset($_GET['id'])){
	    	Building::where('id',input::get('id'))->delete();
	    	$description = 'Building with id => '.input::get('id').' is deleted.';
        	Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Buildings','description'=>$description]);
	    	return redirect("buildings")->with('msg','Building Deleted Successfully!');
	    }else{
	    	return redirect("buildings")->with('error','Something went wrong!');
	    }
    }
    public function editBuilding(){
    	$agents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
    	if(isset($_GET['action'])=='delete' && isset($_GET['id'])){
			$record=Building::where('id',input::get('id'))->first();

			$description = 'Building with id => '.input::get('id').' is edited.';
        	Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Buildings','description'=>$description]);
			return view("addBuildings",["record"=>$record,"Formdisplay"=>"block","Recorddisplay"=>"none",'agents'=>$agents]);
	    }else{
	    	return redirect("buildings")->with('error','Something went wrong!');
	    }
    }
    public function updateBuilding(){
	    if(isset($_GET['id'])){
	    		$date=array(
		    		'building_name'=>input::get('building_name'),
		    		'assigned_agent'=>input::get('assigned_agent'),
	    		);
	    		Building::where('id',input::get('id'))->update($date);
	    		$description = 'Building with id => '.input::get('id').' is updated.';
        		Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Buildings','description'=>$description]);
				$building=new Building();
				 $data=array(
                "property_status"=>"coldCalling"
              );
              coldcallingModel::where('Building',$date['building_name'])->update($data);
	    		return redirect("buildings")->with('msg','Building Updated Successfully!');
			
	    }else{
	    	return redirect("buildings")->with('error','Something went wrong!');
	    }
	}
}
