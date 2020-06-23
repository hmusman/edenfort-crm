@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Agent') || ucfirst('SuperDuperAdmin')))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
@if(@$permissions->leadView!=1)
<script type="text/javascript">
    window.location='{{url("404")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<style>
.filter_input {
    background-color: #1976D2;
    color: #fff;
}
.filter_btn{
    height:37px;
}
.filter_input::placeholder{
color:#fff;
}
    .nav-link{
        padding: .5rem 1rem !important;
        text-align:center !important;
        color:black;
    }
    .deals_tabs a {
    padding-top: 8px !important;
    padding-bottom: 8px !important;
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
    .nav-tabs {
    border-bottom: 2px dashed #ddd !important;
    /*margin-bottom: 15px !important;*/
    background: white !important;
    
}
hr{
    margin-bottom:3rem;
}
label,input,textarea{
    font-size:12px !important;
}
.back_btn_row, .prop_back_btn_row, .property_tabs_row, .prop_information_link,.owner_docs_link, .tabs_row, .owner_information_link{
    display:block;
}
</style>


<!-- Email and Phone Model -->


<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title content_model_title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body content_model_body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addPhoneEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{url('addagentEmailPhone')}}" method="get">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body add_model_body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
</form>
  </div>
</div>


<!-- Email and Phone Model -->
        <div class="page-wrapper" style="margin-top: 2%;">
            <div class="container-fluid">
          @if(session('msg'))
                    {!! session('msg') !!}
                @endif
                <!--adding new owner's form  -->
                <div class="row owner_main_row_leads" >
                    <h3 class="page_heading">My Leads</h3>
                  
                   <div class="col-12 col-sm-12 mb-2">
                    <div class="dropdown_wrapper ">
                        
                        
                    @if($permissions->leadAdd==1)                         <a id="add-new-owne-link" data-toggle="modal" data-target="#addNewLead" style="cursor: pointer;float:left"><span><i class="fa fa-plus"></i></span></a>
                                   @endif
                                   
                  <select  class="form-control access_select" name="accessStatus" style="width:180px; float:right; font-size: 11px;font-weight: 500;">
                     <option  value="">Select Option</option>
                     <option  value="upcoming">upcoming</option>
                     <option  value="Follow up">Follow up</option>
                     <option  value="Not Interested">Not Interested </option>
                     <option  value="Interested">Interested </option>
                     <option  value="Deal Closed">Deal Closed</option>
                     <option  value="In Process">In Process</option>
                     <option  value="Viewing">Viewing</option>
                     </select>
                     
             
                                            </div> 
                               
                                            
                                            </div>
                                           
                        <div class="col-12 col-sm-12">
                        
                            <div class="card">
                            
                            
                                <ul class="nav nav-tabs deals_tabs">
    <li class="nav-item">
      @if(@$_GET['type']=='')
            <a href="{{url('leads')}}" class="nav-link active py-3">All Leads</a>
              @else
               <a href="{{url('leads')}}" class="nav-link py-3">All Leads</a>
               @endif 
           </li>
           <li class="nav-item">
            @if(@$_GET['type']=='Rent' )
            <a href="{{url('leads')}}?type=Rent" class="nav-link active py-3">  Rent</a>
            @else
            <a href="{{url('leads')}}?type=Rent" class="nav-link  py-3"> Rent</a>
            @endif
           </li>
                      <li class="nav-item">
                       @if(@$_GET['type']=='Sale' )
            <a href="{{url('leads')}}?type=Sale" class="nav-link active py-3">  Sale</a>
            @else
            <a href="{{url('leads')}}?type=Sale" class="nav-link  py-3"> Sale</a>
            @endif
           </li>
                      <li class="nav-item">
                       @if(@$_GET['type']=='Reminder' )
            <a href="{{url('leads')}}?type=Reminder" class="nav-link active py-3">  Reminder</a>
            @else
            <a href="{{url('leads')}}?type=Reminder" class="nav-link  py-3"> Reminder</a>
            @endif
           </li>
    
     </ul>
     
      
                                <div class="card-body table-responsive">
                                    
                                  
                              <div class="col-lg-12">
                                 <div class="row">
                                   <div class="col-md-12">
                                                   <div class="row">
          @if(@$_GET['type']=='Rent' && @$_GET['priority']=='A')
            <a href="{{url('leads')}}?type=Rent&priority=A" class="nav-link active py-3">  <label  style="cursor: pointer;line-height: 30px; font-size:28px !important; padding-left:15px; padding-right:15px;" class="label label-success ">A</label></a>
          @elseif(@$_GET['type']=='Rent' )
           <a href="{{url('leads')}}?type=Rent&priority=A" class="nav-link active py-3">  <label  style="cursor: pointer; line-height: 30px;  font-size:28px !important; background:#1976D2; padding-left:15px; padding-right:15px;" class="label label-dange ">A</label></a>
         @elseif(@$_GET['type']=='Sale' && @$_GET['priority']=='A')
            <a href="{{url('leads')}}?type=Sale&priority=A" class="nav-link active py-3">  <label  style="cursor: pointer;line-height: 30px; font-size:28px !important; padding-left:15px; padding-right:15px;" class="label label-success ">A</label></a>
          @elseif(@$_GET['type']=='Sale' )
           <a href="{{url('leads')}}?type=Sale&priority=A" class="nav-link active py-3">  <label  style="cursor: pointer; line-height: 30px;  font-size:28px !important; background:#1976D2; padding-left:15px; padding-right:15px;" class="label label-danger ">A</label></a>
           @endif
          <!--B Priority--> 
            @if(@$_GET['type']=='Rent' && @$_GET['priority']=='B')
            <a href="{{url('leads')}}?type=Rent&priority=B" class="nav-link active py-3">  <label  style="cursor: pointer; line-height: 30px; font-size:28px !important; padding-left:15px; padding-right:15px;" class="label label-success ">B</label></a>
          @elseif(@$_GET['type']=='Rent' )
           <a href="{{url('leads')}}?type=Rent&priority=B" class="nav-link active py-3">  <label  style="cursor: pointer; line-height: 30px;  font-size:28px !important; background:#1976D2; padding-left:15px; padding-right:15px;" class="label label-danger ">B</label></a>
         @elseif(@$_GET['type']=='Sale' && @$_GET['priority']=='B')
            <a href="{{url('leads')}}?type=Sale&priority=B" class="nav-link active py-3">  <label  style="cursor: pointer; line-height: 30px; font-size:28px !important; padding-left:15px; padding-right:15px;" class="label label-success ">B</label></a>
          @elseif(@$_GET['type']=='Sale' )
           <a href="{{url('leads')}}?type=Sale&priority=B" class="nav-link active py-3">  <label  style="cursor: pointer; line-height: 30px;  font-size:28px !important; background:#1976D2; padding-left:15px; padding-right:15px;" class="label label-danger ">B</label></a>
           @endif
    <!-- C Priority-->
     @if(@$_GET['type']=='Rent' && @$_GET['priority']=='C')
            <a href="{{url('leads')}}?type=Rent&priority=C" class="nav-link active py-3">  <label  style="cursor: pointer; line-height: 30px; font-size:28px !important; padding-left:15px; padding-right:15px;" class="label label-success ">C</label></a>
          @elseif(@$_GET['type']=='Rent' )
           <a href="{{url('leads')}}?type=Rent&priority=C" class="nav-link active py-3">  <label  style="cursor: pointer; line-height: 30px;  font-size:28px !important; background:#1976D2; padding-left:15px; padding-right:15px;" class="label label-danger ">C</label></a>
         @elseif(@$_GET['type']=='Sale' && @$_GET['priority']=='C')
            <a href="{{url('leads')}}?type=Sale&priority=C" class="nav-link active py-3">  <label  style="cursor: pointer; line-height: 30px; font-size:28px !important; padding-left:15px; padding-right:15px;" class="label label-success ">C</label></a>
          @elseif(@$_GET['type']=='Sale' )
           <a href="{{url('leads')}}?type=Sale&priority=C" class="nav-link active py-3">  <label  style="cursor: pointer; line-height: 30px;  font-size:28px !important; background:#1976D2; padding-left:15px; padding-right:15px;" class="label label-danger ">C</label></a>
           @endif
           
      </div>      
                                       
                      <form action="{{ route('agentleadSearch') }}" method="GET" class="">
                          <div class="row mt-2 mb-2">
                          <div class="col-md-9">
                            <div class="row">
                          @if(isset($_GET['type'])) <input type="hidden" name="type" value="{{@$_GET['type']}}"/> @endif
                          @if(isset($_GET['priority'])) <input type="hidden" name="priority" value="{{@$_GET['priority']}}"/> @endif
                                        <div class="col-md-5 pl-1 pr-1">
                                       <div class="dropdown_wrapper ">
                                           <input type="text" class="form-control filter_input" list="building" placeholder="select Building" name="build">
                                            <datalist id="building">
                                                <option value="">Select building</option>
                                                @foreach($buildings as $building)
                                                <option value="{{$building->building_name}}">{{$building->building_name}}</option>
                                                @endforeach
                                            </datalist>
                                       </div>
                                   </div>
                                   
                                   <div class="col-md-3 pl-1 pr-1">
                                       <div class="dropdown_wrapper "> 
                                           <input type="text" id="name" class="form-control filter_input" list="source" placeholder="select source" >
                                            <datalist id="source">
                                                <option value="">Select source</option>
                                        
                                            <option data-value="You missed a call" value="Dupizzle Missed"></option>
                                             <option data-value="dubizzle - someone is interested in your" value="Dupizzle MAILS"></option>
                                              <option data-value="Bayut Rental Inquiry" value="Bayut Mails"></option>
                                               <option data-value="Call summary" value="PROPERTY FINDER RECEIVED"></option>
                                                <option data-value="propertyfinder.ae - Contact Eden Fort Real Estate" value="PROPERT FINDER MAILS"></option>
                                                 <option data-value="You just got a Dubizzle phone lead!" value=" DUBIZZLE RECEIVED CALLS"></option>
                                                 <option data-value="Bayut.com Lead Notification: CALL Received" value="BAYUT RECEIVED CALLS"></option>
                                                 
                                                  <option data-value="Bayut.com Lead Notification: CALL Missed" value="BAYUT MISSED CALLS"></option>
                                           
                                            </datalist>
                                             <input type="hidden" id="sourceId" name="source" value="">
                                       </div>
                                   </div>
                                       
                                   <!--      <div class="col-md-2 pl-1 pr-1">-->
                                   <!--    <div class="dropdown_wrapper "> -->
                                   <!--        <input type="text" class="form-control filter_input" list="agent" placeholder="select agent" name="agent" style="display: none;">-->
                                   <!--         <datalist id="agent">-->
                                   <!--             <option value="">Select agent</option>-->
                                   <!--      @foreach($agents as  $agent)-->
                                   <!--         <option value="{{$agent}}">{{$agent}}</option>-->
                                   <!--         @endforeach-->
                                   <!--         </datalist>-->
                                   <!--    </div>-->
                                   <!--</div>-->
                                     
                                   
                                     <div class="col-md-2 pl-1 pr-1">
                                       <div class="dropdown_wrapper ">
                                           <input type="text" class="form-control filter_input" list="unit_no" placeholder="contact" name="contact">
                                            <datalist id="contact">
                                                <option value="">contact</option>
                                         
                                            </datalist>
                                       </div>
                                   </div>
                                   
                                </div></div>   
                                   
                                   
                                        <div class="col-md-3 ">
                                       <div class="filter_btn_wrapper">
                                           <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter" name="search">
                                       </div>
                                   </div>
                               </div>
                                    </form>
                               
                              
                                   </div>
                                       
                               </div>
    
                              </div>
                              
                                  
                              <div class="modal fade" id="addNewLead" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
          
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title   content_model_title" id="exampleModalLabel1">Add Lead</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">    
                                <form action="{{url('agentleadForm')}}" method="post" class="form-horizontal" id="supervision" >
                                    @csrf
                                    <input type="hidden" name="supervision_id">
                                    <ul class="nav nav-tabs nav-justified" role="tablist">
                                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#hom" role="tab"><span><i class="ti-home"></i></span><span class="tab-heading">Lead Basic</span></a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#prof" role="tab"><span><i class="far fa-question-circle"></i></span><span class="tab-heading">Lead Detail</span></a> </li>
                                       
                                    </ul>
                                    <div class="tab-content tabcontent-border">
                                        <div class="tab-pane active p-20" id="hom" role="tabpanel">
                                            <div class="row">
                                                <div class="form-group col-sm-3">
                                                    <label>Form Submission Date</label>
                                                    <input type="date" class="form-control" placeholder="Form Submission Date" name="submission_date">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Lead Priority</label>
                        <select class="form-control"  name="priority">
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Client Name</label>
                                                    <input type="text" class="form-control" placeholder="Client Name"  name="client_name">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>CONTACT No.</label>
                                                    <input type="text" class="form-control" placeholder="CONTACT No." name="contact_no">
                                                </div>
                                                <!--next row-->
                                                <div class="form-group col-sm-3">
                                                    <label>EMAIL</label>
                                              <input type="text" class="form-control" placeholder="EMAIL" name="email">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>SOURCE</label>
                                                    <input type="number" class="form-control" placeholder="SOURCE" name="source">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>AREA</label>
                                                    <input type="text" class="form-control" placeholder="AREA" name="area">
                                                </div>
                                                <!--next row-->
                                                      <div class="form-group col-sm-2">
                                                    <label>Building</label>
                       
                                                    <select class="form-control insertBuilding"  name="building" >
                                                        
                                                           @foreach($buildings as $building)
                                                  <option value="{{$building->building_name}}">{{$building->building_name}}</option>
                                                      @endforeach
                                                    </select>
                                                   
                                                </div>
                                          <div class="col-sm-1" style="padding-top: 20px;">
                                    <i class="fa fa-plus add-building" class="btn btn-primary" data-toggle="modal" data-target="#buildingModal" style="font-size:22px;color:black" aria-hidden="true"></i>
                                 </div>       
                                                <div class="form-group col-sm-3">
                                                    <label>TYPE</label>
                                                    
                                                   <select class="form-control"  name="type">
                                                        <option value="Rent">Rent</option>
                                                        <option value="Sale">Sale</option>
                                                    </select>  
                                                    
                                                </div>
                                                
                                                
                                                 <div class="form-group col-sm-3">
                                                    <label>RENT</label>
                                                    <input type="text" class="form-control" placeholder="RENT" name="rent">
                                                </div> 
                                                
                                                <div class="form-group col-sm-3">
                                                    <label>BUY</label>
                                 <input type="text" class="form-control" placeholder="BUY" name="buy">
                                                </div>
                                               
                                            </div>
                                        </div>
                                        <div class="tab-pane  p-20" id="prof" role="tabpanel">
                                            <div class="row">
                                                <div class="form-group col-sm-3">
                                                    <label>Follow Up Date <i class="fa fa-lg fa-clock-o ml-5" data-toggle="modal" data-target="#reminderAddPopupFollowup" aria-hidden="true"></i></label>
