@include('inc.header')
@if(!session("user_id") && strtoupper(session('role'))!=(strtoupper('Admin') || strtoupper('SuperAgent') || strtoupper('SuperDuperAdmin')))
<script type="text/javascript">
   window.location='{{url("/")}}';
</script>
<?php redirect('/'); ?>
@endif
<style>
  @media (max-width: 550px){
    .table-responsive {
      display: block !important;
    }
    .top-buttons .row img{
      height: 36px !important;
    }
    .top-buttons .row p{
      padding-top: 10px;
      font-size: 13px;
    }
    .btn-group{
      height: 90px !important;
    }
    .whatsapp .row p, .whatsapp_2 .row p, .gmail .row p{
      font-size: 10px !important;
    }
    .msg-status, .msg-status-2{
      font-size: 8px !important;
      font-weight: 500;
      position: absolute;
      margin-top: 0px !important;
      margin-left: 37px;
    }
    .email-loader{
      height: 20px !important;
      visibility: hidden;
      position: relative;
      left: 36px !important;
      margin-top: -56px !important;
    }
    .add-prop{
      color: white !important;
      font-size: 15px;
      padding: 17px 22px 17px 22px;
      margin-top: -58px !important;
      margin-left: -14px !important;
    }
    .all_property_card {
        width: 111% !important;
        margin-left: -17px !important;
    }
    .adminAssign, .adminExport{
        margin-top: 3px !important;
    }
    .pagination {
        float: none !important;
        font-size: 13px !important;
        overflow-x: auto !important;
    }
    
  }
  .table-responsive {
    display: inline-table; 
  }
  .rotate_icon {
      transition: 0.5s;
      transition-property: all;
      transition-duration: 0.5s;
      transition-timing-function: ease;
      transition-delay: 0s;
      transform: rotate(90deg);
  }
  .drop_arrow_icon {
      cursor: pointer;
  }
  .toggleable_row {
      display: none;
  }
  .tgl_row {
      display: table-row !important;
  }
  .btn-outline-dark:not(:disabled):not(.disabled).active{
    color: #fff;
    background-color: #47b38b;
    border-color: #47b38b;
}
  .modal-body .row .data{
    padding:10px 0px;
    border: 1px solid #ccc;
    border-bottom: 0px;
  }
  .datepickers-container{
    z-index: 1065;
  }
   .show_email, .show_content{
       cursor: pointer;
       position: relative;
       right: 5px;
       display: table-cell;
       background-color: #2fa97c;
       color: white;
       padding: 1px 4px 0px 6px;
       border-radius: 50px;
   }
   .add_email, .add_phone{
       cursor: pointer;
       position: relative;
       right: 5px;
       display: table-cell;
       background-color: #3051d3;
       color: white;
       padding: 1px 4px 0px 6px;
       border-radius: 50px;
   }
   .pagination{
      float: right;
   }
   .all_property_card{
      width: 104%;
      margin-left: -25px;
   }
   .property_table{
      margin-top: 15px !important;
      font-size: 11px;
      font-weight: bold;
   }
   .card-header {
       padding: .75rem 1.25rem;
       margin-bottom: 0;
       background-color: #ffffff;
       border-bottom: 1px solid #edeff1;
   }
   #add-new-owne-link:hover{
      transform: rotate(180deg);
   }
   .go-back-prop:hover{
      color: white !important;
   }
   .add-prop{
      cursor: pointer;
      color: white !important;
      font-size: 15px;
      padding: 17px 22px 17px 22px;
      margin-top: -40px;
   }
   .nav-tabs {
       border-bottom: 1px solid #2fa97c;
   }
    .nav-tabs .nav-link.active {
       color: #ffffff;
       background-color: #2fa97c;
       border-color: #2fa97c #2fa97c #2fa97c;
   }
   .top-buttons{
      font-size: 18px;
      font-weight: bold;
      padding: 10px 29px 6px 23px;
   }
   .btn-outline-dark {
       color: white;
       border-color: #47b38b;
   }
   .btn-outline-dark:hover {
       color: #fff;
       background-color: #47b38b;
       border-color: #47b38b;
   }
   .btn-outline-dark:not(:disabled):not(.disabled):active{
       color: #fff;
       background-color: #47b38b;
       border-color: #47b38b;
   }
   a[type="button"]{
          color: white;
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
                    <div class="col-md-3">
                        <h4 class="page-title mb-1">Properties</h4>
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Edenfort Properties</li>
                        </ol>
                    </div>
                    <div class="col-md-6">
                        <div class="btn-group" role="group" aria-label="Basic example">
                           @if(@$_GET['p']=='Dewa')
                           <a href="{{url('property')}}?p=Dewa" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light active">
                              <div class="row" style="padding: 0px 9px 0px 9px;">
                                 <img src="{{url('public/Green/assets/images/icons/browser.png')}}" style="height: 57px;">&nbsp;&nbsp;<p style="padding-top: 22px;">DEWA</p> 
                              </div>
                           </a>
                           @else
                           <a href="{{url('property')}}?p=Dewa" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light">
                              <div class="row" style="padding: 0px 9px 0px 9px;">
                                 <img src="{{url('public/Green/assets/images/icons/browser.png')}}" style="height: 57px;">&nbsp;&nbsp;<p style="padding-top: 22px;">DEWA</p> 
                              </div>
                           </a>
                           @endif
                           @if(@$_GET['p']=='Commercial')
                           <a href="{{url('property')}}?p=Commercial" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light active">
                              <div class="row" style="padding: 0px 9px 0px 9px;">
                                 <img src="{{url('public/Green/assets/images/icons/shanghai.png')}}" style="height: 57px;">&nbsp;&nbsp;<p style="padding-top: 22px;">Commercial</p> 
                              </div>
                           </a>
                           @else
                           <a href="{{url('property')}}?p=Commercial" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light">
                              <div class="row" style="padding: 0px 9px 0px 9px;">
                                 <img src="{{url('public/Green/assets/images/icons/shanghai.png')}}" style="height: 57px;">&nbsp;&nbsp;<p style="padding-top: 22px;">Commercial</p> 
                              </div>
                           </a>
                           @endif
                           @if(@$_GET['p']=='Residential')
                           <a href="{{url('property')}}?p=Residential" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light active">
                              <div class="row" style="padding: 0px 9px 0px 9px;">
                                 <img src="{{url('public/Green/assets/images/icons/appartment.png')}}" style="height: 57px;">&nbsp;&nbsp;<p style="padding-top: 22px;">Residential</p> 
                              </div>
                           </a>
                           @else
                           <a href="{{url('property')}}?p=Residential" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light">
                              <div class="row" style="padding: 0px 9px 0px 9px;">
                                 <img src="{{url('public/Green/assets/images/icons/appartment.png')}}" style="height: 57px;">&nbsp;&nbsp;<p style="padding-top: 22px;">Residential</p> 
                              </div>
                           </a>
                           @endif
                       </div><br><br>
                       <ol class="breadcrumb ml-3">
                           <div class="btn-group" role="group" aria-label="Basic example">
                              <a target="_blank" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light whatsapp" style="border-radius: 50px 0px 0px 50px;">
                                 <div class="row" style="padding: 0px 9px 0px 9px;">
                                    <img src="{{url('public/Green/assets/images/icons/whatsapp.png')}}" style="height: 40px;">&nbsp;&nbsp;<p style="padding-top: 10px;font-size: 16px;">Without Owner</p> <br>
                                    <span class="msg-status" style="font-size:10px;font-weight:500;position:absolute;margin-top: 40px;margin-left: 37px;"></span>
                                 </div>
                              </a>
                              <a target="_blank" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light whatsapp_2">
                                 <div class="row" style="padding: 0px 9px 0px 9px;">
                                    <img src="{{url('public/Green/assets/images/icons/whatsapp.png')}}" style="height:40px;">&nbsp;&nbsp;<p style="padding-top: 10px;font-size: 16px;">With Owner</p> <br>
                                    <span class="msg-status-2" style="font-size:10px;font-weight:500;position:absolute;margin-top: 40px;margin-left: 37px;"></span>
                                 </div>
                              </a>
                              <a type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light gmail" data-toggle="modal" data-target="#emailmodel" style="border-radius: 0px 50px 50px 0px;">
                                 <div class="row" style="padding: 0px 9px 0px 9px;">
                                    <img src="{{url('public/Green/assets/images/icons/gmail.png')}}" style="height: 40px;">&nbsp;&nbsp;<p style="padding-top: 10px;font-size: 16px;">Gmail</p> <br>
                                    <img src="https://thumbs.gfycat.com/UnitedSmartBinturong-small.gif" class="email-loader" style="height:27px;visibility:hidden;position: relative;left: 15px;margin-top: 10px;">
                                 </div>
                              </a>
                          </div>
                        </ol>
                    </div>
                    <div class="col-md-3">
                        <div class="float-right d-md-block">
                            <div class="dropdown">
                                <select class="form-control access_select" name="accessStatus" style="border-radius: 50px;padding: 7px 10px 7px 11px;">
                                    <option value="">Select Option</option>
                                    <option value="For Sale">For Sale</option>
                                    <option value="upcoming">Upcoming</option>
                                    <option value="For Rent">For Rent</option>
                                    <option value="Call Back">Call Back</option>
                                    <option value="Not answering">Not answering</option>
                                    <option value="Not Intrested">Not Intrested</option>
                                    <option value="Interested">Interested</option>
                                 </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                       <a class="btn btn-success btn-rounded waves-effect waves-light add-prop" id="add-new-owne-link" style="cursor: pointer;" class="mb-1"><span><i class="fa fa-plus"></i></span></a>

                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

<!-- End OF MODALS -->
        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card all_property_card" style="<?php if(isset($_GET["action"])){echo "display: none;";}else{echo "display: block;";} ?>">
                          <input id="model" data-toggle="modal" data-target=".bs-example-modal-sm" class="btn btn-danger"  style="visibility: hidden;" type="button" value="">
                            <div class="card-body">
                              <ul class="nav nav-tabs" role="tablist">
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='')
                                     <a class="property-tab nav-link active" href="{{url('property')}}<?php if(isset($_GET['p'])){ echo '?p='.$_GET['p'];} ?>" role="tab"><span class="d-md-inline-block">All property</span> 
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('property')}}<?php if(isset($_GET['p'])){ echo "?p=".$_GET['p'];} ?>" role="tab"><span class="d-md-inline-block">All property</span> 
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                     @if(@$_GET['type']=='For Rent')
                                     <a class="property-tab nav-link active" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=For Rent" role="tab">
                                       <span class="d-md-inline-block">For Rent</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=For Rent"role="tab">
                                       <span class="d-md-inline-block">For Rent</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='For Sale')
                                     <a class="property-tab nav-link active" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=For Sale" role="tab">
                                       <span class="d-md-inline-block">For Sale</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=For Sale" role="tab">
                                       <span class="d-md-inline-block">For Sale</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='upcoming')
                                     <a class="property-tab nav-link active" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=upcoming" role="tab">
                                       <span class="d-md-inline-block">Upcoming</span><span class="badge badge-pill badge-success @if($upcoming==0) hide @endif">{{$upcoming}}</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=upcoming" role="tab">
                                       <span class="d-md-inline-block">Upcoming</span>
                                       <span class="badge badge-pill badge-success @if($upcoming==0) hide @endif">{{$upcoming}}</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='Call back')
                                     <a class="property-tab nav-link active" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=Call back" role="tab">
                                       <span class="d-md-inline-block">Callback</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=Call back" role="tab">
                                       <span class="d-md-inline-block">Callback</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='Not Answering')
                                     <a class="property-tab nav-link active" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=Not Answering" role="tab">
                                       <span class="d-md-inline-block">Not Answering</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=Not Answering" role="tab">
                                       <span class="d-md-inline-block">Not Answering</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='Not Interested')
                                     <a class="property-tab nav-link active" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=Not Interested" role="tab">
                                       <span class="d-md-inline-block">Not Interested</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=Not Interested" role="tab">
                                       <span class="d-md-inline-block">Not Interested</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='Interested')
                                     <a class="property-tab nav-link active" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=Interested" role="tab">
                                       <span class="d-md-inline-block">Interested</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('property')}}?<?php if(isset($_GET['p'])){ echo "p=".$_GET['p']."&";} ?>type=Interested" role="tab">
                                       <span class="d-md-inline-block">Interested</span>
                                     </a>
                                     @endif
                                 </li>
                             </ul>
                             <div class="tab-content pt-4">
                                 <div class="tab-pane active" id="home" role="tabpanel">
                                  <form method="GET" class="" id="propertyForm">
                                   <div class="row">
                                       @if(isset($_GET['type'])) <input type="hidden" name="type" value="{{@$_GET['type']}}"/> @endif
                                       @if(isset($_GET['p'])) <input type="hidden" name="p" value="{{@$_GET['p']}}"/> @endif
                                       <div class="col-md-4 pl-1 pr-1">
                                          <div class="dropdown_wrapper ">
                                             <input type="text" value="{{@$_GET[build]}}" class="form-control filter_input" list="building" placeholder="select Building" name="build">
                                             <datalist id="building">
                                                <option value="">Select building</option>
                                                @foreach($buildings as $building)
                                                <option value="{{$building->building_name}}"></option>
                                                @endforeach
                                             </datalist>
                                          </div>
                                       </div>
                                       <div class="col-md-2 pl-1 pr-1">
                                          <div class="dropdown_wrapper ">
                                             <input type="text" value="{{@$_GET[area]}}" class="form-control filter_input" list="area" placeholder="select area" name="area">
                                             <datalist id="area">
                                                <option value="">Select area</option>
                                                @foreach($areas as $area)
                                                <option value="{{$area}}"></option>
                                                @endforeach
                                             </datalist>
                                          </div>
                                       </div>
                                       <div class="col-md-1 pl-1 pr-1">
                                          <div class="dropdown_wrapper ">
                                             <input type="text" value="{{@$_GET[bedroom]}}" class="form-control filter_input" list="bedroom" placeholder="Bedroom" name="bedroom">
                                             <datalist id="bedroom">
                                                <option value="">Select Bedroom</option>
                                                @foreach($bedrooms as $bedroom)
                                                <option value="{{$bedroom}}"></option>
                                                @endforeach
                                             </datalist>
                                          </div>
                                       </div>
                                       <div class="col-md-2 pl-1 pr-1">
                                          <div class="dropdown_wrapper ">
                                             <input id="name" value="{{@$_GET[agent]}}" class="form-control filter_input" list="allNames" autocomplete="off" placeholder="select Agent"/>
                                             <datalist id="allNames">
                                                @if(@$agents )
                                                @foreach($agents as $agent)
                                                <option data-value="{{$agent->id}}" value="{{$agent->user_name}}" >{{$agent->user_name}}</option>
                                                @endforeach
                                                @endif
                                             </datalist>
                                             <input type="hidden" id="agentId" name="agent" value="">
                                          </div>
                                       </div>
                                       <div class="col-md-1 pl-1 pr-1">
                                          <div class="dropdown_wrapper ">
                                             <input id="unit_no" name="unit_no" value="{{@$_GET[unit_no]}}" class="form-control filter_input" autocomplete="off" placeholder="Unit No"/>
                                          </div>
                                       </div>
                                       <div class="col-md-2 pl-1 pr-1">
                                          <div class="dropdown_wrapper ">
                                             <input id="contact_no" name="contact_no" value="{{@$_GET[contact_no]}}" class="form-control filter_input" autocomplete="off" placeholder="Contact No"/>
                                          </div>
                                       </div>
                                    </div>
                                  </form>
                                  <br>
                                  @if(ucfirst(session('role'))==ucfirst('Admin') || ucfirst(session('role'))==ucfirst('SuperDuperAdmin'))
                                    <div class="row mt-4">
                                       <div class="col-md-8" style="margin-left: -1px;">
                                          
                                       </div>
                                       <div class="col-md-2 pl-1 pr-1 adminFilter" style="margin-top: -35px;">
                                          <div class="filter_btn_wrapper">
                                             <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter" name="search" id="filter">
                                          </div>
                                       </div>
                                       <div class="col-md-1 pl-1 pr-1 adminAssign" style="margin-top: -35px;">
                                                <div class="filter_btn_wrapper">
                                                   <input type="button" class="btn btn-success btn-block" id="assign-single-property" value="Assign">
                                                </div>
                                             </div>
                                        <div class="col-md-1 pl-1 pr-1 adminExport" style=" margin-top: -35px;">
                                           <div class="filter_btn_wrapper">
                                             <input type="button" class="btn btn-primary" id="export" value="Export CVS">
                                         </div>
                                      </div>
                                   </div>
                                  @endif
                                  @if(ucfirst(session('role'))==ucfirst('SuperAgent'))
                                  <div class="row">
                                      <div class="col-md-8">
                                      </div>
                                      @if(@$permissions->propertyAssign==NULL)
                                         <div class="col-md-2 pl-1 pr-1 superAgentFilter">
                                            <div class="filter_btn_wrapper">
                                               <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter" name="search">
                                            </div>
                                         </div>
                                      @else
                                       <div class="col-md-2 pl-1 pr-1 superAgentFilter">
                                            <div class="filter_btn_wrapper">
                                               <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter" name="search">
                                            </div>
                                         </div>
                                      @endif
                                      @if(@$permissions->propertyAssign==1) 
                                        <div class="col-md-2 pl-1 pr-1 superAgentAssign">
                                           <div class="filter_btn_wrapper">
                                              <input type="button" class="btn btn-success btn-block" id="assign-single-property" value="Assign">
                                           </div>
                                        </div>
                                      @endif
                                    </div>
                                    @endif
                                    </div>
                                    <table class="table table-striped property_table table-responsive" style="border-collapse: collapse; border-spacing: 0;">
                                       <thead>
                                         <tr style="background-color: #2fa97c;color: white;">
                                            <th class="checkall" style="cursor:pointer">Select All</th>
                                            <th>Unit No </th>
                                            <th>Building Name </th>
                                            <th>Area </th>
                                            <th>LandLord </th>
                                            <th>Contact No</th>
                                            <th>Email</th>
                                            <th>Area Sqft</th>
                                            <th>Beds</th>
                                            <th>Price</th>
                                            <th>R.Price</th>
                                            <th>S.Price</th>
                                            <th>Added By</th>
                                            <th>Access</th>
                                            <th>Registered</th>
                                            <th colspan="2">Actions</th>

                                         </tr>
                                       </thead>
                                       <form id="bulkForm" class="form-inline">
                                          @csrf

                                          <div class="modal fade" id="assignproperty" tabindex="-1" role="dialog" aria-labelledby="assignproperty" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                               <div class="modal-content">
                                                  <div class="modal-header">
                                                     <h5 class="modal-title" id="assignproperty">Assign Property</h5>
                                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                     <span aria-hidden="true">&times;</span>
                                                     </button>
                                                  </div>
                                                  <div class="modal-body">
                                                      <div class="row" style="font-size:13px;">
                                                          <div class="col-sm-1 text-center"></div>
                                                          <div class="col-sm-3 text-center data"><strong style="font-weight:900;color:black;">Select</strong></div>
                                                          <div class="col-sm-7 text-center data"><strong style="font-weight:900;color:black;">Agent Name</strong></div>
                                                           <div class="col-sm-1 text-center"></div>
                                                          @foreach($agentss as $key => $agent)
                                                             <div class="col-sm-1 text-center"></div>
                                                             <div class="col-sm-3 text-center data"><input class="agents_ids" type="checkbox" name="agents_ids[{{$key}}]" value="{{$agent->id}}"></div>
                                                             <div class="col-sm-7 text-center data">{{$agent->user_name}}</div>
                                                             <div class="col-sm-1 text-center"></div>
                                                          @endforeach
                                                      </div>
                                                  </div>
                                                  <div class="modal-footer">
                                                     <button type="button" id="assign-property-btn" class="btn btn-success">Submit</button>
                                                  </div>
                                               </div>
                                            </div>
                                         </div>

                                          <input type='hidden' value='' name='status' class='status'>
                                          <input type='hidden' value='' name='sending_email' class="sending_email">
                                          <input type='hidden' value='' name='time_date' class='time_date_input'>
                                          <input type='hidden' value='' name='description' class='description_input'>
                                       <tbody>
                                       @if(isset($result_data))
                                       @if(count($result_data) > 0)
                                       <?php $counter=0; ?>
                                       @foreach($result_data as $record)
                                       <tr class="present_row">
                                           <td>
                                             @if(ucfirst(session('role'))==ucfirst('SuperAgent')) 
                                             @if(@$permissions->propertyBulk==1)
                                             <input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$record->id}}"><img style="width: 21px;" src="public/assets/images/next.png" class="drop_arrow_icon pulse-effect">
                                             @else
                                             Not Allowed
                                             @endif
                                             @else
                                             <input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$record->id}}"><img style="width: 21px;" src="public/assets/images/next.png" class="drop_arrow_icon pulse-effect">
                                             @endif
                                          </td>
                                           <td>{{$record->unit_no}}</td>
                                           <td>{{$record->Building}}</td>
                                           <td>{{$record->area}}</td>
                                           <td>{{strtoupper($record->LandLord)}}</td>
                                           <td>
                                              <div class="content" style="display: none;">
                                                <?php $temp=explode(',', $record->contact_no);
                                                   foreach ($temp as $key=>$value) { ?>
                                                <span style="display: block;width: 100%;">{{$value}}</span>
                                                <?php  }  ?>
                                             </div>
                                             <label data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="label label-success show_content" name="Phone Number">Show</label>
                                             <label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer;display: table-cell;" class="label label-primary add_phone">Add</label>
                                           </td>
                                           <td>
                                              <div class="content" style="display: none;">
                                                <?php $temp=explode(',', $record->email);foreach ($temp as $key=>$value) { ?>
                                                <span style="display: block;width: 100%;">{{$value}}</span>
                                                <?php  }  ?>
                                             </div>
                                             <label data-toggle="modal" data-target="#exampleModalCenter" class="label label-success show_content show_email" name="Email Address">Show</label>
                                             <label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer;display: table-cell;" class="label label-primary add_email">Add</label>
                                           </td>
                                           <td>{{$record->Area_Sqft}}</td>
                                           <td>{{$record->Bedroom}}</td>
                                           <td>{{$record->Price}}</td>
                                           <td>{{$record->sale_price}}</td>
                                           <td>{{$record->rented_price}}</td>
                                           @if($record->getAddBy['user_name'])
                                           <td>{{ucfirst($record->getAddBy['user_name'])}}</td>
                                           @else
                                           <td>{{ucfirst($record->Agent['user_name'])}}</td>
                                           @endif
                                           <td>{{$record->access}}</td>
                                           <td>{{date('d-m-Y',strtotime($record->updated_at))}}</td>
                                           <td>
                                              @if(ucfirst(session('role'))==ucfirst('SuperAgent')) 
                                                @if(@$permissions->propertyEdit==1)
                                                <a href="{{url('EditProperty')}}?record_id={{$record->id}}&action=edit" class="edit_supervision"><i class="fa fa-edit"></i> Edit</a>
                                                @else
                                                Not Allowed
                                                @endif
                                                @else
                                                <a href="{{url('EditProperty')}}?record_id={{$record->id}}&action=edit" class="edit_supervision"><i class="fa fa-edit"></i> Edit</a>
                                                @endif
                                           </td>
                                           <td>
                                              @if(ucfirst(session('role'))==ucfirst('SuperAgent')) 
                                                   @if(@$permissions->propertyDelete==1)
                                                   <a onclick="Confirm({{$record->id}})" href="#" class="edit_supervision delete-property"><i class="fa fa-edit"></i> Delete</a>
                                                   @else
                                                   Not Allowed
                                                   @endif
                                                   @else
                                                   <a onclick="Confirm({{$record->id}})" href="#" class="edit_supervision delete-property"><i class="fa fa-edit"></i> Delete</a>
                                                   @endif
                                           </td>
                                       </tr>
                                       <!--TOGGLE ROW START FROM HERE-->
                                        <tr class="toggleable_row">
                                           <td colspan="19">
                                              <div class="row">
                                                 <div class="col-sm-4">
                                                    <label style="text-align: start">Comment</label>
                                                    <!-- <input type="text" name="comment[{{$counter}}]" value="{{@$record->comment}}" class="form-control"> -->
                                                    <textarea type="text" name="comment[{{$counter}}]" value="{{@$record->comment}}" rows="4" class="form-control">{{@$record->comment}}</textarea>
                                                 </div>
                                                 <div class="col-sm-4">
                                                    <label style="text-align: start">Upcoming Dates</label>
                                                    <div style="padding-top: 5px;border: 1px solid lightgray;height: 100px;overflow-y: auto;border-radius: 5px;">
                                                      @php $i = 1; @endphp
                                                      @foreach($reminders as $reminder)
                                                      @if($reminder->property_id == $record->id)
                                                      <span style="font-size: 14px;margin-left: 3%; @if($reminder->date_time < $current_date) text-decoration: line-through;     color: lightgray; @endif">{{$i}}) {{$reminder->date_time}}</span><br><br>
                                                      @php $i++; @endphp
                                                      @endif
                                                      @endforeach
                                                    </div>
                                                 </div>
                                              </div>
                                           </td>
                                        </tr>
                                        <!--TOGGLE ROW END HERE-->
                                       <?php $counter++; ?>     
                                       @endforeach
                                       @else
                                       <tr>
                                          <td colspan="20" align="center">No Record Found</td>
                                       </tr>
                                       @endif 
                                       @endif 
                                       </tbody>
                                   </table>
                                 </div>
                               </form>
                                 <div>
                                    @if(!isset($_GET['action']))
                                    @if(isset($_GET['type']))
                                    {{@$result_data->appends(Request::only('type','build','area','bedroom','agent','unit','contact'))->links()}}
                                    @else  
                                    {{@$result_data->appends(Request::only('type','build','area','bedroom','agent','unit','contact'))->links()}}                       
                                    @endif 
                                    @endif
                                 </div>
                                 <br><br>
                             </div>
                            </div>
                        <div class="card add_property_card" style="<?php if(isset($_GET["action"])){echo "display: block;";}else{echo "display: none;";} ?>" >
                           <div class="card-body">
                            <div class="card-header">
                              <div class="row">
                                  <a href="{{url('property')}}" class="btn btn-outline-secondary btn-rounded waves-effect waves-light go-back-prop" id="go_back" style="cursor: pointer;" class="mb-1"><span><i class="mdi mdi-arrow-left" style="padding: 2px;"></i></span></a>&nbsp;&nbsp;
                                  <h4 class="m-b-0 mt-2 ml-3"><?php if(isset($_GET["action"])){echo "Edit Details";}else{echo "Property Details";} ?></h4>
                              </div>
                            </div>
                            <div class="card-body">
                                 <form action="<?php if(isset($_GET['action'])){ echo url('UpdateProperty'); }else{ echo url('Addproperty'); } ?>" class="form-horizontal" method="post" enctype='multipart/form-data' id="property">
                                 @csrf
                                 <input type="hidden" name="property_id" value="{{@$result[0]['id']}}">
                                 <div class="form-body">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 unit_no">Unit No</label>
                                             <div class="col-md-9">
                                                <input required="" type="text" class="form-control" name="unit_no" value="{{@$result[0]['unit_no']}}">
                                                <!-- <small class="form-control-feedback"> This is inline help </small>  -->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="col-md-6">
                                          <div class="form-group has-danger row">
                                             <label class="control-label col-md-3 building">Building</label>
                                             <div class="col-md-8 building_input" style="padding-left: 15px;">
                                              <input type="text" class="form-control filter_input_name" list="buildings" placeholder="Select Building" name="building" value="">
                                                 <datalist id="buildings">
                                                    <option value="">Select building</option>
                                                    @foreach($buildings as $building)
                                                    <option value="{{$building->building_name}}"></option>
                                                    @endforeach
                                                 </datalist>
                                             </div>
                                             <div class="col-sm-1" style="padding-top: 8px;">
                                                <i class="fa fa-plus add-building" class="btn btn-primary" data-toggle="modal" data-target="#buildingModal" style="font-size:22px;color:black" aria-hidden="true"></i>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>


                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 dewa_no">Dewa No</label>
                                             <div class="col-md-9">
                                                <input type="text" class="form-control" name="dewa_no" value="{{@$result[0]['dewa_no']}}">
                                                <!-- <small class="form-control-feedback"> This is inline help </small>  -->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 bedroom">Bedroom</label>
                                             <div class="col-md-9">
                                                <select  style="font-size: 12px;" name="Bedroom" class="form-control">
                                                   <option value="{{@$result[0]['Bedroom']}}">{{@$result[0]['Bedroom']}}</option>
                                                   <option value="studio">studio</option>
                                                   <option value="1">1</option>
                                                   <option value="2">2</option>
                                                   <option value="3">3</option>
                                                   <option value="4">4</option>
                                                   <option value="5">5</option>
                                                   <option value="6">6</option>
                                                   <option value="7">7</option>
                                                   <option value="8">8</option>
                                                   <option value="9">9</option>
                                                   <option value="10">10</option>
                                                   <option value="11">11</option>
                                                   <option value="12">12</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->          
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 area">Area</label>
                                             <div class="col-md-9">
                                                <input type="text" name="area" class="form-control" value="{{@$result[0]['area']}}">
                                                <!-- <small class="form-control-feedback"> Select your gender. </small>  -->
                                             </div>
                                          </div>
                                       </div>
                                        <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 washroom">Washroom</label>
                                             <div class="col-md-9">
                                                <select name="Washroom"  class="form-control" style="font-size: 12px; " >
                                                   <option value="{{@$result[0]['Washroom']}}">{{@$result[0]['Washroom']}}</option>
                                                   <option value="1">1</option>
                                                   <option value="1.5">1.5</option>
                                                   <option value="2.5">2.5</option>
                                                   <option value="3.5">3.5</option>
                                                   <option value="4.5">4.5</option>
                                                   <option value="5.5">5.5</option>
                                                   <option value="6.5">6.5</option>
                                                   <option value="7.5">7.5</option>
                                                   <option value="8.5">8.5</option>
                                                </select>
                                                <!-- <small class="form-control-feedback"> Select your gender. </small>  -->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>           
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 condition">Conditions</label>
                                             <div class="col-md-9">
                                                <select name="Conditions"  class="form-control"  style="font-size: 12px;">
                                                   <option value="{{@$result[0]['Conditions']}}">{{@$result[0]['Conditions']}}</option>
                                                   <option value="Full Furnished">Full Furnished</option>
                                                   <option value="Furnished">Furnished</option>
                                                   <option value="unfurnished">unFurnished</option>
                                                   <option value="Semi Furnished">Semi Furnished</option>
                                                   <option value="FULLY FITTED">FULLY FITTED</option>
                                                   <option value="SHELL AND CORE">SHELL AND CORE</option>
                                                </select>
                                                <!-- <small class="form-control-feedback"> Select your gender. </small>  -->
                                             </div>
                                          </div>
                                       </div>
                                         <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 email">Email</label>
                                             <div class="col-md-9">
                                                <?php $temp=explode(',', @$result[0]['email']); if(count($temp) > 1){ foreach ($temp as $value) {?>
                                                <input  type="email" class="form-control" name="email[]" value="{{$value}}" style="margin-bottom: 1%">
                                                <?php } }else { ?>
                                                <input type="email" class="form-control" name="email[]" value="{{@$result[0]['email']}}">
                                                <?php  } ?>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 landlord">LandLord</label>
                                             <div class="col-md-9">
                                                <input type="text" style="font-size: 12px;" class="form-control" name="LandLord" value="{{@$result[0]['LandLord']}}">
                                             </div>
                                          </div>
                                       </div>
                                      <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 access">Access</label>
                                             <div class="col-md-9">
                                                <select class="form-control access" name="access" style="font-size: 12px;" >
                                                   <option value="">Select option</option>
                                                   <option value="For Rent" <?php if(strtoupper(@$result[0]["access"])==strtoupper("For Rent")){echo "selected";} ?>>For Rent</option>
                                                   <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("For Sale")){echo "selected";} ?> value="For Sale">For Sale</option>
                                                   <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Upcoming")){echo "selected";} ?> value="Upcoming">Upcoming</option>
                                                   <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Do Not Caller")){echo "selected";} ?> value="Do Not Caller">Do Not Call</option>
                                                   <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Call back")){echo "selected";} ?> value="Call back">Call back</option>
                                                   <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Not answering")){echo "selected";} ?> value="Not answering">Not answering</option>
                                                   <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Not Intrested")){echo "selected";} ?> value="Not Intrested">Not Intrested</option>
                                                   <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Intrested")){echo "selected";} ?> value="Intrested">Intrested</option>
                                                   <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Don't call")){echo "selected";} ?> value="Don't call">Don't call</option>
                                                </select>
                                                <div class="options" style="padding-top:20px;">
                                                   @if(strtoupper(@$result[0]["access"])==strtoupper("Upcoming"))
                                                   @if(!is_null($reminders))
                                                   <div class="row">
                                                      <input type="hidden" name="add_property_reminder_type" value="{{$reminders->reminder_type}}"> 
                                                      <div class="col-sm-12">
                                                         <div class="form-group"> <input style="width:100%" type="datetime-local" value="{{$reminders->reminderDate($reminders->date_time)}}" class="form-control" name="add_property_date_time"> </div>
                                                      </div>
                                                      <div class="col-sm-12"> <textarea class="form-control reminder_description"  value="" style="width:100%" rows="4" name="add_property_reminder_description" placeholder="Description">{{$reminders->description}}</textarea></div>
                                                   </div>
                                                   @endif
                                                   @endif
                                                   @if(strtoupper(@$result[0]["access"])==strtoupper("For Sale"))
                                                   <select class="form-control sale_status valid" style="font-size:12px;margin-bottom: 20px;" name="sale_status" aria-invalid="false">
                                                      <option <?php if(strtoupper(@$result[0]["sale_status"])==strtoupper("Rented")){echo 'selected';}   ?>  value="Rented">Rented</option>
                                                      <option <?php if(strtoupper(@$result[0]["sale_status"])==strtoupper("Vacant")){echo 'selected';}   ?> value="Vacant">Vacant</option>
                                                      <option <?php if(strtoupper(@$result[0]["sale_status"])==strtoupper("Vacant on transfer")){echo 'selected';}   ?>  value="Vacant on transfer">Vacant on transfer</option>
                                                   </select>
                                                   <div class="form-group" style="margin-bottom: 20px;"><input type="date" value="{{@$result[0]["rented_date"]}}" name="rented_date" class="form-control rented_date"></div>
                                                   <div class="form-group"><input type="price" name="rented_price" value="{{@$result[0]["rented_price"]}}" placeholder="Rented Price" class="form-control rented_price"></div>
                                                   @endif
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 phone">Phone Number</label>
                                             <div class="col-md-9">
                                                <?php $temp=explode(',', @$result[0]['contact_no']); if(count($temp) > 1){ foreach ($temp as $value) {?>
                                                <input type="text" class="form-control" name="contact_no[]" value="{{$value}}" style="margin-bottom: 1%">
                                                <?php } }else { ?>
                                                <input  type="text" class="form-control" name="contact_no[]" value="{{@$result[0]['contact_no']}}">
                                                <?php  } ?>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 price">Price</label>
                                             <div class="col-md-9">
                                                <input type="number" class="form-control" name="Price" value="{{@$result[0]['Price']}}">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 areasqft">Area Sqft</label>
                                             <div class="col-md-9">
                                                <input type="number" class="form-control" name="Area_Sqft" value="{{@$result[0]['Area_Sqft']}}">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 ptype">Property Type</label>
                                             <div class="col-md-9">
                                                <select class="form-control" style="font-size:12px !important;" name="property_type">
                                                   <option value="">Please Select Type</option>
                                                   <option @if(@$result[0]['property_type'] == "Commercial") selected @endif value="Commercial">Commercial</option>
                                                   <option @if(@$result[0]['property_type'] == "residential") selected @endif value="residential">residential</option>
                                                   <option @if(@$result[0]['property_type'] == "dewa") selected @endif value="dewa">DEWA</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>

                                    </div>

                                    <div class="row">
                                    
                                    <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="control-label col-md-3 add_comment">Add Comment</label>
                                             <div class="col-md-9">
                                                <textarea class="form-control" name="comment"  cols="4" rows="6">{{@$result[0]['comment']}}</textarea>
                                             </div>
                                          </div>
                                       </div>

                                       <!--/span-->
                                      
                                       <!--/span-->
                                    </div>
                                    
                                    <!--/row-->
                                    <div class="form-actions">
                                       <div class="row">
                                          <div class="col-md-1"> </div>
                                          <div class="col-md-6">
                                             <div class="row">
                                                <div class="col-md-offset-3 col-md-9" style="    padding-left: 10%;">
                                                   <button type="submit" name="add_property" class="btn btn-success submit"><?php if(isset($_GET["action"])){echo "Update";}else{echo "Submit";}?></button>
                                                </div>
                                             </div>
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
                <!-- end row -->

            </div>
            <!-- end container-fluid -->
        </div> 
        <!-- end page-content-wrapper -->
    </div>
    <!-- End Page-content -->
