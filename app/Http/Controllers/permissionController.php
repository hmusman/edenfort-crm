<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\permission;
use App\Models\user;
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
        return view('permission', compact('users', 'usersall','permissions'));
    }
    public function permissionUpdateForm(Request $r) {
        $dashbordView = $r->dashbordView;
        $permissionEditId = $r->permissionEditId;
        $data = array('dashboardView' => $dashbordView, 'propertyView' => $r->propertyView, 'propertyAdd' => $r->propertyAdd, 'propertyEdit' => $r->propertyEdit, 'propertyDelete' => $r->propertyDelete, 'propertyBulk' => $r->propertyBulk, 'coldcallingView' => $r->coldcallingView, 'coldcallingAdd' => $r->coldcallingAdd, 'coldcallingBulk' => $r->coldcallingBulk, 'leadView' => $r->leadView, 'leadAdd' => $r->leadAdd, 'leadEdit' => $r->leadEdit, 'leadBulk' => $r->leadBulk, 'buildingView' => $r->buildingView, 'buildingAdd' => $r->buildingAdd, 'supervisionView' => $r->supervisionView, 'supervisionAdd' => $r->supervisionAdd, 'supervisionEdit' => $r->supervisionEdit, 'dealView' => $r->dealView, 'dealAdd' => $r->dealAdd, 'dealEdit' => $r->dealEdit, 'dealBulk' => $r->dealBulk,'loanView'=>$r->loanView,'loanEdit'=>$r->loanEdit,'loanAdd'=>$r->loanAdd);
        $success = permission::updateOrCreate(["id"=>$permissionEditId]);
        $success->update($data);
        return back()->with('msg', '<div class="alert alert-success">Permissions Updated!</div>');
        
    }
}
