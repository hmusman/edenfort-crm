@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperAgent')))
<script type="text/javascript">
   window.location='{{url("/")}}';
</script>
<?php redirect('/'); ?>
@endif
@if(ucfirst(session('role'))==ucfirst('SuperAgent')) 
@if(@$permissions->dealView!=1)
<script type="text/javascript">
   window.location='{{url("404")}}';
</script>
<?php redirect('/'); ?>
@endif
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
 <!-- Responsive Table css -->
<link href="{{url('public/Green/assets/libs/RWD-Table-Patterns/css/rwd-table.min.css')}}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     

<style>
  @media (max-width: 550px){
    .pagination {
        margin-top: 25px !important;
        float: none !important;
        overflow-x: auto !important;
    }
    .mobility{
      margin-top: -28px !important;
      width: 125% !important;
      margin-left: -9px !important;
    }
  }
  .pagination{
    margin-top: 25px;
    float: right;
  }
  #tech-companies-1 thead{
    background-color: #2fa97c;
    color: white;
    font-weight: bold;
  }
  .card-header{
    background: white;
    border-bottom: 0 solid #2fa97c;
  }
  .nav-tabs {
      border-bottom: 1px solid #2fa97c;
  }
  #add-new-owne-link{
    cursor: pointer;
    float: left;
    color: white;
    padding: 15px 20px 15px 20px;
  }
  .nav-tabs .nav-link.active {
      color: #ffffff;
      background-color: #2fa97c;
      border-color: #2fa97c #2fa97c #2fa97c;
  }
  .deal-card-body{
    width: 106%;
    margin-left: -12px;
  }
  .deal-card-header{
    background: none;
    width: 103%;
    margin-left: -18px;
  }
  .deal-card-header1{
      width: 105%;
      margin-left: -31px;
      background: none;
  }
  .table-wrapper{
    width: 105%;
    margin-left: -31px;
  }
  .toggleable_row {
    display: none;
}
.drop_arrow_icon {
    cursor: pointer;
}
.tgl_row {
      display: table-row !important;
  }
  .rotate_icon {
    transition: 0.5s;
    transition-property: all;
    transition-duration: 0.5s;
    transition-timing-function: ease;
    transition-delay: 0s;
    transform: rotate(90deg);
}
.close{
  z-index: 1050; z-index: 1050; margin-top: -30px; margin-right: -7px;
}
.close_icon{
  background-color: red; padding: 2px 7px 2px 7px; color: white; font-size: 15px;
}
.custome-file .custome-file-label{
      font-size: 9px !important;
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
                    <div class="col-md-11">
                        <h4 class="page-title mb-1">My Deals</h4>
                        <ol class="breadcrumb m-0">
                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li> -->
                        <li class="breadcrumb-item active">Edenfort CRM Deals</li>
                        </ol>
                    </div>
                    <div class="col-md-1">
                        <div class="dropdown">
                           @if(ucfirst(session('role'))==ucfirst('Agent') || ucfirst('SuperAgent')) 
                           @if(@$permissions->dealAdd==1)
                          <a class="btn btn-success btn-rounded waves-effect waves-light" id="add-new-owne-link" data-toggle="modal" data-target="#addNewDeal" style="cursor: pointer;float:left"><span><i class="fa fa-plus"></i></span></a>
                          @endif
                          @else
                          <a class="btn btn-success btn-rounded waves-effect waves-light" id="add-new-owne-link" data-toggle="modal" data-target="#addNewDeal" style="cursor: pointer;float:left"><span><i class="fa fa-plus"></i></span></a>
                          @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid deal-card-body">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                              <a type="button" href="#" title="Update" class="btn btn-success update_record" style="float: right; margin-top: 12px;">Update Record</a>
                              <div class="card-header deal-card-header">
                                <ul class="nav nav-tabs" role="tablist">
                                  <li class="nav-item">
                                    @if(basename(url()->current())=='dealsInfo')
                                      <a href="{{url('/dealsInfo')}}" class="nav-link active" role="tab"><span class=" d-md-inline-block">Deals Renewal</span> 
                                      </a>
                                    @else
                                    <a class="nav-link" data-toggle="tab" href="#home" role="tab"><span class=" d-md-inline-block">Deals Renewal</span> 
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
                                  <div class="card-header deal-card-header1">
                                    <form action="{{url('dealsInfo')}}" method="get" style="width:100%">
                                      <div class="row" style="margin-top: -40px;">
                                        <div class="col-md-12">
                                            <div class="row mt-2 mb-2 deal_search">
                                              <div class="col-md-4 pl-1 pr-1">
                                                   <label>Building Name</label>
                                                  <div class="dropdown_wrapper ">
                                                    <input type="text" value="{{@$_GET[build]}}" class="form-control filter_input" list="building" placeholder="select Building" name="build">
                                                       <datalist id="building">
                                                          <option value="">Select building</option>
                                                          @foreach($buildings as $building)
                                                          <option name="building" value="{{$building->building_name}}" >{{$building->building_name}}</option>
                                                          @endforeach
                                                       </datalist>
                                                  </div>
                                               </div>
                                               <div class="col-md-2 pl-1 pr-1">
                                                   <label>Contract Start Date</label>
                                                  <div class="dropdown_wrapper ">
                                                     <input type="date" value="{{ @$_GET['start_date'] }}" class="form-control filter_input" name="start_date"  placeholder="start date">
                                                  </div>
                                               </div>
                                               <div class="col-md-2 pl-1 pr-1">
                                                   <label>Contract End Date</label>
                                                  <div class="dropdown_wrapper ">
                                                     <input type="date" value="{{ @$_GET['end_date'] }}" class="form-control filter_input" name="end_date" placeholder="End date">
                                                  </div>
                                               </div>
                                               <div class="col-md-2 pl-1 pr-1">
                                                   <label>Select Agent</label>
                                                  <div class="dropdown_wrapper ">
                                                     <input id="name" value="{{@$getAgentName->user_name }}" class="form-control filter_input" list="allNames" autocomplete="off" placeholder="select Agent"/>
                                                     <datalist id="allNames">
                                                        @foreach($agents as $agent)
                                                            <option data-value="{{$agent->id}}" value="{{$agent->user_name}}" >{{$agent->First_name}} {{$agent->Last_name}}</option>
                                                        @endforeach
                                                     </datalist>
                                                     <input type="hidden" id="agentId" name="agent" value="">
                                                  </div>
                                               </div>
                                               <div class="col-md-2 pl-1 pr-1">
                                                   <label>Unit No.</label>
                                                  <div class="dropdown_wrapper ">
                                                     <input type="text" value="{{ @$_GET['unit_no'] }}" class="form-control filter_input" name="unit_no"  placeholder="Unit No.">
                                                  </div>
                                               </div>
                                              <!--  <div class="col-md-2 pl-1 pr-1 filter_deal" style="padding-top: 31px;margin-left: 92%;margin-top: -68px;">
                                                  
                                               </div> -->
                                            </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-10"></div>
                                        <div class="col-md-2 pl-1 pr-1">
                                          <div class="filter_btn_wrapper">
                                             <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter">
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                  <div class="card-body mobility" style="margin-top: -68px;width: 102%;margin-left: -9px;">
                                      <div class="table-rep-plugin">
                                        <form id="bulkForm">
                                        @csrf
                                        <div class="table-responsive mb-0">
                                            <table id="tech-companies-1" class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Select</th>
                                                    <!-- <th>Deal Start</th> -->
                                                    <!-- <th>Contract Start</th> -->
                                                    <th>Contract End</th>
                                                    <th>Building Name</th>
                                                    <th>Reference Number</th>
                                                    <th>Broker</th>
                                                    <th>2nd Broker</th>
                                                    <th>Unit</th>
                                                    <th>Client</th>
                                                    @if(session('role') == 'SuperAgent')
                                                    @if($permissions->deal_show_contact_info == '1')
                                                    <th>Contact</th>
                                                    @endif
                                                    @else
                                                    <th>Contact</th>
                                                    @endif
                                                    <th>Access</th>
                                                </tr>
                                                </thead>
                                                <tbody style="font-size: 12px;">
                                                  @if(isset($deals))
                                                  @if(count($deals) > 0)
                                                  <?php $counter=0;  ?>
                                                  @foreach($deals as $deal)
                                                  @php
                                                    $date1 = strtotime($deal->contract_end_date);
                                                    $date2 = strtotime($date);
                                                    $diff = ($date1 - $date2)/60/60/24;
                                                    //print_r($diff);
                                                  @endphp
                                                  <tr class="present_row">
                                                    <td style="display: none;" data-order="{{$diff}}">{{$diff}}</td>
                                                       @if(ucfirst(session('role'))==ucfirst('Agent') ) 
                                                       @if(@$permissions->dealBulk!=1)
                                                       <td>Not Allowed</td>
                                                       @else 
                                                       <td><input type="checkbox" class="ind_chk_box" value="{{$deal->id}}" name="check_boxes[{{$counter}}]"><img style="width: 21px;" src="public/assets/images/next.png" class="drop_arrow_icon pulse-effect"></td>

                                                       @endif
                                                       @else
                                                       <td><input type="checkbox" class="ind_chk_box" value="{{$deal->id}}" name="check_boxes[{{$counter}}]"><img style="width: 21px;" src="public/assets/images/next.png" class="drop_arrow_icon pulse-effect"></td>

                                                       @endif
                                                       <td class="dealId" style="display:none;">{{$deal->id}}</td>
                                                       <td class="contract_end_date">{{date('d-m-Y',strtotime($deal->contract_end_date))}}</td>

                                                       <td style="display: none;" class="deal_start_datee">{{date('m/d/Y',strtotime($deal->deal_start_date))}}</td>
                                                       <td style="display: none;" class="contract_start_datee">{{date('m/d/Y', strtotime($deal->contract_start_date))}}</td>
                                                       <td style="display: none;" class="contract_end_datee">{{date('m/d/Y', strtotime($deal->contract_end_date))}}</td>

                                                       <td class="building">{{$deal->building}}</td>
                                                       <td class="referenceNo">{{$deal->referenceNo}}</td>
                                                       <td class="broker_name">{{$deal->broker_name}}</td>
                                                       <td class="2nd_broker_name">{{$deal->secondAgentName}}</td>
                                                       <td class="unit_no">{{$deal->unit_no}}</td>
                                                       <td class="client_name">{{$deal->client_name}}</td>
                                                       @if(session('role') == 'SuperAgent')
                                                       @if($permissions->deal_show_contact_info == '1')
                                                       <td class="contanct_no">{{$deal->contanct_no}}</td>
                                                       @endif
                                                       @else
                                                       <td class="contanct_no">{{$deal->contanct_no}}</td>
                                                       @endif
                                                       <td class="email" style="display:none;">{{$deal->email}}</td>
                                                       <td class="property_type" style="display:none;">{{$deal->property_type}}</td>
                                                       <td class="rent_sale_value"  style="display:none;">{{$deal->rent_sale_value}}</td>
                                                       <td class="rentalCheques"  style="display:none;">{{$deal->rentalCheques}}</td>
                                                       <td class="deal_Status"  style="display:none;">{{$deal->dealStatus}}</td>
                                                       <td class="agent_name" style="display:none;">{{$deal->agent_name}}</td>
                                                       <td class="gross_commission" style="display:none;">{{$deal->gross_commission}}</td>
                                                       <td class="gc_vat" style="display:none;">{{$deal->gc_vat}}</td>
                                                       <td class="company_commision" style="display:none;">{{$deal->company_commision}}</td>
                                                       <td class="cc_Vat" style="display:none;">{{$deal->cc_vat}}</td>
                                                       <td class="efAgent_Commission" style="display:none;">{{$deal->efAgentCommission}}</td>
                                                       <td class="efAgent_Vat" style="display:none;">{{$deal->efAgentVat}}</td>
                                                       <td class="secondAgentName" style="display:none;">{{$deal->secondAgentName}}</td>
                                                       <td class="secondAgentCompany" style="display:none;">{{$deal->secondAgentCompany}}</td>
                                                       <td class="sacPhone" style="display:none;">{{$deal->sacPhone}}</td>
                                                       <td class="secondAgent_Commission" style="display:none;">{{$deal->secondAgentCommission}}</td>
                                                       <td class="sacAgent_Vat" style="display:none;">{{$deal->sacAgentVat}}</td>
                                                       <td class="thirdAgentName" style="display:none;">{{$deal->thirdAgentName}}</td>
                                                       <td class="thirdAgentCompany" style="display:none;">{{$deal->thirdAgentCompany}}</td>
                                                       <td class="tacPhone" style="display:none;">{{$deal->tacPhone}}</td>
                                                       <td class="thirdAgentCommission" style="display:none;">{{$deal->thirdAgentCommission}}</td>
                                                       <td class="tacVat" style="display:none;">{{$deal->tacVat}}</td>
                                                       <td class="paymentTerms" style="display:none;">{{$deal->paymentTerms}}</td>
                                                       <td class="chequeNumber" style="display:none;">{{$deal->chequeNumber}}</td>
                                                       <td class="ownerCompanyName" style="display:none;">{{$deal->ownerCompanyName}}</td>
                                                       <td class="ownerName" style="display:none;">{{$deal->ownerName}}</td>
                                                       <td class="ownerPhone" style="display:none;">{{$deal->ownerPhone}}</td>
                                                       <td class="ownerEmail" style="display:none;">{{$deal->ownerEmail}}</td>
                                                       <td class="ownerNameSecond" style="display:none;">{{$deal->ownerNameSecond}}</td>
                                                       <td class="ownerPhoneSecond" style="display:none;">{{$deal->ownerPhoneSecond}}</td>
                                                       <td class="ownerEmailSecond" style="display:none;">{{$deal->ownerEmailSecond}}</td>
                                                       <td class="chequeAmount" style="display:none;">{{$deal->chequeAmount}}</td>
                                                       <td class="note" style="display:none;">{{$deal->note}}</td>
                                                       @if(ucfirst(session('role'))==ucfirst('Agent') || ucfirst('SuperAgent')) 
                                                       @if(@$permissions->dealEdit!=1)
                                                       <td>Not Allowed</td>
                                                       @else 
                                                       <td><label data-toggle="modal" data-target="#editDealPopup" style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="editDealRow edit_supervision" name="{{$deal->id}}" onclick="getdoxuments({{$deal->id}})"><i class="fa fa-edit"></i> Edit</label>&nbsp;
                                                        @if(@$permissions->deal_delete == '1')
                                                        <label style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="editDealRow edit_supervision" name="{{$deal->id}}" onclick="deleteDeal({{$deal->id}})"><i class="fa fa-edit"></i>Delete</label>
                                                        @endif
                                                       </td>
                                                       @endif
                                                       @else
                                                       <td><label data-toggle="modal" data-target="#editDealPopup" style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="editDealRow edit_supervision" name="{{$deal->id}}" onclick="getdoxuments({{$deal->id}})"><i class="fa fa-edit"></i> Edit</label>&nbsp;
                                                        @if(@$permissions->deal_delete == '1')
                                                        <label style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="editDealRow edit_supervision" name="{{$deal->id}}" onclick="deleteDeal({{$deal->id}})"><i class="fa fa-edit"></i>Delete</label>
                                                        @endif
                                                       </td>
                                                    @endif
                                                    </tr>                   
                                                  <tr class="toggleable_row">
                                                     <td colspan="19">
                                                        <div class="row">
                                                           <div class="col-sm-2">
                                                              <label style="text-align: start">referenceNo</label>
                                                              <input class="form-control" type="text" name="referenceNo[{{$counter}}]" value="{{$deal->referenceNo}}" placeholder="">
                                                           </div>
                                                           <div class="col-sm-3">
                                                              <label style="text-align: start">Client Name</label>
                                                              <input class="form-control" type="text" name="clientName[{{$counter}}]" value="{{$deal->client_name}}" placeholder="">
                                                           </div>
                                                           <div class="col-sm-2">
                                                              <label style="text-align: start">Contact Number</label>
                                                              <input class="form-control" type="text" name="contanct_no[{{$counter}}]" value="{{$deal->contanct_no}}" placeholder="">
                                                           </div>
                                                           <div class="col-sm-3">
                                                              <label style="text-align: start">Email</label>
                                                              <input class="form-control" type="text" name="clientEmail[{{$counter}}]" value="{{$deal->email}}" placeholder="">
                                                           </div>
                                                           <div class="col-sm-2">
                                                              <label style="text-align: start">Property Type</label>
                                                              <input class="form-control" type="text" name="propertyType[{{$counter}}]" value="{{$deal->property_type}}" placeholder="">
                                                           </div>
                                                           <div class="col-sm-2">
                                                              <label style="text-align: start">Rent/Sale value</label>
                                                              <input class="form-control" type="number" name="rent_sale_value[{{$counter}}]" value="{{$deal->rent_sale_value}}" placeholder="">
                                                           </div>
                                                           <div class="col-sm-1">
                                                              <label style="text-align: start">Rental Cheques</label>
                                                              <input class="form-control" type="number" name="cheques[{{$counter}}]" value="{{$deal->rentalCheques}}" placeholder="">
                                                           </div>
                                                           <div class="col-sm-2">
                                                              <label style="text-align: start">Deal Status</label>
                                                              <input class="form-control" type="text" name="dealstatus[{{$counter}}]" value="{{$deal->dealStatus}}" placeholder="">
                                                           </div>
                                                           <div class="col-sm-2">
                                                              <label style="text-align: start">Payment Terms</label>
                                                              <input class="form-control" type="text" name="paymentTerms[{{$counter}}]" value="{{$deal->paymentTerms}}" placeholder="">
                                                           </div>
                                                           <div class="col-sm-3">
                                                              <label style="text-align: start">Note</label>
                                                              <textarea type="text" name="note[{{$counter}}]" value="{{$deal->note}}" rows="4" class="form-control">{{$deal->note}}</textarea>
                                                           </div>

                                                     </td>
                                                  </tr>
                                                  @php $counter++; @endphp
                                                  @endforeach
                                                  @else
                                                  <tr>
                                                     <td colspan="15" align="center">No Record Found</td>
                                                  </tr>
                                                  @endif 
                                                  @endif        
                                               </tbody>
                                            </table>
                                        </div>
                                        </form>
                                    </div>
                                  {{$deals->appends(Request::only('start_date','end_date','agent', 'building', 'unit_no'))->links()}}
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
<!--start of add deal popup-->
<div class="modal fade" id="addNewDeal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
   <div class="modal-dialog modal-lg" style=" max-width:1200px;" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title   content_model_title" id="exampleModalLabel1">Add Deal</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
            <form  action="{{route('dealForm')}}" class="form-horizontal" id="supervision" method="post" enctype="multipart/form-data">
               @csrf
               <input type="hidden" name="supervision_id">
               <ul class="nav nav-tabs nav-justified" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" data-toggle="tab" href="#home8" role="tab"><span><i class="ti-home"></i></span><span class="tab-heading">Tanenet & Property</span></a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#profile8" role="tab" id="2ndTab"><span><i class="mdi mdi-coin"></i></span><span class="tab-heading">Payment & Commission</span></a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#profile9" role="tab" id="3rdTab"><span><i class="mdi mdi-note"></i></span><span class="tab-heading">Documents</span></a>
                  </li>
               </ul><br>
               <div class="tab-content tabcontent-border mt-4">
                  <div class="tab-pane active p-20" id="home8" role="tabpanel">
                     <div class="row">
                         <div class="form-group col-sm-3">
                             <label>Deal Start Date</label>
                             <input type="date" class="form-control" placeholder="Deal Start Date" name="deal_start_date" >
                          </div>
                        <div class="form-group col-sm-3">
                           <label>Contract Start Date</label>
                           <input type="date" class="form-control" placeholder="Form Submission Date" name="startDate">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Contract End Date<i class="fa fa-lg fa-clock-o " data-toggle="modal" data-target="#reminderAddPopupContractDate" aria-hidden="true" style="margin-left:130px;"></i></label>
                           <input type="date" class="form-control" placeholder="Form Submission Date" name="endDate">
                        </div>
                        @foreach($upcomingDealId[0] as $u)
                        <input type="hidden" name="reminderLeadId" value="{{$u}}" >
                        @endforeach
                        <!--fields for followup reminder-->
                        <input type="hidden" id="reminderAddPopupContractDateName" name="reminderAddPopupName">
                        <input type="hidden" id="reminder_DateTimeAddPopupContractDate" name="reminderAddPopupDateInput">
                        <input type="hidden" id="reminder_descriptionAddPopupContractDate" name="reminder_descriptionAddPopup">
                        <div class="form-group col-sm-3">
                           <label>Unit No.</label>
                           <input type="text" class="form-control" placeholder="Unit No." name="unitNo">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Reference No.</label>
                           <input type="text" class="form-control" name="referenceNo">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Broker Name</label>
                           <input type="text" class="form-control" placeholder="Broker Name" name="brokerName">
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
                        <div class="form-group col-sm-3">
                           <label>Rental cheques </label>
                           <select class="form-control" name="rentalCheques">
                              <option value='Select Cheque'>Select Cheque </option>
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
                        <div class="form-group col-sm-2">
                           <label>Buildings</label>
                           <select class="form-control insertBuilding" name="building">
                              <option value="Select Building">Select Building</option>
                              @foreach($buildings as $building)
                              <option value="{{$building->building_name}}" >{{$building->building_name}}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-sm-1" style="padding-top: 20px;">
                           <i class="fa fa-plus add-building" class="btn btn-primary" data-toggle="modal" data-target="#buildingModal" style="font-size:22px;color:black" aria-hidden="true"></i>
                        </div>
                        <div class="row owner-extra-fields" style="width:100%;padding:0px;margin:0px;">
                           <div class="form-group col-sm-3">
                              <label>Owner Name</label>
                              <input type="text" class="form-control" placeholder="Client Name" name="owner_name">
                           </div>
                           <div class="form-group col-sm-3">
                              <label>Owner Phone</label>
                              <input type="number" class="form-control" placeholder="Owner Phone" name="owner_phone">
                           </div>
                           <div class="form-group col-sm-3">
                              <label style="width:100%;">Owner Email</label>
                              <input type="email" style="width:90%;" class="form-control" placeholder="Owner Email" name="owner_email">
                           </div>
                           <div class="form-group col-sm-3">
                              <label style="width:100%;visibility:hidden"></label>
                              <span style="cursor:pointer" class="add-owner-details"><i class="fa fa-plus" style="font-size:18px;"></i><span class='add-more'>Add More</span></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane  p-20" id="profile8" role="tabpanel">
                     <div class="row " >
                        <div class="form-group col-sm-3">
                           <label>Deal Status </label>
                           <select id="dealStatus" class="form-control" name="dealStatus">
                              <option value='Select Status'>Select Status </option>
                              <option value='Direct'>Direct</option>
                              <option value='In-Direct'>In-Direct</option>
                           </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-7" style="display:none;">
                           <div class="btn-group mt-4" data-toggle="buttons"  >
                              <label class="btn btn-info active">
                                 <div class="custom-control custom-radio" >
                                    <input type="radio" id="customRadio4" name="vatRadio" class="custom-control-input" value="Vat From Commisson" checked="">
                              <label class="custom-control-label" for="customRadio4">Vat From Commisson
                              </label>
                              </div>
                              </label>
                              <label class="btn btn-info">
                                 <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio5" name="vatRadio" value="Vat On Commisson" class="custom-control-input">
                              <label class="custom-control-label" for="customRadio5">Vat On Commisson</label>
                              </div>
                              </label>
                              <label class="btn btn-info">
                                 <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio6" name="vatRadio" value="Vat From Agent" class="custom-control-input">
                              <label class="custom-control-label" for="customRadio6">Vat From Agent</label>
                              </div>
                              </label>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <!-- start first row agent -->
                        <div class="form-group col-sm-3">
                           <label>Name: Agent</label>
                           <select class="form-control" name="agentName">
                              @foreach($agents as $agent)
                              <option value="{{$agent->id}}">{{$agent->First_name}} {{$agent->Last_name}}</option>
                              @endforeach                      
                           </select>
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Gross Commission</label>
                           <input type="text" class="form-control" placeholder="Gross Commission " id="grossCommission" name="grossCommission">
                        </div>
                        <div class="form-group col-sm-1">
                           <label>VAT:%5</label>
                           <input type="text" id="gVat" class="form-control" placeholder="VAT:%5" name="gcVat">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Company Commission</label>
                           <input type="text" class="form-control" placeholder="Company Commission" id="companyCommission" name="companyCommission">
                        </div>
                        <div class="form-group col-sm-1">
                           <label>VAT:%5</label>
                           <input type="text" class="form-control" placeholder="VAT:%5" id="ccVat" name="ccVat">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>EF Agent Commission</label>
                           <input type="text" class="form-control" placeholder="EF Agent Commission" id="efAgentCommission" name="efAgentCommission">
                        </div>
                        <div class="form-group col-sm-1">
                           <label>VAT:%5</label>
                           <input type="text" class="form-control" placeholder="VAT:%5" id="efAgentVat" name="efAgentVat">
                        </div>
                        <!-- end edenfort row -->
                        <div class="form-group col-sm-4">
                           <label>Second Agent Name</label>
                           <input type="text" class="form-control" placeholder="Second Agent Name" name="secondAgentName">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Second Agent Company</label>
                           <input type="text" class="form-control" placeholder="Second Agent Company" name="secondAgentCompany">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Phone</label>
                           <input type="text" class="form-control" placeholder="Agent Phone" name="sacPhone">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Second Agent Commission</label>
                           <input type="text" class="form-control" placeholder="Second Agent Commission" id="secondAgentCommission" name="secondAgentCommission">
                        </div>
                        <div class="form-group col-sm-1">
                           <label>VAT:%5</label>
                           <input type="text" class="form-control" placeholder="VAT:%5" name="sacAgentVat" id="sacAgentVat">
                        </div>
                        <!-- end 2nd agent -->
                        <div class="form-group col-sm-4">
                           <label>Third Agent Name</label>
                           <input type="text" class="form-control" placeholder="Third Agent Name" name="thirdAgentName">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Third Agent Company</label>
                           <input type="text" class="form-control" placeholder="Third Agent Company" name="thirdAgentCompany">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Phone</label>
                           <input type="text" class="form-control" placeholder="Agent Phone" name="tacPhone">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Third Agent Commission</label>
                           <input type="text" class="form-control" placeholder="Third Agent Commission" name="thirdAgentCommission">
                        </div>
                        <div class="form-group col-sm-1">
                           <label>VAT:%5</label>
                           <input type="text" class="form-control" placeholder="VAT:%5" name="tacVat">
                        </div>
                        <!--end Third agent row-->
                        <div class="form-group col-sm-2">
                           <label>Payment Terms</label>
                           <select class="form-control" name="paymentTerms">
                              <option value='Cheque'>Cheque </option>
                              <option value='Cash'>Cash </option>
                           </select>
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Cheque# </label>
                           <input type="text" class="form-control" placeholder="Cheque#" name="chequeNumber">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Cheque Amount</label>
                           <input type="text" class="form-control" placeholder="Cheque Amunt" name="chequeAmount">
                        </div>
                        <div class="form-group col-sm-12">
                           <label>Note:</label>
                           <textarea class="form-control" rows="3" name="note"></textarea>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane  p-20" id="profile9" role="tabpanel">
                     <div class="row add_more_docments">
                        
                     </div>
                     <div class="row">
                       <div class="col-md-2">
                          <a href="#" title="Add More" class="btn btn-success mb-3" id="add_more_docments">Add Documents</a>
                        </div>
                     </div>
                     <div class="row">
                       <div class="form-group col-sm-3">
                           <input type="submit" value="Submit" class="btn btn-block btn-lg btn-success deals_submit_btn" name="submitDeal"> 
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!--end of add deal-->
<!--start of add deal popup-->
<div class="modal fade" id="editDealPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
   <div class="modal-dialog modal-lg" style=" max-width:1200px;" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title   content_model_title" id="exampleModalLabel1">Edit Deal</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
            <form  action="{{route('editDeal')}}" class="form-horizontal" id="supervision" method="post" enctype="multipart/form-data">
               @csrf
               <input type="hidden" name="supervision_id">
               <ul class="nav nav-tabs nav-justified" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" data-toggle="tab" href="#home9" role="tab"><span><i class="ti-home"></i></span><span class="tab-heading">Tanenet & Property</span></a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#profile19" role="tab" id="2ndTab"><span><i class="mdi mdi-coin"></i></span><span class="tab-heading">Payment & Commission</span></a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#profile10" role="tab" id="3rdTab"><span><i class="mdi mdi-note"></i></span><span class="tab-heading">Documents</span></a>
                  </li>
               </ul>
               <div class="tab-content tabcontent-border">
                  <div class="tab-pane active p-20" id="home9" role="tabpanel">
                     <div class="row">
                         <div class="form-group col-sm-3">
                           <label>Deal Start Date</label>
                           <input type="date" class="form-control" placeholder="Deal Start Date" name="deal_start_date" id="deal_start_dateee" >
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Contract Start Date</label>
                           <input type="date" class="form-control" placeholder="Form Submission Date" name="startDate" id="contract_start_dateee" >
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Contract End Date<i class="fa fa-lg fa-clock-o " data-toggle="modal" data-target="#reminderModal" aria-hidden="true" style="margin-left:130px;"></i></label>
                           <input type="date" class="form-control" placeholder="Form Submission Date" name="endDate" id="contract_end_dateee" >
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Unit No.</label>
                           <input type="text" class="form-control" placeholder="Unit No." name="unitNo" id="unit_no">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Reference No.</label>
                           <input type="text" class="form-control" name="referenceNo" id="referenceNo">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Broker Name</label>
                           <input type="text" class="form-control" placeholder="Broker Name" name="brokerName" id="broker_name">
                        </div>
                        <!--next row-->
                        <div class="form-group col-sm-3">
                           <label>Client Name</label>
                           <input type="text" class="form-control" placeholder="Client Name" name="clientName" id="client_name">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Contact No.</label>
                           <input type="number" class="form-control" placeholder="Contact No." name="contactNo" id="contanct_no">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Email Id</label>
                           <input type="email" class="form-control" placeholder="Email Id" name="email" id="email">
                        </div>
                        <!--next row-->
                        <div class="form-group col-sm-3">
                           <label>Property Type</label>
                           <input type="text" class="form-control" placeholder="Property Type" name="propertyType" id="property_type">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Rent/sale value</label>
                           <input type="number" class="form-control" placeholder="Rent Dale value" name="rentSale" id="rent_sale_value">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Rental cheques </label>
                           <select class="form-control" name="rentalCheques" id="rentalCheques">
                              <option value='Select Cheque'>Select Cheque </option>
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
                        <div class="form-group col-sm-2">
                           <label>Buildings</label>
                           <select class="form-control insertBuilding" name="building" >
                              <option value="Select Building">Select Building</option>
                              @foreach($buildings as $building)
                              <option value="{{$building->building_name}}" >{{$building->building_name}}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-sm-1" style="padding-top: 20px;">
                           <i class="fa fa-plus add-building" class="btn btn-primary" data-toggle="modal" data-target="#buildingModal" style="font-size:22px;color:black" aria-hidden="true"></i>
                        </div>
                        <div class="row owner-extra-fieldsforEdit" style="width:100%;padding:0px;margin:0px;">
                           <div class="form-group col-sm-3">
                              <label>Owner Name</label>
                              <input type="text" class="form-control" placeholder="Client Name" name="owner_name" id="ownerName">
                           </div>
                           <div class="form-group col-sm-3">
                              <label>Owner Phone</label>
                              <input type="number" class="form-control" placeholder="Owner Phone" name="owner_phone" id="ownerPhone">
                           </div>
                           <div class="form-group col-sm-3">
                              <label style="width:100%;">Owner Email</label>
                              <input type="email" style="width:90%;" class="form-control" placeholder="Owner Email" name="owner_email" id="ownerEmail">
                           </div>
                           <div class="form-group col-sm-3">
                              <label style="width:100%;visibility:hidden"></label>
                              <span style="cursor:pointer" class="add-owner-detailsShowBtn"><i class="fa fa-plus add-owner-detailsShowBtn" style="font-size:18px;"></i><span class='add-more add-owner-detailsShowBtn'>Add More</span></span>
                           </div>
                        </div>
                        <div class="row owner-extra-fieldsSecondOwner" style="width:100%;padding:0px;margin:0px;  display: none;">
                           <div class="form-group col-sm-3"><label>Owner Name</label> <input type="text" class="form-control" placeholder="Client Name" name="owner_name_second" id="ownerNameSecond"> </div>
                           <div class="form-group col-sm-3"> <label>Owner Phone</label> <input type="number" class="form-control" placeholder="Owner Phone" name="owner_phone_second" id="ownerPhoneSecond"> </div>
                           <div class="form-group col-sm-3"> <label style="width:100%;">Owner Email</label> <input type="email" style="width:90%;" class="form-control" placeholder="Owner Email" name="owner_email_second" id="ownerEmailSecond"> </div>
                           <div class="form-group col-sm-3"> <label style="width:100%;visibility:hidden"></label> <span style="cursor:pointer" class="hideBtn"><i class="fa fa-window-close" style="font-size:18px;position:unset !important;"></i><span class="hideBtn">Remove</span></span> </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane  p-20" id="profile19" role="tabpanel">
                     <div class="row" >
                        <div class="form-group col-sm-3">
                           <label>Deal Status </label>
                           <select id="deal_Status" class="form-control" name="dealStatus" >
                              <option value='Select Status'>Select Status </option>
                              <option value='Direct'>Direct</option>
                              <option value='In-Direct'>In-Direct</option>
                           </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-7" style="display:none;">
                           <div class="btn-group mt-4" data-toggle="buttons"  >
                              <label class="btn btn-info active">
                                 <div class="custom-control custom-radio" >
                                    <input type="radio" id="customRadio44" name="vatRadio1" class="custom-control-input" value="Vat From Commisson" checked="">
                              <label class="custom-control-label" for="customRadio4">Vat From Commisson
                              </label>
                              </div>
                              </label>
                              <label class="btn btn-info">
                                 <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio55" name="vatRadio1" value="Vat On Commisson" class="custom-control-input">
                              <label class="custom-control-label" for="customRadio5">Vat On Commisson</label>
                              </div>
                              </label>
                              <label class="btn btn-info">
                                 <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio66" name="vatRadio1" value="Vat From Agent" class="custom-control-input">
                              <label class="custom-control-label" for="customRadio6">Vat From Agent</label>
                              </div>
                              </label>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <!-- start first row agent -->
                        <div class="form-group col-sm-3">
                           <label>Name: Agent</label>
                           <select class="form-control" name="agentName" id="agent_name">
                              @foreach($agents as $agent)
                              <option value="{{$agent->id}}">{{$agent->user_name}}</option>
                              @endforeach                      
                           </select>
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Gross Commission</label>
                           <input type="text" class="form-control" placeholder="Gross Commission " id="gross_commission" name="grossCommission">
                        </div>
                        <div class="form-group col-sm-1">
                           <label>VAT:%5</label>
                           <input type="text" id="gc_vat" class="form-control" placeholder="VAT:%5" name="gcVat">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Company Commission</label>
                           <input type="text" class="form-control" placeholder="Company Commission" id="company_commision" name="companyCommission">
                        </div>
                        <div class="form-group col-sm-1">
                           <label>VAT:%5</label>
                           <input type="text" class="form-control" placeholder="VAT:%5" id="cc_Vat" name="ccVat">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>EF Agent Commission</label>
                           <input type="text" class="form-control" placeholder="EF Agent Commission" id="efAgent_Commission" name="efAgentCommission">
                        </div>
                        <div class="form-group col-sm-1">
                           <label>VAT:%5</label>
                           <input type="text" class="form-control" placeholder="VAT:%5" id="efAgent_Vat" name="efAgentVat">
                        </div>
                        <!-- end edenfort row -->
                        <div class="form-group col-sm-4">
                           <label>Second Agent Name</label>
                           <input type="text" class="form-control" placeholder="Second Agent Name" name="secondAgentName" id="secondAgentName">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Second Agent Company</label>
                           <input type="text" class="form-control" placeholder="Second Agent Company" name="secondAgentCompany" id="secondAgentCompany">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Phone</label>
                           <input type="text" class="form-control" placeholder="Agent Phone" name="sacPhone" id="sacPhone">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Second Agent Commission</label>
                           <input type="text" class="form-control" placeholder="Second Agent Commission" id="secondAgent_Commission" name="secondAgentCommission">
                        </div>
                        <div class="form-group col-sm-1">
                           <label>VAT:%5</label>
                           <input type="text" class="form-control" placeholder="VAT:%5" name="sacAgentVat" id="sacAgent_Vat">
                        </div>
                        <!-- end 2nd agent -->
                        <div class="form-group col-sm-4">
                           <label>Third Agent Name</label>
                           <input type="text" class="form-control" placeholder="Third Agent Name" name="thirdAgentName" id="thirdAgentName">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Third Agent Company</label>
                           <input type="text" class="form-control" placeholder="Third Agent Company" name="thirdAgentCompany" id="thirdAgentCompany">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Phone</label>
                           <input type="text" class="form-control" placeholder="Agent Phone" name="tacPhone" id="tacPhone">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Third Agent Commission</label>
                           <input type="text" class="form-control" placeholder="Third Agent Commission" name="thirdAgentCommission" id="thirdAgentCommission">
                        </div>
                        <div class="form-group col-sm-1">
                           <label>VAT:%5</label>
                           <input type="text" class="form-control" placeholder="VAT:%5" name="tacVat" id="tacVat">
                        </div>
                        <!--end Third agent row-->
                        <div class="form-group col-sm-2">
                           <label>Payment Terms</label>
                           <select class="form-control" name="paymentTerms" id="paymentTerms">
                              <option value='Cheque'>Cheque </option>
                              <option value='Cash'>Cash </option>
                           </select>
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Cheque# </label>
                           <input type="text" class="form-control" placeholder="Cheque#" name="chequeNumber" id="chequeNumber">
                        </div>
                        <div class="form-group col-sm-2">
                           <label>Cheque Amount</label>
                           <input type="text" class="form-control" placeholder="Cheque Amunt" name="chequeAmount" id="chequeAmount">
                        </div>
                        <div class="form-group col-sm-12">
                           <label>Note:</label>
                           <textarea class="form-control" rows="3" name="note" id="note"></textarea>
                        </div>
                        <div class="form-group col-sm-2" style="display:none;">
                           <label>DealId</label>
                           <input type="text" class="form-control" placeholder="id" name="dealId" id="dealId">
                        </div>
                        <!-- <div class="form-group col-sm-3">
                           <input type="submit" value="Submit" class="btn btn-block btn-lg btn-success deals_submit_btn" name="updateDeal"> 
                        </div> -->
                     </div>
                  </div>
                  <div class="tab-pane  p-20" id="profile10" role="tabpanel">
                     <div class="row">
                      <div class="col-md-6 add_more_docments_edit" id="more_docments_edit" style="border-right: 1px solid lightgray;">
                      </div>
                      <div class="col-md-6">
                        <div class="">
                          <label>Attached Documents</label>
                          <div class="dealsdocumentsEdit">
                            
                          </div>
                        </div>
                      </div>
                     </div>
                     <div class="row">
                       <div class="col-md-2">
                          <a href="#" title="Add More" class="btn btn-success mb-3" id="add_more_docments_edit">Add Documents</a>
                        </div>
                     </div>
                     <div class="row">
                       <div class="form-group col-sm-3">
                           <input type="submit" value="Submit" class="btn btn-block btn-lg btn-success deals_submit_btn" name="submitDeal"> 
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!--end of add editDealPopup--> 
<!--add building using ajax, if building not exist-->
<div class="modal fade" id="buildingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Building</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form>
               <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Building Name:</label>
                  <input type="text" class="form-control add-building-input" id="recipient-name">
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-model" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add-building-btn">Add Building</button>
         </div>
      </div>
   </div>
</div>
<!--end off adding building using ajax--> 
<!-- Add popup Reminder ContractDate-->
<div class="modal" id="reminderAddPopupContractDate" role="dialog">
   <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Set Reminder</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body ">
            <div class="form-group">
               <form>
                  <input type="datetime-local" class="form-control reminder_DateTimeAddPopupContractDate" placeholder="set min date" id="min-date" name="reminderAddPopupDateInput" > 
            </div>
            <div class="form-group">
            <textarea class="form-control reminder_descriptionAddPopupContractDate" rows="4" class="" name="reminder_descriptionAddPopup" placeholder="Description"></textarea>
            <input type="hidden" class="reminderAddPopupContractDateName" name="reminderAddPopupName" value="dealContractDate">
            </form>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default close-model" data-dismiss="modal" >Close</button>
            <button type="button" class="btn btn-success reminderAddPopupContractDateSubmit">Ok</button>
         </div>
      </div>
   </div>
</div>
<!--End of Add popup Reminder Contract Date-->
<!--reminder Abdul Edit Popup Contract End Date-->
<div class="modal" id="reminderModal" role="dialog">
   <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Set Reminder</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body ">
            <div class="form-group">
               <form>
                  <input type="datetime-local" class="form-control reminder_DateTime" placeholder="set min date" id="min-date" name="reminderDateInput" > 
            </div>
            <div class="form-group">
            <textarea class="form-control reminder_description" rows="4" class="" name="reminder_description" placeholder="Description"></textarea>
            <input type="hidden" class="reminderDealId" name="reminderDealId">
            </form>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default close-model" data-dismiss="modal" >Close</button>
            <button type="button" class="btn btn-success reminderBtn">Ok</button>
         </div>
      </div>
   </div>
</div>
<!--End of Reminder-->
@include('inc.footer')

@if(session('msg'))
   <script> alertify.success("{!! session('msg') !!}"); </script>
@endif
@if(session('error'))
   <script> alertify.error("{!! session('error') !!}"); </script>
@endif
<!-- Responsive Table js -->
<script src="{{url('public/Green/assets/libs/RWD-Table-Patterns/js/rwd-table.min.js')}}"></script>

<!-- Init js -->
<script src="{{url('public/Green/assets/js/pages/table-responsive.init.js')}}"></script>
<!--start of popups-->
<script src="{{url('public/assets/js/deals_extra.js')}}"></script>
<script type="text/javascript">
   function getdoxuments(id){
    $.ajax({
      url: '{{url("editDealDocuments")}}',
      type: 'get',
      dataType: "json",
      data:{'id':id},
      success:function(data){
        // console.log(data);
        for(var i = 0; i < data.length; i++){
          var path = data[i]["file_path"];
          console.log(path);
          $('.dealsdocumentsEdit').append('<a href="'+path+'" title="" target="_blank">'+data[i]["file_name"]+'</a><br>')
        }
      },
      error:function(e){

      }
    })
  }

  function deleteDeal(id){
    $.confirm({
        title: 'Confirm Deletation!',
        content: 'Are you sure you want to delete this deal!',
        type: 'red',
        buttons: {
            confirm:{
              text: 'Confirm',
              btnClass: 'btn-red',
              action: function(){
                $.ajax({
                  url: '{{url("deleteDeal")}}',
                  type: 'get',
                  dataType: "json",
                  data:{'id':id},
                  success:function(data){
                    alertify.success("Deal deleted successfully");
                    window.location.reload();
                  },
                  error:function(e){
                     alertify.error("Something wents wrong");
                  }
                })
              }
            },
            cancel: function () {
                $.alert('Canceled!');
            }
        }
    });
    
  }
</script>
<script>
   $('#reset_docments').on('click',function(event){
    event.preventDefault();
    $('#more_docments_edit').innerHTML = "";
  });
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