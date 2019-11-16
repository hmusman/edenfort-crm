<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supervision;
use App\Models\SupervisionCheaque;
use App\Models\SupervisionMaintenance;
use App\Models\SupervisionComplain;
use App\Models\property;
use App\Models\Building;
use Illuminate\Support\Facades\Input;
use DB;
use App\Models\user;
use App\Models\role;
class ownerController extends Controller
{
	public function ownerDashboard(){
		$propertyData=property::where("LandLord",session('user_name'))->get();
    	$propertyusers=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='owner'");
    	$propertyagents=DB::select("SELECT a.*,b.Rule_type from users a,roles b where a.role=b.Rule_id AND b.Rule_type='agent'");
        $ownerDetails=user::where("id",session('user_id'))->first();
    	if(isset($_GET['contract_id'])){
	    	$result=supervision::where("id",input::get('contract_id'))->get();
	        $result=json_decode(json_encode($result),true);
	        if(count($result) > 0){
		        $complainRecord=SupervisionComplain::where("supervision_id",input::get('contract_id'))->get();
		        $cheaqueRecord=SupervisionCheaque::where("supervision_id",input::get('contract_id'))->get();
		        $users=user::all();
		        $total = DB::table('supervisionmaintenances')
		                ->select(DB::raw('SUM(maintenance_AED) as total'))
		                ->get();
		        $total=json_decode(json_encode($total),true);
		        
		        $maintenances=SupervisionMaintenance::where("supervision_id",input::get('contract_id'))->get();
		        return view("ownerdashboard",["result"=>$result,"complainRecord"=>$complainRecord,"cheaqueRecord"=>$cheaqueRecord,"total"=>$total,"recordID"=>input::get('contract_id'),'propertyData'=>$propertyData,'propertyusers'=>$propertyusers,'propertyagents'=>$propertyagents,'maintenances'=>$maintenances,'ownerDetails'=>$ownerDetails]);
		    }else{
		    	return view('ownerdashboard');
		    }
		}else{
			$ownerDetails=user::where("id",session('user_id'))->first();
			$result_data=supervision::where("assigned_user",session('user_name'))->get();
			return view('ownerdashboard',compact(['result_data','ownerDetails','propertyData','propertyusers','propertyagents']));
		}
	}
}
