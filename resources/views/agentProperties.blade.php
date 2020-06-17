
@include('inc.header')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link href="{{url('public/assets/css/style.css')}}" rel="stylesheet">
<link href="{{url('public/assets/css/myStyle.css')}}" rel="stylesheet" >
<style type="text/css">
  .wtsp:hover,
  .gml:hover{
    background-color:blue !important;
  }
@media only screen and (max-width: 600px) {
  .wtsp, .gml{
    border-radius: 50px !important;
  }
  #add-new-owne-link{
    right: 19px !important;
  }
  .agents-nav{
    width: 120% !important;
  }
  .agent-property{
    width: 95% !important;
  }
}
   .access_select,.action_select{
   background-color: #1976D2;
   color: #fff;
   border-radius: 20px;
   }
   .filter_input{
   background-color:#1976D2 ;
   color:#fff;
   border-radius:4px;
   }
   .filter_input::placeholder{
   color:#fff;
   }
   .bootstrap-datetimepicker-widget,.dropdown-menu{
   font-size: 13px !important;
   font-weight: 500 !important;
   }
   .bootstrap-datetimepicker-widget{
   width:280px !important;
   }
   .topbar .top-navbar .navbar-header .navbar-brand .light-logo {
   display: inline-block;
   }.actionsFilters{
   display: block;
   width: 100%;
   position: absolute;
   z-index: 1;
   left: 33%;
   top: 26%;
   }a.chosen-single {
   width: 100%;
   }
   .filter_btn{
   height:37px;
   }
   @if(@$filterCss)
   .actionsFilters{
   top: 34%;
   }
   @endif
   @if(@$filterCssSecond)
   .actionsFilters{
   top: 44%;
   }
   @endif
   @if(!is_null(@$filterCssThird))
   .actionsFilters{
   top: 46%;
   }
   @endif
   @if(strtoupper(@$_GET['type'])==strtoupper('sale'))
   .actionsFilters{
   top: 33%;
   }
   @endif
   .chosen-container{
   color: black !important;
   font-weight: 500 !important;
   width: 185px !important;
   }
   .footable > tfoot .pagination{
   display:none !important;
   }
   .pagination{
   float:right !important;
   }
.whatsapp{
   position: absolute;
   left: 46%;
   /*margin-top: -30px;*/
   }
   .reset{
   position: absolute;
   left: 10%;
   margin-top: 12px;
   font-size: 29px;
   cursor:pointer;
   }
   .media-wrapper .col-md-6:hover .hw {
    background-color: #1976d2;
    color: #fff;
}.media-wrapper .col-md-4:hover .hw{
    background-color:#1976d2;
    color:#fff;
}.redirect_card_group .card{
    margin-bottom:10px;
    /*border-radius:10px;*/
}
.redirect_card_group .card-body{
    border:2px solid #1976D2;
    margin:0px -2px;
    /*border-radius:10px;*/
    border-radius:0px 10px 10px 0px;
}
.redirect_card_group .card:first-child .card-body,.redirect_card_group .card:first-child{
    border-radius:10px 0 0 10px;
}
.redirect_card_group .card:nth-child(2) .card-body,.redirect_card_group .card:nth-child(2){
    border-radius:0px 0px 0px 0px;
}
.card .card-subtitle{
    font-size:16px;
    color:#1976D2;
    font-weight:500;
}
.redirect_card_group{
    width:50%;
    margin:auto;
}
#add-new-owne-link{
    padding: 17px 22px !important;
    border-radius: 100% !important;
    position: relative;
    top: 50px;
    right: 75px;
    float:none !important;
}
</style>
@if(!session("user_id") || strtoupper(session('role'))!=(strtoupper('Agent') || strtoupper('SuperDuperAdmin')))
<script type="text/javascript">
   window.location='{{url("/")}}';
</script>
<?php redirect('/'); ?>
@endif
@if(@$permissions->propertyView != 1)
<script type="text/javascript">
    window.location='{{url("404")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<!--EMAIL MODEL HERE-->