<input type="date" class="form-control" placeholder=" " name="followup_date">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>VIEWING DATE/TIME<i class="fa fa-lg fa-clock-o ml-4 " data-toggle="modal" data-target="#reminderAddPopupViewDate" aria-hidden="true"></i></label>
<input type="date" class="form-control " placeholder=" " name="view_date_time">
                                                </div>
                                 <!--reminder hidden fields-->
                                 @foreach($upcomingLeadId[0] as $u)
                             
             
<input type="hidden" name="reminderLeadId" value="{{$u}}" >
   @endforeach
   <!--fields for followup reminder-->
 <input type="hidden" id="reminderAddPopupFollowupName" name="reminderAddPopupName">
  <input type="hidden" id="reminder_DateTimeAddPopupFollowup" name="reminderAddPopupDateInput">
 <input type="hidden" id="reminder_descriptionAddPopupFollowup" name="reminder_descriptionAddPopup">
 
 <!--fields for view date reminder-->
 <input type="hidden" id="reminderAddPopupViewDateName" name="reminderAddPopupViewDateName">
  <input type="hidden" id="reminder_DateTimeAddPopupViewDate" name="reminderAddPopupDateInputViewDate">
 <input type="hidden" id="reminder_descriptionAddPopupViewDate" name="reminder_descriptionAddPopupViewDate">
                                                <!--next row-->
                                    
                                                <div class="form-group col-sm-3">
                                                    <label>MOVE INN</label>
                                                    <input type="text" class="form-control" placeholder="MOVE INN" name="move_inn">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>OUTCOME</label>
 <input type="text" class="form-control" placeholder="OUTCOME" name="outcome">
                                                </div>
                                                <!--next row-->
                                                </div>
                                                <div class="row">
                                                <div class="form-group col-sm-6">
                                                    <label>FOLLOW UP</label>
  <textarea class="form-control" rows="3" name="follow_up"></textarea>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>FEED BACK</label>
                                                    <textarea class="form-control" rows="3" name="feedback"></textarea>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <input type="submit" value="Submit" class="btn btn-block btn-lg btn-success" name="submitLead"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                           </div></div>
                           </div></div>
                           
                           
                                    <table  class="table">
                                        <thead>
                                            <tr>
                                                <th class="checkall" style="cursor:pointer">Select</th>
                                               <th>Date</th>
                                               <th>Client </th> 
                                               <th>Building </th> 
                                               <th>Agent </th> 
                                               <th>Contact </th>
                                              <th>Email </th>
                                               <th>Source </th>
                                                 <th>Type </th>
                                              <th>Rent </th>
                                                <th>Buy</th> 
                                                 <th>status</th> 
                                                <th>Updated_at</th>
                                             <th style="display:none;">Assign</th>    
                                              <th>Action</th>
                                             
                                            </tr>
                                        </thead>     
                         <form id="bulkForm" class="form-inline">
                        <input type='hidden' value='' name='status' class='status'>
                        <input type='hidden' value='' name='time_date' class='time_date_input'>                
                                        <tbody style="font-size: 12px;">
                          @if(isset($leads))
                          
                    @if(count($leads) > 0)
                    <?php $counter=0; ?>
                          
                          @foreach($leads as $lead)
                                            <tr class="present_row">
                       @if($permissions->leadBulk!=1)<td>Not Allowed</td>  @else                                <td>
                                                     <input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$lead->id}}">
                                                 <!-- https://img.icons8.com/cotton/24/000000/circled-right.png -->
                                             <img style="width: 21px;margin-top: -9px !important;" src="public/assets/images/next.png" class="drop_arrow_icon pulse-effect">
                                            
                                          </td>@endif
                                               <td class="lsubmissionDate">@if(!is_null($lead->submission_date)){{date('d M Y' ,strtotime($lead->submission_date))}} @else {{date('d M Y' ,strtotime($lead->created_at))}} @endif</td>
                     <td class="lClient" >{{$lead->client_name}}</td>
                                                 <td class="lUser">{{$lead->building}}</td></td>
                                               <td class="lUser">{{str_replace("</p>","",$lead->lead_user)}}</td></td>
                                     
                                     <td>
                                     <div class="content" >
                                                    <?php $temp=explode(',', $lead->contact_no);
                                                    foreach ($temp as $key=>$value) { ?>
                                                            <span style="display: block;width: 100%;">{{$value}}</span>
                                                    <?php  }  ?>
                                                    </div> <label data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer;position: relative;right: 5px;display: none;" class="label label-success show_EmailPhone" name="Phone Number">Show</label>
                                                            <label data-toggle="modal" data-target="#addPhoneEmail" id="{{$lead->id}}" style="cursor: pointer;display: table-cell;" class="label label-primary add_phone">Add</label>
                                                    </td>          
                    <!--                           <td class="lContact">{{$lead->contact_no}}</td>-->
                    
                     
                     <td>
                                                    <div class="content" style="display: none;">
                                                    <?php $temp=explode(',', $lead->email);foreach ($temp as $key=>$value) { ?>
                                                        <span style="display: block;width: 100%;">{{$value}}</span>
                                                    <?php  }  ?>
                                                    </div>
                                                    <label data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer;display: table-cell;position: relative;right: 5px;" class="label label-success show_EmailPhone" name="Email Address">Show</label>
                                                    <label data-toggle="modal" data-target="#addPhoneEmail" id="{{$lead->id}}" style="cursor: pointer;display: table-cell;" class="label label-primary add_email">Add</label>
                                                </td>
                                                
                                                  
                                                <td class="lSource">{{$lead->lead_source}}</td>
                                                <td class="lType">{{$lead->type}}</td>
                                                
                                      
                                         
                               <td class="lPriority" style="display:none;">{{$lead->priority}}</td> 
                             
                             
                                <td class="lArea" style="display:none;">{{$lead->area}}</td> 
                                <td class="lBuilding" style="display:none;">{{$lead->building}}</td> 
                                
                               
                                  <td class="lRent" >{{$lead->rent}}</td> 
                                   <td class="lBuy" >{{$lead->buy}}</td> 
                                   <td class="lBuy" >{{$lead->status}}</td> 
                                   
                                   <td class="lMovein" style="display:none;">{{$lead->move_inn}}</td> 
                                   <td class="lOutcome" style="display:none;">{{$lead->outcome}}</td> 
                                   <td class="lFollowup" style="display:none;"><?php $counterr= 1; ?>