<!-- MODALS -->
<div class="modal fade" id="emailmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Email</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <label>Enter Sending Email</label>
            <input type="email" id="sending_email" class="form-control"/>
         </div>
         <div class="modal-footer">
            <button type="button" class="sent-email-btn btn btn-secondary" data-dismiss="modal">Send</button>
         </div>
      </div>
   </div>
</div>

<form action="{{url('PropertyBulkActions')}}" method="GET" style="width: 100%;">
  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
     <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <div class="modal-header">
              <h4 class="modal-title" id="mySmallModalLabel">Set Reminder</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
           </div>
           <div class="modal-body">
              <div class="container">
                 <div class="row">
                    <div class='col-sm-12'>
                       <div class="form-group">
                          <input type="datetime-local" class="form-control datetime" id="min-date"> 
                          <!-- <input type="text" id="min-date" class="form-control datepicker-here datetime" data-timepicker="true" data-language="en"> -->
                          <span class="date_time_error" style="font-size: 11px;font-weight: 500;color: red;"></span>
                       </div>
                    </div>
                    <div class="col-sm-12">
                       <textarea class="form-control reminder_description" rows="4" class="" name="reminder_description" placeholder="Description"></textarea>
                       <span class="reminder_description-error" style="font-size: 11px;font-weight: 500;color: red;"></span>
                    </div>
                    <div class="col-sm-12" style="text-align: end">
                       <div class="form-group" style="padding-top: 6%;">
                          <input type="button" value="OK" class="reminder btn btn-success" >
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
        <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
  </div>
