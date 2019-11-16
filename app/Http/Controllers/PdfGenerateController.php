<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use PDF;
use App\Models\agentAccounts;
use App\Models\deal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
class PdfGenerateController extends Controller
{
    public function pdfview(Request $request)
    {
        $supervision = DB::table("supervisions")->where("id",input::get('record_id'))->get();
        $maintenance = DB::table("supervisionmaintenances")->where("supervision_id",input::get('record_id'))->get();
        $total = DB::table('supervisionmaintenances')->where('supervision_id',input::get('record_id'))->sum('maintenance_AED');
        view()->share(['supervision'=>$supervision,"maintenance"=>$maintenance,"total"=>$total]);
        	PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            $pdf = PDF::loadView('pdfview');
            return $pdf->download('pdfview.pdf');
    }
    public function exportSalary(Request $request)
    {
        $month = DB::table('months')->select('month')->where('status','open')->first();
        $loan = DB::table('loans')->where("agent_id",input::get('agent_id'))->first();
        $getAgentsDeals = deal::where(["agent_name"=>input::get('agent_id')])->whereYear('deal_start_date', date('Y',strtotime($month->month)))->whereMonth('deal_start_date', date('m',strtotime($month->month)))->get();
        $account = agentAccounts::where('agent_id',input::get('agent_id'))->whereYear('created_at', date('Y',strtotime($month->month)))->whereMonth('created_at', date('m',strtotime($month->month)))->first();
        view()->share(['account'=>$account,"getAgentsDeals"=>$getAgentsDeals,'open_month'=>$month,"loan"=>$loan]);
        	PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            $pdf = PDF::loadView('salarypdf');
            return $pdf->download(rand('11111','999999').'-salary.pdf');
    }
}