@foreach($lead->getLeadRecord as $leadd)
{{$counterr++}}) {{date('d-m-Y',strtotime($leadd->created_at))}}
{{$leadd->description}}

@endforeach</td> 
                                   <td class="lFeedback" style="display:none;">{{$lead->feedback}}</td> 
                                                
                                     <td class="lFollowupDate" style="display:none;">{{$lead->followup_date}}</td>  
                                      <td class="lEmail" style="display:none;">{{$lead->email}}</td>  
                                     <td class="lViewDate" style="display:none;">{{$lead->view_date_time}}</td>     
                                              <td class="leadId" style="display:none;">{{$lead->id}}</td>  
                  <td >{{date('d-m-Y' ,strtotime($lead->updated_at))}}</td> 
                 <td style="display: none;"><label data-toggle="modal" data-target="#assignLeadModal" style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="assignPopup" name="{{$lead->id}}"><i class="fa fa-edit"></i> Assign</label></td>
                                       
                  @if($permissions->leadEdit!=1)<td>Not Allowed</td>  @else      <td><label data-toggle="modal" data-target="#exampleModal" style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="show_content" name="{{$lead->id}}"><i class="fa fa-edit"></i> Edit</label>
                                              </td>@endif
                                 
                                        </tr>
                                 <!--TOGGLE ROW START FROM HERE-->
                                       <tr class="toggleable_row">
                                          
                                          <td colspan="19">
                                             <div class="row">
                                              <div class="form-group col-sm-3">
                                                    <label>Follow Up Date <i class="fa fa-lg fa-clock-o ml-5 watchReminderFollowupDate" aria-hidden="true"></i></label>
