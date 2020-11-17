@include('inc.header')
 <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
 <link href="{{url('public/assets/css/style.css')}}" rel="stylesheet">
<link href="{{url('public/assets/css/myStyle.css')}}" rel="stylesheet" >

<style type="text/css">
    .bootstrap-datetimepicker-widget,.dropdown-menu{
        font-size: 13px !important;
        font-weight: 500 !important;
    }
    .bootstrap-datetimepicker-widget{
        width:280px !important;
    }
    .topbar .top-navbar .navbar-header .navbar-brand .light-logo {
        display: inline-block;
    }
    .actionsFilters{
        display: block;
    width: 100%;
    position: absolute;
    z-index: 1;
    left: 47%;
    top: 42%;
    }a.chosen-single {
    width: 100%;
}
.chosen-container{
    color: black !important;
    font-weight: 500 !important;
        width: 185px !important;
}
</style>
@if(!session("user_id") || ucfirst(session('role'))!=ucfirst('agent'))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif

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

<!-- End -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{url('addLandlordEmailPassByAgent')}}" method="get">
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
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
        <div class="page-wrapper" style="margin-top: 2%;">
            <div class="container-fluid">
                @if(session('msg'))
                    {!! session('msg') !!}
                @endif
                
                <!-- owner's main page -->
                <div class="row owner_main_row" style="display: {{@$Recorddisplay}}">
                    <h3 class="page_heading" style="padding-bottom: 0px;">{{@$property}}</h3>
                 <!--        <div class="row" style="margin:auto;width: 50%;">
                            <div class="col-sm-3">
                                <a href="{{url('allAddedProperties')}}" class="btn btn-warning">All property</a>
                            </div>
                            <div class="col-sm-3">
                                <a href="{{url('allAddedProperties')}}?type=rent" class="btn btn-success">For Rent</a>
                            </div>
                            <div class="col-sm-3">
                                <a href="{{url('allAddedProperties')}}?type=sale"  class="btn btn-danger">For Sale</a>
                            </div>
                            <div class="col-sm-3">
                                <a href="{{url('allAddedProperties')}}?type=upcoming"  class="btn btn-primary">Upcoming</a>
                            </div>
                        </div>-->

                        <form action="{{url('PropertyBulkActionsByAgent')}}" method="GET" style="width: 100%;">
                          
                    
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
                                                <input type="datetime-local" class="form-control date-time" placeholder="set min date" id="min-date"> 
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
                <input id="model" data-toggle="modal" data-target=".bs-example-modal-sm" class="btn btn-danger"  style="visibility: hidden;" type="button" value="">
                        <div class="col-12 col-sm-12">
                               <ul class="nav nav-tabs ">
    <li class="nav-item">
     @if(@$_GET['type']=='')
       <a href="{{url('allAddedProperties')}}"  class="nav-link active py-3">All property</a>
       @else
        <a href="{{url('allAddedProperties')}}"  class="nav-link py-3">All property</a>
       @endif
    </li>
    <li class="nav-item">
    @if(@$_GET['type']=='rent')
      <a href="{{url('allAddedProperties')}}?type=rent"  class="nav-link active py-3">For Rent</a>
      @else
           <a href="{{url('allAddedProperties')}}?type=rent"  class="nav-link py-3">For Rent</a>
      @endif
    </li>
    <li class="nav-item">
    @if(@$_GET['type']=='sale')
      <a href="{{url('allAddedProperties')}}?type=sale" class="nav-link active py-3">For Sale</a>
      @else
      <a href="{{url('allAddedProperties')}}?type=sale" class="nav-link py-3">For Sale</a>
      @endif
    </li>
    <li class="nav-item">
    @if(@$_GET['type']=='upcoming')
    <a href="{{url('allAddedProperties')}}?type=upcoming"  class="nav-link active py-3">Upcoming</a>
    @else
     <a href="{{url('allAddedProperties')}}?type=upcoming"  class="nav-link py-3">Upcoming</a>
     @endif
    </li>
     <li class="nav-item ml-auto">
                                    
                               </li>  </ul>
                            <div class="card">
                                <div class="card-body">
                                  
                                     <div class="col-lg-12">  
                           <div class="row"> 
                                  <div>
                                        <a id="add-new-owne-link" style="cursor: pointer;" class="mb-1"><span><i class="fa fa-plus"></i></span></a></div>
                                        <div class="ml-auto">
                                         <input id="demo-input-search2" class="demo-input-search" type="text" placeholder="Search" autocomplete="off">
                                         </div>
                                         </div>
                                      <!-- filters-->
                                      <div class="row mt-4 mb-5">
                                      
                                      <div class=" col-4 ">
        <select class="form-control action_select" name="action">
                                            <option value="NULL">Bulk Action</option>
                                            <option value="Update">Update</option>
                                            <option value="Delete">Delete</option>
                                        </select>
                                        <input type="submit" name="apply" value="Apply" class="btn btn-success apply" >     </div></form>
                                        <div class="col-8 "> 
                    <form action="{{ route('searchAgent') }}" method="post" class="form-inline">
 {{csrf_field()}}
        <select class="form-control chosen-select " name="build" >
          <option value=""  >Select building </option>
              @foreach($buildings as $building)
    <option value="{{$building->building_name}}">{{$building->building_name}}</option>
                     @endforeach  
                                        </select>
                                        <select name="area" class="form-control ml-2 chosen-select" >
                  <option value="">Select area</option>
                 
              @foreach($areas as $area)
    <option value="{{$area->area}}">{{$area->area}}</option>
                     @endforeach  
                     
                                        </select>
                                         <select name="bedroom" class="form-control ml-2 chosen-select" >
                  <option value="">Select bedroom</option>
              @foreach($bedrooms as $bedroom)
    <option value="{{$bedroom->Bedroom}}">{{$bedroom->Bedroom}}</option>
                     @endforeach  
                                        </select>
                                          <select name="agent" class="form-control ml-2 chosen-select" >
                  <option value="">Select agent</option>
              @foreach($agents as $agent)
    <option value="{{$agent->id}}">{{$agent->user_name}}</option>
                     @endforeach  
                                        </select>
                                     
                            <button class="btn btn-danger ml-2" type="submit" name="searchBtn">  Filter</button>    
                                        </form>    </div>   
                                        </div>      
                 <!--  <div class="form-group ml-auto mt-2">-->
                                           
                        <!--  <i class="fa fa-search"></i>  -->
                                         <!--  </div>-->
        
                                     </div>
                                    <table id="demo-foo-pagination" class="table">
                                        <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Unit No </th>
                                                <th>Building Name </th>
                                                <th>Area </th>
                                                <th>LandLord </th>
                                                <th>Contact No</th>
                                                <th>Email</th>
                                                <th>Area Sqft</th>
                                                <th>Price</th>
                                                @if(@$_GET['type']=='upcoming')
                                                <th>upcoming date</th>
                                                @endif
                                                @if(strtoupper(@$_GET['type'])==strtoupper('sale'))
                                                <th>Status</th>
                                                <th>Rented Date</th>
                                                <th>Rented Price</th>
                                                @endif

                                           
                                                <th>Access</th>
                                                <th>Registered</th>
                                                <th>Action</th>
                                                

                                            </tr>
                                        </thead>     
                                        <tbody style="font-size: 12px;" id="table_body">
                @if(isset($result_data))
                    @if(count($result_data) > 0)
                        <?php $counter=0; ?>
                            @foreach($result_data as $record)
                                            <tr>
                                                <td><img style="width: 21px; margin-top: -9px !important;" src="public/assets/images/next.png" class="drop_arrow_icon pulse-effect"><input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$record->id}}"></td>
                                                <td class="unit_no">{{$record->unit_no}}</td>
                                                <td class="building">{{$record->Building}}</td>
                                                <td class="area">{{$record->area}}</td>
                                                <td class="landlord">{{strtoupper($record->LandLord)}}</td>
                                                  @if(session('user_id')==$record->add_by)   
                                                 <td class="number">
                                                    <div class="content" style="display: none;">
                                                    <?php $temp=explode(',', $record->contact_no);
                                                    foreach ($temp as $key=>$value) { ?>
                                                            <span style="display: block;width: 100%;">{{$value}}</span>
                                                    <?php  }  ?>
                                                    </div>
                                                    <label data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="label label-success show_content" name="Phone Number">Show</label>
                                                    <label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer;display: table-cell;" class="label label-primary add_phone">Add</label>
                                                </td>
                                                @else
                                                <td>
                                                </td>
                                                @endif

                                                  @if(session('user_id')==$record->add_by)   
                                                <td class="email">
                                                    <div class="content" style="display: none;">
                                                    <?php $temp=explode(',', $record->email);foreach ($temp as $key=>$value) { ?>
                                                        <span style="display: block;width: 100%;">{{$value}}</span>
                                                    <?php  }  ?>
                                                    </div>
                                                    <label data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer;display: table-cell;position: relative;right: 5px;" class="label label-success show_content" name="Email Address">Show</label>
                                                    <label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer;display: table-cell;" class="label label-primary add_email">Add</label>
                                                </td>
                                                @else
                                                <td>

                                                </td>
                                                @endif
                                                <td class="sqft">{{$record->Area_Sqft}}</td>
                                                <td class="price">{{$record->Price}}</td>
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

                                                  @if(session('user_id')==$record->add_by)   
                                                <td class="acess">
                                                    <select class="form-control access_select" style="font-size: 11px;font-weight: 500;" unit="{{$record->unit_no}}" required name="updated_access[{{$counter++}}]">
                                                        <option <?php if(strtoupper($record->access)==strtoupper("For Rent")){echo "selected";}  ?> value="For Rent">For Rent</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("For Sale")){echo "selected";}  ?> value="For Sale">For Sale</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("Upcoming")){echo "selected";}  ?> value="Upcoming">Upcoming</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("Do Not Caller")){echo "selected";}  ?> value="Do Not Caller">Do Not Call</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("Call Back")){echo "selected";}  ?> value="Call Back">Call Back</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("Not answering")){echo "selected";}  ?> value="Not answering">Not answering</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("Not Interested")){echo "selected";}  ?> value="Not Interested">Not Interested</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("Interested")){echo "selected";}  ?> value="Interested">Intrested</option>
                                                    </select>
                                                </td>
                                         @endif
                               @if(session('user_id')==$record->add_by)
                                                <td class="edit">
                                                    <a href="{{url('EditPropertyByAgent')}}?record_id={{$record->id}}&action=edit" class="edit_supervision"><i class="fa fa-edit"></i> Edit</a>
                                                </td>
                                                @endif
                                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan="20" align="center">No Record Found</td></tr>
                        @endif 
                    @endif                    </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="20">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-split m-t-30"> </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
                               <form action="{{url('addPropertyByAgent')}}" class="form-horizontal" method="post" enctype='multipart/form-data' id="property">
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
                                                 <div class="col-md-8" style="padding-left: 15px;">
                                                    <select class="form-control" required style="font-size: 12px;" name="building" id="insertBuilding">
                                                       <option value="">Select option</option>
                                                       @foreach($buildingss as $building)
                                                       <option value="{{$building->building_name}}">{{$building->building_name}}</option>
                                                       @endforeach
                                                    </select>
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
                                                 <label class="control-label text-right col-md-3">Area</label>
                                                 <div class="col-md-9">
                                                    <input required="" type="text" name="area" class="form-control" value="{{@$result[0]['area']}}">
                                                    <!-- <small class="form-control-feedback"> Select your gender. </small>  -->
                                                 </div>
                                              </div>
                                           </div>
                                           <div class="col-md-6">
                                              <div class="form-group row">
                                                 <label class="control-label text-right col-md-3">Bedroom</label>
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
                                                 <label class="control-label text-right col-md-3">Conditions</label>
                                                 <div class="col-md-9">
                                                    <select name="Conditions"  class="form-control" required style="font-size: 12px;">
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
                                                 <label class="control-label text-right col-md-3">Washroom</label>
                                                 <div class="col-md-9">
                                                    <select name="Washroom" required class="form-control" style="font-size: 12px; " >
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
                                        <!--/row-->
                                        <div class="row">
                                           <div class="col-md-6">
                                              <div class="form-group row">
                                                 <label class="control-label text-right col-md-3">LandLord</label>
                                                 <div class="col-md-9">
                                                    <input required="" type="text" style="font-size: 12px;" class="form-control" name="LandLord" value="{{@$result[0]['LandLord']}}">
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
                                        <div class="row">
                                           <div class="col-md-6">
                                              <div class="form-group row">
                                                 <label class="control-label text-right col-md-3">Phone Number</label>
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
                                                 <label class="control-label text-right col-md-3">Access</label>
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
                                                 <label class="control-label text-right col-md-3">Area Sqft</label>
                                                 <div class="col-md-9">
                                                    <input required="" type="number" class="form-control" name="Area_Sqft" value="{{@$result[0]['Area_Sqft']}}">
                                                 </div>
                                              </div>
                                           </div>
                                           <div class="col-md-6">
                                              <div class="form-group row">
                                                 <label class="control-label text-right col-md-3">Price</label>
                                                 <div class="col-md-9">
                                                    <input required="" type="number" class="form-control" name="Price" value="{{@$result[0]['Price']}}">
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                        <div class="row">
                                           <!--<div class="col-md-6">-->
                                           <!--    <div class="form-group row">-->
                                           <!--        <label class="control-label text-right col-md-3">Assigned Agent</label>-->
                                           <!--        <div class="col-md-9">-->
                                           <!--            <select class="form-control" required="" style="font-size: 12px;" name="agent" id="agent">-->
                                           <!--                <option value="">Select option</option>-->
                                           <!--                @foreach(@$agents as $agent)-->
                                           <!--                    <option value="{{$agent->user_name}}">{{$agent->user_name}}</option>-->
                                           <!--                @endforeach-->
                                           <!--            </select>-->
                                           <!--        </div>-->
                                           <!--    </div>-->
                                           <!--</div>-->
                                           <div class="col-md-6">
                                              <div class="form-group row">
                                                 <label class="control-label text-right col-md-3">Add Comment</label>
                                                 <div class="col-md-9">
                                                    <textarea class="form-control" name="comment" required cols="4" rows="6">{{@$result[0]['comment']}}</textarea>
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
<script type="text/javascript">
$(document).delegate('.show_content','click',function(){
        var content=$(this).prev('.content').html();
        $('.content_model_title').text($(this).attr('name'));
        $('.content_model_body').html(content);
    })
    var user_id=$("#user_id").val();
</script>
<script type="text/javascript">
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
        $.ajax({
            url:'<?php echo url('reminder');  ?>',
            type:'get',
            data:{time_date:time_date,description:description,unit:$(this).attr('unit'),access:$(this).attr('access'),reminder_type:$(this).attr('reminder_type')},
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
 })
</script>
<?php  if(isset($_GET['action'])) {?>

    <script type="text/javascript">
        $("#LandLord option").each(function(){
            if($(this).val()=="{{@$result[0]['LandLord']}}"){
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
<script type="text/javascript">
    var value=<?php echo @$Bedroom;  ?>;
    $('.Bedroom').val(value);
</script>
<script>
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