@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
 <!-- DataTables -->
<link href="{{url('public/Green/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('public/Green/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     

<!-- Responsive Table css -->
<link href="{{url('public/Green/assets/libs/RWD-Table-Patterns/css/rwd-table.min.css')}}" rel="stylesheet" type="text/css" />

<style>
    @media (max-width: 550px){
        .mobility{
            width: 122%;
            margin-left: -30px;
        }
    }
    .owner_information_link{display: none;}
    #back_to_owner{
        font-size: 45px;
        position: absolute;
    }
    #tech-companies-1 thead{
        background-color: #2fa97c;
        color: white;
    }
    .table-rep-plugin{
        margin-top: -47px;
    }
    .focus-btn-group{
        margin-left: 80px;
    }
    .btn-toolbar {
        margin-bottom: 39px;
    }
    .nav-tabs .nav-link.active {
        color: #ffffff;
        background-color: #2fa97c;
        border-color: #2fa97c #2fa97c #2fa97c;
    }
    .nav-tabs {
        border-bottom: 1px solid #2fa97c;
    }
    #add-new-owne-link{
        cursor: pointer;
        padding: 20px 25px 20px 25px;
        border-radius: 50px;
        color: white;  
        z-index: 999;
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
                        @if(isset($_GET['action']))
                        <h4 class="page-title mb-1">Update User</h4>
                        @else
                        <h4 class="page-title mb-1">All Users</h4>
                        @endif
                        <ol class="breadcrumb m-0">
                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li> -->
                        <li class="breadcrumb-item active">Edenfort CRM Users</li>
                        </ol>
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <?php  if(!isset($_GET['action'])) { ?>
                            <div class="card-body all_user_card">
                                <div class="card-header" style="background-color: white;">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            @if(@$_GET['type']=='')
                                            <a href="{{url('admins')}}" class="nav-link active" role="tab">
                                                <span class="d-md-inline-block">Admins</span> 
                                            </a>
                                            @else
                                            <a href="{{url('admins')}}" class="nav-link" role="tab">
                                                <span class="d-md-inline-block">Admins</span> 
                                            </a>
                                            @endif
                                        </li>
                                        <li class="nav-item">
                                            @if(@$_GET['type']=='Owners')
                                            <a href="{{url('owners')}}?type=Owners" class="nav-link active" role="tab">
                                                <span class="d-md-inline-block">Owners</span>
                                            </a>
                                            @else
                                            <a href="{{url('owners')}}?type=Owners" class="nav-link" role="tab">
                                                <span class="d-md-inline-block">Owners</span>
                                            </a>
                                            @endif
                                        </li>
                                        <li class="nav-item">
                                            @if(@$_GET['type']=='Agents')
                                            <a href="{{url('agents')}}?type=Agents" class="nav-link active" role="tab">
                                                <span class="d-md-inline-block">Agents</span>
                                            </a>
                                            @else
                                            <a href="{{url('agents')}}?type=Agents" class="nav-link" role="tab">
                                                <span class="d-md-inline-block">Agents</span>
                                            </a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body mobility">
                                    <div class="d-flex">
                                        <a class="btn btn-success btn-rounded waves-effect waves-light" style="cursor: pointer" id="add-new-owne-link"><span><i class="fa fa-plus"></i></span></a>
                                    </div>

                                    <div class="table-rep-plugin">
                                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                                            <table id="tech-companies-1" class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th data-toggle="true"> user Name </th>
                                                    <th data-toggle="true"> First Name </th>
                                                    <th data-toggle="true">Last Name</th> 
                                                    <th data-toggle="true">Gender</th>                    
                                                    <th data-toggle="true"> Phone </th>
                                                    <th data-toggle="true"> Email </th>
                                                    <th data-toggle="true">Role</th>
                                                    <th data-toggle="all"> DOB </th>
                                                    <th data-toggle="all">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(count($value) > 0){
                                                 foreach($value as $values){ ?>
                                                    <tr>
                                                        <td>{{ucwords($values->user_name)}}</td>
                                                        <td>{{ucwords($values->First_name)}}</td>
                                                        <td>{{ucwords($values->Last_name )}}</td>
                                                        <td>{{ucwords($values->Gender )}}</td>
                                                        <td>{{ucwords($values->Phone)}}</td>
                                                        <td>{{ucwords($values->Email)}}</td>
                                                        <td>{{ucwords($values->Rule_type)}} </td>
                                                        <td>{{date('d-m-Y',strtotime(ucwords($values->birth_date)))}}</td>
                                                        <td><a class="edit_supervision" href='{{url("EditUser/{$values->id}")}}?action=editUser&user={{@$heading}}'><i class="fa fa-edit"></i> Edit</a></td>
                                                    </tr>
                                               <?php  } 
                                                } else{ ?>
                                                    <tr><td colspan="9" align="center">No Record Found</td></tr>
                                                <?php }  ?>
                                                </tbody>
                                            </table>
                                        </div>
    
                                    </div>
                                </div>
                            </div>
                            <?php  } else{ ?><style type="text/css">.owner_information_link{display: block;</style> <?php  } ?>
                            <div class="card-body owner_information_link">
                                <div class="card-header" style="background-color: white;">
                                    @if(!isset($_GET['action']))
                                    <span ><a href="#"><i class="fas fa-arrow-circle-left" id="back_to_owner"></i></a></span>
                                    <h4 class="ml-5 mt-2" id="back_to_owner_text" style="font-size: 26px;">New User</h4>
                                    @else
                                    <h4 id="back_to_owner_text">User Details</h4>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <form action="<?php if(isset($_GET['action'])){echo url("updateUser",array(@$record->id))."?username=".@$record->user_name."&user_email=".@$record->Email."&user=$user";}else{ echo url("insert")."?&user=".$heading; }  ?>" id="user_form" class="form-horizontal" method="post">
                                        {{csrf_field()}}
                                            <div class="form-body">
                                               <!--  <h3 class="box-title">Owner information</h3> -->
                                              <!--   <hr class="m-t-0 m-b-40"> -->
                                                <div class="row">
                                                    
                                                     <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3 username">User Name</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" placeholder="user Name" name="user_name" value="{{@$record->user_name}}" required="" id="user_name">
                                                               <!--  <small class="form-control-feedback"> This is inline help </small> --> </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3 first_name">First Name</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" placeholder="First Name" name="First_name" value="{{@$record->First_name}}" required="">
                                                               <!--  <small class="form-control-feedback"> This is inline help </small> --> </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!--/span-->
                                              </div>
                                                <!--/row-->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group has-danger row">
                                                            <label class="control-label text-right col-md-3 last_name">Last Name</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control form-control-danger" placeholder="Last Name" name="Last_Name" required="" value="{{@$record->Last_name}}">
                                                                <!-- <small class="form-control-feedback"> This field has error. </small> --> </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3 gender">Gender</label>

                                                            <div class="col-md-9">
                                                                  <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="Gender" style="font-size: 12px;" required="">
                                                                    <option value="">Select Gender</option>
                                                                    <option <?php  if(@$record->Gender=="Male"){echo "Selected";} ?> value="Male">Male</option>
                                                                    <option <?php  if(@$record->Gender=="Female"){echo "Selected";} ?> value="Female">Female</option>
                                                                </select>
                                                                <!-- <small class="form-control-feedback"> Select your gender. </small> --> </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                </div>
                                                <!--/row-->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3 dob">Date of Birth</label>
                                                            <div class="col-md-9">
                                                                <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="birth_date" required="" value="{{@$record->birth_date}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3 role">Role</label>
                                                            <div class="col-md-9">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="role" style="font-size: 12px;" required="" id="role">
                                                                    <option value="">Select Role</option>
                                                                    <?php  foreach($Role as $Roles){ ?>
                                                                    <option value="<?php echo $Roles['Rule_id'] ?>"><?php echo $Roles['Rule_type'] ?></option>
                                                                    <?php  } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!--/row-->
                                                <div class="row">
                                                       <?php if(!isset($_GET['action'])) { ?>
                                                    <!--<div class="col-md-6">-->
                                                    <!--    <div class="form-group row">-->
                                                    <!--        <label class="control-label text-right col-md-3">Password</label>-->
                                                    <!--        <div class="col-md-9">-->
                                                    <!--            <input type="password" class="form-control" name="Password" placeholder="Password" required="">-->
                                                    <!--        </div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <?php } ?>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3 email">Email</label>
                                                            <div class="col-md-9">
                                                                <input type="email" class="form-control" name="Email" placeholder="Email" required="" value="{{@$record->Email}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <?php if(isset($_GET['action'])) { ?>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Status</label>
                                                            <div class="col-md-9">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="status" style="font-size: 12px;" required="" id="status">
                                                                     <option value="">Select Status</option>
                                                                    <option <?php  if(@$record->status=="1"){echo "Selected";} ?> value="1">Activate</option>
                                                                    <option <?php  if(@$record->status=="0"){echo "Selected";} ?> value="0">Deactivate</option>
                                                                   
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <?php } ?>
                                                </div>
                                                <!--/row-->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3 phone">Phone</label>
                                                            <div class="col-md-9">
                                                                <input type="number" class="form-control" name="Phone" placeholder="Phone" required="" value="{{@$record->Phone}}">
                                                            </div>
                                                        </div>                                
                                                    </div>
                                                    <!--/span-->
                                                   <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3 password">Password</label>
                                                            <div class="col-md-9">
                                                                <input type="Password" class="form-control" name="Password" placeholder="**********" value="{{@$record->Password}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                </div>
                                                <!--/row-->
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9" style="    padding-left: 28%;">
                                                                <button type="submit" class="btn btn-success submit"><?php  if(isset($_GET['action'])){echo "Update";}else{echo "Submit";}?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6"> </div>
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
<!-- Responsive Table js -->
<script src="{{url('public/Green/assets/libs/RWD-Table-Patterns/js/rwd-table.min.js')}}"></script>

<!-- Init js -->
<script src="{{url('public/Green/assets/js/pages/table-responsive.init.js')}}"></script>
<script>$('#tech-companies-1').DataTable();</script>
<script>
    $('#add-new-owne-link').on('click',function(){
        $('.owner_information_link').css('display', 'block');
        $('.all_user_card').css('display', 'none');
    })
    $('#back_to_owner').on('click',function(){
        $('.owner_information_link').css('display', 'none');
        $('.all_user_card').css('display', 'block');
    })
    
</script>
<?php  if(isset($_GET['action'])) { ?>
    <script type="text/javascript">
        $("#role option").each(function(){
            if($(this).val()=={{$record->role}}){
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
