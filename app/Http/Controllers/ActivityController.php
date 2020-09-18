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
use App\Models\permission;
use Illuminate\Http\Request;
use App\Models\Clicks;

class ActivityController extends Controller
{
    public function agentsAll(){
    $permissions = permission::where('user_id', session('user_id'))->first();

		$agents = user::whereIn('role',[3,5])->get();
        $selectedAgent=input::get('agent');
        $previousDate=date("Y-m-d h:i:s",strtotime("-1 days"));
        $todayDate=date("Y-m-d h:i:s");
        $properties =property::whereBetween('updated_at',[$previousDate, $todayDate])->get();
        // dd(session('user_id'),session('user_name'));
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'AgentActivity','description'=>'Agent Activity page visited.']);
		return view('agentActivity',compact('agents','properties','permissions'));
	}
	public function agentActivityProperties(){
        $selectedAgent=input::get('agent');
        $fromDate=input::get('from_date').' '.date("h:i:s");
        $toDate=input::get('to_date').' '.date("h:i:s");
        $properties =property::whereBetween('updated_at',[$fromDate, $toDate])->where("add_by",$selectedAgent)->get();
        $agents = user::where('role',3)->get();
        $from_date=input::get('from_date');
        $to_date=input::get('to_date');
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'AgentActivity','description'=>'Agent Activity page visited.']);
        return view("agentActivity",compact('properties','agents','from_date','to_date','selectedAgent'));
    }
}
