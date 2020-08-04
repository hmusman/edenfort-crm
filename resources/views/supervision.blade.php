@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperAgent') || ucfirst('Agent') || ucfirst('SuperDuperAdmin')))
<script type="text/javascript">
   window.location='{{url("/")}}';
</script>
<?php redirect('/'); ?>
@endif

@if(ucfirst(session('role'))==ucfirst('Agent') || ucfirst('SuperAgent') || ucfirst('SuperDuperAdmin'))  
@if(@$permissions->supervisionView!=1)
<script type="text/javascript">
    window.location='{{url("404")}}';
  </script>
  <?php redirect('/'); ?>
@endif
@endif
<!-- DataTables -->
<link href="{{url('public/Green/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('public/Green/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     

<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<style>
   #datepickers-container{
      z-index: 1100;
   }
   #datatable{
      font-weight: bold;
   }
   #add-new-owne-link{
    cursor: pointer;
    color: white;
    padding: 16px 20px 16px 20px;
   }
   #back_to_owner_text{
      font-size: 25px;
      margin-top: 12px;
   }
   #back_to_owner{
     font-size: 45px;
     position: absolute;
     cursor: pointer;
   }
   .nav-tabs .nav-link.active {
       color: #ffffff;
       background-color: #2fa97c;
       border-color: #2fa97c #2fa97c #2fa97c;
   }
   .nav-tabs {
       border-bottom: 1px solid #2fa97c;
   }
</style>
<!-- modals -->
<!--add user mode-->
<div class="modal fade" id="exampleModal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" style="max-width:800px;" role="document">
   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Contact Details</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <form id="addOwnerForm" class="form-horizontal" enctype="multipart/form-data">
         @csrf
         <div class="modal-body">
            <div class="form-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3">UserName</label>
                        <div class="col-md-9">
                           <input type="text" class="form-control" placeholder="userName" name="user_name" required="" id="user_name">
                        </div>
                     </div>
                  </div>
                  <!--/span-->
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3">First Name</label>
                        <div class="col-md-9">
                           <input type="text" class="form-control" placeholder="First Name" name="First_name" required="">
                        </div>
                     </div>
                  </div>
                  <!--/span-->
               </div>
               <!--/row-->
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group has-danger row">
                        <label class="control-label text-right col-md-3">Last Name</label>
                        <div class="col-md-9">
                           <input type="text" class="form-control form-control-danger" placeholder="Last Name" name="Last_Name" value="">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3">Gender</label>
                        <div class="col-md-9">
                           <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="Gender" style="font-size: 12px;">
                              <option value="">Select Gender</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <!--/span-->
               </div>
               <!--/row-->
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3">DOB</label>
                        <div class="col-md-9">
                           <input type="text" class="form-control datepicker-here" data-language="en" placeholder="dd/mm/yyyy" name="birth_date" value="">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3">Email</label>
                        <div class="col-md-9">
                           <input type="email" class="form-control" name="Email" placeholder="Email" required="" value="">
                        </div>
                     </div>
                  </div>
               </div>
               <!--/row-->
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3">Password</label>
                        <div class="col-md-9">
                           <input type="password" class="form-control" name="Password" placeholder="Password" required="">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3">Status</label>
                        <div class="col-md-9">
                           <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="status" style="font-size: 12px;" required="" id="status">
                              <option value="">Select Status</option>
                              <option  value="1">Activate</option>
                              <option  value="0">Deactivate</option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3">Account Number</label>
                        <div class="col-md-9">
                           <input type="number" class="form-control" name="account_number" placeholder="Account Number">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3">Bank Name</label>
                        <div class="col-md-9">
                           <input type="text" class="form-control" name="bank_name" placeholder="Bank Name">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3">IBAN</label>
                        <div class="col-md-9">
                           <input type="text" class="form-control" name="IBAN" placeholder="IBAN">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3">Swift Code</label>
                        <div class="col-md-9">
                           <input type="text" class="form-control" name="swift_code" placeholder="Swift Code">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3">Phone</label>
                        <div class="col-md-9">
                           <input type="number" class="form-control" name="Phone" placeholder="Phone">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row others_documents" style="display:none"></div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="control-label text-right col-md-3"></label>
                        <div class="col-md-9">
                           <button type="button" class="btn btn-success add-more-docs">Add more</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-owner-btn" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary add-owner-btn">Add</button>
         </div>
      </form>
   </div>