<input type="date" class="form-control"  name="followup_dateoutside[{{$counter}}]" value="{{$lead->followup_date}}" value="{{$lead->followup_date}}">
                                                </div>
                                                
                                                <div class="form-group col-sm-3">
                                                    <label>VIEWING DATE/TIME<i class="fa fa-lg fa-clock-o ml-4 watchReminderViewDate" aria-hidden="true"></i></label>
  <input type="date" class="form-control viewDateReminder" name="leadViewDateoutside[{{$counter}}]" value="{{$lead->view_date_time}}">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>FOLLOW UP</label>
  <textarea class="form-control" rows="3" name="follow_upoutside[{{$counter}}]" disabled><?php $counterr= 1; ?>
@foreach($lead->getLeadRecord as $leadd)
{{$counterr++}}) {{date('d-m-Y',strtotime($leadd->created_at))}}
{{$leadd->description}}

@endforeach
  </textarea>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>FEED BACK</label>
                                                    <textarea class="form-control" rows="3" name="feedbackoutside[{{$counter}}]" >{{$lead->feedback}}</textarea>
                                                </div>
                                                <!--next row-->
                                             </div>
                                          </td>
                                       </tr>
                             <!--TOGGLE ROW END HERE-->    
                             <?php $counter++; ?>
                            @endforeach
                            @else
                            <tr>
                                          <td colspan="15" align="center">No Record Found</td>
                                       </tr>
                            @endif
                            @endif
                            <!--<tr><td colspan="11" align="center">No Record Found</td></tr>-->
                                         </tbody>
                                         </form>
                                       
                                    </table>
                                </div>
                                <div class="ml-auto pr-3">
  
     {{$leads->appends(Request::only('type','priority','build','source','agent','contact'))->links()}}  
                                                    </div>
                            </div>
                        </div>
                
               
                </div>
                
      