<div class="modal fade" id="emailmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form action="{{url('addLandlordEmailPass')}}" method="get">
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
<!-- Email and Phone Model -->
<!-- End -->
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<div class="page-wrapper" style="margin-top: 2%;">
   <div class="container-fluid">
      @if(session('msg'))
      {!! session('msg') !!}
      @endif
      <!-- owner's main page -->
      <div class="row owner_main_row" style="display: {{@$Recorddisplay}}">
         <h3 class="page_heading" style="padding-bottom: 0px;display:block !important;width:100%;">Properties</h3>
         <div class="card-group redirect_card_group">
                     <div class="card">
                        <a href="{{url('allAddedProperties')}}?p=Dewa">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0">
                                            <img src="https://img.icons8.com/dusk/40/000000/home.png">
                                            <span class="card-subtitle">DEWA</span>
                                            </h2>
                                    <!--<h3 class="">64</h3>-->
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="{{url('allAddedProperties')}}?p=Commercial">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0">
                                            <img src="https://img.icons8.com/dusk/40/000000/skyscrapers.png">
                                            <span class="card-subtitle">Commercial</span>
                                            </h2>
                                    <!--<h3 class="">64</h3>-->
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="{{url('allAddedProperties')}}?p=Residential">
                            <div class="card-body resi">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0">
                                            <img src="https://img.icons8.com/ultraviolet/40/000000/apartment.png">
                                            <span class="card-subtitle">Residential</span>
                                            </h2>
                                        <!--<h3 class="">64</h3>-->
                                        </div>
                                    
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                </div>
         <div class="container">
         @if(@$permissions->propertyAdd==1)    <a id="add-new-owne-link" style="cursor: pointer;" class="mb-1"><span><i class="fa fa-plus"></i></span></a>
         @else
   <a  style="cursor: pointer; height:40px;" class="mb-3"><span><i class=""></i></span></a>
         @endif
            <div class="media-wrapperr" style="width: 60%; margin:auto;">
                            <div class="row">
                                <div class="col-md-6 wtsp" style="padding-right:0 ; border-radius: 50px 0px 0px 50px; border: 2px solid blue; background-color: white;    height: 60px; ">
                                    <div class="whatsapp-wrapper text-center hw" style="height:100%;">
                                    <i class="fa fa-refresh reset" aria-hidden="true" style="display:none;"></i>
                                    <a target="_blank"  class="whatsapp">
                                        <img src="https://png.pngtree.com/element_our/md/20180626/md_5b321ca97f12d.png" style="width:50px;"/>
                                        <!--<span class="msg-status" style="font-size:13px;font-weight:500;"></span>-->
                                    </a>
                                    </div>
                                    <span class="msg-status" style="font-size:10px;font-weight:500;position:absolute"></span>
                                </div>
                                <div class="col-md-6 gml" style="padding-left:0; border-radius: 0px 50px 50px 0px; border: 2px solid blue; background-color: white;">
                                  <div class="gmail-wapper text-center hw" style="height:100%;">
                                      <img src="https://img.icons8.com/color/420/gmail.png" data-toggle="modal" data-target="#emailmodel" class="sent-email" style="height:50px;cursor:pointer;margin-left: 40px;">
                                      <img src="https://thumbs.gfycat.com/UnitedSmartBinturong-small.gif" class="email-loader" style="height:35px;visibility:hidden;position: relative;left: 20px;">
                                  </div>
                                </div>
                            </div>
                        </div>
         </div>
       <!--<i class="fa fa-refresh reset" aria-hidden="true" style="display:none;"></i>-->
       <!--  <a target="_blank"  class="whatsapp">-->
       <!--  <img src="https://png.pngtree.com/element_our/md/20180626/md_5b321ca97f12d.png" style="width:100px;"/>-->
       <!--  <span class="msg-status" style="font-size:13px;font-weight:500;"></span>-->
       <!--  </a>-->
         <form action="{{url('PropertyBulkActions')}}" method="GET" style="width: 100%;">
            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
               <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title" id="mySmallModalLabel">Set Remider</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">
                        <div class="container">
                           <div class="row">
                              <div class='col-sm-12'>
                                 <div class="form-group">
                                    <input type="datetime-local" class="form-control datetime" id="min-date"> 
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
         <input id="model" data-toggle="modal" data-target=".bs-example-modal-sm" class="btn btn-danger"  style="visibility: hidden;" type="button" value="">
         <div class="col-12 col-sm-12">
            <ul class="nav nav-tabs agents-nav">
               <li class="nav-item">
                  @if(@$_GET['type']=='')
                  <a href="{{url('allAddedProperties')}}<?php if(isset($_GET['p'])){ echo '?p='.$_GET['p'].'&';} ?>"  class="nav-link active py-3">All property</a>
                  @else
                  <a href="{{url('allAddedProperties')}}<?php if(isset($_GET['p'])){ echo '?p='.$_GET['p'].'&';} ?>"  class="nav-link py-3">All property</a>
                  @endif
               </li>
              <li class="nav-item">
                  @if(@$_GET['type']=='For Rent')
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=For Rent"  class="nav-link active py-3">For Rent</a>
                  @else
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=For Rent"  class="nav-link py-3">For Rent</a>
                  @endif
               </li>
               <li class="nav-item">
                  @if(@$_GET['type']=='For Sale')
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=For Sale" class="nav-link active py-3">For Sale</a>
                  @else
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=For Sale" class="nav-link py-3">For Sale</a>
                  @endif
               </li>
               <li class="nav-item">
                  @if(@$_GET['type']=='upcoming')
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=upcoming"  class="nav-link active py-3">Upcoming</a>
                  @else
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=upcoming"  class="nav-link py-3">Upcoming</a>
                  @endif
               </li>
               <li class="nav-item">
                  @if(@$_GET['type']=='Call Back')
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=Call Back"  class="nav-link active py-3">Callback</a>
                  @else
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=Call Back"  class="nav-link py-3">Callback</a>
                  @endif
               </li>
               <li class="nav-item">
                  @if(@$_GET['type']=='Not answering')
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=Not answering"  class="nav-link active py-3">Not Answering</a>
                  @else
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=Not answering"  class="nav-link py-3">Not Answering</a>
                  @endif
               </li>
               <li class="nav-item">
                  @if(@$_GET['type']=='Not Interested')
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=Not Interested"  class="nav-link active py-3">Not Interested</a>
                  @else
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=Not Interested"  class="nav-link py-3">Not Interested</a>
                  @endif
               </li>
               <li class="nav-item">
                  @if(@$_GET['type']=='Interested')
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=Interested"  class="nav-link active py-3">Interested</a>
                  @else
                  <a href="{{url('allAddedProperties')}}?<?php if(isset($_GET['p'])){ echo 'p='.$_GET['p'].'&';} ?>type=Interested"  class="nav-link py-3">Interested</a>
                  @endif
               </li>
               <!--<li class="nav-item" style="padding: 10px 20px 5px;width: 100%;text-align: center;">-->
               <!--   <img src="https://img.icons8.com/color/420/gmail.png" data-toggle="modal" data-target="#emailmodel" class="sent-email" style="height:50px;cursor:pointer;margin-left: 40px;"/>-->
               <!--   <img src="https://thumbs.gfycat.com/UnitedSmartBinturong-small.gif" class="email-loader" style="height:35px;visibility:hidden;position: relative;left: 20px;"/>-->
               <!--</li>-->
               <li class="nav-item ml-auto" >
                  <select class="form-control access_select" name="accessStatus">
                     <option  value="">Select Option</option>
                     <option  value="For Sale">For Sale</option>
                     <option value="upcoming">Upcoming</option>
                     <option  value="For Rent">For Rent</option>
                     <option value="Call Back">Call Back</option>
                     <option  value="Not answering">Not answering</option>
                     <option  value="Not Interested">Not Interested</option>
                     <option  value="Interested">Interested</option>
                  </select>
               </li>
            </ul>
            <!-- </form>-->
            <div class="card">
               <div class="card-body table-responsive">
                  <!-- <div class="d-flex mb-4">-->
                  <div class="col-lg-12 agent-property">
                     <div class="row">
                        <div class="col-md-12">
                           <form action="{{ route('PropertysearchForAgent') }}" method="GET" class="">
                              <div class="row mt-2 mb-2">
                                 <div class="col-md-9">
                                    <div class="row">
                                       @if(isset($_GET['type'])) <input type="hidden" name="type" value="{{@$_GET['type']}}"/> @endif
                                       @if(isset($_GET['p'])) <input type="hidden" name="p" value="{{@$_GET['p']}}"/> @endif
                                       <div class="col-md-3 pl-1 pr-1">
                                          <div class="dropdown_wrapper ">
                                             <input type="text" class="form-control filter_input" list="building" placeholder="select Building" name="build">
                                             <datalist id="building">
                                                <option value="">Select building</option>
                                                @foreach($buildings as $building)
                                                <option value="{{$building}}"></option>
                                                @endforeach
                                             </datalist>
                                          </div>
                                       </div>
                                       <div class="col-md-3 pl-1 pr-1">
                                          <div class="dropdown_wrapper ">
                                             <input type="text" class="form-control filter_input" list="area" placeholder="select area" name="area">
                                             <datalist id="area">
                                                <option value="">Select area</option>
                                                @foreach($areas as $area)
                                                <option value="{{$area}}"></option>
                                                @endforeach
                                             </datalist>
                                          </div>
                                       </div>
                                       <div class="col-md-3 pl-1 pr-1">
                                          <div class="dropdown_wrapper ">
                                             <input type="text" class="form-control filter_input" list="bedroom" placeholder="select Bedroom" name="bedroom">
                                             <datalist id="bedroom">
                                                <option value="">Select bedroom</option>
                                                @foreach($bedrooms as $bedroom)
                                                <option value="{{$bedroom}}"></option>
                                                @endforeach
                                             </datalist>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
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
        <form id="bulkForm" class="form-inline">
                  <table class="table">
                     <thead>
                        <tr>
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
                           <th>Updated_at</th>
                           @if(@$_GET['type']=='upcoming')
                           <th>upcoming date</th>
                           @endif
                           @if(strtoupper(@$_GET['type'])==strtoupper('sale'))
                           <th>Status</th>
                           <th>Rented Date</th>
                           <th>Rented Price</th>
                           @endif
                           <th colspan="2">Action</th>
                        </tr>
                     </thead>
                        <input type='hidden' value='' name='status' class='status'>
                        <input type='hidden' value='' name='sending_email' class="sending_email">
                        <input type='hidden' value='' name='time_date' class='time_date_input'>
                        <input type='hidden' value='' name='description' class='description_input'> 
                        <tbody style="font-size: 12px;">
                           @if(isset($result_data))
                           @if(count($result_data) > 0)
                           <?php $counter=0; ?>
                           @foreach($result_data as $record)
                           <tr>
                     @if(@$permissions->propertyBulk!=1  )<td> Not Allowed </td>  @else             <td><input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$record->id}}"></td>@endif
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
                                 <label data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer;display: table-cell;position: relative;right: 5px;" class="label label-success show_content" name="Email Address">Show</label>
                                 <label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer;display: table-cell;" class="label label-primary add_email">Add</label>
                              </td>
                              <td>{{$record->Area_Sqft}}</td>
                              <td>{{$record->Bedroom}}</td>
                              <td>{{$record->Price}}</td>
                              @if(@$_GET['type']=='upcoming')
                              <td>{{$record->getUpcomingDate['date_time']}}</td>
                              @endif
                              @if(strtoupper(@$_GET['type'])==strtoupper('sale'))
                              <th>{{$record->rented_status}}</th>
                              @if(is_null($record->rented_date))
                              <td>N/A</td>
                              <td>N/A</td>
                              @else
                              <td>{{$record->rented_date}}</td>
                              <td>{{$record->rented_price}}</td>
                              @endif
                              @endif
                               <td>{{date('Y-m-d',strtotime($record->created_at))}}</td>
                           @if(@$permissions->propertyEdit!=1  )
                               <td>Not Allowed</td>  
                           @else           
                            <td>
                                <a href="{{url('EditPropertyByAgent')}}?record_id={{$record->id}}&action=edit" class="edit_supervision"><i class="fa fa-edit"></i> Edit</a>
                            </td>
                            @endif
                            @if(@$permissions->propertyDelete == 1  )
                                <td>
                                    <a href="{{url('DeletePropertyByAdmin')}}/{{$record->id}}" class="edit_supervision"><i class="fa fa-trash"></i> Delete</a>
                                </td>
                            @endif
                           </tr>
                           <?php $counter++; ?>     
                           @endforeach
                           @else
                           <tr>
                              <td colspan="20" align="center">No Record Found</td>
                           </tr>
                           @endif 
                           @endif                    
                        </tbody>
                    
                     <!--<tfoot>-->
                     <!--   <tr>-->
                     <!--      <td colspan="20">-->
                     <!--         <div class="text-right">-->
                     <!--            <ul class="pagination pagination-split m-t-30"> </ul>-->
                     <!--         </div>-->
                     <!--      </td>-->
                     <!--   </tr>-->
                     <!--</tfoot>-->
                  </table>
                 </form>
                  @if(!isset($_GET['action']))
                  @if(isset($_GET['type']))
                  {{@$result_data->appends(Request::only('type','build','area','bedroom','agent','unit','contact'))->links()}}
                  @else  
                  {{@$result_data->appends(Request::only('type','build','area','bedroom','agent','unit','contact'))->links()}}                       
                  @endif 
                  @endif
               </div>
            </div>
         </div>
         <!--  </form>-->
      </div>
      <!-- back button -->
      <div class="row back_btn_row m-b-40">
         <div class="col-12 back_wrapper">
            <span ><i class="fas fa-arrow-circle-left" id="back_to_owner"></i></span>
            <span id="back_to_owner_text">New Property</span>
         </div>
      </div>
      <!-- owners info  -->
      <div class="row owner_information_link" style="display: {{@$Formdisplay}};>">
         <div class="col-lg-12">
            <div class="card card-outline-info">
               <div class="card-header">
                  <h4 class="m-b-0 text-white"><?php if(isset($_GET["action"])){echo "Edit Details";}else{echo "Property Details";} ?></h4>
               </div>
               <div class="card-body">
                  <form action="<?php if(isset($_GET['action'])){ echo url('updatePropertyByAgent'); }else{ echo url('AddpropertyAgent'); } ?>" class="form-horizontal" method="post" enctype='multipart/form-data' id="property">
                     @csrf
                     <input type="hidden" name="property_id" value="{{@$result[0]['id']}}">
                     <div class="form-body">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Unit No</label>
                                 <div class="col-md-9">
                                    <input required="" type="text" class="form-control" name="unit_no" value="{{@$result[0]['unit_no']}}">
                                    <!-- <small class="form-control-feedback"> This is inline help </small>  -->
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                           <div class="col-md-6">
                              <div class="form-group has-danger row">
                                 <label class="control-label text-right col-md-3">Building</label>
                                 <div class="col-md-8 building_input" style="padding-left: 15px;">
                                  <input type="text" class="form-control filter_input_name" list="buildings" placeholder="select Building" name="building" value="">
                                     <datalist id="buildings">
                                        <option value="">Select building</option>
                                        @foreach($allBuildings as $building)
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
                                 <label class="control-label text-right col-md-3">Dewa No</label>
                                 <div class="col-md-9">
                                    <input type="text" class="form-control" name="dewa_no" value="{{@$result[0]['dewa_no']}}">
                                    <!-- <small class="form-control-feedback"> This is inline help </small>  -->
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Bedroom</label>
                                 <div class="col-md-9">
                                    <select style="font-size: 12px;" name="Bedroom" class="form-control">
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
                         </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Area</label>
                                 <div class="col-md-9">
                                    <input  type="text" name="area" class="form-control" value="{{@$result[0]['area']}}">
                                    <!-- <small class="form-control-feedback"> Select your gender. </small>  -->
                                 </div>
                              </div>
                           </div>
                           
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Washroom</label>
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
                                 <label class="control-label text-right col-md-3">Conditions</label>
                                 <div class="col-md-9">
                                    <select name="Conditions"  class="form-control" style="font-size: 12px;">
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
                                 <label class="control-label text-right col-md-3">Email</label>
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
                                 <label class="control-label text-right col-md-3">LandLord</label>
                                 <div class="col-md-9">
                                    <input  type="text" style="font-size: 12px;" class="form-control" name="LandLord" value="{{@$result[0]['LandLord']}}">
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Access</label>
                                 <div class="col-md-9">
                                    <select class="form-control access" name="access" style="font-size: 12px;"> 
                                       <option value="">Select option</option>
                                       <option value="For Rent" <?php if(strtoupper(@$result[0]["access"])==strtoupper("For Rent")){echo "selected";} ?>>For Rent</option>
                                       <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("For Sale")){echo "selected";} ?> value="For Sale">For Sale</option>
                                       <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Upcoming")){echo "selected";} ?> value="Upcoming">Upcoming</option>
                                       <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Do Not Caller")){echo "selected";} ?> value="Do Not Caller">Do Not Call</option>
                                       <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Call back")){echo "selected";} ?> value="Call back">Call back</option>
                                       <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Not answering")){echo "selected";} ?> value="Not answering">Not answering</option>
                                       <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Not Interested")){echo "selected";} ?> value="Not Interested">Not Interested</option>
                                       <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Intrested")){echo "selected";} ?> value="Intrested">Intrested</option>
                                       <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Don't call")){echo "selected";} ?> value="Don't call">Don't call</option>
                                    </select>
                                    <div class="options" style="padding-top:20px;">
                                       @if(strtoupper(@$result[0]["access"])==strtoupper("Upcoming"))
                                       @if(!is_null($reminders))
                                       <div class="row">
                                          <input type="hidden" name="add_property_reminder_type" value="{{$reminders->reminder_type}}"> 
                                          <div class="col-sm-12">
                                             <div class="form-group"> <input  style="width:100%" type="datetime-local" value="{{$reminders->reminderDate($reminders->date_time)}}" class="form-control" name="add_property_date_time"> </div>
                                          </div>
                                          <div class="col-sm-12"> <textarea class="form-control reminder_description" value="" style="width:100%" rows="4" name="add_property_reminder_description" placeholder="Description">{{$reminders->description}}</textarea></div>
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
                                 <label class="control-label text-right col-md-3">Phone Number</label>
                                 <div class="col-md-9">
                                    <?php $temp=explode(',', @$result[0]['contact_no']); if(count($temp) > 1){ foreach ($temp as $value) {?>
                                    <input  type="text" class="form-control" name="contact_no[]" value="{{$value}}" style="margin-bottom: 1%">
                                    <?php } }else { ?>
                                    <input  type="text"  class="form-control" name="contact_no[]" value="{{@$result[0]['contact_no']}}">
                                    <?php  } ?>
                                 </div>
                              </div>
                           </div>

                            <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Area Sqft</label>
                                 <div class="col-md-9">
                                    <input  type="number" class="form-control" name="Area_Sqft" value="{{@$result[0]['Area_Sqft']}}">
                                 </div>
                              </div>
                           </div>
                           
                           <!--/span-->
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Price</label>
                                 <div class="col-md-9">
                                    <input  type="number" class="form-control" name="Price" value="{{@$result[0]['Price']}}">
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Property Type</label>
                                 <div class="col-md-9">
                                    <select class="form-control" style="font-size:12px !important;" name="property_type">
                                        <option value="">Please Select Type</option>
                                        <option @if(@$result[0]['property_type'] == "Commercial") selected @endif value="Commercial">Commercial</option>
                                        <option @if(@$result[0]['property_type'] == "residential") selected @endif value="residential">Residential</option>
                                         <option @if(@$result[0]['property_type'] == "Dewa") selected @endif value="Dewa">Dewa</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                            
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="control-label text-right col-md-3">Add Comment</label>
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
</div>
@include('inc.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet">
<script>
$('.sent-email-btn').click(function(){
          $('.sending_email').val($('#sending_email').val());
         if(!$('.ind_chk_box:checkbox:checked').val()){
             toastr["error"]("please select Rows!");
             $('.msg-status').text('');
             return;
         }
        
         $('.email-loader').css('visibility','visible');
         $.ajax({
            url:'<?php echo url('agent-sent-property-emails');  ?>',
            type:'get',
            data:$("#bulkForm").serialize(),
            success:function(data){
                $('.email-loader').css('visibility','hidden');
                if($.trim(data)=="true"){
                    toastr["success"]("Email Sent Successfully!");
                }else{
                    toastr["error"]("Something went wrong");
                }
            },
            error: function(xhr, status, error){
                 $('.email-loader').css('visibility','hidden');
                 toastr["error"]("Something went wrong");
            }
        })
     });
   $(document).ready(function(){
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
             alert('please select Rows!');
             $('.msg-status').text('');
             return;
         }
        $.ajax({
            url:'<?php echo url('whatsAppMsgsForAgentProperty');  ?>',
            type:'get',
            data : $("#bulkForm").serialize(),
            success:function(data){
                var whatsappMessage = window.encodeURIComponent(data);
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
             alert('please select Rows!');
             $('.msg-status-2').text('');
             return;
         }
        $.ajax({
            url:'<?php echo url('whatsAppOwnerMsgsForAgentProperty');  ?>',
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
    <!-- add building using ajax-->
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
            
                       $('#buildings').append('<option value='+buildingName+'></option>');
                       $('.close-model').trigger('click');
                       // alert(buildingName);
                       // $('.building_input').reload();
                       $("#buildings").load(location.href + " #buildings");
                   }else{
                       alert('something went wrong!');
                   }
               }
           })
       })
   })
