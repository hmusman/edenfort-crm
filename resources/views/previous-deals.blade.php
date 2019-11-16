@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=ucfirst('Admin'))
<script type="text/javascript">
   window.location='{{url("/")}}';
</script>
<?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/datepicker.min.css')}}">
<style>
   .filter_input,.month_wise_deals{
   background-color:#1976D2 ;
   color:#fff;
   }
   .deals_table thead tr th{
   color:#ffffff;
   }
   .month_wise_deals,.export_btn{
   border-radius:40px;
   }
   .filter_input::placeholder{
   color:#fff;
   }
   .filter_btn{
   height:36px;
   }
   .nav-link{
   padding: .5rem 1rem !important;
   text-align:center !important;
   color:black;
   }
   .nav-tabs .nav-link.active{
   color: white !important;
   background-color: #1976D2 !important;
   }
   span.tab-heading{
   display:block;
   font-size:12px !important;
   font-weight:400 !important;
   }
   .tabcontent-border{
   background: white !important;
   min-height: 400px;
   padding:20px 0px !important;
   }
   .toggle_commission_row{
   display:none;
   }
   .deals_drp_img {
   cursor:pointer;
   }
   hr{
   margin-bottom:3rem;
   }
   label,input,textarea,select{
   font-size:12px !important;
   }
   .back_btn_row, .prop_back_btn_row, .property_tabs_row, .prop_information_link,.owner_docs_link, .tabs_row, .owner_information_link{
   display:block;
   }
   .deals_tabs a{
   padding-top:8px !important;
   padding-bottom:8px !important;
   }
   .stylish-table tbody tr:hover, .stylish-table tbody tr.active,.stylish-table tbody tr{
   border-left:none !important;
   }
   .toggle_commission_row thead tr th{
   color:#555 !important;
   }
   .spinner_content{
   opacity:0;
   }
   .check_content{
   display:none;
   }
   .calculate_text{
   position: relative;
   left: -8px;
   }
   .month-btn{
        margin-left: 20px;
        margin-top: 4px;
   }