<!--start of assign popup-->
<div class="modal fade" id="assignLeadModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
       <form action="{{url('assignLead')}}" method="post" class="form-horizontal" id="supervision" >
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Assign Lead</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
         <div class="modal-body add_model_body">
        
               <div class="form-group">
               
                                    @csrf
                      <label>Agents</label>
                       
                                                    <select class="form-control"  name="assignedAgent" id="agent">
                                    <option value="Select Agent">Select Agent</option>
                                                           @foreach($agents as $agent)
                                                  <option value="{{$agent}}">{{$agent}}</option>
                                                      @endforeach
                                                    </select>
                    <input type="hidden"  id="assignedId" name="assignedLeadId">        
                                                
              </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default close-model" data-dismiss="modal" >Close</button>
           <button type="submit" class="btn btn-primary ">Assign</button>
        </div>
      </div>
      </form>
      
    </div>
  </div>
  
  
<!--end of assign  popup-->

<!--edit popup-->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
          
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title   content_model_title" id="exampleModalLabel1">Edit Lead</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                    
                                <form action="{{url('agentleadUpdateForm')}}" method="post" class="form-horizontal" id="supervision" >
                                    @csrf
                                    <input type="hidden" name="supervision_id">
                                     <input type="hidden" name="leadEditId" id="leadEditId">
                                     
                                    <ul class="nav nav-tabs nav-justified" role="tablist">
                                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home8" role="tab"><span><i class="ti-home"></i></span><span class="tab-heading">Lead Basic</span></a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile8" role="tab"><span><i class="far fa-question-circle"></i></span><span class="tab-heading">Lead Detail</span></a> </li>
                                       
                                    </ul>
                                    <div class="tab-content tabcontent-border">
                                        <div class="tab-pane active p-20" id="home8" role="tabpanel">
                                            <div class="row">
                                                <div class="form-group col-sm-3">
                                                    <label>Form Submission Date</label>
                                                    <input type="text" class="form-control" name="submission_date" id="submission_date" disabled>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Lead Priority</label>
                        <select class="form-control"  name="priority" id="priority">
                                                      <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Client Name</label>
                                                    <input type="text" class="form-control" placeholder="Client Name"  name="client_name" id="cName" >
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    <label>CONTACT No.</label>
                                                    <input type="text" class="form-control" placeholder="CONTACT No." name="contact_no" id="contactNumber" disabled>
                                                </div>
                                                <div class="col-sm-1" style="padding-top: 8px;">
                                          <i class="fa fa-plus add-building mt-3" class="btn btn-primary" data-toggle="modal" data-target="#addPhoneNumberModal" style="font-size:22px;color:black" aria-hidden="true"></i>
                                       </div>
                                                
                                                <!--next row-->
                                              <!--  <div class="form-group col-sm-3">
                                                    <label>EMAIL</label>
                                                    <input type="email" class="form-control" placeholder="EMAIL" name="email" id="lEmail">
                                                </div>-->
                                                <div class="form-group col-sm-3">
                                                    <label>SOURCE</label>
                                                    <input type="text" class="form-control" placeholder="SOURCE" name="source" id="lSource" disabled>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>AREA</label>
                                                    <input type="text" class="form-control" placeholder="AREA" name="area" id="lArea">
                                                </div>
                                                <!--next row-->
                                                  <div class="form-group col-sm-2">
                                                    <label>Building</label>
                       
                                                    <select class="form-control insertBuilding"  name="building" >
                                                        
                                                           @foreach($buildings as $building)
                                                  <option value="{{$building->building_name}}">{{$building->building_name}}</option>
                                                      @endforeach
                                                    </select>
                                                   
                                                </div>
                                                <div class="col-sm-1" style="padding-top: 20px;">
                                    <i class="fa fa-plus add-building" class="btn btn-primary" data-toggle="modal" data-target="#buildingModal" style="font-size:22px;color:black" aria-hidden="true"></i>
                                 </div>
                                                <div class="form-group col-sm-3">
                                                    <label>TYPE</label>
                                                  
                                              <select class="form-control"  name="type" id="lType">
                                                        <option value="Rent">Rent</option>
                                                        <option value="Sale">Sale</option>
                                                    </select> 
                                                </div>
                                                
                                                
                                                 <div class="form-group col-sm-3">
                                                    <label>RENT</label>
                                                    <input type="text" class="form-control" placeholder="RENT" name="rent" id="lRent">
                                                </div> 
                                                
                                                <div class="form-group col-sm-3">
                                                    <label>BUY</label>
                                 <input type="text" class="form-control" placeholder="BUY" name="buy" id="lBuy">
                                                </div>
                                               
                                            </div>
                                        </div>
                                        <div class="tab-pane  p-20" id="profile8" role="tabpanel">
                                            <div class="row">
                                                <div class="form-group col-sm-3">
                                                    <label>Follow Up Date <i class="fa fa-lg fa-clock-o ml-5 watchReminderFollowupDate" aria-hidden="true"></i></label>
