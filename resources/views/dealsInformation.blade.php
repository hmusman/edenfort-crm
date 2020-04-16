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
<style>
   .filter_input{
   background-color:#1976D2 ;
   color:#fff;
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
    @media only screen and (max-width: 600px) {
      
    }
</style>
<div class="page-wrapper" style="margin-top: 2%;">
   <div class="container-fluid">
      <!--adding new owner's form  -->
      <!-- owners info  -->
      <div class="row owner_main_row_deals" >
         <h3 class="page_heading">My Deals</h3>
         <div class="col-12 col-sm-12 mb-2">
            <div class="dropdown_wrapper ">
               @if(ucfirst(session('role'))==ucfirst('Agent') || ucfirst('SuperAgent')) 
               @if(@$permissions->dealAdd==1) 
               <a id="add-new-owne-link" data-toggle="modal" data-target="#addNewDeal" style="cursor: pointer;float:left"><span><i class="fa fa-plus"></i></span></a>
               @endif 
               @else
               <a id="add-new-owne-link" data-toggle="modal" data-target="#addNewDeal" style="cursor: pointer;float:left"><span><i class="fa fa-plus"></i></span></a>
               @endif
            </div>
         </div>
         <div class="col-12 col-sm-12">
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
                     @if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('SuperAgent')))
                     @if(ucfirst(session('role'))!==ucfirst('Agent')) 
                     @if(basename(url()->current())=='dealsAccountStatement')
                     <a href="{{url('/dealsAccountStatement')}}" class="nav-link active  py-3">Account statement</a>
                     @else
                     <a href="{{url('/dealsAccountStatement')}}" class="nav-link py-3">Account statement</a>
                     @endif
                     @endif
                     @endif
                  </li>
                  <li class="nav-item ml-auto">
                     <select class="form-control access_select" style="font-size: 11px;font-weight: 500;" required name="">
                        <option value="For Rent">For Rent</option>
                        <option  value="For Sale">For Sale</option>
                        <option  value="Upcoming">Upcoming</option>
                        <option value="Do Not Caller">Do Not Caller</option>
                        <option value="Add Property">Add Property</option>
                     </select>
                  </li>
               </ul>
               <div class="card-body">
                   <form action="{{url('dealsInfo')}}" method="get" style="width:100%">
                        <div class="row" style="padding: 0px;margin: 0px;position: relative;top: -15px;">
                            <div class="col-md-10">
                                <div class="row mt-2 mb-2">
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
                                                <option data-value="{{$agent->id}}" value="{{$agent->user_name}}" >{{$agent->user_name}}</option>
                                            @endforeach
                                         </datalist>
                                         <input type="hidden" id="agentId" name="agent" value="">
                                      </div>
                                   </div>
                                   <div class="col-md-3 " style="padding-top: 31px;">
                                      <div class="filter_btn_wrapper">
                                         <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter">
                                      </div>
                                   </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                            <div class="form-group ml-auto">
                                <input id="demo-input-search2" class="demo-input-search" type="text" placeholder="Search" autocomplete="off">
                            </div>
                            </div>
                            </div>
                  </form>
                  <!--start of add deal popup-->
                  <div class="modal fade" id="addNewDeal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                     <div class="modal-dialog modal-lg" style=" max-width:1200px;" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h4 class="modal-title   content_model_title" id="exampleModalLabel1">Add Deal</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                           </div>
                           <div class="modal-body">
                              <form  action="{{route('dealForm')}}" class="form-horizontal" id="supervision" method="post">
                                 @csrf
                                 <input type="hidden" name="supervision_id">
                                 <ul class="nav nav-tabs nav-justified" role="tablist">
                                    <li class="nav-item">
                                       <a class="nav-link active" data-toggle="tab" href="#home8" role="tab"><span><i class="ti-home"></i></span><span class="tab-heading">Tanenet & Property</span></a>
                                    </li>
                                    <li class="nav-item">
                                       <a class="nav-link" data-toggle="tab" href="#profile8" role="tab" id="2ndTab"><span><i class="mdi mdi-coin"></i></span><span class="tab-heading">Payment & Commission</span></a>
                                    </li>
                                 </ul>
                                 <div class="tab-content tabcontent-border">
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
                                                <option value="{{$agent->id}}">{{$agent->user_name}}</option>
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
                  <div class="table-responsive">
                  <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny demo-pagination">
                     <thead>
                        <tr>
                           <th>Select</th>
                           <th>Deal Start</th>
                           <th>Contract Start</th>
                           
                           <th>Contract End</th>
                           <th>Building Name </th>
                           <th>Reference Number </th>
                           <th>Broker</th>
                           <th>Unit</th>
                           <th>Client</th>
                           <th>Contact </th>
                           <th>Access</th>
                           <!--<th>Action</th>-->
                        </tr>
                     </thead>
                     <tbody style="font-size: 12px;">
                        @if(isset($deals))
                        @if(count($deals) > 0)
                        <?php $counter=0;  ?>
                        @foreach($deals as $deal)
                        <tr>
                           @if(ucfirst(session('role'))==ucfirst('Agent') ) 
                           @if(@$permissions->dealBulk!=1)
                           <td>Not Allowed</td>
                           @else 
                           <td><input type="checkbox" name="" class="ind_chk_box" value=""></td>
                           @endif
                           @else
                           <td><input type="checkbox" name="" class="ind_chk_box" value=""></td>
                           @endif
                           <td class="dealId" style="display:none;">{{$deal->id}}</td>
                           <td class="deal_start_date">{{$deal->deal_start_date}}</td>
                           <td class="contract_start_date">{{$deal->contract_start_date}}</td>
                           <td class="contract_end_date">{{$deal->contract_end_date}}</td>
                           <td class="building">{{$deal->building}}</td>
                           <td class="referenceNo">{{$deal->referenceNo}}</td>
                           <td class="broker_name">{{$deal->broker_name}}</td>
                           <td class="unit_no">{{$deal->unit_no}}</td>
                           <td class="client_name">{{$deal->client_name}}</td>
                           <td class="contanct_no">{{$deal->contanct_no}}</td>
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
                           <td><label data-toggle="modal" data-target="#editDealPopup" style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="editDealRow edit_supervision" name="{{$deal->id}}"><i class="fa fa-edit"></i> Edit</label>
                           </td>
                           @endif
                           @else
                           <td><label data-toggle="modal" data-target="#editDealPopup" style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="editDealRow edit_supervision" name="{{$deal->id}}"><i class="fa fa-edit"></i> Edit</label>
                           </td>
                           @endif                    
                        </tr>
                        @endforeach
                        @else
                        <tr>
                           <td colspan="15" align="center">No Record Found</td>
                        </tr>
                        @endif 
                        @endif        
                     </tbody>
                     <tfoot>
                            <tr>
                                <td colspan="16">
                                    <div class="text-right">
                                        <ul style="visibility:hidden;" class="pagination pagination-split m-t-30"> </ul>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                  </table>

                  {{$deals->appends(Request::only('start_date','end_date','agent'))->links()}}
                    </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--start of add deal popup-->