</script>
<!-- end of add building using ajax-->
<script type="text/javascript">
   //ACCESS DROPDOWN CODE START HERE  
        $('.access_select').change(function(e){
           if(!$('.ind_chk_box:checkbox:checked').val()){
             $(this).val('');
             alert('please select Rows!');
             return;
         }
         if($(this).val()==""){
             return;
         }
           if($(this).val().toLowerCase()=='call back' || $(this).val().toLowerCase()=='upcoming' || $(this).val().toLowerCase()=='interested' || $(this).val().toLowerCase()=='not answering' || $(this).val().toLowerCase()=='pending' || $(this).val().toLowerCase()=='off plan' || $(this).val().toLowerCase()=='investor' || $(this).val().toLowerCase()=='check availability'){
                $('.reminder').show();
                $('.update-status-by-row').hide();
                var access=$(this).val();
               $('.status').val(access);
               $("#model").trigger( "click" );
           }else{
               var access=$(this).val();
               $('.status').val(access);
           $.ajax({
               url:'<?php echo url('bulkUpdateStatusPropertyAgent');  ?>',
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
   
       $('.chosen-container.chosen-container-single').show();
            $(document).delegate('.show_content','click',function(){
               var content=$(this).prev('.content').html();
               $('.content_model_title').text($(this).attr('name'));
               $('.content_model_body').html(content);
           })
       $('.access').change(function(){
           if($(this).val()=='Upcoming'){
               $('.options').html('<div class="row"><input type="hidden" name="add_property_reminder_type" value="Upcoming"> <div class="col-sm-12"> <div class="form-group"> <input  style="width:100%" type="datetime-local" class="form-control" name="add_property_date_time"> </div></div><div class="col-sm-12"> <textarea class="form-control reminder_description"  style="width:100%" rows="4" name="add_property_reminder_description" placeholder="Description"></textarea></div></div></div></div>');
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
       $("#property").validate();
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
        $('.reminder').click(function(){
           $('.date_time_error,.reminder_description-error').text("");
           if($('.datetime').val()==""){
              $('.date_time_error').text('This field is Required');
              return; 
           }
           else if($('.reminder_description').val()==""){
               $('.reminder_description-error').text('This field is Required');
              return; 
           }
            var time_date=$('#min-date').val();
            var description=$('.reminder_description').val();
            $('.time_date_input').val(time_date);
            $('.description_input').val(description);
           $.ajax({
               url:'<?php echo url('setReminderForPropertyAgent');  ?>',
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
   $('body').delegate('.add_phone','click',function(){
       var id=$(this).attr('id');
       $('.add_model_body').html('<label>Phone</label><input type="number" name="phone" class="form-control"><input type="hidden" name="id" class="form-control" value="'+id+'">');
    })
     $('body').delegate('.add_email','click',function(){
       var id=$(this).attr('id');
       $('.add_model_body').html('<label>Email</label><input type="email" name="email" class="form-control"><input type="hidden" name="id" class="form-control" value="'+id+'">');
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
   $(document).delegate('#name','click', function () {
    alert();
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
</script>
<?php }  ?>
<script type="text/javascript">
   var value='<?php echo @$Bedroom;  ?>';
   $('.Bedroom').val(value);
</script>
    <script>
      $('.access').change(function(){
           if($(this).val()=='Upcoming'){
               $('.options').html('<div class="row"><input type="hidden" name="add_property_reminder_type" value="Upcoming"> <div class="col-sm-12"> <div class="form-group"> <input  style="width:100%" type="datetime-local" class="form-control" name="add_property_date_time"> </div></div><div class="col-sm-12"> <textarea class="form-control reminder_description"  style="width:100%" rows="4" name="add_property_reminder_description" placeholder="Description"></textarea></div></div></div></div>');
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