</form>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form action="{{url('addLandlordEmailPass')}}" method="get">
         <div class="modal-content">
            <div class="modal-header">
               
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog" role="document">
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
<!-- Email and Phone Model -->
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

<!-- END MODALS -->


@include('inc.footer')
@section('extra-script')
<!-- Required datatable js -->
        <script src="{{url('public/Green/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <!-- Buttons examples -->
        <script src="{{url('public/Green/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/jszip/jszip.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
        <!-- Responsive examples -->
        <script src="{{url('public/Green/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

        <!-- Datatable init js -->
        <script src="{{url('public/Green/assets/js/pages/datatables.init.js')}}"></script>
@ednsection
<script>
  @if(session('msg'))
    alertify.success("{!! session('msg') !!}")
  @endif

  @if(session('error'))
    alertify.error("{!! session('error') !!}")
  @endif
</script>
<script>
    $(document).ready(function(){
        $("#assign-single-property").click(function(){
            if(!$('.ind_chk_box:checkbox:checked').val()){
                // toastr["error"]("please select Rows!");
                alertify.error("please select Rows!");
                // window.stop();
            }else{
               $("#assignproperty").modal("show"); 
            }
            
        });
        $("#assign-property-btn").click(function(){
            if(!$('.agents_ids:checkbox:checked').val()){
                // toastr["error"]("");
                alertify.error("Please select Agent!");
            }else{
               if($('.agents_ids:checkbox:checked').length > 1){
                   // toastr["error"]("Please select Only One Agent");
                  alertify.error("Please select Only One Agent!");
                   // return;
               }else{
                 $("#bulkForm").attr("action","{{url('assign-singleproperty')}}");
                 $("#bulkForm").attr("method","POST");
                 $("#bulkForm").submit(); 
               }
            }
        })
    })