<div class="modal fade" id="editDealPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
   <div class="modal-dialog modal-lg" style=" max-width:1200px;" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title   content_model_title" id="exampleModalLabel1">Edit Deal</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
            <form  action="{{route('editDeal')}}" class="form-horizontal" id="supervision" method="post">
               @csrf
               <input type="hidden" name="supervision_id">
               <ul class="nav nav-tabs nav-justified" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" data-toggle="tab" href="#home9" role="tab"><span><i class="ti-home"></i></span><span class="tab-heading">Tanenet & Property</span></a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#profile9" role="tab" id="2ndTab"><span><i class="mdi mdi-coin"></i></span><span class="tab-heading">Payment & Commission</span></a>
                  </li>
               </ul>
               <div class="tab-content tabcontent-border">
                  <div class="tab-pane active p-20" id="home9" role="tabpanel">
                     <div class="row">
                         <div class="form-group col-sm-3">
                           <label>Deal Start Date</label>
                           <input type="date" class="form-control" placeholder="Deal Start Date" name="deal_start_date" id="deal_start_date">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Contract Start Date</label>
                           <input type="date" class="form-control" placeholder="Form Submission Date" name="startDate" id="contract_start_date">
                        </div>
                        <div class="form-group col-sm-3">
                           <label>Contract End Date<i class="fa fa-lg fa-clock-o " data-toggle="modal" data-target="#reminderModal" aria-hidden="true" style="margin-left:130px;"></i></label>
                           <input type="date" class="form-control" placeholder="Form Submission Date" name="endDate" id="contract_end_date">
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
                  <div class="tab-pane  p-20" id="profile9" role="tabpanel">
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
                        <div class="form-group col-sm-3">
                           <input type="submit" value="Submit" class="btn btn-block btn-lg btn-success deals_submit_btn" name="updateDeal"> 
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
<!--start of popups-->
<script>
$("#name").on('input', function () {
      var val = this.value;
      if($('#allNames option').filter(function(){
          if(this.value === val) {
            var agentId = $(this).attr("data-value");
            console.log(agentId+" if condition");
            $("#agentId").val(agentId);
          }      
      }).length) {
          //send ajax request
          
      }
   });
   //add popup reminder Contract date start
      $('.reminderAddPopupContractDateSubmit').click(function(){
       
     $("#reminderAddPopupContractDateName").val($('.reminderAddPopupContractDateName').val());
       $("#reminder_DateTimeAddPopupContractDate").val($('.reminder_DateTimeAddPopupContractDate').val());
     $("#reminder_descriptionAddPopupContractDate").val($('.reminder_descriptionAddPopupContractDate').val());
   $("#reminderAddPopupContractDate").hide();
     
       });
   //end of add popup Contract Date reminder
   
   
   //start of reminder on EditPopup ContractDate
     $('.reminderBtn').click(function(){
   	    var reminderDate=$('.reminder_DateTime').val();
           var reminderDescription=$('.reminder_description').val();
           
         var reminderName="dealContractDate";
   
          var reminderDealId=$('.reminderDealId').val();
          
   	 // alert($('.reminder_DateTime').val());
   	   
   	      $.ajax({
                  type : 'GET',
                  url : "{{url('add-reminder-by-ajaxDealReminder')}}",
       data : {'reminderDate' : reminderDate,'reminderDescription':reminderDescription,'reminderName':reminderName,'reminderDealId':reminderDealId},
                  success:function(data){
   				   
                      if($.trim(data) == 'true'){
               
   			     $('.close-model').trigger('click');
                      }else{
   					   
                          alert('something went wrong!');
                      }
                  }
              })
      });
   
   	 
   //endof reminder on EditPopup ContractDate
   
   //add building using ajax
     $(document).ready(function(){
     $('.add-building-btn').click(function(){
          var buildingName=$('.add-building-input').val();
             
              if(!$('.add-building-input').val()){
                  alert('invalid Building Name');
                  return;
              }
              $.ajax({
                  type : 'GET',
                  url : "{{url('add-building-by-ajax')}}",
                  data : {'buldingName' : buildingName},
                  success:function(data){
                      if($.trim(data) == 'true'){
               
                          $('.insertBuilding').append('<option selected value='+buildingName+'>'+buildingName+'</option>');
                          $('.close-model').trigger('click');
                      }else{
                          alert('something went wrong!');
                      }
                  }
              })
          })
      })