</div>
</div>
<!--End-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <h4 class="page-title mb-1">Supervisions</h4>
                        <ol class="breadcrumb m-0">
                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li> -->
                        <li class="breadcrumb-item active">Edenfort CRM Supervisions</li>
                        </ol>
                    </div>
                   <!--  <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
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
                        </div>
                    </div> -->
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body all_supervisions" style="display: {{@$Recorddisplay}}">
                               <form action="{{url('SupervisionBulkActions')}}" method="GET" style="width: 100%;">
                                 <div class="card-header" style="background-color: white;">
                                    <div class="d-flex row">
                                       <div class="col-md-8">
                                          @if(ucfirst(session('role'))==ucfirst('Agent') || ucfirst('SuperAgent')) 
                                          @if($permissions->supervisionAdd==1) 
                                          <a class="btn btn-success btn-rounded waves-effect waves-light" id="add-new-owne-link" style="cursor: pointer;"><span><i class="fa fa-plus"></i></span></a>
                                          @endif
                                          @else
                                            <a class="btn btn-success btn-rounded waves-effect waves-light" id="add-new-owne-link" style="cursor: pointer;"><span><i class="fa fa-plus"></i></span></a>
                                          @endif
                                       </div>
                                       <!-- <div class="col-md-4 row">
                                          <div class="col-md-8">
                                             <select class="form-control action_select mr-3" name="action">
                                             <option value="NULL">Bulk Action</option>
                                             <option value="Update">Update</option>
                                             <option value="Delete">Delete</option>
                                          </select>
                                          </div>
                                          <div class="col-md-4">
                                             <input type="submit" name="apply" value="Apply" class="btn btn-success apply">
                                          </div>
                                       </div> -->
                                    </div>
                                 </div>
                                 <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                       <thead>
                                       <tr>
                                          <th>Select</th>
                                          <th>Unit No </th>
                                          <th>Owner</th>
                                          <th>Building Name </th>
                                          <th>Location </th>
                                          <th>Tanet</th>
                                          <th>Bedroom</th>
                                          <th>Contract Start Date</th>
                                          <th>Contract End Date</th>
                                         <!-- <th>Access</th>-->
                                          <th>Action</th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                          @if(isset($result_data))
                                          @if(count($result_data) > 0)
                                          <?php $counter=0; ?>
                                          @foreach($result_data as $record)
                                          <tr>
                                             <td><input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$record->id}}"></td>
                                             <td>{{$record->unit_no}}</td>
                                             <td>{{ucwords($record->assigned_user)}}</td>
                                             <td>{{$record->Building}}</td>
                                             <td>{{$record->area}}</td>
                                             <td>{{$record->tenant_name}}</td>
                                             <td>{{$record->Bedroom}}</td>
                                             <td>{{date('d-m-Y',strtotime($record->contract_start_date))}}</td>
                                             <td>{{date('d-m-Y',strtotime($record->contract_end_date))}}</td>
                                          <!--   <td>
                                                <select class="form-control access_select" style="font-size: 11px;font-weight: 500;" required="" name="updated_access[{{$counter++}}]">
                                                   <option <?php if($record->access=="For Rent"){echo "selected";}  ?> value="For Rent">For Rent</option>
                                                   <option <?php if($record->access=="For Sale"){echo "selected";}  ?> value="For Sale">For Sale</option>
                                                   <option <?php if($record->access=="Upcoming"){echo "selected";}  ?> value="Upcoming">Upcoming</option>
                                                   <option <?php if($record->access=="Do Not Caller"){echo "selected";}  ?> value="Do Not Caller">Do Not Caller</option>
                                                   <option value="Add Property">Add Property</option>
                                                </select>
                                             </td>-->
                                             @if(ucfirst(session('role'))==ucfirst('Agent') || ucfirst('SuperAgent')) 
                       
                                              @if($permissions->supervisionEdit!=1)<td>Not Allowed</td>  @else 
                                             <td>
                                                <a href="{{url('EditSupervision')}}?record_id={{$record->id}}&action=edit" class="edit_supervision"><i class="fa fa-edit"></i> Edit</a>
                                             </td>
                                             @endif
                                             
                                             @else
                                              <td>
                                                <a href="{{url('EditSupervision')}}?record_id={{$record->id}}&action=edit" class="edit_supervision"><i class="fa fa-edit"></i> Edit</a>
                                             </td>
                                             @endif
                                             
                                          </tr>
                                          @endforeach
                                          @else
                                          <tr>
                                             <td colspan="11" align="center">No Record Found</td>
                                          </tr>
                                          @endif 
                                          @endif   
                                       </tbody>
                                   </table>
                                 </div>
                              </form>
                            </div>
                           <div class="card-body add_suppervision" style="display: {{@$Formdisplay}};>">
                              <!-- back button -->
                              <div class="row back_btn_row m-b-40">
                                 <div class="col-12 back_wrapper">
                                    @if(isset($_GET['action']))
                                    <span ><a href="{{url('supervision')}}"><i class="fas fa-arrow-circle-left" id="back_to_owner"></i></a></span>
                                    <h4 class="ml-5" id="back_to_owner_text">Update Supervision Record</h4>
                                    @else
                                    <span ><i class="fas fa-arrow-circle-left" id="back_to_owner"></i></span>
                                    <h4 class="ml-5" id="back_to_owner_text">Add New Supervision Record</h4>
                                    @endif
                                 </div>
                              </div><br>
                               <form action="<?php if(isset($_GET['action'])){ echo url('UpdateSupervision'); }else{ echo url('AddSupervison'); } ?>" class="form-horizontal" method="post" enctype='multipart/form-data' id="supervision">
                              @csrf
                              <input type="hidden" name="supervision_id" value="{{@$result[0]['id']}}">
                              <ul class="nav nav-tabs nav-justified mb-5" role="tablist">
                                 <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home8" role="tab"><span><i class="ti-home"></i></span><span class="tab-heading">Owner & Property info</span></a> </li>
                                 <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile8" role="tab"><span><i class="fa fa-file" aria-hidden="true"></i></span><span class="tab-heading">Tenant Contract</span></a> </li>
                                 <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages8" role="tab"><span><i class="fa fa-file-archive-o"></i></span><span class="tab-heading">Supervision Contract</span></a> </li>
                                 <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#cheque" role="tab"><span><i class="fa fa-money"></i></span><span class="tab-heading">Payment/Cheque</span></a> </li>
                                 <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#account_statment" role="tab"><span><i class="fa fa-wrench"></i></span><span class="tab-heading">Account Statement</span></a> </li>
                              </ul>
                              <!-- Tab panes -->
                              <div class="tab-content tabcontent-border">
                                 <div class="tab-pane active p-20" id="home8" role="tabpanel">
                                    <div class="form-body">
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 unit_no">Unit No</label>
                                                <div class="col-md-9">
                                                   <input required="" type="text" class="form-control" name="unit_no" value="{{@$result[0]['unit_no']}}">
                                                   <!-- <small class="form-control-feedback"> This is inline help </small>  -->
                                                </div>
                                             </div>
                                          </div>
                                          <!--/span-->
                                          <div class="col-md-6">
                                             <div class="form-group has-danger row">
                                                <label class="control-label text-right col-md-3 building">Building</label>
                                                <div class="col-md-8" style="padding-left: 15px;">
                                                   <select class="form-control" required="" style="font-size: 12px;" name="building" id="building">
                                                      <option value="">Select option</option>
                                                      @foreach($buildings as $building)
                                                      <option value="{{$building->building_name}}">{{$building->building_name}}</option>
                                                      @endforeach
                                                   </select>
                                                </div>
                                                <div class="col-sm-1" style="padding-top: 8px;">
                                                   <i class="fa fa-plus add-building" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="font-size:22px;color:black" aria-hidden="true"></i>
                                                </div>
                                             </div>
                                          </div>
                                          <!--/span-->
                                       </div>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 location">Location</label>
                                                <div class="col-md-9">
                                                   <input required="" type="text" name="area" class="form-control" value="{{@$result[0]['area']}}">
                                                   <!-- <small class="form-control-feedback"> Select your gender. </small>  -->
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 bedroom">Bedroom</label>
                                                <div class="col-md-9">
                                                   <select required="" style="font-size: 12px;" name="Bedroom" class="form-control">
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
                                                   <!-- <small class="form-control-feedback"> Select your gender. </small>  -->
                                                </div>
                                             </div>
                                          </div>
                                          <!--/span-->
                                       </div>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 condition">Conditions</label>
                                                <div class="col-md-9">
                                                   <select required="" style="font-size: 12px;" name="Conditions" class="form-control" required="">
                                                      <option value="{{@$result[0]['area']}}">{{@$result[0]['Conditions']}}</option>
                                                      <option value="furnished">furnished</option>
                                                      <option value="full furnished">full furnished</option>
                                                      <option value="semi furnished">semi furnished</option>
                                                   </select>
                                                   <!-- <small class="form-control-feedback"> Select your gender. </small>  -->
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 washroom">Washroom</label>
                                                <div class="col-md-9">
                                                   <select  style="font-size: 12px;" name="Washroom" class="form-control">
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
                                                <label class="control-label text-right col-md-3 owner">Owner</label>
                                                <div class="col-md-8" style="padding-left: 15px;">
                                                   <select class="form-control" required="" style="font-size: 12px;" name="assigned_user" id="assigned_user">
                                                      <option value="">Select option</option>
                                                      @foreach($users as $user)
                                                      <option value="{{$user->user_name}}">{{$user->user_name}}</option>
                                                      @endforeach
                                                   </select>
                                                </div>
                                                <div class="col-sm-1" style="padding-top: 8px;">
                                                   <i class="fa fa-user-plus add-user" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_2" style="font-size:22px;color:black" aria-hidden="true"></i>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 maintenence-amount">Maintenance amount</label>
                                                <div class="col-md-9">
                                                   <input required="" type="number" name="maintenance_amount" class="form-control" value="{{@$result[0]['maintenance_amount']}}" <?php if(isset($_GET["action"])){echo "disabled";} ?>>
                                                   <!-- <small class="form-control-feedback"> Select your gender. </small>  -->
                                                </div>
                                             </div>
                                          </div>
                                          <!--/span-->
                                          <!--/span-->
                                       </div>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 access">Access</label>
                                                <div class="col-md-9">
                                                   <select class="form-control" name="access" style="font-size: 13px;" required="">
                                                      <option value="">Select option</option>
                                                      <option value="For Rent" <?php if(@$result[0]["access"]=="For Rent"){echo "selected";} ?>>For Rent</option>
                                                      <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("For Sale")){echo "selected";} ?> value="For Sale">For Sale</option>
                                                      <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Upcoming")){echo "selected";} ?> value="Upcoming">Upcoming</option>
                                                      <option <?php if(strtoupper(@$result[0]["access"])==strtoupper("Do Not Caller")){echo "selected";} ?> value="Do Not Caller">Do Not Caller</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 dep_amount">Security Deposit Amount</label>
                                                <div class="col-md-9">
                                                   <input required="" type="number" name="security_deposit_amount" class="form-control" value="{{@$result[0]['security_deposit_amount']}}" <?php if(isset($_GET["action"])){echo "disabled";} ?>>
                                                </div>
                                             </div>
                                          </div>
                                          <!--/span-->
                                       </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane  p-20" id="profile8" role="tabpanel">
                                    <div class="form-body">
                                       <h4>Tenant Details & Contract</h4>
                                       <hr>
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 name">Name</label>
                                                <div class="col-md-9">
                                                   <input required="" type="text" class="form-control" name="tenant_name" value="{{@$result[0]['tenant_name']}}">
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 number">Number</label>
                                                <div class="col-md-9">
                                                   <input required="" type="number" class="form-control" name="tenant_number" value="{{@$result[0]['tenant_number']}}">
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 email">Email</label>
                                                <div class="col-md-9">
                                                   <input required="" type="email" class="form-control" name="tenant_email" value="{{@$result[0]['tenant_email']}}">
                                                </div>
                                             </div>
                                          </div>
                                          <!--/span-->
                                       </div>
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 s_date">Start Date</label>
                                                <div class="col-md-9">
                                                   <input required="" type="text" class="form-control datepicker-here" data-language="en" placeholder="mm/dd/yyyy" name="contract_start_date" value="{{@$result[0]['contract_start_date']}}" <?php if(isset($_GET['action'])){ echo "disabled"; }?>>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 e_date">End Date</label>
                                                <div class="col-md-9">
                                                   <input required="" type="text" class="form-control datepicker-here" data-language="en" placeholder="mm/dd/yyyy" name="contract_end_date" value="{{@$result[0]['contract_end_date']}}" <?php if(isset($_GET['action'])){ echo "disabled"; }?>>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 contract">Contract Attchment</label>
                                                <div class="col-md-6">
                                                   <?php if(!isset($_GET['action'])){ ?>
                                                   <input required="" type="file" class="file" name="contract_attachment">
                                                   <?php }else{ ?>
                                                   <a href="{{URL::to('public/contract_attachments/'.@$result[0]['contract_attachment'])}}" target="_blank" class="attachments">Download</a> <?php } ?>
                                                </div>
                                                <div class="col-sm-3"><button type="button" class="btn btn-success btn-add-contract">Add</button></div>
                                             </div>
                                          </div>
                                          <!--/span-->
                                       </div>
                                       <div class="tenant_contract_div row">
                                       @if(isset($documents))
                                       @foreach($documents as $document)
                                             <div class="col-md-4">
                                                <div class="form-group row">
                                                   <label class="control-label text-right col-md-3">Document</label> 
                                                   <div class="col-md-9">
                                                      <div class="row">
                                                         <div class="col-sm-4" style="padding-right: 5px;"><input type="text" class="form-control" disabled="" name="document_name[]" value="{{$document->file_type}}"></div>
                                                         <div class="col-sm-8" style="padding-left: 0px;padding-right: 15px;">
                                                            <a href="{{URL::to('public/user_attachments/'.@$document['file_name'])}}" target="_blank" class="attachments">Download</a> 
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                       @endforeach
                                      @endif
                                       </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane p-20" id="messages8" role="tabpanel">
                                    <div class="form-body">
                                       <h4>Supervison Contract</h4>
                                       <hr>
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 s_date">Start Date</label>
                                                <div class="col-md-9">
                                                   <input required="" type="text" class="form-control datepicker-here" data-language="en" placeholder="mm/dd/yyyy" name="supervision_contract_start_date" value="{{@$result[0]['supervision_contract_start_date']}}" <?php if(isset($_GET['action'])){ echo "disabled"; }?>>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-3 e_date">End Date</label>
                                                <div class="col-md-9">
                                                   <input required="" type="text" class="form-control datepicker-here" data-language="en" placeholder="mm/dd/yyyy" name="supervision_contract_end_date" value="{{@$result[0]['supervision_contract_end_date']}}" <?php if(isset($_GET['action'])){ echo "disabled"; }?>>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-group row">
                                                <label class="control-label text-right col-md-5 contract">Contract Attchment</label>
                                                <div class="col-md-7">
                                                   <?php if(!isset($_GET['action'])){ ?>
                                                   <input required="" type="file" class="file" name="supervision_contract_attachment">
                                                   <?php }else{ ?>
                                                   <a href="{{URL::to('public/contract_attachments/'.@$result[0]['supervision_contract_attachment'])}}" target="_blank" class="attachments">Download</a> <?php } ?>
                                                </div>
                                             </div>
                                          </div>
                                          <!--/span-->
                                       </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane p-20" id="cheque" role="tabpanel">
                                    <div class="form-body">
                                       <div class="">
                                          <h4>Cheque</h4>
                                          <hr>
                                          <div class="" style="width:100%">
                                             <div class="">
                                                <table class="table">
                                                   <thead>
                                                      <tr>
                                                         <th>Cheque Number</th>
                                                         <th>Cheque amount</th>
                                                         <th>Cheque Date</th>
                                                         <th>clearance Date</th>
                                                         <th>Attachments</th>
                                                         <th>Action</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      @if(isset($cheaqueRecord))
                                                      @if(count($cheaqueRecord) > 0)
                                                      @foreach($cheaqueRecord as $record)
                                                      <tr>
                                                         <td>
                                                            <input required="" type="number" class="form-control" value="{{$record->cheque_number}}" disabled>
                                                         </td>
                                                         <td>
                                                            <input required="" type="number" value="{{$record->Cheque_amount}}" class="form-control" disabled>
                                                         </td>
                                                         <td>
                                                            <input required="" type="Date" value="{{$record->cheque_date}}" class="form-control" disabled>
                                                         </td>
                                                         <td>
                                                            <input required="" type="Date" value="{{$record->cheque_deposit_date}}" class="form-control" disabled>
                                                         </td>
                                                         <td>
                                                            <a href="{{URL::to('public/Cheque_attachment_files/'.$record->cheque_attach_file)}}" target="_blank" class="attachments">Download</a>
                                                         </td>
                                                         <td style="text-align: center;">
                                                            <input required="" type="button" value="Add" class="btn btn-primary apply" id="add_cheque" style="width: 100%;"> 
                                                         </td>
                                                      </tr>
                                                      @endforeach
                                                      @endif
                                                      @else
                                                      <tr>
                                                         <td>
                                                            <input required="" type="number" name="Cheque_number[]" class="form-control">
                                                         </td>
                                                         <td>
                                                            <input required="" type="number" name="Cheque_amount[]" class="form-control">
                                                         </td>
                                                         <td>
                                                            <input required="" type="text" class="form-control datepicker-here" data-language="en" placeholder="mm/dd/yyyy" name="Cheque_date[]" class="form-control">
                                                         </td>
                                                         <td>
                                                            <input required="" type="text" class="form-control datepicker-here" data-language="en" placeholder="mm/dd/yyyy" name="Cheque_deposit_date[]" class="form-control">
                                                         </td>
                                                         <td>
                                                            <input required="" type="file" class="file" name="Cheque_attach_file[]">
                                                         </td>
                                                         <td style="text-align: center;">
                                                            <input required="" type="button" value="Add" class="btn btn-primary apply" id="add_cheque" style="width: 100%;"> 
                                                         </td>
                                                      </tr>
                                                      @endif
                                                   </tbody>
                                                </table>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane p-20" id="account_statment" role="tabpanel">
                                    <div class="form-body">
                                       <div class="">
                                          <h4>Account Stat</h4>
                                          <?php if(isset($_GET["action"])){ ?>
                                          <span style="font-size: 12px;" class="danger">Remaining Maintenance amount : <span style="font-size: 14px;" class="label label-danger">{{number_format($result[0]['maintenance_amount']-$total,2)}}</span></span>
                                          <?php } ?> 
                                          <hr>
                                          <div class="row">
                                             <div class="col-sm-12">
                                                <table class="table">
                                                   <thead>
                                                      <tr>
                                                         <th>Maintenance Date</th>
                                                         <th>Description</th>
                                                         <th>AED</th>
                                                         <th>Maintenance type</th>
                                                         <th>Attachments</th>
                                                         <th>Action</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      @if(isset($maintenanceRecord))
                                                      @if(count($maintenanceRecord) > 0)
                                                      @foreach($maintenanceRecord as $record)
                                                      <tr>
                                                         <td>
                                                            <input required="" type="text" class="form-control datepicker-here" data-language="en" placeholder="mm/dd/yyyy" value="{{$record->maintenance_date}}" disabled class="form-control">
                                                         </td>
                                                         <td width="300px">
                                                            <textarea required="" class="form-control" value="" disabled cols="5" rows="5">{{$record->maintenance_description}}</textarea>
                                                         </td>
                                                         <td width="250px">
                                                            <input required="" type="number" value="{{$record->maintenance_AED}}" disabled class="form-control">
                                                         </td>
                                                         <td width="250px">
                                                            <input required="" type="text" value="{{$record->maintenance_type}}" disabled class="form-control">
                                                         </td>
                                                         <td style="width: 1px">
                                                            <a href="{{URL::to('public/maintenance_attach_files/'.$record->maintenance_attach_file)}}" target="_blank" class="attachments">Download</a>
                                                         </td>
                                                         <td style="text-align: center;">
                                                            <input required="" type="button" value="Add" class="btn btn-primary apply" id="add_maintenance" style="width: 100%;">
                                                         </td>
                                                      </tr>
                                                      @endforeach
                                                      @endif
                                                      @else
                                                      <tr>
                                                         <td>
                                                            <input required="" type="text" class="form-control datepicker-here" data-language="en" placeholder="mm/dd/yyyy" name="maintenance_date[]" class="form-control">
                                                         </td>
                                                         <td width="300px">
                                                            <textarea required="" class="form-control" name="maintenance_description[]" cols="5" rows="5"></textarea>
                                                         </td>
                                                         <td width="250px">
                                                            <input required="" type="number" name="maintenance_AED[]" class="form-control">
                                                         </td>
                                                         <td width="250px">
                                                            <input required="" type="text" class="form-control" name="maintenance_type[]">
                                                         </td>
                                                         <td style="width: 1px">
                                                            <input required="" type="file" class="file" name="maintenance_attach_file[]" style="width: 172px;">
                                                         </td>
                                                         <td style="text-align: center;">
                                                            <input required="" type="button" value="Add" class="btn btn-primary apply" id="add_maintenance" style="width: 100%;"> 
                                                         </td>
                                                      </tr>
                                                      @endif                 
                                                   </tbody>
                                                </table>
                                             </div>
                                          </div>
                                          <!--/row-->
                                          <div class="form-actions">
                                             <div class="row">
                                                <div class="col-md-6"> </div>
                                                <div class="col-md-6" style="    padding-right: 31px;">
                                                   <div class="row" style="display: contents;">
                                                      <button style="float: right;padding: 15px 50px;background: green !important;" type="submit" name="add_supervison" class="btn btn-success submit"><?php if(isset($_GET["action"])){echo "Update";}else{echo "Submit";}?></button>
                                                   </div>
                                                </div>
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
                <!-- end row -->

            </div>
            <!-- end container-fluid -->
        </div> 
        <!-- end page-content-wrapper -->
    </div>
    <!-- End Page-content -->