</script>
<!-- add building using ajax-->
<script>
  $('.delete-property').on('click', function(){
      $('.ajs-header').empty();
      $('.ajs-header').append('Delete Property')
  })
  function Confirm(id){
    // console.log(id);
    alertify.confirm("Are You sure you want to delete this property.", function() {
            $.ajax({
              url: "{{url('DeletePropertyByAdmin')}}/"+id,
              type: "get",
              data: {'id':id},
              success: function(responce){
                alertify.success("property deleted successfully.")

                 // $('.property_table').load(location.href + " .property_table");
                  setTimeout(function() { 
                      window.location.reload();
                  }, 2000);
              },
              error: function(responce){
                alertify.error("Something went wrong.")
              }
            })
            
        }, function() {
            alertify.error("Canceled property deletion.")
        })
  }
</script>
<script>
   $(document).ready(function(){
           // Select all
    var clicked = false;
    $(".checkall").on("click", function() {
      $(".ind_chk_box").prop("checked", !clicked);
      if(!clicked){
         $(".ind_chk_box").attr("checked",""); 
      }else{
          $(".ind_chk_box").removeAttr("checked"); 
      }
      clicked = !clicked;
    });
    // RESET
    $('.reset').click(function(){
        $(this).hide();
        $('.whatsapp').removeAttr('href');
        $('.msg-status').text('');
    })
    $('.reset-2').click(function(){
        $(this).hide();
        $('.whatsapp_2').removeAttr('href');
        $('.msg-status-2').text('');
    })
    //whatsapp Button
    $(document).delegate('.whatsapp','click',function(e){
        $('.msg-status').text('Wait...');
        if(!$('.ind_chk_box:checkbox:checked').val()){
             // alert('please select Rows!');
             alertify.error("please select Rows!");
             $('.msg-status').text('');
             return;
         }
        $.ajax({
            url:'<?php echo url('whatsApp-msgsForProperty');  ?>',
            type:'get',
            data : $("#bulkForm").serialize(),
            success:function(data){
                console.log(data);
                var whatsappMessage = window.encodeURIComponent(data)
                $('.whatsapp').attr('href','https://wa.me/?text='+whatsappMessage+'');
                $('.msg-status').text('Click again to sent Message');
                $('.reset').show();
            }
        })
    })
        //whatsapp Button two
    $(document).delegate('.whatsapp_2','click',function(e){
        $('.msg-status-2').text('Wait...');
        if(!$('.ind_chk_box:checkbox:checked').val()){
             alertify.error("please select Rows!");
             // alert('please select Rows!');
             $('.msg-status-2').text('');
             return;
         }
        $.ajax({
            url:'<?php echo url('whatsApp-OwnermsgsForProperty');  ?>',
            type:'get',
            data : $("#bulkForm").serialize(),
            success:function(data){
                console.log(data);
                var whatsappMessage = window.encodeURIComponent(data)
                $('.whatsapp_2').attr('href','https://wa.me/?text='+whatsappMessage+'');
                $('.msg-status-2').text('Click again to sent Message');
                $('.reset-2').show();
            }
        })
    })
       $('.add-building-btn').click(function(){
           var buildingName=$('.add-building-input').val();
           if(!$('.add-building-input').val()){
             alertify.error("invalid Building Name");
               // alert('invalid Building Name');
               return;
           }
           $.ajax({
               type : 'GET',
               url : "{{url('add-building-by-ajax')}}",
               data : {'buldingName' : buildingName},
               success:function(data){
                   if($.trim(data) == 'true'){
                       $('#buildings').append('<option selected value="'+buildingName+'">'+buildingName+'</option>');
                       $('.close-model').trigger('click');
                       $("#buildings").load(location.href + " #buildings");
                   }else{
                       // alert('something went wrong!');
                       alertify.error("something went wrong!");


                   }
               }
           })
       })
   })