<input type="date" class="form-control" placeholder=" " name="followup_date" id="lFollowupDate" >
                                                </div>
                                                
                                                <div class="form-group col-sm-3">
                                                    <label>VIEWING DATE/TIME<i class="fa fa-lg fa-clock-o ml-4 watchReminderViewDate" aria-hidden="true"></i></label>
  <input type="date" class="form-control viewDateReminder" placeholder=" " name="leadViewDate" id="lViewDate">
                                                </div>
                                                <!--next row-->
                                    
                                                <div class="form-group col-sm-3">
                                                    <label>MOVE INN</label>
                                                    <input type="text" class="form-control" placeholder="MOVE INN" name="move_inn" id="lMovein">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>OUTCOME</label>
 <input type="text" class="form-control" placeholder="OUTCOME" name="outcome" id="lOutcome">
                                                </div>
                                                <!--next row-->
                                                </div>
                                                <div class="row">
                                                <div class="form-group col-sm-6">
                                                    <label>FOLLOW UP</label>
  <textarea class="form-control" rows="3" name="follow_up" id="lFollowup" disabled></textarea>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>FEED BACK</label>
                                                    <textarea class="form-control" rows="3" name="feedback" id="lFeedback"></textarea>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <input type="submit" value="Submit" class="btn btn-block btn-lg btn-success" name="submitLead"> 
                                                    
                                                </div>
                                       
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                                            </div>
                                            <div class="modal-footer">
                                              
                                        </div>
                                    </div>
                                </div>
                                <!--end of edit popup-->
                                <!-- /.modal -->
                                
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
                                
     <!--add phone number in edit lead popup using ajax, if building not exist-->
<div class="modal fade" id="addPhoneNumberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Contact</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form>
               <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Contact Number:</label>
                  <input type="text" class="form-control add-contact-input" id="recipient-name">
                  
                  <input type="text" style="display:none;" class="form-control leadValue" id="leadId">
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-model" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add-contact-btn">Add Contact</button>
         </div>
      </div>
   </div>
