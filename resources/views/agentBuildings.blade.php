@include('inc.header')

@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Agent') || ucfirst('SuperAgent')))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
@if($permissions->buildingView!=1)
<script type="text/javascript">
    window.location='{{url("404")}}';
  </script>
  <?php redirect('/'); ?>
@endif
 <!-- DataTables -->
<link href="{{url('public/Green/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('public/Green/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     
<style>
  .owner_information_link{
    display: none;
  }
  .card-header{
    background-color: white;
  }
  #back_to_owner{
    font-size: 35px;
    position: absolute;
  }
  #back_to_owner_text{
    font-size: 21px;
    margin-left: 45px;
    font-weight: bold;
  }
</style>
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
                                <input type="text" class="form-control date-time" placeholder="set min date" id="min-date"> 
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
    </div>
</div>
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">  
<style>
    #add-new-owne-link{
       cursor: pointer;
       color: white;
       padding: 20px 24px 20px 24px;
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
                        <h4 class="page-title mb-1">Buildings</h4>
                        <ol class="breadcrumb m-0">
                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li> -->
                        <li class="breadcrumb-item active">Edenfort CRM Buildings</li>
                        </ol>
                    </div>
                    <!-- <div class="col-md-4">
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
                            <div class="card-body owner_main_row">
                                <form action="{{url('PropertyBulkActions')}}" method="GET" style="width: 100%;">
                                    <div class="col-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        @if($permissions->buildingAdd==1)                      <a style="cursor: pointer" class="btn btn-success btn-rounded waves-effect waves-light" id="add-new-owne-link"><span><i class="fa fa-plus"></i></span></a>
                                                        @endif
                                                    </div>
                                                    <!-- <div class="form-group ml-auto col-md-3">
                                                       <select class="form-control action_select" name="action" style="margin-right: 100px;">
                                                          <option value="NULL">Bulk Action</option>
                                                          <option value="Update">Update</option>
                                                       </select>
                                                   </div>
                                                   <div class="col-md-1">
                                                       <input type="submit" name="apply" value="Apply" class="btn btn-success apply">
                                                   </div> -->
                                                   <div class="col-md-12 mt-4">
                                                      @if(isset($_GET['action']))
                                                      <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                            <th>Assign agent</th>
                                                            <th>Access</th>
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
                                                              <td>{{$record->Building}}</td>
                                                              <td>{{$record->area}}</td>
                                                              <td>{{strtoupper($record->LandLord)}}</td>
                                                              <td><?php $temp=explode(',', $record->contact_no);foreach ($temp as $key=>$value) {
                                                                  if($key==0){ ?>
                                                                 <span>{{$value}}</span>&#160;&#160;<label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer" class="label label-primary add_phone">Add</label>
                                                                  <?php }else{ ?>
                                                                      <span style="display: block;width: 100%;">{{$value}}</span>
                                                              <?php  } } ?></td>
                                                              <td><?php $temp=explode(',', $record->email);foreach ($temp as $key=>$value) {
                                                                  if($key==0){ ?>
                                                                 <span>{{$value}}</span>&#160;&#160;<label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer" class="label label-primary add_email">Add</label>
                                                                  <?php }else{ ?>
                                                                      <span style="display: block;width: 100%;">{{$value}}</span>
                                                              <?php  } } ?></td>
                                                              <td>{{$record->Area_Sqft}}</td>
                                                              <td>{{$record->Price}}</td>
                                                              
                                                              <td>{{$record->agent}}</td>
                                                              <td>
                                                                  <select class="form-control access_select" style="font-size: 11px;font-weight: 500;" unit="{{$record->unit_no}}" required="" name="updated_access[{{$counter++}}]">
                                                                      <option <?php if(strtoupper($record->access)==strtoupper("For Rent")){echo "selected";}  ?> value="For Rent">For Rent</option>
                                                                      <option <?php if(strtoupper($record->access)==strtoupper("For Sale")){echo "selected";}  ?> value="For Sale">For Sale</option>
                                                                      <option <?php if(strtoupper($record->access)==strtoupper("Upcoming")){echo "selected";}  ?> value="Upcoming">Upcoming</option>
                                                                      <option <?php if(strtoupper($record->access)==strtoupper("Do Not Caller")){echo "selected";}  ?> value="Do Not Caller">Do Not Call</option>
                                                                      <option <?php if(strtoupper($record->access)==strtoupper("Call Back")){echo "selected";}  ?> value="Call Back">Call Back</option>
                                                                      <option <?php if(strtoupper($record->access)==strtoupper("Not answering")){echo "selected";}  ?> value="Not answering">Not answering</option>
                                                                      <option <?php if(strtoupper($record->access)==strtoupper("Not Intrested")){echo "selected";}  ?> value="Not Intrested">Not Intrested</option>
                                                                      <option <?php if(strtoupper($record->access)==strtoupper("Intrested")){echo "selected";}  ?> value="Intrested">Intrested</option>
                                                                  </select>
                                                              </td>
                                                          </tr>
                                                            @endforeach
                                                          @else
                                                          <tr><td colspan="11" align="center">No Record Found</td></tr>
                                                          @endif 
                                                          @endif 
                                                        </tbody>
                                                      </table>
                                                    @else
                                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                          <thead>
                                                          <tr>
                                                              <th>SNO#</th>
                                                              <th>Building Name</th>
                                                          </tr>
                                                          </thead>
                                                          <tbody>
                                                            <?php  if(isset($building)){ ?>
                                                            <?php $counter=1; ?>
                                                            @foreach($building as $record)
                                                            <tr>
                                                              <td>{{$counter++}}</td>
                                                              <td>{{ucwords($record->building_name)}}</td>
                                                            </tr>
                                                            @endforeach
                                                            <?php }  ?>
                                                          </tbody>
                                                      </table>
                                                      @endif
                                                   </div>
                                                </div>
                                                <input id="model" data-toggle="modal" data-target=".bs-example-modal-sm" class="btn btn-danger"  style="visibility: hidden;" type="button" value="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body owner_information_link">
                              <div class="row">
                                 <div class="col-12 back_wrapper">
                                   <a href="{{url('agent-buildings')}}">
                                    <i class="fas fa-arrow-circle-left" id="back_to_owner"></i>
                                    </a>
                                        <span id="back_to_owner_text">Add New Building</span>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card card-outline-info" style="margin-top: 40px;">
                                            <div class="card-header" style="background-color: #2fa97c;">
                                                <h4 class="m-b-0 text-white">Building Details</h4>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{url('/insert-building-agent')}}" id="user_form" class="form-horizontal" method="post" novalidate="novalidate">
                                                    @csrf                      
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label class="control-label text-right col-md-3">Building Name</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" placeholder="" name="building_name" value="" required="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                <!--/span-->
                                                            <div class="col-md-6">
                                                            </div>
                                                        </div>
                                                        <div class="form-actions">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-md-offset-3 col-md-9" style="padding-left: 28%;">
                                                                            <button type="submit" class="btn btn-success submit">Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6"> </div>
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
@if(session('msg'))
    <script>alertify.success("{!! session('msg') !!}")</script>
@endif
@if(session('error'))
    <script>alertify.error("{!! session('error') !!}")</script>
@endif
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

<script type="text/javascript">
$("#property").validate();
     $("body").delegate(".apply","click",function(e){
        var action=$(".action_select option:selected").val();
        if(action=="NULL" || action=="Delete"){
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
 });
 
</script>
<script>
  $('#add-new-owne-link').click(function(){
  $('.owner_main_row').hide();
  $('.owner_information_link').show();
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