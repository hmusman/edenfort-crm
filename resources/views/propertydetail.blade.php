@include('inc.header')
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
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperAgent') || ucfirst('Agent')))

  <script type="text/javascript">

    window.location='{{url("/")}}';

  </script>

  <?php redirect('/'); ?>

@endif

	<div class="page-wrapper">
		<div class="ml-3" style="width: 98%;">
			 <div style="background:white;" class="mb-3 px-3">
    <div class="tab-pane active p-20 " >
      <h2 align="center">Property Detail</h2>
       <div class="form-body">
           <div class="row table-responsive">
            <table id="myTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Unit No.</th>
                            <th>Building</th>
                            <th>Area</th>
                            <th>LandLord</th>
                            <th>Email</th>
                            <th>Contect No.</th>
                            <th>Bedroom</th>
                            <th>Washroom</th>
                            <th>Condition</th>
                            <th>Area squarefeet</th>
                            <th>Price</th>
                            <th>Description</th>


                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>{{$data->unit_no}}</th>
                            <th>{{$data->Building}}</th>
                            <th>{{$data->area}}</th>
                            <th>{{$data->LandLord}}</th>
                            <th>{{$data->email}}</th>
                            <th>{{$data->contect_no}}</th>
                            <th>{{$data->Bedroom}}</th>
                            <th>{{$data->Washroom}}</th>
                            <th>{{$data->Condition}}</th>
                            <th>{{$data->Area_Sqft}}</th>
                            <th>{{$data->Price}}</th>
                            <th>{{$data->comment}}</th>
                        </tr>
                    </tbody>
                    </table>
                    <!-- single page detail -->
                    <!-- <div class="col-sm-6 mt-3">
                        <b>Building:</b> {{$data->unit_no}}<br><br>
                        <b>Area:</b> {{$data->area}}<br><br>
                        <b>Email:</b> {{$data->email}}<br><br>
                        <b>Bedrooms:</b> {{$data->bedrooms}}<br><br>
                        <b>Condition:</b> {{$data->Condition}}<br><br>
                        <b>Price:</b> {{$data->Price}}<br><br>


                        
                    </div>
                    <div class="col-sm-6 mt-3">
                        <b>Building:</b> {{$data->Building}}<br><br>
                        <b>LandLord:</b> {{$data->LandLord}}<br><br>
                        <b>Contect No.</b> {{$data->contect_no}}<br><br>
                        <b>washrooms:</b> {{$data->washroom}}<br><br>
                        <b>Area squarefeet :</b> {{$data->Area_Sqft}}<br><br>
                        <b>Current Situation:</b> {{$data->comment}}<br><br>
                        
                    </div> -->
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
    @if(ucfirst(session('role')) == (ucfirst('Admin')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == (ucfirst('SuperAgent')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == ucfirst('Agent'))
      @include('reminder')
    @endif

    </body>

</html>