</div>
<!--end off adding extra contact number in edit lead popup using ajax-->
    
    <!-- Add popup Reminder followupdate-->
 <div class="modal" id="reminderAddPopupFollowup" role="dialog">
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
                    <input type="datetime-local" class="form-control reminder_DateTimeAddPopupFollowup" placeholder="set min date" id="min-date" name="reminderAddPopupDateInput" > 
                    </div>
                    <div class="form-group">
                                        <textarea class="form-control reminder_descriptionAddPopupFollowup" rows="4" class="" name="reminder_descriptionAddPopup" placeholder="Description"></textarea>
                                        
                                        <input type="hidden" class="reminderAddPopupFollowupName" name="reminderAddPopupName" value="followup_date">
                                  </form>
               </div>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default close-model" data-dismiss="modal" >Close</button>
           <button type="button" class="btn btn-success reminderAddPopupFollowupSubmit">Ok</button>
        </div>
      </div>
      
    </div>
  </div>
  
    <!--End of Add popup Reminder followupdate-->
    
        <!-- Add popup Reminder View date-->
 <div class="modal" id="reminderAddPopupViewDate" role="dialog">
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
                    <input type="datetime-local" class="form-control reminder_DateTimeAddPopupViewDate" placeholder="set min date" id="min-date" name="reminderAddPopupDateInput" > 
                    </div>
                    <div class="form-group">
                                        <textarea class="form-control reminder_descriptionAddPopupViewDate" rows="4" class="" name="reminder_descriptionAddPopup" placeholder="Description"></textarea>
                                        
                                        <input type="hidden" class="reminderAddPopupViewDateName" name="reminderAddPopupName" value="leadViewDate">
                                  </form>
               </div>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default close-model" data-dismiss="modal" >Close</button>
           <button type="button" class="btn btn-success reminderAddPopupViewDateSubmit">Ok</button>
        </div>
      </div>
      
    </div>
  </div>
  
    <!--End of Add popup Reminder View date-->
    <!--reminder Abdul followUp Date-->
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
                                        
                                        <input type="hidden" class="reminderLeadId" name="reminderLeadId">
                  
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
    
  <!--reminder of view Date-->
 <div class="modal" id="reminderViewDate" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Set Reminder </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
         <div class="modal-body ">
        
               <div class="form-group">
                   <form>
                    <input type="datetime-local" class="form-control reminder_ViewDate" placeholder="set min date" id="min-date" name="reminderDateInput" > 
                    </div>
                    <div class="form-group">
                                        <textarea class="form-control reminder_viewDescription" rows="4" class="" name="reminder_description" placeholder="Description"></textarea>
                  <input type="hidden" class="reminderLeadId" name="reminderLeadId">
             </form>
                  
               </div>
            
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default close-model" data-dismiss="modal" >Close</button>
           <button type="button" class="btn btn-success reminderViewBtn">Ok</button>
        </div>
      </div>
      
    </div>
  </div>
  
    <!--End of Reminder-->    
            </div>
              </div>
@include('inc.footer')

<script>

//source filter values
$("#name").on('input', function () {
    var val = this.value;
    if($('#source option').filter(function(){
        if(this.value === val) {
          var sourceValue = $(this).attr("data-value");
          console.log(sourceValue+" if condition");
          $("#sourceId").val(sourceValue);
        }      
    }).length) {
        //send ajax request
        
    }
});

//ACCESS DROPDOWN CODE START HERE  
        $('.access_select').change(function(e){
            
           if(!$('.ind_chk_box:checkbox:checked').val()){
             $(this).val('');
             alert('please select Rows!');
            
         }else{
             // alert($('.ind_chk_box').val());
              var access=$(this).val();
                $('.status').val(access);
            
   
        
          $.ajax({
              url:'<?php echo url('bulkUpdateStatusAgentLeads');  ?>',
              type:'get',
              data : $("#bulkForm").serialize(),
              success:function(data){
                  console.log(data);
                  if(data=="true"){
                      location.reload();
                  }else{
                      alert('something went wrong');
                  }
              }
          })
         }
        })
        
   //ACCESS DROPDOWN CODE END HERE 

//toggleable row start
$('.present_row .drop_arrow_icon').click(function(){
    $(this).parents('.present_row').next('.toggleable_row').toggleClass('tgl_row');
    $(this).toggleClass('rotate_icon');
});
//toggleable row end
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

//assigneAgent Popup

 $(document).delegate('.assignPopup','click',function(){
      
        var $row = $(this).closest("tr"); 
		 var $leadId = $row.find(".leadId").text(); 
		 
    // Let's test it out
       $("#assignedId").val($leadId); 
 });


//add contact in edit popup using ajax

//add popup reminder follow up date
    $('.reminderAddPopupFollowupSubmit').click(function(){
  $("#reminderAddPopupFollowupName").val($('.reminderAddPopupFollowupName').val());
$("#reminder_DateTimeAddPopupFollowup").val($('.reminder_DateTimeAddPopupFollowup').val());
  $("#reminder_descriptionAddPopupFollowup").val($('.reminder_descriptionAddPopupFollowup').val());
$("#reminderAddPopupFollowup").hide();
  
    });
//end of add popup follow up reminder

//add popup reminder View date start
   $('.reminderAddPopupViewDateSubmit').click(function(){
    
  $("#reminderAddPopupViewDateName").val($('.reminderAddPopupViewDateName').val());
    $("#reminder_DateTimeAddPopupViewDate").val($('.reminder_DateTimeAddPopupViewDate').val());
  $("#reminder_descriptionAddPopupViewDate").val($('.reminder_descriptionAddPopupViewDate').val());
$("#reminderAddPopupViewDate").hide();
  
    });
//end of add popup View Date reminder

//viewDate Reminder Start
$('.watchReminderViewDate').click(function(){
       	$('#reminderViewDate').modal();
      });
  $('.reminderViewBtn').click(function(){
	    var reminderDate=$('.reminder_ViewDate').val();
        var reminderDescription=$('.reminder_viewDescription').val();
		var reminderName=$('#lViewDate').attr('name');
		 var reminderLeadId=$('.reminderLeadId').val();
		
	 // alert($('.reminder_DateTime').val());
	   
	      $.ajax({
               type : 'GET',
               url : "{{url('add-viewDateReminder-by-ajax')}}",
    data : {'reminderDate' : reminderDate,'reminderDescription':reminderDescription,'reminderName':reminderName,'reminderLeadId':reminderLeadId},
               success:function(data){
				   
                   if($.trim(data) == 'true'){
            
			     $('.close-model').trigger('click');
                   }else{
					   
                       alert('something went wrong!');
                   }
               }
           })
   });