</script>
<!-- end of add building using ajax-->

<script>
  $('.add_phone').on('click',function(){
    // alert('me');
     var id=$(this).attr('id');
     $('.modal-header').empty();
     $('.add_model_body').empty();
     $('.modal-header').append('<h5 class="modal-title" id="exampleModalLabel">Add Phone</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
     $('.add_model_body').append('<label>Phone</label><input type="text" name="phone" class="form-control"><input type="hidden" name="id" class="form-control" value="'+id+'">');
  })
  $('.add_email').on('click',function(){
     var id=$(this).attr('id');
     $('.modal-header').empty();
     $('.add_model_body').empty();
     $('.modal-header').append('<h5 class="modal-title" id="exampleModalLabel">Add Email</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
     $('.add_model_body').append('<label>Email</label><input type="email" name="email" class="form-control"><input type="hidden" name="id" class="form-control" value="'+id+'">');
  });

  $('.present_row .drop_arrow_icon').click(function(){
    $(this).parents('.present_row').next('.toggleable_row').toggleClass('tgl_row');
    $(this).toggleClass('rotate_icon');
  });
</script>
<script type="text/javascript">
   //datalist on click, agents search
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
     //ACCESS DROPDOWN CODE START HERE  
          $('.access_select').change(function(e){
             if(!$('.ind_chk_box:checkbox:checked').val()){
               $(this).val('');
               // alert('please select Rows!');
                alertify.error("please select Rows!");
               return;
           }
           if($(this).val()==""){
               return;
           }
             if($(this).val().toLowerCase()=='call back' || $(this).val().toLowerCase()=='upcoming' || $(this).val().toLowerCase()=='not answering' || $(this).val().toLowerCase()=='pending' || $(this).val().toLowerCase()=='off plan' || $(this).val().toLowerCase()=='investor' || $(this).val().toLowerCase()=='check availability'){
                  $('.reminder').show();
                  $('.update-status-by-row').hide();
                  var access=$(this).val();
                 $('.status').val(access);
                 $("#model").trigger( "click" );
             }else{
                 var access=$(this).val();
                 $('.status').val(access);
             $.ajax({
                 url:'<?php echo url('bulkUpdateStatusProperty');  ?>',
                 type:'get',
                 data : $("#bulkForm").serialize(),
                 success:function(data){
                     console.log(data);
                     if(data=="true"){
                         location.reload();
                     }else{
                         // alert('something went wrong');
                         alertify.error("something went wrong");
                     }
                 }
             })
             }
          })
          
     //ACCESS DROPDOWN CODE END HERE  
     
         $('.chosen-container.chosen-container-single').show();
              $(document).delegate('.show_content','click',function(){
                 var content=$(this).prev('.content').html();
                 $('.content_model_title').text($(this).attr('name'));
                 $('.content_model_body').html(content);
             })
         $('.access').change(function(){
             if($(this).val()=='Upcoming'){
                 $('.options').html('<div class="row"><input type="hidden" name="add_property_reminder_type" value="Upcoming"> <div class="col-sm-12"> <div class="form-group"> <input style="width:100%" type="datetime-local" class="form-control" name="add_property_date_time"> </div></div><div class="col-sm-12"> <textarea class="form-control reminder_description" style="width:100%" rows="4" name="add_property_reminder_description" placeholder="Description"></textarea></div></div></div></div>');
             }else  if($(this).val()=='For Sale'){
                 $('.options').html('<select class="form-control sale_status" style="font-size:12px;margin-bottom: 20px;"><option value="Rented">Rented</option><option value="Vacant">Vacant</option><option value=" Vacant on transfer"> Vacant on transfer</option></select><div class="form-group below" style="margin-bottom: 20px;"><input type="date" name="rented_date" class="form-control rented_date"></div><div class="form-group below"><input type="price" name="rented_price" placeholder="Rented Price" class="form-control rented_price"></div>');
             }
             else{
                 $('.options').html('');
             }
         })
     $(document).delegate('.sale_status','change',function(){
         if($(this).val()=='Rented'){
             $('.options').html('<select class="form-control sale_status" style="font-size:12px;margin-bottom: 20px;" name="sale_status"><option value="Rented">Rented</option><option value="Vacant">Vacant</option><option value=" Vacant on transfer"> Vacant on transfer</option></select><div class="form-group" style="margin-bottom: 20px;"><input type="date" name="rented_date" class="form-control rented_date"></div><div class="form-group"><input type="price" name="rented_price" placeholder="Rented Price" class="form-control rented_price"></div>');
         }
         else{
             $('.below').remove();
         }
     })
         // $("#property").validate();
          $("body").delegate(".apply","click",function(e){
             var action=$(".action_select option:selected").val();
             if(action=="NULL"){
                 e.preventDefault();
                 return;
             }
         })
          $('.access_select').change(function(e){
             if($(this).val().toLowerCase()=='call back' || $(this).val().toLowerCase()=='upcoming' || $(this).val().toLowerCase()=='intrested' || $(this).val().toLowerCase()=='not answering'){
                 var unit=$(this).attr("unit");
                 var access=$(this).val();
                 $('.reminder').attr('unit',unit);
                 $('.reminder').attr('access',access);
                 $('.reminder').attr('reminder_type',access);
                 $("#model").trigger( "click" );
             }
          })
</script>
<!-- send email -->
<script>
  $('.sent-email-btn').click(function(){
      $('.sending_email').val($('#sending_email').val());
     if(!$('.ind_chk_box:checkbox:checked').val()){
         // toastr["error"]("please select Rows!");
          alertify.error("please select Rows!");
         $('.msg-status').text('');
         // return;
     }
    else{
     $('.email-loader').css('visibility','visible');
     $.ajax({
        url:'<?php echo url('sent-property-emails');  ?>',
        type:'get',
        data:$("#bulkForm").serialize(),
        success:function(data){
            $('.email-loader').css('visibility','hidden');
            if($.trim(data)=="true"){
                // toastr["success"]("Email Sent Successfully!");
                 alertify.success("Email Sent Successfully!");

            }else{
                // toastr["error"]("Something went wrong");
                 alertify.error("Something went wrong");
            }
        },
        error: function(xhr, status, error){
             $('.email-loader').css('visibility','hidden');
             // toastr["error"]("Something went wrong");
             alertify.error("Something went wrong");

        }
    })
   }
 });
</script>
<?php  if(isset($_GET['action'])) {?>
<script type="text/javascript">
   $("#LandLord option").each(function(){
       if($(this).val()=="{{@$result[0]['LandLord']}}"){
           $(this).attr("Selected",true);
       }
   })
    $("#agent option").each(function(){
       if($(this).val()=="{{@$result[0]['agent']}}"){
           $(this).attr("Selected",true);
       }
   })
    $("#insertBuilding option").each(function(){
       if($(this).val()=="{{@$result[0]['Building']}}"){
           $(this).attr("Selected",true);
       }
   });
    //datalist on click, agents search
   // $(document).delegate('#name','click', function () {
   //     alert();
   //     var val = this.value;
   //     if($('#allNames option').filter(function(){
   //         if(this.value === val) {
   //           var agentId = $(this).attr("data-value");
   //           console.log(agentId+" if condition");
   //           $("#agentId").val(agentId);
   //         }      
   //     }).length) {
   //         //send ajax request
        
   //     }
   // });
</script>

<?php }  ?>

<script>
   $('.property-tab').on('click',function(){
      $('.property-tab').removeClass('active');
      $(this).addClass('active');
   })

   $('#add-new-owne-link').on('click',function(){
      $('.all_property_card').css('display', 'none');
      $('.add_property_card').css('display', 'block');
   })

   $('.top-buttons').on('click',function(){
      $('.top-buttons').removeClass('active');
      $(this).addClass('active');
   })
</script>
<script type="text/javascript">
   var value='<?php echo @$Bedroom;  ?>';
   $('.Bedroom').val(value);
</script>
<script>
  $('.reminder').click(function(){
     $('.date_time_error,.reminder_description-error').text("");
     if($('.datetime').val()==""){
        // $('.date_time_error').text('This field is Required!');
         alertify.error("DateTime field is Required!");
        return; 
     }
     else if($('.reminder_description').val()==""){
         // $('.reminder_description-error').text('This field is Required!');
         alertify.error("Description field is Required!");
        return; 
     }
        var time_date=$('#min-date').val();
        var description=$('.reminder_description').val();
        console.log(time_date);
        console.log(description);
        $('.time_date_input').val(time_date);
        $('.description_input').val(description);
       $.ajax({
           url:'<?php echo url('setReminderForProperty');  ?>',
           type:'get',
           data : $("#bulkForm").serialize(),
           success:function(data){
               if(data=="true"){
                   location.reload();
               }else{
                   $('.reminder_description-error').html(data);
               }
           }
       })
  })
</script>
<script>
  $(document).ready(function(){
     document.getElementById("filter").onclick = function() {
      document.getElementById("propertyForm").action = "{{ route('Propertysearch') }}";
      document.getElementById("propertyForm").submit();
    };

    document.getElementById("export").onclick = function() {
      document.getElementById("propertyForm").action = "{{url('propertiesexport')}}";
      document.getElementById("propertyForm").submit(); 
    };
  });
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