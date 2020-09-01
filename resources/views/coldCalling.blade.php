@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperAgent')))
<script type="text/javascript">
   window.location='{{url("/")}}';
</script>
<?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/coldCalling.css')}}">
<style>
  @media (max-width: 550px){
    .tab-pane-coldcalling{
        margin-left: 0px !important;
        width: 100% !important;
        font-size: 13px;
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
    .pagination {
        float: none !important;
        font-size: 13px !important;
        overflow-x: auto !important;
    }
    .buttons{
      margin-top: 0px !important;
    }
    .assign_button{
      margin-top: 4px !important;
      margin-bottom: 4px !important;
    }
    .table-responsive{
      width: 119%;
      margin-left: -28px;
      overflow-x: auto !important;
      display: block !important;

    }

  }
  #back_to_owner{
    font-size: 42px;
    position: absolute;
    cursor: pointer;
  }
  .table-responsive{
    overflow-x: hidden;
    display: inline-table;
  }
  .table td{
      padding: .75rem;
      vertical-align: top;
      border-top: 1px solid #eff2f7;
      font-weight: bold;
  }
  .table thead{
    background-color: #2fa97c;
    color: white;
  }
  .nav-tabs .nav-item {
    margin-bottom: -1px;
    font-size: 13px;
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
       padding: 1px 4px 1px 6px;
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
      /*width: 105% !important;
      margin-left: -29px;*/
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
   .nav-tabs {
       border-bottom: 1px solid #2fa97c;
       margin-top: 0px;
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
   .add-prop {
    cursor: pointer;
    color: white !important;
    font-size: 15px;
    padding: 17px 22px 17px 22px;
    margin-top: -40px;
}
.tab-pane-coldcalling{
    margin-left: -25px;
    width: 104%;
    font-size: 10px;
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
                        <h4 class="page-title mb-1">Cold Calling</h4>
                        <ol class="breadcrumb m-0">
                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li> -->
                        <li class="breadcrumb-item active">Edenfort CRM ColdCallings</li>
                        </ol>
                    </div>
                     <div class="col-md-6">
                        <div class="btn-group" role="group" aria-label="Basic example">
                           @if(@$_GET['p']=='Dewa')
                           <a href="{{url('coldCalling')}}?p=Dewa" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light active">
                              <div class="row" style="padding: 0px 9px 0px 9px;">
                                 <img src="{{url('public/Green/assets/images/icons/browser.png')}}" style="height: 57px;">&nbsp;&nbsp;<p style="padding-top: 22px;">DEWA</p> 
                              </div>
                           </a>
                           @else
                           <a href="{{url('coldCalling')}}?p=Dewa" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light">
                              <div class="row" style="padding: 0px 9px 0px 9px;">
                                 <img src="{{url('public/Green/assets/images/icons/browser.png')}}" style="height: 57px;">&nbsp;&nbsp;<p style="padding-top: 22px;">DEWA</p> 
                              </div>
                           </a>
                           @endif
                           @if(@$_GET['p']=='Commercial')
                           <a href="{{url('coldCalling')}}?p=Commercial" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light active">
                              <div class="row" style="padding: 0px 9px 0px 9px;">
                                 <img src="{{url('public/Green/assets/images/icons/shanghai.png')}}" style="height: 57px;">&nbsp;&nbsp;<p style="padding-top: 22px;">Commercial</p> 
                              </div>
                           </a>
                           @else
                           <a href="{{url('coldCalling')}}?p=Commercial" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light">
                              <div class="row" style="padding: 0px 9px 0px 9px;">
                                 <img src="{{url('public/Green/assets/images/icons/shanghai.png')}}" style="height: 57px;">&nbsp;&nbsp;<p style="padding-top: 22px;">Commercial</p> 
                              </div>
                           </a>
                           @endif
                           @if(@$_GET['p']=='Residential')
                           <a href="{{url('coldCalling')}}?p=Residential" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light active">
                              <div class="row" style="padding: 0px 9px 0px 9px;">
                                 <img src="{{url('public/Green/assets/images/icons/appartment.png')}}" style="height: 57px;">&nbsp;&nbsp;<p style="padding-top: 22px;">Residential</p> 
                              </div>
                           </a>
                           @else
                           <a href="{{url('coldCalling')}}?p=Residential" type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light">
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
                              <a type="button" class="top-buttons btn btn-outline-dark waves-effect waves-light" data-toggle="modal" data-target="#emailmodel" style="border-radius: 0px 50px 50px 0px;">
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
                          <select class="form-control access_select repo" name="accessStatus">
                            <option value="">Select Option</option>
                            <option value="Call Back">Call Back</option>
                            <option  value="Not answering">Not answering</option>
                            <option  value="Not Interested">Not Interested</option>
                            <option  value="Interested">Interested</option>
                            <option  value="For Sale">For Sale</option>
                            <option  value="ForSale/ForRent">ForSale/ForRent</option>
                            <option value="upcoming">upcoming</option>
                            <option  value="For Rent">For Rent</option>
                            <option  value="Off Plan">Off Plan</option>
                            <option  value="Investor">Investor</option>
                            <option  value="Check Availability">Check Availability</option>
                            <option  value="Switch Off">Switch Off</option>
                            <option  value="Wrong Number">Wrong Number</option>
                            <option  value="Commercial">Commercial</option>
                            <option  value="Residential">Residential</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                       <a class="btn btn-success btn-rounded waves-effect waves-light add-prop" id="add-new-owne-link" style="cursor: pointer;" class="mb-1"><span><i class="fa fa-plus"></i></span></a>
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

  <div class="page-content-wrapper">
      <div class="container-fluid">
          <div class="row">
              <div class="col-xl-12">
                  <div class="card all_property_card" style="display:{{@$Recorddisplay}}">
                      <div class="card-body">
                        <!--REMINDER MODEL START FROM HERE-->
                         <form action="{{url('PropertyBulkActions')}}" method="GET" style="width: 100%;" class="t_table">
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
                                                    <input type="datetime-local" name="datetime" class="form-control date-time" id="min-date">
                                                    <!-- <input type="text" id="min-date" class="form-control datepicker-here datetime" data-timepicker="true" data-language="en" placeholder="mm/dd/yyy --:-- --">  -->
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
                         <!--REMINDER MODEL END HERE-->
                         <input id="model" data-toggle="modal" data-target=".bs-example-modal-sm" class="btn btn-danger"  style="visibility: hidden;" type="button" value="">
                          <ul class="nav nav-tabs" role="tablist">
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='')
                                     <a class="property-tab nav-link active" href="{{url('coldCalling')}}@if(isset($_GET['p']))?p={{$_GET['p']}} @endif" role="tab"><span class="d-md-inline-block">All property</span> 
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('coldCalling')}}" role="tab"><span class="d-md-inline-block">All property</span> 
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                     @if(@$_GET['type']=='For Rent')
                                     <a class="property-tab nav-link active" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=For Rent" role="tab">
                                       <span class="d-md-inline-block">For Rent</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=For Rent"role="tab">
                                       <span class="d-md-inline-block">For Rent</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='For Sale')
                                     <a class="property-tab nav-link active" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=For Sale" role="tab">
                                       <span class="d-md-inline-block">For Sale</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=For Sale" role="tab">
                                       <span class="d-md-inline-block">For Sale</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='upcoming')
                                     <a class="property-tab nav-link active" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=upcoming" role="tab">
                                       <span class="d-md-inline-block">Upcoming</span><span class="badge badge-pill badge-success @if($upcoming==0) hide @endif">{{$upcoming}}</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=upcoming" role="tab">
                                       <span class="d-md-inline-block">Upcoming</span>
                                       <span class="badge badge-pill badge-success @if($upcoming==0) hide @endif">{{$upcoming}}</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='Off Plan')
                                     <a class="property-tab nav-link active" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Off Plan" role="tab">
                                       <span class="d-md-inline-block">Off Plan</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Off Plan" role="tab">
                                       <span class="d-md-inline-block">Off Plan</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='Investor')
                                     <a class="property-tab nav-link active" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Investor" role="tab">
                                       <span class="d-md-inline-block">Investor</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Investor" role="tab">
                                       <span class="d-md-inline-block">Investor</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='Check Availability')
                                     <a class="property-tab nav-link active" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Check Availability" role="tab">
                                       <span class="d-md-inline-block">Check Availability</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Check Availability" role="tab">
                                       <span class="d-md-inline-block">Check Availability</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='Not Interested')
                                     <a class="property-tab nav-link active" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Not Interested" role="tab">
                                       <span class="d-md-inline-block">Not Interested</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Not Interested" role="tab">
                                       <span class="d-md-inline-block">Not Interested</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='Interested')
                                     <a class="property-tab nav-link active" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Interested" role="tab">
                                       <span class="d-md-inline-block">Interested</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Interested" role="tab">
                                       <span class="d-md-inline-block">Interested</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='Not Answering')
                                     <a class="property-tab nav-link active" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Not answering" role="tab">
                                       <span class="d-md-inline-block">Not Answering</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Not answering" role="tab">
                                       <span class="d-md-inline-block">Not Answering</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='Switch Off')
                                     <a class="property-tab nav-link active" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Switch Off" role="tab">
                                       <span class="d-md-inline-block">Switch Off</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Switch Off" role="tab">
                                       <span class="d-md-inline-block">Switch Off</span>
                                     </a>
                                     @endif
                                 </li>
                                 <li class="nav-item">
                                    @if(@$_GET['type']=='Wrong Number')
                                     <a class="property-tab nav-link active" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Wrong Number" role="tab">
                                       <span class="d-md-inline-block">Wrong Number</span>
                                     </a>
                                     @else
                                     <a class="property-tab nav-link" href="{{url('coldCalling')}}?<?php if(isset($_GET['p'])){ echo'p='.@$_GET['p'].'&'; }?>type=Wrong Number" role="tab">
                                       <span class="d-md-inline-block">Wrong Number</span>
                                     </a>
                                     @endif
                                 </li>
                          </ul>
                          <div class="tab-content p-3">
                            <div class="tab-pane active tab-pane-coldcalling" id="home" role="tabpanel">
                              <!--COLDCALLING FILTERS AND SEARCH START FROM HERE-->  
                              <div class="col-lg-12">
                                  <div class="row">
                                     <div class="col-md-12">
                                        <form method="GET" class="coldcallingForm" id="coldsForm">
                                           <div class="row mt-2 mb-2">
                                              <div class="col-md-12">
                                                 <div class="row">
                                                    @if(isset($_GET['type'])) <input type="hidden" name="type" value="{{@$_GET['type']}}"/> @endif
                                                    @if(isset($_GET['p'])) <input type="hidden" name="p" value="{{@$_GET['p']}}"/> @endif
                                                    <div class="col-md-4 pl-1 pr-1">
                                                       <div class="dropdown_wrapper ">
                                                          <input type="text" class="form-control filter_input" list="building" placeholder="select Building" name="build" @if(@$_GET['build']) value="{{@$_GET['build']}}" @endif>
                                                          <datalist id="building">
                                                             <option value="">Select building</option>
                                                             @if(@$buildings)
                                                             @foreach($buildings as $building)
                                                             <option value="{{$building}}"></option>
                                                             @endforeach
                                                             @endif
                                                          </datalist>
                                                       </div>
                                                    </div>
                                                    <div class="col-md-2 pl-1 pr-1">
                                                       <div class="dropdown_wrapper ">
                                                          <input type="text" class="form-control filter_input" list="area" placeholder="select area" name="area" @if(@$_GET['area']) value="{{@$_GET['area']}}" @endif>
                                                          <datalist id="area">
                                                             <option value="">Select area</option>
                                                             @foreach($areas as $area)
                                                             <option value="{{$area}}"></option>
                                                             @endforeach
                                                          </datalist>
                                                       </div>
                                                    </div>
                                                    <div class="col-md-2 pl-1 pr-1">
                                                       <div class="dropdown_wrapper ">
                                                          <input type="text" class="form-control filter_input" list="bedroom" placeholder="select Bedroom" name="bedroom" @if(@$_GET[bedroom]) value="{{@$_GET['bedroom']}}" @endif>
                                                          <datalist id="bedroom">
                                                             <option value="">Select bedroom</option>
                                                             @foreach($bedrooms as $bedroom)
                                                             <option value="{{$bedroom}}"></option>
                                                             @endforeach
                                                          </datalist>
                                                       </div>
                                                    </div>
                                                    <div class="col-md-2 pl-1 pr-1">
                                                       <div class="dropdown_wrapper ">
                                                          <input id="name" class="form-control filter_input" list="allNames" autocomplete="off" @if(@$_GET[agent]) value="{{@$_GET['agent']}}" @endif placeholder="select Agent"/>
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
                                                    <div class="col-md-2 pl-1 pr-1">
                                                       <div class="dropdown_wrapper ">
                                                          <input type="text" class="form-control filter_input" list="unit" placeholder="unit_No" name="unit" @if(@$_GET[unit]) value="{{@$_GET['unit']}}" @endif>
                                                          <datalist id="unit">
                                                             <option value="">unit_No</option>
                                                          </datalist>
                                                       </div>
                                                    </div>
                                                    <div class="col-md-2 pl-1 pr-1 mt-2"style="z-index: 9;">
                                                       <div class="dropdown_wrapper ">
                                                          <input type="text" class="form-control filter_input" list="unit_no" placeholder="contact" name="contact" @if(@$_GET[contact]) value="{{@$_GET['contact']}}" @endif>
                                                          <datalist id="contact">
                                                             <option value="">contact</option>
                                                          </datalist>
                                                       </div>
                                                    </div>
                                                 </div>
                                              </div>
                                           </div>
                                              <div class="row buttons" style="margin-right: 0px;margin-top: -48px;">
                                              <div class="col-md-8"></div>
                                                @if(ucfirst(session('role'))==ucfirst('Admin') || ucfirst(session('role'))==ucfirst('SuperDuperAdmin'))
                                                  <div class="col-md-2  filter_button">
                                                     <div class="filter_btn_wrapper" style="padding-right: 0px;">
                                                        <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter" name="search" id="filter">
                                                     </div>
                                                  </div>
                                                  <div class="col-md-1 assign_button">
                                                     <div class="filter_btn_wrapper">
                                                        <input type="button" class="btn btn-success btn-block" id="assign-single-coldcalling" value="Assign">
                                                      </div>
                                                    </div>
                                                    <div class="col-md-1 export_button">
                                                      <div class="filter_btn_wrapper">
                                                        <input type="button" class="btn btn-primary" id="export" value="Export CVS">
                                                    </div>
                                                   </div>
                                                  @endif
                                                  @if(ucfirst(session('role'))==ucfirst('SuperAgent'))
                                                  @if(@$permissions->coldCallingAssign==NULL)
                                                     <div class="col-md-3 coldFilter" style="margin-left: 1071px; margin-top: 1px; padding-left: 0%; padding-right: 9px;">
                                                        <div class="filter_btn_wrapper">
                                                           <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter" name="search">
                                                        </div>
                                                     </div>
                                                  @else
                                                   <div class="col-md-2 pl-1 pr-1 coldFilter" style="margin-left: 932px; margin-top: 1px;">
                                                        <div class="filter_btn_wrapper">
                                                           <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter" name="search">
                                                        </div>
                                                     </div>
                                                  @endif
                                                      @if(@$permissions->coldCallingAssign==1) 
                                                        <div class="col-md-1 pl-1 pr-1 coldAssign" style="margin-top: 0px;">
                                                           <div class="filter_btn_wrapper">
                                                              <input type="button" class="btn btn-success btn-block" id="assign-single-coldcalling" value="Assign" style="height: 39px;">
                                                           </div>
                                                        </div>
                                                     @endif
                                                  @endif
                                              </div>
                                        </form>
                                     </div>
                                  </div>
                              </div>
                              <!--COLDCALLING FILTERS AND SEARCH END HERE--> 

                              <table class="table table-striped mb-0 mt-5 table-responsive">
                                <thead>
                                    <tr>
                                        @if(@$_GET['type']=='')
                                        <th class="checkall" style="cursor:pointer">Select All</th>
                                        <th style="padding: 0px !important;width: 1%;">Unit No </th>
                                        <th>Building Name </th>
                                        <th>Area </th>
                                        <th style="width: 12% !important;">LandLord </th>
                                        <th>Agent</th>
                                        <th>Upcoming </th>
                                        <th>C.A </th>
                                        @if(session('role') == 'SuperAgent')
                                        @else
                                        <th>Call</th>
                                        @endif
                                        <th>Interested</th>
                                        <th>Not Interested</th>
                                        <th>Off Plan</th>
                                        <th>Investor</th>
                                        @if(session('role') == 'SuperAgent')
                                        @else
                                        <th>Email</th>
                                        @endif
                                        <th>Access</th>
                                        <th>Action</th>
                                        @else
                                        <th class="checkall" style="cursor:pointer">Select All</th>
                                        <th>Unit No </th>
                                        <th>Building</th>
                                        <th>Area </th>
                                        <th style="width: 12% !important;">LandLord </th>
                                        <th>Agent</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Area Sqft</th>
                                        <th>Bedroom</th>
                                        <th>Washroom</th>
                                        <th>Condition</th>
                                        <th>Type</th>
                                        <th>Sale Price</th>
                                        <th>Rent Price</th>
                                        <th>Access</th>
                                        @endif
                                    </tr>
                                </thead>
                                  <form id="bulkForm" class="form-inline">
                                    @csrf
                                    <!--ASSIGN SINGLE COLDCALLING-->
                                      <div class="modal fade" id="assigncoldcalling" tabindex="-1" role="dialog" aria-labelledby="assigncoldcalling" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                               <div class="modal-header">
                                                  <h5 class="modal-title" id="assigncoldcalling">Assign Cold Calling</h5>
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
                                                  <button type="submit" id="assign-coldcalling-btn" class="btn btn-success">Submit</button>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                      <!--ASSIGN SINGLE COLDCALLING-->
                                      
                                   <input type='hidden' value='' name='status' class='status'>
                                   <input type='hidden' value='' name='sending_email' class="sending_email">
                                   <input type='hidden' value='' name='time_date' class='time_date_input'>
                                   <input type='hidden' value='' name='description' class='description_input'>
                                    
                                    @if(@$_GET['type']=='')    
                                     <!--ALL PROPERTY TABLE START FROM HERE-->
                                     <tbody style="font-size: 12px;">
                                        @if(isset($result_data))
                                        @if(count($result_data) > 0)
                                        <?php $counter=0;  ?>
                                        @foreach($result_data->chunk(3) as $chunks)
                                        @foreach($chunks as $record)
                                        <tr class="present_row">
                                           <td>
                                              <img style="width: 21px;margin-top: -9px !important;" src="public/assets/images/next.png" class="drop_arrow_icon pulse-effect">
                                              <input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$record->id}}">
                                           </td>
                                           <td style="padding: 0px !important">       {{$record->unit_no}}</td>
                                           <td>{{$record->Building}}</td>
                                           <td>{{$record->area}}</td>
                                           <td>{{strtoupper($record->LandLord)}}</td>
                                           <td>{{strtoupper(@$record->user->user_name)}}</td>
                                           <td>
                                              <label data-toggle="modal" data-target=".bs-example-modal-sm" id="{{$record->id}}" value="upcoming" style="cursor: pointer;display: table-cell;" class="label label-primary update-status-row">Register</label>
                                           </td>
                                           <td>
                                              <label data-toggle="modal" data-target=".bs-example-modal-sm" id="{{$record->id}}" value="Check Availability" style="cursor: pointer;display: table-cell;" class="label label-primary update-status-row">Register</label>
                                           </td>
                                           @if(session('role') == 'SuperAgent')
                                           @else
                                           <td>
                                              <div class="content" style="display: none;">
                                                 <?php $temp=explode(',', $record->contact_no);
                                                    foreach ($temp as $key=>$value) { ?>
                                                 <span style="display: block;width: 100%;" class="content-inner">Phone : {{$value}}</span>
                                                 <?php  }  ?>
                                              </div>
                                              <label data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="label label-success show_content" name="Phone Number">Show</label>
                                              <label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer;display: table-cell;" class="label label-primary add_phone">Add</label>
                                           </td>
                                           @endif
                                           <td>
                                              <label data-toggle="modal" data-target=".bs-example-modal-sm" id="{{$record->id}}" value="Interested" style="cursor: pointer;display: table-cell;" class="label label-primary update-status-row">Register</label>
                                           </td>
                                           <td>
                                              <label  id="{{$record->id}}" value="Not interested" style="cursor: pointer;display: table-cell;" class="label label-primary update-status-row-no-reminder">Register</label>
                                           </td>
                                           <td>
                                              <label data-toggle="modal" data-target=".bs-example-modal-sm" id="{{$record->id}}" value="off plan" style="cursor: pointer;display: table-cell;" class="label label-primary update-status-row">Register</label>
                                           </td>
                                           <td>
                                              <label data-toggle="modal" data-target=".bs-example-modal-sm" id="{{$record->id}}" value="Investor" style="cursor: pointer;display: table-cell;" class="label label-primary update-status-row">Register</label>
                                           </td>
                                           @if(session('role') == 'SuperAgent')
                                           @else
                                           <td>
                                              <div class="content" style="display: none;">
                                                 <?php $temp=explode(',', $record->email);foreach ($temp as $key=>$value) { ?>
                                                 <span class="content-inner" style="display: block;width: 100%;">Email : {{$value}}</span>
                                                 <?php  }  ?>
                                              </div>
                                              <label data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer;display: table-cell;position: relative;right: 5px;" class="label label-success show_content" name="Email Address">Show</label>
                                              <label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer;display: table-cell;" class="label label-primary add_email">Add</label>
                                           </td>
                                           @endif
                                           <td>{{$record->access}}</td>
                                           <td>
                                             <a href="{{url('EditColdcalling')}}?record_id={{$record->id}}&coldcalling-action=edit" class="edit_supervision">Edit <i class="fa fa-edit"></i></a>
                                           </td>
                                        </tr>
                                        <!--TOGGLE ROW START FROM HERE-->
                                        <tr class="toggleable_row">
                                           <td colspan="19">
                                              <div class="row">
                                                 <div class="col-sm-4">
                                                    <div class="form-group">
                                                       <label>Washroom </label>
                                                       <select class="form-control" style="font-size: 12px;" name="washroom[{{$counter}}]">
                                                          <option value="">Select Option</option>
                                                          <option>1</option>
                                                          <option @if(@$record->Washroom == 1.5) Selected @endif value="1.5">1.5</option>
                                                          <option @if(@$record->Washroom == 2.5) Selected @endif value="2.5">2.5</option>
                                                          <option @if(@$record->Washroom == 3.5) Selected @endif value="3.5">3.5</option>
                                                          <option @if(@$record->Washroom == 4.5) Selected @endif value="4.5">4.5</option>
                                                          <option @if(@$record->Washroom == 5.5) Selected @endif value="5.5">5.5</option>
                                                          <option @if(@$record->Washroom == 6.5) Selected @endif value="6.5">6.5</option>
                                                          <option @if(@$record->Washroom == 7.5) Selected @endif value="7.5">7.5</option>
                                                          <option @if(@$record->Washroom == 8.5) Selected @endif value="8.5">8.5</option>
                                                       </select>
                                                    </div>
                                                 </div>
                                                 <div class="col-sm-4">
                                                    <div class="form-group">
                                                       <label>Condtion</label>
                                                       <select name="Conditions[{{$counter}}]" class="form-control" required style="font-size: 12px;"  >
                                                          <option value="">Select Option</option>
                                                          <option @if(@$record->Conditions == 'Furnished') Selected @endif value="Furnished">Furnished</option>
                                                          <option @if(@$record->Conditions == 'unFurnished') Selected @endif value="unFurnished">unFurnished</option>
                                                          <option @if(@$record->Conditions == 'Full Furnished') Selected @endif value="Full Furnished">Full Furnished</option>
                                                          <option @if(@$record->Conditions == 'Semi Furnished') Selected @endif value="Semi Furnished">Semi Furnished</option>
                                                       </select>
                                                    </div>
                                                 </div>
                                                 <div class="col-sm-4">
                                                    <label>Bedrooms</label>
                                                    <select class="form-control" style="font-size: 12px;"  name="bedroom[{{$counter}}]">
                                                       <option value="">Select Option</option>
                                                       <option @if(@$record->Bedroom == 'studio') Selected @endif value="studio">studio</option>
                                                       <option @if(@$record->Bedroom == '1') Selected @endif value="1">1</option>
                                                       <option @if(@$record->Bedroom == '2') Selected @endif value="2">2</option>
                                                       <option @if(@$record->Bedroom == '3') Selected @endif value="3">3</option>
                                                       <option @if(@$record->Bedroom == '4') Selected @endif value="4">4</option>
                                                       <option @if(@$record->Bedroom == '5') Selected @endif value="5">5</option>
                                                       <option @if(@$record->Bedroom == '6') Selected @endif value="6">6</option>
                                                       <option @if(@$record->Bedroom == '7') Selected @endif value="7">7</option>
                                                       <option @if(@$record->Bedroom == '8') Selected @endif value="8">8</option>
                                                       <option @if(@$record->Bedroom == '9') Selected @endif value="9">9</option>
                                                       <option @if(@$record->Bedroom == '10') Selected @endif value="10">10</option>
                                                       <option @if(@$record->Bedroom == '11') Selected @endif value="11">11</option>
                                                       <option @if(@$record->Bedroom == '12') Selected @endif value="12">12</option>
                                                    </select>
                                                 </div>
                                                 <div class="col-sm-4">
                                                    <label>Type </label>
                                                    <input type="text" name="type[{{$counter}}]" value="{{@$record->type}}" class="form-control">
                                                 </div>
                                                 <div class="col-sm-4" style="display: none;">
                                                    <label>Area Sqft </label>
                                                    <input type="text" name="Area_Sqft[{{$counter}}]" value="{{@$record->Area_Sqft}}" class="form-control">
                                                 </div>
                                                 <div class="col-sm-4">
                                                    <label style="text-align: start">Comment</label>
                                                    <input type="text" name="comment[{{$counter}}]" value="{{@$record->comment}}" class="form-control">
                                                 </div>
                                                 <div class="col-sm-4 p-2">
                                                    <div class="row">
                                                       <div class="col-xs-6">
                                                          <div class="form-group">
                                                             <label class="ccontainer">Rent
                                                             <input @if(!is_null(@$record->rented_status)) checked="" @endif type="checkbox" name="rentedStatus[{{$counter}}]">
                                                             <span class="checkmark"></span>
                                                             </label>
                                                          </div>
                                                       </div>
                                                       <div class="col-sm-3">
                                                          <label>Price</label>
                                                          <input type="text" value="{{@$record->rented_price}}" class="form-control" name="rentedPrice[{{$counter}}]">
                                                       </div>
                                                       <div class="col-xs-6">
                                                          <div class="form-group">
                                                             <label class="ccontainer">Sale
                                                             <input type="checkbox" @if(!is_null(@$record->sale_status)) checked="" @endif name="saleStatus[{{$counter}}]">
                                                             <span class="checkmark"></span>
                                                             </label>
                                                          </div>
                                                       </div>
                                                       <div class="col-sm-3">
                                                          <label>Price</label>
                                                          <input type="text" value="{{@$record->sale_price}}" class="form-control"  name="salePrice[{{$counter++}}]">
                                                       </div>
                                                    </div>
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
                                        @endforeach
                                        @endforeach
                                        @else
                                        <tr>
                                           <td colspan="15" align="center">No Record Found</td>
                                        </tr>
                                        @endif 
                                        @endif                    
                                     </tbody>
                                     <!--ALL PROPERTY TABLE END HERE-->
                                     @else
                                     <tbody style="font-size: 12px;">
                                        @if(isset($result_data))
                                        @if(count($result_data) > 0)
                                        <?php $counter=0; ?>
                                        @foreach($result_data as $record)
                                        <tr class="present_row">
                                           <td><img style="width: 21px;margin-top: -9px !important;" src="https://img.icons8.com/cotton/24/000000/circled-right.png" class="drop_arrow_icon pulse-effect"><input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$record->id}}"></td>
                                           <td style="padding: 0px !important">{{$record->unit_no}}</td>
                                           <td>{{$record->Building}}</td>
                                           <td>{{$record->area}}</td>
                                           <td>{{strtoupper($record->LandLord)}}</td>
                                           <td>{{strtoupper(@$record->user->user_name)}}</td>
                                           <td>
                                              <div class="content" style="display: none;">
                                                 <?php $temp=explode(',', $record->contact_no);
                                                    foreach ($temp as $key=>$value) { ?>
                                                 <span style="display: block;width: 100%;" class="content-inner">Phone : {{$value}}</span>
                                                 <?php  }  ?>
                                              </div>
                                              <label data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="label label-success show_content" name="Phone Number">Show</label>
                                              <label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer;display: table-cell;" class="label label-primary add_phone">Add</label>
                                           </td>
                                           <td>
                                              <div class="content" style="display: none;">
                                                 <?php $temp=explode(',', $record->email);foreach ($temp as $key=>$value) { ?>
                                                 <span style="display: block;width: 100%;" class="content-inner">Email : {{$value}}</span>
                                                 <?php  }  ?>
                                              </div>
                                              <label data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer;display: table-cell;position: relative;right: 5px;" class="label label-success show_content" name="Email Address">Show</label>
                                              <label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer;display: table-cell;" class="label label-primary add_email">Add</label>
                                           </td>
                                           <td>{{$record->Area_Sqft}}</td>
                                           <td>@if(!is_null($record->Bedroom)){{$record->Bedroom}}@else N/A @endif</td>
                                           <td>@if(!is_null($record->Washroom)){{$record->Washroom}}@else N/A @endif</td>
                                           <td>@if(!is_null($record->Conditions)){{$record->Conditions}}@else N/A @endif</td>
                                           <td>@if(!is_null($record->type)){{$record->type}}@else N/A @endif</td>
                                           <td>@if(!is_null($record->sale_price)){{$record->sale_price}}@else N/A @endif</td>
                                           <td>@if(!is_null($record->rented_price)){{$record->rented_price}}@else N/A @endif</td>
                                           <td>{{$record->access}}</td>
                                        </tr>
                                        <!--TOGGLE ROW START FROM HERE-->
                                        <tr class="toggleable_row">
                                           <td colspan="19">
                                              <div class="row">
                                                 <div class="col-sm-4">
                                                    <div class="form-group">
                                                       <label>Washroom </label>
                                                       <select class="form-control" style="font-size: 12px;" name="washroom[{{$counter}}]">
                                                          <option value="">Select Option</option>
                                                          <option>1</option>
                                                          <option @if(@$record->Washroom == 1.5) Selected @endif value="1.5">1.5</option>
                                                          <option @if(@$record->Washroom == 2.5) Selected @endif value="2.5">2.5</option>
                                                          <option @if(@$record->Washroom == 3.5) Selected @endif value="3.5">3.5</option>
                                                          <option @if(@$record->Washroom == 4.5) Selected @endif value="4.5">4.5</option>
                                                          <option @if(@$record->Washroom == 5.5) Selected @endif value="5.5">5.5</option>
                                                          <option @if(@$record->Washroom == 6.5) Selected @endif value="6.5">6.5</option>
                                                          <option @if(@$record->Washroom == 7.5) Selected @endif value="7.5">7.5</option>
                                                          <option @if(@$record->Washroom == 8.5) Selected @endif value="8.5">8.5</option>
                                                       </select>
                                                    </div>
                                                 </div>
                                                 <div class="col-sm-4">
                                                    <div class="form-group">
                                                       <label>Condtion</label>
                                                       <select name="Conditions[{{$counter}}]" class="form-control" required style="font-size: 12px;"  >
                                                          <option value="">Select Option</option>
                                                          <option @if(@$record->Conditions == 'Furnished') Selected @endif value="Furnished">Furnished</option>
                                                          <option @if(@$record->Conditions == 'unFurnished') Selected @endif value="unFurnished">unFurnished</option>
                                                          <option @if(@$record->Conditions == 'Full Furnished') Selected @endif value="Full Furnished">Full Furnished</option>
                                                          <option @if(@$record->Conditions == 'Semi Furnished') Selected @endif value="Semi Furnished">Semi Furnished</option>
                                                       </select>
                                                    </div>
                                                 </div>
                                                 <div class="col-sm-4">
                                                    <label>Bedrooms</label>
                                                    <select class="form-control" style="font-size: 12px;"  name="bedroom[{{$counter}}]">
                                                       <option value="">Select Option</option>
                                                       <option @if(@$record->Bedroom == 'studio') Selected @endif value="studio">studio</option>
                                                       <option @if(@$record->Bedroom == '1') Selected @endif value="1">1</option>
                                                       <option @if(@$record->Bedroom == '2') Selected @endif value="2">2</option>
                                                       <option @if(@$record->Bedroom == '3') Selected @endif value="3">3</option>
                                                       <option @if(@$record->Bedroom == '4') Selected @endif value="4">4</option>
                                                       <option @if(@$record->Bedroom == '5') Selected @endif value="5">5</option>
                                                       <option @if(@$record->Bedroom == '6') Selected @endif value="6">6</option>
                                                       <option @if(@$record->Bedroom == '7') Selected @endif value="7">7</option>
                                                       <option @if(@$record->Bedroom == '8') Selected @endif value="8">8</option>
                                                       <option @if(@$record->Bedroom == '9') Selected @endif value="9">9</option>
                                                       <option @if(@$record->Bedroom == '10') Selected @endif value="10">10</option>
                                                       <option @if(@$record->Bedroom == '11') Selected @endif value="11">11</option>
                                                       <option @if(@$record->Bedroom == '12') Selected @endif value="12">12</option>
                                                    </select>
                                                 </div>
                                                 <div class="col-sm-4">
                                                    <label>Type </label>
                                                    <input type="text" name="type[{{$counter}}]" value="{{@$record->type}}" class="form-control">
                                                 </div>
                                                 <div class="col-sm-4">
                                                    <label>Area Sqft </label>
                                                    <input type="text" name="Area_Sqft[{{$counter}}]" value="{{@$record->Area_Sqft}}" class="form-control">
                                                 </div>
                                                 <div class="col-sm-4">
                                                    <label style="text-align: start">Comment</label>
                                                    <input type="text" name="comment[{{$counter}}]" value="{{@$record->comment}}" class="form-control">
                                                 </div>
                                                 <div class="col-sm-4 p-2">
                                                    <div class="container">
                                                       <div class="row">
                                                          <div class="col-xs-6">
                                                             <div class="form-group">
                                                                <label class="ccontainer">Rent
                                                                <input @if(!is_null(@$record->rented_status)) checked="" @endif type="checkbox" name="rentedStatus[{{$counter}}]">
                                                                <span class="checkmark"></span>
                                                                </label>
                                                             </div>
                                                          </div>
                                                          <div class="col-sm-4">
                                                             <label>Price</label>
                                                             <input type="number" value="{{@$record->rented_price}}" class="form-control" name="rentedPrice[{{$counter}}]">
                                                          </div>
                                                       </div>
                                                    </div>
                                                 </div>
                                                 <div class="col-sm-4 p-2">
                                                    <div class="container">
                                                       <div class="row">
                                                          <div class="col-xs-6">
                                                             <div class="form-group">
                                                                <label class="ccontainer">Sale
                                                                <input type="checkbox" @if(!is_null(@$record->sale_status)) checked="" @endif name="saleStatus[{{$counter}}]">
                                                                <span class="checkmark"></span>
                                                                </label>
                                                             </div>
                                                          </div>
                                                          <div class="col-sm-4">
                                                             <label>Price</label>
                                                             <input type="number" value="{{@$record->sale_price}}" class="form-control"  name="salePrice[{{$counter++}}]">
                                                          </div>
                                                       </div>
                                                    </div>
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
                                        @endforeach
                                        @else
                                        <tr>
                                           <td colspan="17" align="center">No Record Found</td>
                                        </tr>
                                        @endif 
                                        @endif                    
                                     </tbody>
                                     @endif
                                  </form>
                                </tbody>
                            </table>
                            </div>
                            <div class="ml-auto pr-3 mb-5 mt-3">
                              @if(@$result_data)
                               @if(isset($_GET['p']))
                               @if(isset($_GET['type']))
                               {{$result_data->appends(Request::only('p','type','build','area','bedroom','agent','unit','contact'))->links()}}
                               @else  
                               {{$result_data->appends(Request::only('p','type','build','area','bedroom','agent','radioSearch','filterContact','unit','contact'))->links()}}                       
                               @endif   
                               @else
                               @if(isset($_GET['type']))
                               {{$result_data->appends(Request::only('p','type','build','area','bedroom','agent','unit','contact'))->links()}}
                               @else  
                               {{$result_data->appends(Request::only('p','type','build','area','bedroom','agent','unit','contact'))->links()}}                       
                               @endif   
                               @endif
                              @endif
                            </div>
                          </div>
                      </div>
                  </div>
                  <div class="card add_property_card" style="display: {{@$Formdisplay}};">
                    <div class="card-header">
                      <!-- ADD COLDCALLING PROPERTY START FROM HERE -->
                         <div class="row back_btn_row m-b-40">
                          @if(isset($_GET["coldcalling-action"]))
                          <h4 class="ml-3 mt-3">ColdCalling Details</h4>
                          @else
                            <div class="col-12 back_wrapper cold">
                              <a href="{{url('coldCalling')}}">
                               <span><i class="fas fa-arrow-circle-left" id="back_to_owner"></i></span>
                              </a>
                               <h4 class="ml-5 mt-2">New ColdCalling Property</h4>
                            </div>
                          @endif
                         </div>
                    </div>
                      <div class="card-body">
                         
                         <div class="row owner_information_link">
                            <div class="col-lg-12 mobile-card">
                               <div class="card card-outline-info">
                                  <div class="card-body">
                                     <form action="<?php if(isset($_GET['coldcalling-action'])){ echo url('UpdateColdcalling'); }else{ echo url('Addproperty'); } ?>" class="form-horizontal" method="post" enctype='multipart/form-data' id="property">
                                        @csrf
                                        <input type="hidden" name="property_id" value="{{@$result[0]['id']}}">
                                        <div class="form-body">
                                           <div class="row">
                                              <div class="col-md-6">
                                                 <div class="form-group row">
                                                    <label class="control-label  col-md-3 unit_no">Unit No</label>
                                                    <div class="col-md-9">
                                                       <input required="" type="text" class="form-control" name="unit_no" value="{{@$result[0]['unit_no']}}">
                                                       <!-- <small class="form-control-feedback"> This is inline help </small>  -->
                                                    </div>
                                                 </div>
                                              </div>
                                              <!--/span-->
                                              <div class="col-md-6">
                                                 <div class="form-group has-danger row">
                                                    <label class="control-label  col-md-3 building">Building</label>
                                                    <div class="col-md-8 building_input" style="padding-left: 15px;">
                                                        <input type="text" class="form-control filter_input_name" list="buildings" placeholder="select Building" name="building" value="">
                                                           <datalist id="buildings">
                                                              <option value="">Select building</option>
                                                              @foreach($buildingss as $building)
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
                                                       <label class="control-label  col-md-3 dewa_no">Dewa No</label>
                                                       <div class="col-md-9">
                                                          <input type="text" class="form-control" name="dewa_no" value="{{@$result[0]['dewa_no']}}">
                                                          <!-- <small class="form-control-feedback"> This is inline help </small>  -->
                                                       </div>
                                                    </div>
                                                 </div>
                                              <!--/span-->
                                              <div class="col-md-6">
                                                 <div class="form-group row">
                                                    <label class="control-label  col-md-3 bedroom">Bedroom</label>
                                                    <div class="col-md-9">
                                                       <select required style="font-size: 12px;" name="Bedroom" class="form-control">
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
                                                    <label class="control-label  col-md-3 area">Area</label>
                                                    <div class="col-md-9">
                                                       <input required="" type="text" name="area" class="form-control" value="{{@$result[0]['area']}}">
                                                       <!-- <small class="form-control-feedback"> Select your gender. </small>  -->
                                                    </div>
                                                 </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group row">
                                                    <label class="control-label  col-md-3 washroom">Washroom</label>
                                                    <div class="col-md-9">
                                                       <select name="Washroom" class="form-control" style="font-size: 12px; " >
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
                                                    <label class="control-label  col-md-3 condition">Conditions</label>
                                                    <div class="col-md-9">
                                                       <select name="Conditions"  class="form-control" style="font-size: 12px;">
                                                          <option value="{{@$result[0]['Conditions']}}">{{@$result[0]['Conditions']}}</option>
                                                          <option value="Furnished">Furnished</option>
                                                          <option value="unfurnished">unfurnished</option>
                                                          <option value="full Furnished">full Furnished</option>
                                                          <option value="Semi Furnished">Semi Furnished</option>
                                                       </select>
                                                       <!-- <small class="form-control-feedback"> Select your gender. </small>  -->
                                                    </div>
                                                 </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group row">
                                                    <label class="control-label  col-md-3 email">Email</label>
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
                                                    <label class="control-label  col-md-3 landlord">LandLord</label>
                                                    <div class="col-md-9">
                                                       <input required="" type="text" style="font-size: 12px;" class="form-control" name="LandLord" value="{{@$result[0]['LandLord']}}">
                                                    </div>
                                                 </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group row">
                                                    <label class="control-label  col-md-3 access">Access</label>
                                                    <div class="col-md-9">
                                                       <select class="form-control access" name="access" style="font-size: 12px;" required>
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
                                                                <div class="form-group"> <input required="" style="width:100%" type="datetime-local" value="{{$reminders->reminderDate($reminders->date_time)}}" class="form-control" name="add_property_date_time"> </div>
                                                             </div>
                                                             <div class="col-sm-12"> <textarea class="form-control reminder_description" required value="" style="width:100%" rows="4" name="add_property_reminder_description" placeholder="Description">{{$reminders->description}}</textarea></div>
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
                                                    <label class="control-label  col-md-3 phone">Phone Number</label>
                                                    <div class="col-md-9">
                                                       <?php $temp=explode(',', @$result[0]['contact_no']); if(count($temp) > 1){ foreach ($temp as $value) {?>
                                                       <input required="" type="text" class="form-control" name="contact_no[]" value="{{$value}}" style="margin-bottom: 1%">
                                                       <?php } }else { ?>
                                                       <input  type="text" required="" class="form-control" name="contact_no[]" value="{{@$result[0]['contact_no']}}">
                                                       <?php  } ?>
                                                    </div>
                                                 </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group row">
                                                    <label class="control-label  col-md-3 price">Price</label>
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
                                                    <label class="control-label  col-md-3 areasqft">Area Sqft</label>
                                                    <div class="col-md-9">
                                                       <input required="" type="number" class="form-control" name="Area_Sqft" value="{{@$result[0]['Area_Sqft']}}">
                                                    </div>
                                                 </div>
                                              </div>

                                              <div class="col-md-6">
                                                    <div class="form-group row">
                                                       <label class="control-label  col-md-3 ptype">Property Type</label>
                                                       <div class="col-md-9">
                                                          <select class="form-control" style="font-size:12px !important;" name="property_type">
                                                             <option value="">Please Select Type</option>
                                                             <option @if(@$result[0]['property_type'] == "Commercial") selected @endif value="Commercial">Commercial</option>
                                                             <option @if(@$result[0]['property_type'] == "residential") selected @endif value="residential">Residential</option>
                                                             <option @if(@$result[0]['property_type'] == "dewa") selected @endif value="dewa">DEWA</option>
                                                          </select>
                                                       </div>
                                                    </div>
                                                 </div>
                                              </div>
                                           </div>

                                           
                                           <div class="row">
                                              <div class="col-md-6">
                                                 <div class="form-group row">
                                                    <label class="control-label  col-md-3 add_comment">Add Comment</label>
                                                    <div class="col-md-9">
                                                       <textarea class="form-control" name="comment" cols="4" rows="6">{{@$result[0]['comment']}}</textarea>
                                                    </div>
                                                 </div>
                                              </div>
                                           </div>
                                           <!--/row-->
                                           <div class="form-actions">
                                              <div class="row">
                                                 <div class="col-md-1"> </div>
                                                 <div class="col-md-6">
                                                    <div class="row">
                                                       <div class="col-md-offset-3 col-md-9" style="    padding-left: 10%;">
                                                          <button type="submit" name="add_property" class="btn btn-success submit"><?php if(isset($_GET["coldcalling-action"])){echo "Update";}else{echo "Submit";}?></button>
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
                         <!-- ADD COLDCALLING PROPERTY END HERE -->
                      </div>
                  </div>
              </div>
          </div>
          <!-- end row -->

      </div>
      <!-- end container-fluid -->
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
    <!--SHOW ADDITIONAL EMAIL AND PHONE MODEL START FROM HERE-->
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
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             </div>
          </div>
       </div>
    </div>
    <!--EMAIL MODEL HERE-->
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
    <!--SHOW ADDITIONAL EMAIL AND PHONE MODEL END HERE-->
    <!--ADD ADDITIONAL EMAIL AND PHONE MODEL START FROM HERE-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
          <form action="{{url('addLandlordEmailPass')}}?ref=coldcalling" method="get">
             <div class="modal-content">
                <div class="modal-header">
                   
                </div>
                <div class="modal-body add_model_body">
                </div>
                <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                   <button type="submit" class="btn btn-primary">Save changes</button>
                   <input type="hidden" name="ref" value="coldcalling" />
                </div>
             </div>
          </form>
       </div>
    </div>
    <!--ADD ADDITIONAL EMAIL AND PHONE MODEL END HERE-->
  </div> 
  <!-- end page-content-wrapper -->