</style>
<div class="page-wrapper" style="margin-top: 2%;">
<div class="container-fluid">
<div class="row owner_main_row" >
   <h3 class="page_heading">Deals of {{$currentMonth}},{{$currentYear}}</h3>
   <div class="col-12 col-sm-12">
      {!! session('message') !!}
      <div class="card">
          <form action="{{url('get-months-deals')}}" method="get">
             <ul class="nav nav-tabs deals_tabs">
                <li class="nav-item">
                    
                    <input type="text" name="current" class="form-control current" value="{{$currentYear}}-{{$currentMonth}}"/>
                </li>
                <li class="nav-item month-btn">
                    <input type="submit" value="Submit" class="btn btn-success" />
                </li>
             </ul>
         </form>
         <div class="card-body">
            <h4 class="card-title">Deals of {{$currentMonth}},{{$currentYear}}</h4>
            @php 
                $commission = App\Models\deal::getTotalDealsCommissions($currentMonth,$currentYear);  
            @endphp
            <div class="row">
               <div class="col-sm-4">
                  <div class="card mt-0 mb-0">
                     <div class="d-flex flex-row">
                        <div class="p-10 bg-info">
                           <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                        </div>
                        <div class="align-self-center m-l-20">
                           <h3 class="m-b-0 text-info company_commision">AED {{$commission[0]}}</h3>
                           <h5 class="text-muted m-b-0">Company Commission</h5>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="card mt-0 mb-0">
                     <div class="d-flex flex-row">
                        <div class="p-10 bg-info">
                           <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                        </div>
                        <div class="align-self-center m-l-20">
                           <h3 class="m-b-0 text-success agent_commision">AED {{$commission[1]}}</h3>
                           <h5 class="text-muted m-b-0">Agent Commission</h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="table-responsive m-t-10">
               <table class="table stylish-table deals_table">
                  <thead >
                     <tr >
                        <th>Agent</th>
                        <th>Username</th>
                        <th>No. of Deals</th>
                        <th>Budget</th>
                        <th class="text-center">Salary</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($agents as $agent)
                     <tr class="current_com_row">
                        <td >
                           <span><img src="https://img.icons8.com/cotton/26/000000/circled-right.png" class="deals_drp_img"></span>
                           <span class="round">{{ucfirst($agent->user_name[0])}}</span>
                        </td>
                        <td>
                           <h6>{{$agent->user_name}}</h6>
                        </td>
                        <td>
                            <span style="font-size:12px !important;color:black !important;" class="label label-light-success">
                            {{count(App\Models\deal::getMonthDeals($agent->id,$currentMonth,$currentYear))}}
                            </span>
                        </td>
                        <td>{{App\Models\deal::getDealBudget($agent->id,$currentMonth,$currentYear)}}</td>
                        <td class="text-right">
                        @if(@App\Models\deal::getAgentSalary($agent->id,$currentMonth,$currentYear))
                            @if(count(App\Models\deal::getAgentSalary($agent->id,$currentMonth,$currentYear)) > 0)
                                Gross Commission : <label class="label label-danger">{{App\Models\deal::getAgentSalary($agent->id,$currentMonth,$currentYear)->gross_commission}}</label><br>
                                Percentage : <label class="label label-success">{{App\Models\deal::getAgentSalary($agent->id,$currentMonth,$currentYear)->percentage}}</label><br>
                                Relief : <label class="label label-warning">@if(App\Models\deal::getAgentSalary($agent->id,$currentMonth,$currentYear)->relief){{App\Models\deal::getAgentSalary($agent->id,$currentMonth,$currentYear)->relief}} @else 0.00 @endif</label>
                            @else 
                                Gross Commission : <label class="label label-danger">0.00</label><br>
                                Percentage : <label class="label label-success">0.00</label><br>
                                Relief : <label class="label label-warning">0.00</label>
                            @endif
                     @else 
                        Gross Commission : <label class="label label-danger">0.00</label><br>
                        Percentage : <label class="label label-success">0.00</label><br>
                        Relief : <label class="label label-warning">0.00</label>
                    @endif
                         </td>
                     </tr>
                     <tr class="toggle_commission_row">
                        <td colspan="5" class="p-0 bg-light">
                           <div>
                              <table class="table table-bordered table-hover table-striped">
                                 <thead>
                                    <tr class="bg-light">
                                       <th class="text-dark">Sr. no</th>
                                       <th class="text-dark">Date</th>
                                       <th class="text-dark">REF#</th>
                                       <th class="text-dark">Property
                                       </th>
                                       <th class="text-dark">Total Commission</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php  $counter=1; ?>
                                    @if(count(App\Models\deal::getMonthDeals($agent->id,$currentMonth,$currentYear)) > 0)
                                        @foreach(App\Models\deal::getMonthDeals($agent->id,$currentMonth,$currentYear) as $deal)
                                    <tr>
                                       <td>{{$counter++}}</td>
                                       <td>{{date('Y-m-d',strtotime($deal->created_at))}}</td>
                                       <td>{{$deal->referenceNo}}</td>
                                       <td>Unit No: {{$deal->unit_no}} {{$deal->building}}</td>
                                       <td>{{$deal->company_commision}}</td>
                                    </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                       <td style="text-align:center;" colspan="20">No Deal Found!</td>
                                    </tr>
                                    @endif
                                 </tbody>
                              </table>
                           </div>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
               {{$agents->appends(Request::only('current'))->links()}}
            </div>
         </div>
         </form>
      </div>
      <style>
         .pagination{
         float:right;
         }
      </style>
   </div>
</div>
@include('inc.footer')
<script src="{{url('public/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
$('.current').datepicker({
    autoclose: true,
    minViewMode: 1,
    format: 'yyyy-m'
});
</script>
<script>
    $('.buttonload').click(function(){
        $('.calculate_text').removeClass('calculate_text');
         $('.spinner_content').css('opacity','1');
        setTimeout(function() {
       $('.spinner_content').hide();
       $('.buttonload span').hide();
       $('.check_content').show();
   }, 3000);
    });
    $('.deals_drp_img').click(function(){
        $(this).toggleClass('rotate_icon');
        $(this).parents('tr.current_com_row').next('tr.toggle_commission_row').slideToggle('slow');
    });
    @if(app('request')->input('current'))
        $('.current_month').val({{ app('request')->input('current') }});
    @endif
</script>
@include('reminder')
</body>
</html>