@include('inc.footer')
 <!-- Required datatable js -->
<script src="{{url('public/Green/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
 <!-- Responsive examples -->
<script src="{{url('public/Green/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

<!-- Datatable init js -->
<script src="{{url('public/Green/assets/js/pages/datatables.init.js')}}"></script>


@if(session('msg'))
<script>alertify.success("{!! session('msg') !!}")</script>
@endif
@if(session('error'))
<script>alertify.error("{!! session('error') !!}")</script>
@endif
<script type="text/javascript" src="{{url('public/assets/js/additional.js')}}"></script>
<script>
   $('#add-new-owne-link').on('click', function(){
      $('.all_supervisions').css('display', 'none');
      $('.add_suppervision').css('display', 'block');
   })
   $('#back_to_owner').on('click', function(){
      $('.all_supervisions').css('display', 'block');
      $('.add_suppervision').css('display', 'none');
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
<script>
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
                       $('#building').append('<option selected value='+buildingName+'>'+buildingName+'</option>');
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
   $(document).ready(function(){
       $('#addOwnerForm').validate({
           rules : {
                 password:{
                   minlength : 6,
               },
       },
       submitHandler:function(form){
           $('.add-owner-btn').text('wait...');
           $.ajax({
               type : 'POST',
               url : "{{url('add-owner-by-ajax')}}",
               data : new FormData($('#addOwnerForm')[0]),
               contentType: false,
               cache: false,
               processData: false,
               success:function(data){
                   if($.trim(data) == 'true'){
                       var ownerName=$('#user_name').val();
                       $('#assigned_user').append('<option selected value='+ownerName+'>'+ownerName+'</option>');
                       $('.close-owner-btn').trigger('click');
                       document.getElementById("addOwnerForm").reset();
                       $('.others_documents').html('');
                       $('.others_documents').hide();
                       $('.add-owner-btn').text('Add');
                   }else{
                       alert(data);
                       $('.add-owner-btn').text('Add');
                   }
               }
           })
       }
   });

   })
</script>
<script>
   $(document).delegate('.btn-add-contract','click',function(){
         $('.tenant_contract_div').append('<div class="col-md-4"> <div class="form-group row"> <label class="control-label text-right col-md-3">Document</label> <div class="col-md-9"><div class="row"><div class="col-sm-4" style="padding-right: 5px;"><input type="text" class="form-control" name="document_name[]"></div><div class="col-sm-8" style="padding-left: 0px;padding-right: 15px;"> <input style="font-size:11px !important;padding-top: 10px;" type="file" class="form-control" name="documents[]"></div><i class="fa fa-window-close btn-delete-contract" style="font-size: 17px !important;    color: #DE5449 !important;position: absolute;cursor: pointer !important;left: 90%;top: 23%;color: #DE5449 !important;cursor: pointer !important;" aria-hidden="true"></i></div> </div></div></div>')
     });
     
      $(document).delegate('.btn-delete-contract','click',function(){
           $(this).parent().parent().parent().parent().remove();
      });
</script>
<script>
      $('.add-more-docs').click(function(){
       $('.others_documents').show();
       $('.others_documents').append('<div class="col-md-6"> <div class="form-group row"> <label class="control-label text-right col-md-3">Document</label> <div class="col-md-9"><div class="row"><div class="col-sm-4" style="padding-right: 5px;"><input type="text" class="form-control" name="document_name[]"></div><div class="col-sm-8" style="padding-left: 0px;"> <input style="font-size:10px !important;padding-top: 5px;padding-left: 4px;" type="file" class="form-control" name="documents[]"></div></div> </div></div></div><i class="fa fa-window-close close-other-doc" style="font-size: 17px !important;margin-left: -25px !important;margin-top: 13px !important;color: #DE5449 !important;cursor: pointer !important;" aria-hidden="true"></i>');
        });

      $(document).delegate('.close-other-doc','click',function(){
           $(this).prev().remove();
           $(this).remove();
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