</div>
<!-- End Page-content -->


@include('inc.footer')

@if(session('msg'))
   <script> alertify.success("{!! session('msg') !!}"); </script>
@endif
@if(session('error'))
   <script> alertify.error("{!! session('error') !!}"); </script>
@endif
<!-- add building using ajax-->
<script>
   $(document).ready(function(){
       $('.add-building-btn').click(function(){
           var buildingName=$('.add-building-input').val();
           if(!$('.add-building-input').val()){
               // alert('invalid Building Name');
               alertify.error("invalid Building Name");
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
<script>
  $('#add-new-owne-link').on('click',function(){
    $('.all_property_card').css('display','none');
    $('.add_property_card').css('display','block');
  })
</script>
<!-- end of add building using ajax-->
<script type="text/javascript">
   // Select all
   var clicked = false;
   $(".checkall").on("click", function() {
     $(".ind_chk_box").prop("checked", !clicked);
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
            alertify.error("please select Rows!");
            // alert('please select Rows!');
            $('.msg-status').text('');
            return;
        }
       $.ajax({
           url:'<?php echo url('whatsApp-msgs');  ?>',
           type:'get',
           data : $("#bulkForm").serialize(),
           success:function(data){
               var whatsappMessage = window.encodeURIComponent(data)
               $('.whatsapp').attr('href','https://wa.me/?text='+whatsappMessage+'');
               $('.msg-status').text('Please Click the Button again to sent Message');
               $('.reset').show();
           }
       })
   })
          //whatsapp Button two
   $(document).delegate('.whatsapp_2','click',function(e){
       $('.msg-status-2').text('Wait...');
       if(!$('.ind_chk_box:checkbox:checked').val()){
            // alert('please select Rows!');
            alertify.error("please select Rows!");
            $('.msg-status-2').text('');
            return;
        }
       $.ajax({
           url:'<?php echo url('whatsApp-Ownermsgs');  ?>',
           type:'get',
           data : $("#bulkForm").serialize(),
           success:function(data){
               console.log(data);
               var whatsappMessage = window.encodeURIComponent(data)
               $('.whatsapp_2').attr('href','https://wa.me/?text='+whatsappMessage+'');
               $('.msg-status-2').text('Please Click the Button again to sent Message');
               $('.reset-2').show();
           }
       })
   })
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
   //FILTER CODE START FROM HERE
   $('.slct_building_btn').click(function(){
       var current_drp_content = $(this).next('.drpcontent').attr('id');
       $('.drpcontent').not('#'+current_drp_content).hide();
       $(this).next('.drpcontent').toggle('fast');
   });
   $('#drpcontent1 a').click(function(){
       var clicked_a =  $(this).text();
       $('#myInput').val(clicked_a);
       $('#slctBuilding').text(clicked_a);
       $('#drpcontent1').slideUp();
   });
   $('#drpcontent2 a').click(function(){
       var clicked_a =  $(this).text();
       $('#myInput2').val(clicked_a);
       $('#slctArea').text(clicked_a);
       $('#drpcontent2').slideUp();
   });
   $('#drpcontent3 a').click(function(){
       var clicked_a =  $(this).text();
       $('#myInput3').val(clicked_a);
       $('#slctBedroom').text(clicked_a);
       $('#drpcontent3').slideUp();
   });
   $('#drpcontent4 a').click(function(){
       var clicked_a =  $(this).text();
       $('#myInput4').val(clicked_a);
       $('#slctAgent').text(clicked_a);
       $('#drpcontent4').slideUp();
   });
   function filterFunction() {
   var input,filter, ul, li, a, i;
   input = document.getElementById("myInput");
   filter = input.value.toUpperCase();
   a = $('.dropdown_content a');
   for (i = 0; i < a.length; i++) {
   txtValue = a[i].textContent || a[i].innerText;
   if (txtValue.toUpperCase().indexOf(filter) > -1) {
     a[i].style.display = "";
   } else {
     a[i].style.display = "none";
   }
   }
   }
   function filterFunction2() {
   var input2,filter2, ul, li, a, i;
   input2 = document.getElementById("myInput2");
   filter2 = input2.value.toUpperCase();
   a = $('.dropdown_content2 a');
   for (i = 0; i < a.length; i++) {
   txtValue = a[i].textContent || a[i].innerText;
   if (txtValue.toUpperCase().indexOf(filter2) > -1) {
     a[i].style.display = "";
   } else {
     a[i].style.display = "none";
   }
   }
   }
   function filterFunction3() {
   var input3,filter3, ul, li, a, i;
   input3 = document.getElementById("myInput3");
   filter3 = input3.value.toUpperCase();
   a = $('.dropdown_content3 a');
   for (i = 0; i < a.length; i++) {
   txtValue = a[i].textContent || a[i].innerText;
   if (txtValue.toUpperCase().indexOf(filter3) > -1) {
     a[i].style.display = "";
   } else {
     a[i].style.display = "none";
   }
   }
   }
   function filterFunction4() {
       console.log('key up');
   var input4,filter4, ul, li, a, i;
   input4 = document.getElementById("myInput3");
   filter4 = input4.value.toUpperCase();
   a = $('.dropdown_content4 a');
   for (i = 0; i < a.length; i++) {
   txtValue = a[i].textContent || a[i].innerText;
   if (txtValue.toUpperCase().indexOf(filter4) > -1) {
     a[i].style.display = "";
   } else {
     a[i].style.display = "none";
   }
   }
   }
   
   //FILTER CODE END FROM HERE  
   
   // SHOW PHONE NUMBER AND EMAIL CODE START FROM HERE
   $('.present_row .drop_arrow_icon').click(function(){
   $(this).parents('.present_row').next('.toggleable_row').toggleClass('tgl_row');
   $(this).toggleClass('rotate_icon');
   });
   $(document).delegate('.show_content','click',function(){
   var content=$(this).prev('.content').html();
   $('.content_model_title').text($(this).attr('name'));
   $('.content_model_body').html(content);
   })
   // SHOW EMAIL AND PHONE END HERE
   
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
       if($(this).val().toLowerCase()=='call back' || $(this).val().toLowerCase()=='upcoming' || $(this).val().toLowerCase()=='intrested' || $(this).val().toLowerCase()=='not answering' || $(this).val().toLowerCase()=='pending' || $(this).val().toLowerCase()=='off plan' || $(this).val().toLowerCase()=='investor' || $(this).val().toLowerCase()=='check availability'){
            $('.reminder').show();
            $('.update-status-by-row').hide();
            var access=$(this).val();
           $('.status').val(access);
           $("#model").trigger( "click" );
       }else{
           var access=$(this).val();
           $('.status').val(access);
       $.ajax({
           url:'<?php echo url('bulkUpdateStatusColdCalling');  ?>',
           type:'get',
           data : $("#bulkForm").serialize(),
           success:function(data){
               console.log(data);
               if(data=="true"){
                   location.reload();
               }else{
                   // alert('something went wrong');
                   alertify.error("something went wrong!");
               }
           }
       })
       }
    })
    
   //ACCESS DROPDOWN CODE END HERE  
   
   //SET REMINDER BUTTON CLICK CODE START FROM HERE  
    $('.reminder').click(function(){
       $('.date_time_error,.reminder_description-error').text("");
       if($('.date-time').val()==""){
          $('.date_time_error').text('This field is required!');
          return; 
       }
       else if($('.reminder_description').val()==""){
           $('.reminder_description-error').text('This field is required!');
          return; 
       }
       var time_date=$('.date-time').val();
       var description=$('.reminder_description').val();
       $('.time_date_input').val(time_date);
       $('.description_input').val(description);
       $.ajax({
           url:'<?php echo url('setReminderForColdCalling');  ?>',
           type:'get',
           data:$("#bulkForm").serialize(),
           success:function(data){
               if($.trim(data)=="true"){
                   location.reload();
               }else{
                   $('.reminder_description-error').html(data);
               }
           }
       })
    })
    
   //SET REMINDER BUTTON CLICK CODE END HERE 
   
   //ADD PHONE ADDITIONAL NUMBER AND EMAIL CODE START FROM HERE 
   $('body').delegate('.add_phone','click',function(){
   var id=$(this).attr('id');
   $('.modal-header').empty();
   $('.modal-header').append('<h4 class="modal-title" id="mySmallModalLabel">Add Phone</h4> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
   $('.add_model_body').html('<label>Phone</label><input type="number" name="phone" class="form-control"><input type="hidden" name="id" class="form-control" value="'+id+'">');
   })
   $('body').delegate('.add_email','click',function(){
   var id=$(this).attr('id');
   $('.modal-header').empty();
   $('.modal-header').append('<h4 class="modal-title" id="mySmallModalLabel">Add Email</h4> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
   $('.add_model_body').html('<label>Email</label><input type="email" name="email" class="form-control"><input type="hidden" name="id" class="form-control" value="'+id+'">');
   })
   
   //ADD PHONE ADDITIONAL NUMBER AND EMAIL CODE END HERE 
   
</script>
<script>
   $(document).ready(function(){
   //SET REMINDER FOR EACH ROW CDOE START FROM HERE
       $(document).delegate('.update-status-row','click',function(){
           $('.reminder').hide();
           $('.update-status-by-row').show();
           $('.update-status-by-row').attr('property_id',$(this).attr('id'));
           $('.update-status-by-row').attr('access',$(this).attr('value'));
       })
       
       $('.update-status-by-row').click(function(){
           $('.date_time_error,.reminder_description-error').text("");
           if($('.date-time').val()==""){
              $('.date_time_error').text('This field is required!');
              return; 
           }
           else if($('.reminder_description').val()==""){
               $('.reminder_description-error').text('This field is required!');
              return; 
           }
           var time_date=$('.date-time').val();
           var property_id=$(this).attr('property_id');
           var access=$(this).attr('access');
           var description=$('.reminder_description').val();
           $.ajax({
               url:'<?php echo url('setReminderByRow');  ?>',
               type:'get',
               data:{'property_id' : property_id,'time_date' : time_date,'access' : access, 'description' : description},
               success:function(data){
                   if($.trim(data)=="true"){
                       location.reload();
                   }else{
                       $('.reminder_description-error').html(data);
                   }
               }
           })
    })
       
   //SET REMINDER FOR EACH ROW CDOE START FROM HERE 
   
   //CHANGE ACCESS STATUS FOR EACH ROW CDOE START FROM HERE 
       $('.update-status-row-no-reminder').click(function(){
           var property_id=$(this).attr('id');
           var access=$(this).attr('value');
           $.ajax({
               url:'<?php echo url('updateColdCallingRow');  ?>',
               type:'get',
               data:{'property_id' : property_id,'access' : access},
               success:function(data){
                   if($.trim(data)=="true"){
                       location.reload();
                   }else{
                       alert(data);
                   }
               }
           })
    })
    $('.sent-email-btn').click(function(){
         $('.sending_email').val($('#sending_email').val());
        if(!$('.ind_chk_box:checkbox:checked').val()){
            // toastr["error"]("please select Rows!");
               alertify.error("please select Rows!");
            $('.msg-status').text('');
            return;
        }
       
        $('.email-loader').css('visibility','visible');
        $.ajax({
           url:'<?php echo url('sent-cold-calling-emails');  ?>',
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
    });
   //CHANGE ACCESS STATUS FOR EACH ROW CDOE END HERE 
       
   })
          $('.access').change(function(){
          if($(this).val()=='Upcoming'){
              $('.options').html('<div class="row"><input type="hidden" name="add_property_reminder_type" value="Upcoming"> <div class="col-sm-12"> <div class="form-group"> <input required="" style="width:100%" type="datetime-local" class="form-control" name="add_property_date_time"> </div></div><div class="col-sm-12"> <textarea class="form-control reminder_description" required="" style="width:100%" rows="4" name="add_property_reminder_description" placeholder="Description"></textarea></div></div></div></div>');
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
</script>
<script>
    $(document).ready(function(){
        $("#assign-single-coldcalling").click(function(){
            if(!$('.ind_chk_box:checkbox:checked').val()){
                // toastr["error"]("please select Rows!");
                alertify.error("please select Rows!");
            }else{
               $("#assigncoldcalling").modal("show"); 
            }
            
        })
        $("#assign-coldcalling-btn").click(function(){
            if(!$('.agents_ids:checkbox:checked').val()){
                // toastr["error"]("Please select Agent");
                alertify.error("Please select Agent");
            }else{
               if($('.agents_ids:checkbox:checked').length == 2){
                   // toastr["error"]("Please select Only One Agent");
                   alertify.error("Please select Only One Agent");
                   return;
               }
               $("#bulkForm").attr("action","{{url('assign-singlecoldcalling')}}");
               $("#bulkForm").attr("method","POST");
               $("#bulkForm").submit();
            }
        })
    })
</script>
<script>
  $(document).ready(function(){
     document.getElementById("filter").onclick = function() {
      document.getElementById("coldsForm").action = "{{route('coldcallingsearch')}}";
      document.getElementById("coldsForm").submit();
    };

    document.getElementById("export").onclick = function() {
      document.getElementById("coldsForm").action = "{{url('coldcallingexport')}}";
      document.getElementById("coldsForm").submit(); 
    };
  });
</script>
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

<!--REMINDER AJAX REQUEST CODE START FROM HERE-->
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