</script>
<script>
   // Owner Details Add Row
   $('.add-owner-details').click(function(){
       
       $('<div class="row owner-extra-fields" style="width:100%;padding:0px;margin:0px;"><div class="form-group col-sm-3"><label>Owner Name</label> <input type="text" class="form-control " placeholder="Client Name" name="owner_name_second " > </div><div class="form-group col-sm-3"> <label>Owner Phone</label> <input type="number" class="form-control" placeholder="Owner Phone" name="owner_phone_second" > </div><div class="form-group col-sm-3"> <label style="width:100%;">Owner Email</label> <input type="email" style="width:90%;" class="form-control" placeholder="Owner Email" name="owner_email_second"> </div><div class="form-group col-sm-3"> <label style="width:100%;visibility:hidden"></label> <span style="cursor:pointer" class="remove-owner-details"><i class="fa fa-window-close" style="font-size:18px;position:unset !important;"></i><span class="add-more">Remove</span></span> </div></div>').insertAfter('.owner-extra-fields');
     
   
       $(this).hide();
   })
   
      $(document).ready(function(){
          $(document).delegate('.remove-owner-details','click',function(){
               $(this).parent().parent().remove();
               $('.add-owner-details').show();
               $(this).hide();
           })
      })
      
      //edit popup  add second owner show
        $(document).ready(function(){
          $(document).delegate('.hideBtn','click',function(){
               
               $('.owner-extra-fieldsSecondOwner').hide();
               $(this).hide();
               $('.add-owner-detailsShowBtn').show();
           })
      })
      //edit popup  add second owner hide
         $(document).ready(function(){
          $(document).delegate('.add-owner-detailsShowBtn','click',function(){
               
               $('.owner-extra-fieldsSecondOwner').show();
               $(this).hide();
                $('.hideBtn').show();
           })
      })
      // Owner Details Add Row for Edit popup
     var $row;
      $(document).delegate('.editDealRow','click',function(){
          
         $row = $(this).closest("tr");    // Find the row
         var $deal_start_date = $row.find(".deal_start_date").text(); 
         console.log($deal_start_date);
       var $contract_start_date = $row.find(".contract_start_date").text(); 
       var $contract_end_date = $row.find(".contract_end_date").text(); 
       var $unit_no = $row.find(".unit_no").text(); 
   	var $referenceNo = $row.find(".referenceNo").text(); 
   	var $broker_name = $row.find(".broker_name").text(); 
   	var $client_name = $row.find(".client_name").text(); 
   	var $contanct_no = $row.find(".contanct_no").text(); 
   	var $email = $row.find(".email").text(); 
   	var $property_type = $row.find(".property_type").text(); 
   	var $rent_sale_value = $row.find(".rent_sale_value").text(); 
   	var $rentalCheques = $row.find(".rentalCheques").text(); 
   	var $building = $row.find(".building").text(); 
   	var $deal_Status = $row.find(".deal_Status").text(); 
   	var $unit_no = $row.find(".unit_no").text();
   	 var $agent_name = $row.find(".agent_name").text(); 
   	var $gross_commission = $row.find(".gross_commission").text(); 
   	var $gc_vat = $row.find(".gc_vat").text(); 
   	var $company_commision = $row.find(".company_commision").text(); 
   	var $cc_Vat = $row.find(".cc_Vat").text(); 
   	var $efAgent_Commission = $row.find(".efAgent_Commission").text(); 
   	var $efAgent_Vat = $row.find(".efAgent_Vat").text(); 
   	var $secondAgentName = $row.find(".secondAgentName").text(); 
   	var $secondAgentCompany = $row.find(".secondAgentCompany").text(); 
   	var $sacPhone = $row.find(".sacPhone").text(); 
   	var $secondAgent_Commission = $row.find(".secondAgent_Commission").text(); 
   	var $sacAgent_Vat = $row.find(".sacAgent_Vat").text(); 
   	var $thirdAgentName = $row.find(".thirdAgentName").text(); 
   	var $thirdAgentCompany = $row.find(".thirdAgentCompany").text(); 
   	var $tacPhone = $row.find(".tacPhone").text(); 
   	var $thirdAgentCommission = $row.find(".thirdAgentCommission").text(); 
   	var $tacVat = $row.find(".tacVat").text(); 
   	var $paymentTerms = $row.find(".paymentTerms").text(); 
   	
   	var $chequeNumber = $row.find(".chequeNumber").text(); 
   	var $ownerCompanyName = $row.find(".ownerCompanyName").text(); 
   	var $ownerName = $row.find(".ownerName").text(); 
   	var $ownerPhone = $row.find(".ownerPhone").text(); 
   	var $ownerEmail = $row.find(".ownerEmail").text(); 
   	
   	var $ownerNameSecond = $row.find(".ownerNameSecond").text(); 
   	var $ownerPhoneSecond = $row.find(".ownerPhoneSecond").text(); 
   	var $ownerEmailSecond = $row.find(".ownerEmailSecond").text(); 
        if ($ownerNameSecond) {
           
           $(".owner-extra-fieldsSecondOwner").show();
           $(".add-owner-detailsShowBtn").hide();
           $(".hideBtn").show();
        }else{
             $(".owner-extra-fieldsSecondOwner").hide();
              $(".add-owner-detailsShowBtn").show();
        }
        
        
   	var $chequeAmount = $row.find(".chequeAmount").text(); 
   	var $note = $row.find(".note").text(); 
   	var $dealId = $row.find(".dealId").text(); 
   	
   	
       // Let's assign fetched data rows data to edit popup fields
   	        $("#deal_start_date").val($deal_start_date); 
          $("#contract_start_date").val($contract_start_date); 
          $("#contract_end_date").val($contract_end_date); 
          $("#unit_no").val($unit_no); 
   	   $("#referenceNo").val($referenceNo); 
          $("#broker_name").val($broker_name); 
   	   $("#client_name").val($client_name); 
          $("#contanct_no").val($contanct_no); 
   	   $("#email").val($email); 
          $("#property_type").val($property_type); 
   	   $("#rent_sale_value").val($rent_sale_value); 
          $("#rentalCheques").val($rentalCheques);
   	    $(".insertBuilding").val($building); 
          $("#deal_Status").val($deal_Status); 
   	   $("#agent_name").val($agent_name); 
          $("#gross_commission").val($gross_commission); 
   	   $("#gc_vat").val($gc_vat); 
          $("#company_commision").val($company_commision);
   	    $("#cc_Vat").val($cc_Vat); 
          $("#efAgent_Commission").val($efAgent_Commission); 
   	   $("#efAgent_Vat").val($efAgent_Vat); 
          $("#secondAgentName").val($secondAgentName); 
   	   $("#secondAgentCompany").val($secondAgentCompany); 
          $("#sacPhone").val($sacPhone); 
   	   $("#secondAgent_Commission").val($secondAgent_Commission); 
          $("#sacAgent_Vat").val($sacAgent_Vat);
   	    $("#thirdAgentName").val($thirdAgentName); 
          $("#thirdAgentCompany").val($thirdAgentCompany);
   	    $("#tacPhone").val($tacPhone); 
          $("#thirdAgentCommission").val($thirdAgentCommission);
   	    $("#tacVat").val($tacVat); 
          $("#paymentTerms").val($paymentTerms);
   	    $("#chequeNumber").val($chequeNumber); 
          $("#unit_no").val($unit_no);
   	    $("#ownerCompanyName").val($ownerCompanyName); 
          $("#ownerName").val($ownerName);
   	    $("#ownerPhone").val($ownerPhone); 
          $("#unit_no").val($unit_no);
   	    $("#ownerEmail").val($ownerEmail); 
   	    
   	  
   	    $("#ownerNameSecond").val($ownerNameSecond);
   	    $("#ownerPhoneSecond").val($ownerPhoneSecond);
   	    $("#ownerEmailSecond").val($ownerEmailSecond);
   	    
   	    
          $("#chequeAmount").val($chequeAmount);
   	    $("#note").val($note);
   		$("#dealId").val($dealId);
   	 $(".reminderDealId").val($dealId); 
   })
</script>
<script type="text/javascript" src="{{url('public/assets/js/additional.js')}}">
   jQuery('#datepicker-autoclose').datepicker({
       autoclose: true,
       todayHighlight: true
   });
</script>
<script type="text/javascript">
   $('#add-new-owne-link').click(function(){
       $('.owner_information_link_deals').slideToggle();
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
    @endif

</body>
</html>