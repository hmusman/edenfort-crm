<?php

namespace App\Http\Controllers;

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
use App\Models\Reminder;
use App\Models\role;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function agentsAll(){
		$agents = user::where('role',3)->get();
        $selectedAgent=input::get('agent');
        $previousDate=date("Y-m-d h:i:s",strtotime("-1 days"));
        $todayDate=date("Y-m-d h:i:s");
        $properties =property::whereBetween('updated_at',[$previousDate, $todayDate])->get();
		return view('agentActivity',compact('agents','properties'));
	}
	public function agentActivityProperties(){
        $selectedAgent=input::get('agent');
        $fromDate=input::get('from_date').' '.date("h:i:s");
        $toDate=input::get('to_date').' '.date("h:i:s");
        $properties =property::whereBetween('updated_at',[$fromDate, $toDate])->where("add_by",$selectedAgent)->get();
        $agents = user::where('role',3)->get();
        $from_date=input::get('from_date');
        $to_date=input::get('to_date');
        return view("agentActivity",compact('properties','agents','from_date','to_date','selectedAgent'));
    }
}
