
@include('inc.header')
@if(!session("user_id") && ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
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
/*    .nav-tabs {*/
/*    border-bottom: 1px solid #ddd !important;*/
/*    margin-bottom: 15px !important;*/
/*    background: white !important;*/
/*}*/
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
 @media only screen and (max-width: 600px) {
  .deals_tabs{
      width: 120% !important;
      margin-left: -30px !important;
  }
 }

</style>
        <div class="page-wrapper" style="margin-top: 2%;">
            <div class="container-fluid">
                <!--adding new owner's form  -->
             <!-- owners info  -->
             <div class="row owner_main_row" >
                    <h3 class="page_heading">My Deals</h3>
                        <div class="col-12 col-sm-12">
                            {!! session('message') !!}
                            <div class="card">
                                <ul class="nav nav-tabs deals_tabs">
    <li class="nav-item">
         @if(basename(url()->current())=='dealsInfo')
            <a href="{{url('/dealsInfo')}}" class="nav-link active py-3">Deals Renewal</a>
            @else
            <a href="{{url('/dealsInfo')}}" class="nav-link  py-3">Deals Renewal</a>
             @endif
           </li>
           <li class="nav-item">
               @if(basename(url()->current())=='dealsAccountStatement')
            <a href="{{url('/dealsAccountStatement')}}" class="nav-link active  py-3">Account statement</a>
            @else
            <a href="{{url('/dealsAccountStatement')}}" class="nav-link py-3">Account statement</a>
            @endif
           </li>
    <li class="nav-item ml-auto">
         </li>
     </ul>
     <!--Model-->
     <div class="modal fade" id="sureModel" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Warning</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>AGENT Salary will be <label class="label label-danger"><b>AED</b><label class="agent_salary"></label></label></p>
          Are you Sure to Calculate the Salary ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default sure_close_btn" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sure_btn">
            <span>Sure</span></button>
        </div>
      </div>
      
    </div>
  </div>
     <!-- Modal -->
          <!--Model-->
     <div class="modal fade" id="reliefModel" role="dialog">
    <div class="modal-dialog">
    <form action="{{url('update-percentage')}}" method="get"/>
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Relief</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            
          <p>Current Agent Salary <label class="label label-danger">AED <label class="current_agent_salary"></label></label></p>
          <p>Current Agent commission <label class="label label-danger">  <label class="current_agent_commission"></label>%</label></p>
          <label>Enter Relief Amount : </label>
          <input type="number" name="new_percentage" class="form-control" id="new_percentage" required=""/>
          <input type="hidden" name="agent_id" class="form-control" id="new_percentage_agent_id" value=""/>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">
            <span>Update Salaray</span></button>
        </div>
      </div>
      </form>
    </div>
  </div>
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
     <!--<div class="card">-->
                        <div class="card-body">

                            <h4 class="card-title">Deals of the Month</h4>
                            <div class="row">
                                <div class="col-sm-4">
                                 <div class="card mt-0 mb-0">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
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
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-success agent_commision">AED {{$getCommissions['agentCommission']}}</h3>
                                    <h5 class="text-muted m-b-0">Agent Commission</h5></div>
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
                                            <th>Calculate Salary</th>
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
                           {{$agents->links()}}
                            </div>
                        </div>
                    </form>
                </div>
                <style>
                    .pagination{
                        float:right;
                    }
                </style>
                <div class="row back_btn_row m-b-40" style="display:none">
                    <div class="col-12 back_wrapper">
                    <span><i class="fas fa-arrow-circle-left" id="back_to_owner"></i></span>
                    <span id="back_to_owner_text">New Record</span>
                    </div>
                </div>
             <div class="row owner_information_link" style="display:none">
                    <div class="col-lg-12">
                        <div class="">
                            <div>
                                <form  action="{{url('dealForm')}}" class="form-horizontal" id="supervision" method="post">
                                    @csrf
                                    <input type="hidden" name="supervision_id">
                                    <ul class="nav nav-tabs nav-justified" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#home8" role="tab"><span><i class="ti-home"></i></span><span class="tab-heading">Tanenet & Property</span></a>
                                        </li>
                                        
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#profile8" role="tab"><span><i class="mdi mdi-coin"></i></span><span class="tab-heading">Payment & Commission</span></a>
                                            </li>
                                       
                                    </ul>
                                    <div class="tab-content tabcontent-border">
                                        <div class="tab-pane active p-20" id="home8" role="tabpanel">
                                            <div class="row">
                                                <div class="form-group col-sm-3">
                                                    <label>Contract Start Date</label>
                                                    <input type="date" class="form-control" placeholder="Form Submission Date" name="startDate">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Contract End Date</label>
                                                    <input type="date" class="form-control" placeholder="Form Submission Date" name="endDate">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Broker Name</label>
                                                    <input type="text" class="form-control" placeholder="Broker Name" name="brokerName">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Property Name & No.</label>
                                                    <input type="text" class="form-control" placeholder="Property Name & No." name="unitNo">
                                                </div>
                                                <!--next row-->
                                                <div class="form-group col-sm-3">
                                                    <label>Client Name</label>
                                                    <input type="text" class="form-control" placeholder="Client Name" name="clientName">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Contact No.</label>
                                                    <input type="number" class="form-control" placeholder="Contact No." name="contactNo">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Email Id</label>
                                                    <input type="email" class="form-control" placeholder="Email Id" name="email">
                                                </div>
                                                <!--next row-->
                                                <div class="form-group col-sm-3">
                                                    <label>Property Type</label>
                                                    <input type="text" class="form-control" placeholder="Property Type" name="propertyType">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Rent/sale value</label>
                                                    <input type="number" class="form-control" placeholder="Rent Dale value" name="rentSale">
                                                </div>
                                                
                                                <!--<div class="form-group col-sm-6">-->
                                                    <!--<label>Property Type</label>-->
                                                <!--    <input type="submit" class="btn btn-success btn-block btn-lg" value="Submit">-->
                                                <!--</div>-->
                                            </div>
                                        </div>
                                        <div class="tab-pane  p-20" id="profile8" role="tabpanel">
                                            <div class="row">
                                                <div class="form-group col-sm-3">
                                                    <label>Gross Commission</label>
                                                    <input type="text" class="form-control" placeholder="Gross Commission " name="grossCommission">
                                                </div>
                                                <!--next row-->
                                                <div class="form-group col-sm-3">
                                                    <label>VAT:%5</label>
                                                    <input type="text" class="form-control" placeholder="VAT:%5" name="gcVat">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Second Agent Commission</label>
                                                    <input type="text" class="form-control" placeholder="Second Agent Commission" name="secondAgentCommission">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>VAT:%5</label>
                                                    <input type="text" class="form-control" placeholder="Payment Term" name="sacVat">
                                                </div>
                                                <!--next row-->
                                                <div class="form-group col-sm-3">
                                                    <label>Company Commission</label>
                                                    <input type="date" class="form-control" placeholder="Start date" name="companyCommission">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>VAT:%5</label>
                                                    <input type="date" class="form-control" placeholder="End date" name="ccVat">
                                                </div>
                                                <!--</div>-->
                                                <!--<div class="row">-->
                                                <div class="form-group col-sm-3">
                                                    <label>Name: Agent</label>
                                                    <input type="text" class="form-control" placeholder="Name: Agent" name="agentName">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Contact Number</label>
                                                    <input type="number" class="form-control" placeholder="Contact Number" name="agentPhone">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Company Name</label>
                                                    <input type="text" class="form-control" placeholder="Company Name" name="agentCompanyName">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Name: Owner</label>
                                                    <input type="text" class="form-control" placeholder="Name: Owner" name="ownerName">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Contact Number</label>
                                                    <input type="number" class="form-control" placeholder="Contact Number" name="ownerPhone">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Email Id (CAPS LOCK)</label>
                                                    <input type="email" class="form-control" placeholder="Email Id (CAPS LOCK)" name="ownerEmail">
                                                </div>
                                                 <div class="form-group col-sm-3">
                                                    <label>Checks </label>
                                                    <select class="form-control" name="checks">
                             <option value='Select Check'>Select Check </option>
                               <option value='1'>1</option>
                                <option value='2'>2</option>
                                 <option value='3'>3</option>
                                 <option value='4'>4</option>
                                 <option value='5'>5</option> 
                                 <option value='6'>6</option>
                                 <option value='7'>7</option> 
                                 <option value='8'>8</option>
                                 <option value='9'>9</option> 
                                 <option value='10'>10</option> 
                                 <option value='11'>11</option> 
                                 <option value='12'>12</option>
                                 </select>
                                                </div>
                                            <div class="form-group col-sm-3">
                                                <label>Agent</label>
                                                <select class="form-control agent_selection">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label>Reference No.</label>
                                                <input type="number" class="form-control">
                                            </div>
                                                <div class="form-group col-sm-12">
                                                    <label>Note:</label>
                                                    <textarea class="form-control" rows="3" name="note"></textarea>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <input type="submit" value="Submit" class="btn btn-block btn-lg btn-success" name="submitDeal"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
                        
                
            </div>
@include('inc.footer')
<script type="text/javascript" src="{{url('public/assets/js/additional.js')}}">
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
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