<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\permission;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\lead;
use App\Models\Building;
use App\Models\user;
use App\Models\Reminder;
use App\Models\Clicks;
use DB;
use Mail;
use App\Http\Middleware\userPermissions;
use View;
use App\Models\loan;
class loanController  extends Controller
{
    public function __construct(){
        $this->middleware('userPermissions');
    } 
    public function index(){
        $loans = loan::orderBy('created_at','DESC')->get();
        $agents = user::select(["user_name",'id'])->where("role",3)->get();

        $description = 'Loan page is visited.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Create Lead','description'=>$description]);
        return view('loans',compact('loans','agents'));
    }
    public function addLoan(){
        $data = array(
            "agent_id" => input::get('agent_id'),
            "advance_type" => input::get('advance_type'),
            "loan_amount" => input::get('loan_amount'),
        );
        DB::table('loans')->insert($data);
        $description = 'new Loan is added';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Create Lead','description'=>$description]);
        return redirect('loans')->with('msg','Loan Added Successfully!');
    }
    public function editLoan($id){
        $record = loan::where('id',$id)->first();
        $agents = user::select(["user_name",'id'])->where("role",3)->get();
        $edit = "SET";

        $description = 'loan with id => '.$id.' is edited.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Create Lead','description'=>$description]);
        return view('loans',compact('record','agents','edit'));
    }
    public function updateLoan(){
        $data = array(
            "agent_id" => input::get('agent_id'),
            "advance_type" => input::get('advance_type'),
            "loan_amount" => input::get('loan_amount'),
        );
        DB::table('loans')->where("id",input::get('id'))->update($data);

        $description = 'loan with id => '.input::get('id').' is edited.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Create Lead','description'=>$description]);
        return redirect('loans')->with('msg','Loan Updated Successfully!');
    }
    public function addPaidAmount(){
        $currentMonth = date('d-m-Y');
        $record = loan::where('id',input::get('id'))->first();
        $data = array(
            "paid_amount" => $record->paid_amount + input::get('paid_amount'),
            "month" => Date('d-F-Y', strtotime($currentMonth . " last month")).','.input::get('paid_amount'),
        );
        DB::table('loans')->where("id",input::get('id'))->update($data);

        $description = 'In loan with id => '.input::get('id').', paid ammount => '. input::get('paid_amount').' is added.';
        Clicks::create(['user_id'=>session('user_id'),'user_name'=>session('user_name'),'page_name'=>'Create Lead','description'=>$description]);
        return redirect('loans')->with('msg','Loan Updated Successfully!');
    }
}