//viewDate Reminder End

	 //reminder on followupdate
    $('.watchReminderFollowupDate').click(function(){
       	$('#reminderModal').modal();
      });
  $('.reminderBtn').click(function(){
	    var reminderDate=$('.reminder_DateTime').val();
        var reminderDescription=$('.reminder_description').val();
        
      var reminderName=$('#lFollowupDate').attr('name');

       var reminderLeadId=$('.reminderLeadId').val();
       
	 // alert($('.reminder_DateTime').val());
	   
	      $.ajax({
               type : 'GET',
               url : "{{url('add-reminder-by-ajax')}}",
    data : {'reminderDate' : reminderDate,'reminderDescription':reminderDescription,'reminderName':reminderName,'reminderLeadId':reminderLeadId},
               success:function(data){
				   
                   if($.trim(data) == 'true'){
            
			     $('.close-model').trigger('click');
                   }else{
					   
                       alert('something went wrong!');
                   }
               }
           })
   });

	 
//endof reminder on  followupdate 

 $(document).ready(function(){
       $('.add-contact-btn').click(function(){
           var contactNo=$('.add-contact-input').val();
		   var leadId=$('.leadValue').val();
		  
           if(!$('.add-contact-input').val()){
               alert('invalid Building Name');
               return;
           }
           $.ajax({
               type : 'GET',
               url : "{{url('add-contact-by-ajax')}}",
               data : {'contactNo' : contactNo,'leadId':leadId},
               success:function(data){
                   if($.trim(data) == 'true'){
            
			     $('.close-model').trigger('click');
                   }else{
                       alert('something went wrong!');
                   }
               }
           })
       })
   })
//end of add contact in edit popup using ajax


$(document).delegate('.show_EmailPhone','click',function(){
        var content=$(this).prev('.content').html();
        $('.content_model_title').text($(this).attr('name'));
        $('.content_model_body').html(content);
    })

$('body').delegate('.add_phone','click',function(){
    var id=$(this).attr('id');
    $('.add_model_body').html('<label>Phone</label><input type="number" name="phone" class="form-control"><input type="hidden" name="id" class="form-control" value="'+id+'">');
 })	
 $('body').delegate('.add_email','click',function(){
    var id=$(this).attr('id');
    $('.add_model_body').html('<label>Email</label><input type="email" name="email" class="form-control"><input type="hidden" name="id" class="form-control" value="'+id+'">');
 });
	
//fill the toggleable row field reminder id to reminder popup
$(document).delegate('.pulse-effect','click',function(){
    var $rowID = $(this).closest("tr");  
     var $rowleadId = $rowID.find(".leadId").text(); 
     $(".reminderLeadId").val($rowleadId); 
});
//fill the fields when click on edit
   $(document).delegate('.show_content','click',function(){
       
        var $row = $(this).closest("tr");    // Find the row
    var $lContact = $row.find(".lContact").text(); // Find the text
    
    var $lsubmissionDate = $row.find(".lsubmissionDate").text(); 
    
   var $lFollowupDate = $row.find(".lFollowupDate").text(); 
   var $lViewDate = $row.find(".lViewDate").text(); 

     //$('#myinput').val('2013-12-31');   
     
    var $lPriority = $row.find(".lPriority").text(); 
    var $lBuilding = $row.find(".lBuilding").text(); 
    
 
    var $lClient = $row.find(".lClient").text(); 
    var $lSource = $row.find(".lSource").text(); 
    var $lArea = $row.find(".lArea").text(); 
    
    
    
    var $lType = $row.find(".lType").text(); 
    var $lRent = $row.find(".lRent").text(); 
    var $lBuy = $row.find(".lBuy").text();
    
    var $lMovein = $row.find(".lMovein").text(); 
    var $lOutcome = $row.find(".lOutcome").text(); 
    var $lFollowup = $row.find(".lFollowup").text(); 
    var $lFeedback = $row.find(".lFeedback").text(); 

    
    var $lSubject = $row.find(".lSubject").text(); 
    var $lEmail = $row.find(".lEmail").text(); 
    var $leadId = $row.find(".leadId").text(); 
    
    
    // Let's test it out
       $("#submission_date").val($lsubmissionDate); 
       $("#lFollowupDate").val($lFollowupDate); 
       $("#lViewDate").val($lViewDate); 
       
       $("#priority").val($lPriority);
      
       $(".insertBuilding").val($lBuilding); 
       $("#cName").val($lClient); 
       $("#contactNumber").val($lContact);
        $("#lEmail").val($lEmail); 
        $("#lSource").val($lSource); 
        $("#lArea").val($lArea); 
        $("#lType").val($lType); 
        $("#lRent").val($lRent); 
        
        $("#lBuy").val($lBuy); 
        
        $("#lMovein").val($lMovein); 
        $("#lOutcome").val($lOutcome); 
        $("#lFollowup").val($lFollowup); 
        $("#lFeedback").val($lFeedback); 
      
       
        $("#leadId").val($leadId);
		$("#leadEditId").val($leadId);
	 $(".reminderLeadId").val($leadId); 	
    // var content=$('.content').html();
    //  $('.content_model_title').text($(this).attr('name'));
     
    //   $('.content_model_title').text($('.lContact').attr('name'));
    // $('.content_model_body').html(content);
   
   

})
</script>



<script type="text/javascript" src="{{url('public/assets/js/additional.js')}}">
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
</script>
<script>
    // 
    $('.add-new-owne-link_leads').click(function(){
       $('.owner_information_link_leads').slideToggle(); 
    });
     var clicked = false;
    $(".checkall").on("click", function() {
      $(".ind_chk_box").prop("checked", !clicked);
      clicked = !clicked;
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