@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperAgent')))

  <script type="text/javascript">

    window.location='{{url("/")}}';

  </script>

  <?php redirect('/'); ?>

@endif
<style>
    .nav-tabs li{
        color:white !important;
         text-align:center !important;
    }
    .btn a{
        color:white !important;
        text-align:center !important;
        font-size:12px !important;
    }
    .btn{
        border-radius:0px !important;
        margin-right:10px !important;
        color:white !important;
         text-align:center !important;
    }
    a.active{
        text-decoration:underline !important;
    }
</style>


	<div class="page-wrapper">
		<div class="container">
			 <div style="background:white;" class="mb-3 px-3">
    <div class="tab-pane active p-20 " >
      <h3 align="center">{{ $user->user_name}}'s Reminders</h3>
       <div class="form-body">
           <div class="row"> 
                <table id="myTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
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
            @if(isset($reminder))
               @if(count($reminder) > 0)
                    @foreach($reminder as $rem)
                        
                        <tr style="@if($rem->status=='viewed') background-color: #e2e2e2; 
                        @endif">
                          <td>{{ $user->user_name}}</td> 
                          <td>{{$rem->reminder_type}}</td>  
                          <td>{{$rem->reminder_of}} </td>
                          <td>{{$rem->property_id}}</td>
                          <td>{{$rem->description}}</td>
                          <!-- <td>{{$rem->unit_no}}</td> -->
                          <td>{{$rem->date_time}}</td>
                          <td><a class="p-2" href="{{ url('get-reminder-record')}}?property_id={{$rem->property_id}}&ref={{$rem->reminder_of}}&status={{$rem->status}}&active={{$rem->add_by}}">View<i class="fas fa-info-circle"></i></a>
                            @if($rem->user_id==session('user_id'))
                            <a id="property_id" class="p-2 disable_reminder" href="#" property_id="{{$rem->property_id}}">Disable<i class="fas fa-close"></i></a>@endif</td>
                        </tr>

                       <!--  <div id="create" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
            </div>
            <div class="modal-body">
                <form id="formadd" class="form-horizontal" role="form" method="post">
                {{csrf_field()}}
                <input type="hidden" name="property_id" id="property_id" class="property_id" value="{{$rem->property_id}}">
                <input type="hidden" name="user_id" id="user_id" class="user_id" value="{{$rem->user_id}}">
                    <div class="form-group row add">
                        <label class="control-label col-sm-2" for="reason">Reason:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control reason" id="reason" name="reason"
                                placeholder="Your Reason Here" required>
                            <span class="reminder-reason-error" style="font-size: 11px;font-weight: 500;color: red;"></span>
                            <p class="error text-center"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit" id="add" property_id="{{$rem->property_id}}">
                    <span class="fa fa-check"></span>Disable
                </button>
                <button class="btn btn-warning" type="button" data-dismiss="modal">
                    <span class="fa fa-remove"></span>Close
                </button>
            </div>
        </div>
    </div>
</div>
</div>
 -->
                            
                        
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
		</div>
	</div>
    


@include('inc.footer')

 <!--<script src="{{url('public/assets/plugins/jquery/jquery.min.js')}}"></script>-->
  <script src="{{url('public/assets/plugins/raphael/raphael-min.js')}}"></script>
    <script src="{{url('public/assets/plugins/morrisjs/morris.min.js')}}"></script>
    <!-- Chart JS 
    <script src="{{url('public/assets/js/dashboard1.js')}}"></script>-->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script>
        $(document).ready( function () {
            $('#myTable,#myTable2,#myTable3').DataTable();
        });
    </script>
   <!--  <script>
        $(document).on('click', '.disable_reminder', function() {
        $('#create').modal('show');
        $('.form-horizontal').show();
        $('.modal-title').text('Disable Reminder');
    });
        $("#add").click(function() {
            var reason=$('#reason').val();
            var property_id=$('#property_id').val();
            var user_id=$('#user_id').val();
            $('.reason').val(reason);
            $('.property_id').val(property_id);
            $('.user_id').val(user_id);

            $.ajax({
                 type: 'get',
                 url: 
                 data: $('#formadd').serialize(),

                 success: function(data){
                    if(data=="true"){
                        location.reload();
                    }
                    if(data=="no"){
                        alert('Sorry! You can not disable other users reminders.');
                    }
                    else{
                        alert('Plaease enter the valid reason.');
                         // $('.reminder-reason-error').html(data);
                    }
                 }
            });
        });
    </script> -->
    
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
            // onContentReady: function () {
            //     // bind to events
            //     var jc = this;
            //     this.$content.find('form').on('submit', function (e) {
            //         // if the user submits the form by pressing enter in the field.
            //         e.preventDefault();
            //         // jc.$$formSubmit.trigger('click'); // reference the button and click it
            //     });
            // }
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
    @include('reminder')
    </body>

</html>