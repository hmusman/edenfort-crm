<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\deal;
use App\Models\user;
use App\Models\Building;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\permission;
class dealController extends Controller {
    public function months() {
        $month = DB::table('months')->first();
        return view('open-close-months', compact('month'));
    }
    public function closeMonth() {
        $month = DB::table('months')->first();
        $nextMonth = date('Y-m-d', strtotime('first day of +1 month'));
        $month = DB::table('months')->update(["month" => $nextMonth]);
        return back()->with('success', "<div class='alert alert-success'>Month Closed Successfully! <br><b>Next Month Opened Automatically</b></div>");
    }
    public function getRecentDeals() {
        $date = explode("-", input::get('current'));
        if (input::get('current')) {
            $currentMonth = $date[1];
            $currentYear = $date[0];
        } else {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
        }
        $agents = user::where(['role' => 3])->paginate(10);
        return view('previous-deals', compact('agents', 'currentMonth', 'currentYear'));
    }
    public function getDeals() {
        $month = DB::table('months')->select('month')->where('status', 'open')->first();
        $agents = user::where(['role' => 3])->paginate(10);
        return view('dealsAccountStatement', compact('agents', 'month'));
    }
    public function index(Request $request) {
        $buildings = Building::all();
        $agents = user::where(['role' => 3])->get();
        $query = deal::query();
        $getAgentName = '';
        if($request->start_date){
            $query->where("deal_start_date",">=",$request->start_date);
        }
        if($request->end_date){
            $query->where("deal_start_date","<=",$request->end_date);
        }
        if($request->agent){
            $getAgentName = user::find($request->agent);
            $query->where("agent_name","<=",$request->agent);
        }
        $deals = $query->orderBy("created_at","DESC")->paginate(20);
        $permissions = permission::where('user_id', session('user_id'))->first();
        $dbName = DB::getDatabaseName();
        $upcomingDealId = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'deals'");
        return view('dealsInformation', compact('getAgentName','deals', 'buildings', 'agents', 'upcomingDealId', 'permissions'));
    }
    public function insert(Request $r) {
        $buildings = Building::all();
        $agents = user::where(['role' => 3])->get();
        $created = deal::create(['deal_start_date' => $r->deal_start_date,'contract_start_date' => $r->startDate, 'contract_end_date' => $r->endDate, 'unit_no' => $r->unitNo, 'referenceNo' => $r->referenceNo, 'broker_name' => $r->brokerName, 'client_name' => $r->clientName, 'contanct_no' => $r->contactNo, 'email' => $r->email, 'ownerName' => $r->owner_name, 'ownerPhone' => $r->owner_phone, 'ownerEmail' => $r->owner_email, 'ownerNameSecond' => $r->owner_name_second, 'ownerPhoneSecond' => $r->owner_phone_second, 'ownerEmailSecond' => $r->owner_email_second, 'property_type' => $r->propertyType, 'rent_sale_value' => $r->rentSale, 'rentalCheques' => $r->rentalCheques, 'building' => $r->building, 'dealStatus' => $r->dealStatus, 'agent_name' => $r->agentName, 'gross_commission' => $r->grossCommission, 'gc_vat' => $r->gcVat, 'company_commision' => $r->companyCommission, 'cc_vat' => $r->ccVat, 'efAgentCommission' => $r->efAgentCommission, 'efAgentVat' => $r->efAgentVat, 'secondAgentName' => $r->secondAgentName, 'secondAgentCompany' => $r->secondAgentCompany, 'sacPhone' => $r->sacPhone, 'secondAgentCommission' => $r->secondAgentCommission, 'sacAgentVat' => $r->sacAgentVat, 'thirdAgentName' => $r->thirdAgentName, 'thirdAgentCompany' => $r->thirdAgentCompany, 'tacPhone' => $r->tacPhone, 'thirdAgentCommission' => $r->thirdAgentCommission, 'tacVat' => $r->tacVat, 'paymentTerms' => $r->paymentTerms, 'chequeNumber' => $r->chequeNumber, 'ownerCompanyName' => $r->ownerCompanyName, 'chequeAmount' => $r->chequeAmount, 'note' => $r->note, 'user_id' => session('user_id') ]);
        //reminder insertion if some person add reminder on add Deal Popup Contract Date
        if ($r->reminderAddPopupDateInput != '') {
            $dateTime = $r->reminderAddPopupDateInput;
            $description = $r->reminder_descriptionAddPopup;
            $currentUser = session('user_id');
            $reminderName = $r->reminderAddPopupName;
            $addby = strtoupper(session('role'));
            $reminderLeadId = $r->reminderLeadId;
            DB::table('reminders')->insert(['date_time' => $dateTime, 'description' => $description, 'reminder_type' => $reminderName, 'reminder_of' => 'Leads', 'user_id' => $currentUser, 'add_by' => $addby, 'property_id' => $reminderLeadId]);
        }
        return Redirect::back();
    }
    public function update(Request $r) {
        $update = (['deal_start_date' => $r->deal_start_date,'contract_start_date' => $r->startDate, 'contract_end_date' => $r->endDate, 'unit_no' => $r->unitNo, 'referenceNo' => $r->referenceNo, 'broker_name' => $r->brokerName, 'client_name' => $r->clientName, 'contanct_no' => $r->contactNo, 'email' => $r->email, 'ownerName' => $r->owner_name, 'ownerPhone' => $r->owner_phone, 'ownerEmail' => $r->owner_email, 'ownerNameSecond' => $r->owner_name_second, 'ownerPhoneSecond' => $r->owner_phone_second, 'ownerEmailSecond' => $r->owner_email_second, 'property_type' => $r->propertyType, 'rent_sale_value' => $r->rentSale, 'rentalCheques' => $r->rentalCheques, 'building' => $r->building, 'dealStatus' => $r->dealStatus, 'agent_name' => $r->agentName, 'gross_commission' => $r->grossCommission, 'gc_vat' => $r->gcVat, 'company_commision' => $r->companyCommission, 'cc_vat' => $r->ccVat, 'efAgentCommission' => $r->efAgentCommission, 'efAgentVat' => $r->efAgentVat, 'secondAgentName' => $r->secondAgentName, 'secondAgentCompany' => $r->secondAgentCompany, 'sacPhone' => $r->sacPhone, 'secondAgentCommission' => $r->secondAgentCommission, 'sacAgentVat' => $r->sacAgentVat, 'thirdAgentName' => $r->thirdAgentName, 'thirdAgentCompany' => $r->thirdAgentCompany, 'tacPhone' => $r->tacPhone, 'thirdAgentCommission' => $r->thirdAgentCommission, 'tacVat' => $r->tacVat, 'paymentTerms' => $r->paymentTerms, 'chequeNumber' => $r->chequeNumber, 'ownerCompanyName' => $r->ownerCompanyName, 'chequeAmount' => $r->chequeAmount, 'note' => $r->note, 'user_id' => session('user_id') ]);
        deal::where(['id' => $r->dealId])->update($update);
        return Redirect::back();
    }
    public function addSalary() {
        $month = DB::table('months')->select('month')->where('status', 'open')->first();
        $data = array('agent_id' => input::get('agent_id'), 'total_company_commission' => input::get('monthly_balance'), 'gross_commission' => input::get('monthly_balance') * input::get('agent_percentage') / 100, 'percentage' => input::get('agent_percentage'), 'created_at' => $month->month, 'updated_at' => $month->month,);
        DB::table('agent_accounts')->insert($data);
        return back()->with('message', '<div class="alert alert-success">Salaray Added Successfully!</div>');
    }
    public function updatePercentage() {
        $total_commission = DB::table('agent_accounts')->where('agent_id', input::get('agent_id'))->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->first();
        $data = array('gross_commission' => $total_commission->gross_commission + input::get('new_percentage'), 'relief' => input::get('new_percentage'),);
        DB::table('agent_accounts')->where('agent_id', input::get('agent_id'))->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->update($data);
        return back()->with('message', '<div class="alert alert-success">Salaray Updated Successfully!</div>');
    }
}
