@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperAgent') || ucfirst('SuperDuperAdmin')))

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
<style>
    #datatable-buttons_wrapper{
        margin-top: 20px;
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
                        <h4 class="page-title mb-1">{{strtoupper($user->user_name)}}'s Reminders</h4>
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Edenfort CRM > {{strtoupper($user->user_name)}}'s Reminders</li>
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
                            <div class="card-body">
                                <table id="datatable-buttons" class="mt-4 table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Add By</th>
                                        <th>Reminder Type</th>
                                        <th>Reminder Of</th>
                                        <th>Property ID</th>
                                        <th>Description</th>
                                        <!-- <th>Unit No.</th> -->
                                        <th>Date&Time</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                         <?php $i=1; ?>
                                        @if(isset($reminder))
                                           @if(count($reminder) > 0)
                                                @foreach($reminder as $rem)
                                                    
                                                    <tr style="@if($rem->status=='viewed') background-color: #e2e2e2; 
                                                    @endif">
                                                      <td><?php echo $i; ?></td> 
                                                      <td>{{ $user->user_name}}</td> 
                                                      <td>{{$rem->reminder_type}}</td>  
                                                      <td>{{$rem->reminder_of}} </td>
                                                      <td>{{$rem->property_id}}</td>
                                                      <td style="white-space: break-spaces;">{{$rem->description}}</td>
                                                      <!-- <td>{{$rem->unit_no}}</td> -->
                                                      <td>{{$rem->date_time}}</td>
                                                      <td><div class="row" style="padding-left: 14px;">
                                                        <a class="p-2" href="{{ url('get-single-reminder-record')}}?property_id={{$rem->property_id}}&ref={{$rem->reminder_of}}&status={{$rem->status}}&active={{$rem->add_by}}">View<i class="fas fa-info-circle"></i></a>
                                                        @if($rem->user_id==ucfirst(session('user_id')))
                                                        <a id="property_id" class="p-2 disable_reminder" href="#" property_id="{{$rem->property_id}}">Disable<i class="fas fa-times-circle"></i></a><br>
                                                        <a class="p-2 update_reminder" href="#" property_id="{{$rem->property_id}}">Update<i class="fas fa-edit"></i></a>@endif
                                                    </div>
                                                    </td>
                                                    </tr>
                                                        
                                                    <?php $i++;  ?>
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

<!--<script src="{{url('public/assets/plugins/jquery/jquery.min.js')}}"></script>-->
<script src="{{url('public/assets/plugins/raphael/raphael-min.js')}}"></script>
<script src="{{url('public/assets/plugins/morrisjs/morris.min.js')}}"></script>
   
    <script>
        $('body').delegate('.disable_reminder','click',function(){
        var property_id=$(this).attr('property_id');
        var notification = $(this);
        // $('.property_id').val(property_id);
        $.confirm({
            title: 'Disable Reminder!',
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label><i class="fa fa-info-circel"></i>Reason:</label>' +
            '<input type="text" placeholder="Please enter the valid reason." class="name form-control" required />' +
            '</div>' +
            '</form>',
             type: 'blue',
             icon: 'fa fa-warning',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue submit',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert('provide a valid reason');
                            return false;
                        }else{
                            // $('body').delegate('click','.formSubmit',function(){
                            
                                    $.ajax({
                                    url:'<?php echo url('delete-single-reminder')  ?>',
                                    type:'get',
                                    data:{property_id, name},
                                    success:function(data){
                                      console.log(data);
                                        if($.trim(data)=="false"){
                                            $.notify("something Went Wrong", "warn",{
                                                globalPosition: 'top right',
                                            });
                                        }else{
                                            $.notify("Reminder Disable Successfully", "warn",{elementPosition: 'bottom left',
                                                globalPosition: 'top left'});
                                            $('.ti-close').trigger('click');
                                            $('.notification_counter').text(data);
                                            notification.parent().remove();
                                            location.reload();
                                        }
                                    }
                                });
                                // });
                        }
                    }
                },
                cancel: function () {
                    //close
                },
            },
        });
      })


    </script>
    <script>
         $('body').delegate('.update_reminder','click',function(){
        var property_id=$(this).attr('property_id');
        var notification = $(this);
        // $('.property_id').val(property_id);
        $.confirm({
            title: 'Update Reminder!',
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label><i class="fa fa-info-circel"></i>Time & date:</label>' +
            '<input type="datetime-local" placeholder="Please enter the valid reason." class="datetime form-control" required />' +
            '<label><i class="fa fa-info-circel"></i>Description:</label>' +
            '<input type="text" placeholder="Please enter the valid reason." class="description form-control" required />' +
            '</div>' +
            '</form>',
             type: 'blue',
             icon: 'fa fa-warning',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue submit',
                    action: function () {
                        var datetime = this.$content.find('.datetime').val();
                        var description = this.$content.find('.description').val();
                        if(!datetime){
                            $.alert('Date & Time is required');
                            return false;
                        }
                        else if(!description){
                            $.alert('Description is required');
                            return false;
                        }
                        else{
                            // $('body').delegate('click','.formSubmit',function(){
                            
                                    $.ajax({
                                    url:'<?php echo url("update-reminder") ?>',
                                    type:'get',
                                    data:{property_id, datetime, description},
                                    success:function(data){
                                      console.log(data);
                                        if($.trim(data)=="false"){
                                            $.notify("something Went Wrong", "warn",{
                                                globalPosition: 'top right',
                                            });
                                        }else{
                                            $.notify("Reminder Updated Successfully", "warn",{elementPosition: 'bottom left',
                                                globalPosition: 'top left'});
                                            $('.ti-close').trigger('click');
                                            $('.notification_counter').text(data);
                                            notification.parent().remove();
                                            location.reload();
                                            // $('.notification_bucket').html("");
                                        }
                                    }
                                });
                                // });
                        }
                        // $.alert('Reminder Disable Successfully!');
                    }
                },
                cancel: function () {
                    //close
                },
            },
        });
      })
    </script>
    <style>
        #myTable_wrapper,#myTable2_wrapper,#myTable3_wrapper{
            width:100% !important;
        }
        table.dataTable thead th, table.dataTable thead td {
            font-size: 12px !important;
            color:black !important;
        }
        table.dataTable tbody th, table.dataTable tbody td{
            font-size: 12px !important;
            color:black !important;
        }
        #myTable_wrapper, #myTable2_wrapper, #myTable3_wrapper{
            font-size: 12px !important;
            color:black !important;
            font-weight: 500 !important;
        }
    </style>
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