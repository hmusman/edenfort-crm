
@include('inc.header')
@if(!session("user_id") && ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<style>
  @media (max-width: 550px){
    .table-responsive {
      display: block !important;
    }
  }
  .table-responsive {
    display: inline-table;
  }
  .pagination{
    float: right;
  }
  .deals_drp_img{
    cursor: pointer;
  }
  .rotate_icon {
      transition: 0.5s;
      transition-property: all;
      transition-duration: 0.5s;
      transition-timing-function: ease;
      transition-delay: 0s;
      transform: rotate(90deg);
  }
  .rnd{
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
  .nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #2fa97c;
    border-color: #2fa97c #2fa97c #2fa97c;
}
.nav-tabs {
    border-bottom: 1px solid #2fa97c;
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
                        <h4 class="page-title mb-1">My Deals</h4>
                        <ol class="breadcrumb m-0">
                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li> -->
                        <li class="breadcrumb-item active">Edenfort CRM Deals Account Statement</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <!-- <div class="float-right  d-md-block">
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
                                    <ul class="nav nav-tabs" role="tablist">
                                      <li class="nav-item">
                                        @if(basename(url()->current())=='dealsInfo')
                                          <a href="{{url('/dealsInfo')}}" class="nav-link active" role="tab"><span class=" d-md-inline-block">Deals Renewal</span> 
                                          </a>
                                        @else
                                        <a href="{{url('/dealsInfo')}}" class="nav-link" role="tab"><span class=" d-md-inline-block">Deals Renewal</span> 
                                          </a>
                                        @endif
                                      </li>
                                      <li class="nav-item">
                                      @if(!session("user_id") || ucfirst(session('role')) !=(ucfirst('SuperAgent')))
                                      @if(ucfirst(session('role'))!==ucfirst('Agent')) 
                                      @if(basename(url()->current())=='dealsAccountStatement')
                                      <a href="{{url('/dealsAccountStatement')}}" class="nav-link active" role="tab">
                                          </i> <span class=" d-md-inline-block">Account Statement</span>
                                      </a>
                                      @else
                                      <a href="{{url('/dealsAccountStatement')}}" class="nav-link" role="tab">
                                          </i> <span class=" d-md-inline-block">Account Statement</span>
                                      </a>
                                      @endif
                                      @endif
                                      @endif
                                      </li>
                                  </ul>
                                </div>
                                <div class="card-body">
                                  <h4 class="card-title">Deals of the Month</h4>
                                  <div class="row">
                                    <div class="col-sm-4">
                                     <div class="card mt-0 mb-0">
                                        <div class="d-flex flex-row shadow">
                                            <div class="p-10 bg-primary">
                                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                            <div class="align-self-center m-l-20">
                                                @php  
                                                    $getCommissions = \App\Models\user::getCommissions();
                                                @endphp
                                                <h3 class="m-b-0 text-info company_commision">AED {{$getCommissions['companyCommission']}}</h3>
                                                <h5 class="text-muted m-b-0">Company Commission</h5></div>
                                        </div>
                                     </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="card mt-0 mb-0">
                                        <div class="d-flex flex-row shadow">
                                            <div class="p-10 bg-primary">
                                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                            <div class="align-self-center m-l-20">
                                                <h3 class="m-b-0 text-success agent_commision">AED {{$getCommissions['agentCommission']}}</h3>
                                                <h5 class="text-muted m-b-0">Agent Commission</h5></div>
                                        </div>
                                     </div>
                                    </div>
                                  </div>
                                  <table class="table stylish-table deals_table mt-3 table-responsive">
                                    <thead >
                                        <tr >
                                            <th>Agent</th>
                                            <th>Username</th>
                                            <th>No. of Deals</th>
                                            <th>Budget</th>
                                            <th>Calculate Salary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($agents as $agent)
                                        <tr class="current_com_row">
                                            <td >
                                                <span><img src="public/assets/images/next.png" class="deals_drp_img" style="height: 23px;"></span>
                                                <span class="badge badge-pill badge-primary rnd">{{ucfirst($agent->user_name[0])}}</span>
                                            </td>
                                            <td>
                                                <h6>{{$agent->user_name}}</h6>
                                                <!--<small class="text-muted">Web Designer</small>-->
                                            </td>
                                            <td><span style="font-size:12px !important;color:black !important;" class="label label-light-success"><?php $number_of_deals = 0 ?>
                                        @if(count($agent->getAgentsDeals) > 0)
                                            @foreach($agent->getAgentsDeals as $deal)
                                                 @if(date('m-Y',strtotime($deal->deal_start_date)) == date('m-Y',strtotime($month->month)))
                                            <?php
                                            $number_of_deals++;
                                            ?>
                                        
                                                  @endif
                                            @endforeach
                                        @endif {{$number_of_deals}}</span></td>
                                            <td><?php $total = 0;  ?>@if(count($agent->getAgentsDeals) > 0) @foreach($agent->getAgentsDeals as $deal)  @if(date('m-Y',strtotime($deal->deal_start_date)) == date('m-Y',strtotime($month->month)))<?php $total = $total + $deal->company_commision ?> @endif @endforeach  {{number_format($total,2)}}<input type="hidden" class="company_commision" value="{{number_format($total,2)}}"/>  @else <input type="hidden" class="company_commision" value="{{number_format($total,2)}}"/>  {{number_format($total,2)}} @endif</td>
                                            <td>
                                                @php 
                                                    $currenMonth = date('m',strtotime($month->month));
                                                    $currentYear = date('Y',strtotime($month->month)); 
                                                @endphp                    
                                    @if(!App\Models\deal::getCurrenMonthSalary($agent->id,$currenMonth,$currentYear))
                                            <button type="button" class="btn btn-sm btn-success calculate" data-toggle="modal" @if($total != 0) data-target="#exampleModal" @endif agent_id="{{$agent->id}}">Calculate</button>
                                            
                                @else
                                <?php  
                                $temp = App\Models\deal::getCurrenMonthSalaryAmount($agent->id,$currenMonth,$currentYear);  ?>
                                    <button type="button" class="btn btn-sm btn-danger relief_agent" data-toggle="modal" data-target="#reliefModel" gross_commission="{{@$temp->gross_commission}}" percentage="{{@$temp->percentage}}"  agent_id="{{$agent->id}}">Relief</button>
                                    <a href="{{url('export-salary')}}?agent_id={{$agent->id}}" class="btn btn-info">Export Salary</a>
                                @endif</td>
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
                                                    @if(count($agent->getAgentsDeals) > 0)
                                                    
                                                    <?php  $companyComission = 0;
                                                            $agentCommision =0;
                                                    ?>
                                                    @foreach($agent->getAgentsDeals as $deal)
                                                         @if(date('m-Y',strtotime($deal->deal_start_date)) == date('m-Y',strtotime($month->month)))
                                                    <?php
                                                    $companyComission = $companyComission + $deal->company_commision;
                                                        $agentCommision = $agentCommision +($deal->efAgentCommission+$deal->secondAgentCommission+$deal->thirdAgentCommission); 
                                                    ?>
                                                                <tr>
                                                                     <td>{{$counter++}}</td>
                                                                     <td>{{date('Y-m-d',strtotime($deal->created_at))}}</td>
                                                                     <td>{{$deal->referenceNo}}</td>
                                                                     <td>Unit No: {{$deal->unit_no}} {{$deal->building}}</td>
                                                                     <td>{{$deal->company_commision}}</td>
                                                                </tr>
                                                          @endif
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
                                </div>
                                {{$agents->links()}}
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
<form class="salary_form" action="{{url('add-salary')}}" method="get">
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Calculations</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Current Month Balance : <strong></strong><input type="text" class="form-control" name="monthly_balance" id="monthly_balance" value="" readonly="" /></p>
          <p>Calculation Percentage : <strong><input type="number" class="form-control" name="agent_percentage" id="agent_percentage" required=""/>
          <input type="hidden" id="agent_id" name="agent_id" value=""/></strong></p>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary calculate_model_close" data-dismiss="modal">Close</button>
          <button data-toggle="modal" data-target="#sureModel" type="button" class="btn btn-primary calculate_model_calculate">
              <span>Calculate</span></button>
  
        </div>
      </div>
    </div>
  </div>
</form>

@include('inc.footer')
<script type="text/javascript" src="{{url('public/assets/js/additional.js')}}"></script>
@if(session('msg'))
<script>alertify.success("{!! session('msg') !!}")</script>
@endif
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
        // alert();
    });
    $(document).delegate('.calculate','click',function(){
        $('#monthly_balance').attr('value',$(this).parent().prev().children('input.company_commision').val().replace(/,/g, ""));
        $('#agent_id').val($(this).attr('agent_id'));
    })
    $('.calculate_model_calculate').click(function(){
        if(!parseInt($('input#agent_percentage').val())){
            alert('please enter the percentage');
            return;
        }
        var monthly_balance = parseInt($("input#monthly_balance").attr('value'));
        var agent_percentage = parseInt($('input#agent_percentage').val());
        console.log(monthly_balance);
        console.log(agent_percentage);
        var salaray = monthly_balance * agent_percentage / 100;
        $('label.agent_salary').text(salaray);
        $('.calculate_model_close').trigger('click');
    })
    $('button.sure_btn').click(function(){
        $('form.salary_form').submit();
    })
    $(document).delegate('.relief_agent','click',function(){
        $('#new_percentage_agent_id').val($(this).attr('agent_id'));
        $('.current_agent_commission').text($(this).attr('percentage'));
        $('.current_agent_salary').text($(this).attr('gross_commission'));
    })
</script>


<?php  if(isset($_GET['action'])) { ?>
    <script type="text/javascript">
        $("#assigned_user option").each(function(){
            if($(this).val()=="{{@$result[0]['assigned_user']}}"){
                $(this).attr("Selected",true);
            }
        })
        $("#building option").each(function(){
            if($(this).val()=="{{@$result[0]['Building']}}"){
                $(this).attr("Selected",true);
            }
        })
        
    </script>
<?php }  ?>
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