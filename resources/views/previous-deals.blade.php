@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
<script type="text/javascript">
   window.location='{{url("/")}}';
</script>
<?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<style>
  .pagination{
    float: right;
  }
  .rnd {
    line-height: 48px;
    color: #ffffff;
    width: 52px;
    height: 52px;
    display: inline-block;
    font-weight: 700;
    text-align: center;
    border-radius: 100%;
    background: #2fa97c;
    font-size: 13px;
}
  .rotate_icon {
    transition: 0.5s;
    transition-property: all;
    transition-duration: 0.5s;
    transition-timing-function: ease;
    transition-delay: 0s;
    transform: rotate(90deg);
}
  .deals_drp_img {
    cursor: pointer;
    height: 25px;
}
  .toggle_commission_row{
    display: none;
  }
  .deals_table thead{
    background-color: #2fa97c;
    color: white;
  }
  .card-header{
    background-color: white;
  }
  .nav-tabs {
    border-bottom: 1px solid #ffffff;
}
.card-title{
    background-color: #2fa97c;
    color: white;
    padding: 10px;
}
.p-10{
      padding: 23px 15px 11px 15px;
}
.m-l-20 {
    margin-left: 20px;
}
.shadow {
    -webkit-box-shadow: 0 2px 4px rgba(0,0,0,.08)!important;
    box-shadow: 9px 11px 28px 8px rgba(0,0,0,.08)!important;
}
</style>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Deals of {{$currentMonth}},{{$currentYear}}</h4>
                        <ol class="breadcrumb m-0">
                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li> -->
                        <li class="breadcrumb-item active">Edenfort CRM Deals of {{$currentMonth}},{{$currentYear}}</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                       <!--  <div class="float-right d-none d-md-block">
                            <div class="dropdown">
                                <button class="btn btn-light btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-settings-outline mr-1"></i> Settings
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header">
                                    <form class="deals" action="{{url('get-months-deals')}}" method="get">
                                       <ul class="nav nav-tabs deals_tabs">
                                          <li class="nav-item">
                                              
                                              <input type="text" name="current" class="form-control current" value="{{$currentYear}}-{{$currentMonth}}"/>
                                          </li>
                                          <li class="nav-item month-btn">
                                              <input type="submit" value="Submit" class="btn btn-success" />
                                          </li>
                                       </ul>
                                   </form>
                                </div>
                                <div class="card-body">
                                  <h4 class="card-title">Deals of {{$currentMonth}},{{$currentYear}}</h4>
                                  @php 
                                    $commission = App\Models\deal::getTotalDealsCommissions($currentMonth,$currentYear);  
                                  @endphp
                                  <div class="row aed-cards">
                                     <div class="col-sm-4">
                                        <div class="card mt-0 mb-0">
                                           <div class="d-flex flex-row shadow">
                                              <div class="p-10 bg-primary">
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
                                           <div class="d-flex flex-row shadow">
                                              <div class="p-10 bg-primary">
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
                                   <table class="table stylish-table deals_table mt-3">
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
                                               <span><img src="public/assets/images/next.png" class="deals_drp_img"></span>
                                               <span class="badge badge-pill badge-primary rnd">{{ucfirst($agent->user_name[0])}}</span>
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
                                                    Gross Commission : <label class="badge badge-pill badge-danger">{{App\Models\deal::getAgentSalary($agent->id,$currentMonth,$currentYear)->gross_commission}}</label><br>
                                                    Percentage : <label class="badge badge-pill badge-success">{{App\Models\deal::getAgentSalary($agent->id,$currentMonth,$currentYear)->percentage}}</label><br>
                                                    Relief : <label class="badge badge-pill badge-warning">@if(App\Models\deal::getAgentSalary($agent->id,$currentMonth,$currentYear)->relief){{App\Models\deal::getAgentSalary($agent->id,$currentMonth,$currentYear)->relief}} @else 0.00 @endif</label>
                                                @else 
                                                    Gross Commission : <label class="badge badge-pill badge-danger">0.00</label><br>
                                                    Percentage : <label class="badge badge-pill badge-success">0.00</label><br>
                                                    Relief : <label class="badge badge-pill badge-warning">0.00</label>
                                                @endif
                                         @else 
                                            Gross Commission : <label class="badge badge-pill badge-danger">0.00</label><br>
                                            Percentage : <label class="badge badge-pill badge-success">0.00</label><br>
                                            Relief : <label class="badge badge-pill badge-warning">0.00</label>
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
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
            <!-- end container-fluid -->
        </div> 
        <!-- end page-content-wrapper -->
    </div>
    <!-- End Page-content -->

@include('inc.footer')
<script src="{{url('public/bootstrap-datepicker.min.js')}}"></script>
@if(session('msg'))
<script>alertify.success("{!! session('msg') !!}")</script>
@endif
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
@if(ucfirst(session('role')) == (ucfirst('Admin')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == (ucfirst('SuperAgent')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == ucfirst('Agent'))
      @include('reminder')
    @elseif(ucfirst(session('role')) == ucfirst('SuperDuperAdmin'))
      @include('admin_SuperAgent_reminders')
    @endif

</body>
</html>