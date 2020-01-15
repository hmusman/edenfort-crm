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
                            <th>Agent Name</th>
                            <th>Reminder Type</th>
                            <th>Reminder Of</th>
                            <th>Property ID</th>
                            <th>Description</th>
                            <th>Unit No.</th>
                            <th>Action</th>

                            
                        </tr>
                    </thead>
                    <tbody>
            @if(isset($reminder))
               @if(count($reminder) > 0)
                    @foreach($reminder as $rem)
                        
                        <tr style="@if($rem->status=='viewed') background-color: #e2e2e2; 
                        @endif">
                          <td>{{$rem->add_by}}</td> 
                          <td>{{$rem->reminder_type}}</td>  
                          <td>{{$rem->reminder_of}} </td>
                          <td>{{$rem->property_id}}</td>
                          <td>{{$rem->description}}</td>
                          <td>{{$rem->unit_no}}</td>
                          <td><a class="p-2" href="{{ url('get-reminder-record')}}?property_id={{$rem->property_id}}&ref={{$rem->reminder_of}}&active={{$rem->add_by}}">View<i class="fas fa-info-circle"></i></a>
                            <a class="p-2 disable_reminder" href="{{url('delete-single-reminder')}}/{{$rem->property_id}}">Disable<i class="fas fa-close"></i></a></td>
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
    <!-- <script>
        $('#myTable').on( 'click', 'tbody tr', function () {
          window.location.href = $(this).data('href');
        });
    </script> -->
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