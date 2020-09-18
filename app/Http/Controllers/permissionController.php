<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\permission;
use App\Models\user;
use App\Models\Clicks;
use DB;
class permissionController extends Controller {
    
    public function index(Request $r) {
        $permissions = permission::where("user_id",session("user_id"))->first();
        if (!empty($r->filterUser)) {
            $users = user::whereIn('role', [3, 4])->where("status",1)->orderBy('updated_at', 'DESC')->where('user_name', $r->filterUser)->paginate(10);
        } else {
            $users = user::whereIn('role', [3, 4])->where("status",1)->orderBy('updated_at', 'DESC')->paginate(10);
        }
        $usersall = user::whereIn('role', [3, 4])->where("status",1)->orderBy('updated_at', 'DESC')->get();

        $description = 'Permission page is visited.' ;
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'supervision','description'=>$description]);
        return view('permission', compact('users', 'usersall','permissions'));
    }
    public function permissionUpdateForm(Request $r) {
        // dd($r->prop_show_contact_info);
        $dashbordView = $r->dashbordView;
        $permissionEditId = $r->permissionEditId;
        $data = array('dashboardView' => $dashbordView, 'propertyView' => $r->propertyView, 'propertyAdd' => $r->propertyAdd, 'propertyEdit' => $r->propertyEdit, 'propertyDelete' => $r->propertyDelete, 'propertyAssign' => $r->propertyAssign, 'propertyBulk' => $r->propertyBulk, 'coldcallingView' => $r->coldcallingView, 'coldcallingAdd' => $r->coldcallingAdd, 'coldCallingAssign' => $r->coldCallingAssign, 'coldcallingBulk' => $r->coldcallingBulk, 'leadView' => $r->leadView, 'leadAdd' => $r->leadAdd, 'leadEdit' => $r->leadEdit, 'leadBulk' => $r->leadBulk, 'buildingView' => $r->buildingView, 'buildingAdd' => $r->buildingAdd, 'supervisionView' => $r->supervisionView, 'supervisionAdd' => $r->supervisionAdd, 'supervisionEdit' => $r->supervisionEdit, 'dealView' => $r->dealView, 'dealAdd' => $r->dealAdd, 'dealEdit' => $r->dealEdit, 'dealBulk' => $r->dealBulk,'loanView'=>$r->loanView,'loanEdit'=>$r->loanEdit,'loanAdd'=>$r->loanAdd,'cold_show_contact_info'=>$r->cold_show_contact_info,'prop_show_contact_info'=>$r->prop_show_contact_info,'lead_show_contact_info'=>$r->lead_show_contact_info,'deal_show_contact_info'=>$r->deal_show_contact_info);
        // dd($data);
        $success = permission::updateOrCreate(["id"=>$permissionEditId]);
        $success = permission::where('id',$permissionEditId);
        $success->update($data);
        $description = 'Permissions updated.' ;
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'supervision','description'=>$description]);
        return back()->with('msg', 'Permissions Updated!');
        
    }
}
