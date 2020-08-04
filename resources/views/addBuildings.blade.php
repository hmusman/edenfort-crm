@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<!-- Responsive Table css -->
<link href="{{url('public/Green/assets/libs/RWD-Table-Patterns/css/rwd-table.min.css')}}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{('public/Green/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{('public/Green/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{('public/Green/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     

<style>
    .delete-building{
        cursor: pointer;
        color: #2fa97c !important;
    }
    .owner_information_link{
        display: none;
    }
    #tech-companies-1 thead{
        background-color: #2fa97c;
        color: white;
    }
    .nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #2fa97c;
    border-color: #2fa97c #2fa97c #2fa97c;
}
.nav-tabs {
    border-bottom: 1px solid #2fa97c;
}
#demo-input-search2 {
    background-color: #ddd !important;
    padding: 8px 5px;
    border-radius: 5px;
    min-height: 31px;
    background-image: linear-gradient(#ddd, #ddd), linear-gradient(#ddd, #ddd);
}
#demo-input-search2 {
    border: 0;
    background-image: linear-gradient(#1976d2, #1976d2), linear-gradient(#b1b8bb, #b1b8bb);
    background-size: 0 2px, 100% 1px;
    background-repeat: no-repeat;
    background-position: center bottom, center calc(100% - 1px);
    background-color: transparent;
    transition: background 0s ease-out;
    float: none;
    box-shadow: none;
    border-radius: 0;
    margin-left: 10px;
    color: #67757c;
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
                    @if(basename(url()->current())=='edit-building')
                    <li class="breadcrumb-item active">Update Building</li>
                    @else
                    <li class="breadcrumb-item active">Add Building</li>
                    @endif
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
<?php  if(!isset($_GET['action'])) { ?>
    <div class="page-content-wrapper owner_main_row">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header" style="background-color: white;">
                                <ul class="nav nav-tabs" role="tablist">
                                  @if(basename(url()->current())=='buildings')
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{url('buildings')}}">
                                          <span class="d-none d-md-inline-block">Add Building</span> 
                                        </a>
                                    </li>
                                  @else
                                  <li class="nav-item">
                                        <a class="nav-link" href="{{url('buildings')}}">
                                          <span class="d-none d-md-inline-block">Add Building</span> 
                                        </a>
                                    </li>
                                  @endif
                                   @if(basename(url()->current())=='assignAgent')
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{url('assignAgent')}}">
                                          <span class="d-none d-md-inline-block">Assign Coldcalling</span>
                                        </a>
                                    </li>
                                  @else
                                  <li class="nav-item">
                                        <a class="nav-link" href="{{url('assignAgent')}}">
                                          <span class="d-none d-md-inline-block">Assign Coldcalling</span>
                                        </a>
                                    </li>
                                  @endif
                                </ul>
                              </div>
                              <div class="card-body">
                                  <div class="d-flex" style="float: right;">
                                    <a data-toggle="modal" data-target=".bs-example-modal-lg" class="btn btn-success waves-effect waves-light btn-rounded add-building" style="cursor: pointer;color: white;" id="add-new-owne-link"><span><i class="fa fa-plus" style="padding: 12px 9px 12px 9px;"></i></span></a>

                                    <!--  Modal content for the above example -->
                                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Add Building</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{url('insert-building')}}" id="user_form" class="form-horizontal" method="post">
                                                    {{csrf_field()}}
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label class="control-label text-right col-md-3" style="float: left;">Building Name</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" placeholder="" name="building_name" value="{{@$record->building_name}}" required="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-offset-3 col-md-9" style="padding-left:51%;">
                                                                        <button type="submit" class="btn btn-success submit">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"> </div>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                  </div>
                                  <br>
                                  <div class="table-rep-plugin">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="tech-companies-1" class="table table-striped" data-page-length='25'>
                                            <thead>
                                            <tr>
                                                <th data-toggle="true">SNO#</th>
                                                <th data-toggle="true">Building Name</th>
                                                                               
                                                <th data-toggle="all">Action</th>
                                                <th data-toggle="all">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                           <?php if(count($value) > 0){ $counter=1;
                                             foreach($value as $values){ ?>
                                            <tr>
                                                <td>{{$counter++}}</td>
                                                <td>{{ucwords($values->building_name)}}</td>
                                                
                                                <td><a class="edit_supervision" href='{{url("edit-building")}}?action=edit&id={{$values->id}}'><i class="fa fa-edit"></i> Edit</a></td>
                                                <td><a class="edit_supervision delete-building" onclick="Confirm({{$values->id}})" href='#'><i class="fa fa-edit"></i> Delete</a></td>
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
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div>
        <!-- end container-fluid -->
    </div> 
    <!-- end page-content-wrapper -->
<?php  } else{ ?><style type="text/css">.owner_information_link{display: block;</style> <?php  } ?>
<div class="page-content-wrapper owner_information_link">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                         <div class="row ">
                            <div class="col-lg-12">
                                <div class="card card-outline-info">
                                    <div class="card-header" style="background-color: white;">
                                        <h4 class="m-b-0">Building Details</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{url('update-building')}}?id={{@$record->id}}" id="user_form" class="form-horizontal" method="post">
                                        {{csrf_field()}}
                                            <div class="form-body">
                                                <div class="row">
                                                    
                                                     <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Building Name</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" placeholder="" name="building_name" value="{{@$record->building_name}}" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                              </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9" style="padding-left: 28%;">
                                                                <button type="submit" class="btn btn-success submit">Update</button>
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
<!-- Responsive Table js -->
<script src="{{url('public/Green/assets/libs/RWD-Table-Patterns/js/rwd-table.min.js')}}"></script>

<!-- Init js -->
<script src="{{url('public/Green/assets/js/pages/table-responsive.init.js')}}"></script>
 <!-- Required datatable js -->
<script src="{{url('public/Green/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{url('public/Green/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
<script>
    $('#tech-companies-1').DataTable();
</script>
<!-- Datatable init js -->
<script src="{{url('public/Green/assets/js/pages/datatables.init.js')}}"></script>
@if(session('msg'))
 <script>alertify.success("{!! session('msg') !!}")</script>
@endif
@if(session('error'))
 <script>alertify.error("{!! session('error') !!}")</script>
@endif
<?php  if(isset($_GET['action'])) { ?>
    <script type="text/javascript">
        $("#agent option").each(function(){
            if($(this).val()=='{{$record->assigned_agent}}'){
                $(this).attr("Selected",true);
            }
        })
    </script>
<?php }  ?>

<script>
    $('.delete-building').on('click', function(){
        $('.ajs-header').empty();
        $('.ajs-header').append('Delete Building')
    })
    
  function Confirm(id){
    console.log(id);
    alertify.confirm("Are You sure you want to delete this building.", function() {
            $.ajax({
              url: "{{url('delete-building')}}/?action=delete&id="+id,
              type: "get",
              data: {'id':id},
              success: function(responce){
                alertify.success("property deleted successfully.")

                 // $('#tech-companies-1').load(location.href + " #tech-companies-1");
                 window.location.reload();
              },
              error: function(responce){
                alertify.error("Something went wrong.")
              }
            })
            
        }, function() {
            alertify.error("Canceled building deletion.")
        })
  }
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

