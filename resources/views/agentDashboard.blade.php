@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=ucfirst('agent'))
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
@if(@$permissions->dashboardView!=1)
<script type="text/javascript">
    window.location='{{url("404")}}';
  </script>
  <?php redirect('/'); ?>
@endif
	<div class="page-wrapper">

		<div class="container">

			<h3 class="page_heading" style="padding-left: 0px;">Dashboard</h3>

       <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-briefcase-check text-info"></i></h2>
                                    <h3 class="">{{$properties}}</h3>
                                    <h6 class="card-subtitle">Properties</h6></div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-wallet text-success"></i></h2>
                                    <h3 class="">{{$coldCallings}}</h3>
                                    <h6 class="card-subtitle">Cold Calling</h6></div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-buffer text-warning"></i></h2>
                                    <h3 class="">{{$leads}}</h3>
                                    <h6 class="card-subtitle">Leads</h6></div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<div class="row">
    <div class="col-lg-12 col-xlg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                      <h4 class="page_heading" style="padding:0px !important;margin:0px !important;margin-bottom:10px !important;">Report Summary : </h4>
                      <ul class="nav nav-tabs">
                        <li class="btn btn-primary" aria-expanded="false"><a data-toggle="tab" href="#home" class="active" aria-expanded="true">Upcoming Reminders</a></li>
                        <li class="btn btn-primary"><a data-toggle="tab" href="#menu1">Latest Properties</a></li>
                        <li class="btn btn-primary"><a data-toggle="tab" href="#menu2">Latest Leads</a></li>
                      </ul>
                      <div class="tab-content">
                        <div id="home" class="tab-pane fade in active show" aria-expanded="true">
                          <table id="myTable2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sno# </th>
                                        <th>Property id</th>
                                        <th>Agent</th>
                                        <th>Reminder of</th>
                                        <th>Reminder Type</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                @php  $counter = 1; @endphp
                                @foreach($reminders as $reminder)
                                    <tr>
                                      <td class="text-center;"> {{$counter++}}</td>  
                                      <td class="text-center;">{{$reminder->property_id}} </td>
                                      <td class="text-center;"> {{@$reminder->user->user_name}}</td>
                                      <td class="text-center;"> {{$reminder->reminder_of}}</td>  
                                      <td class="text-center;">{{$reminder->reminder_type}} </td>
                                      <td class="text-center;"> {{date("Y-m-d",strtotime($reminder->date_time))}}</td>
                                      <td class="text-center;"> {{$reminder->description}}</td>  
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                          <table id="myTable2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                       <th>Unit No </th>
                                       <th>Building Name </th>
                                       <th>Area </th>
                                       <th>LandLord </th>
                                       <th>Contact No</th>
                                       <th>Email</th>
                                       <th>Area Sqft</th>
                                       <th>Beds</th>
                                       <th>Price</th>
                                       <th>Added By</th>
                                       <th>Registered</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                @php  $counter = 1; @endphp
                                @foreach($latestProperties as $property)
                                    <tr>
                                      <td>{{$property->unit_no}}</td>
                                      <td>{{$property->Building}}</td>
                                      <td>{{$property->area}}</td>
                                      <td>{{strtoupper($property->LandLord)}}</td>
                                      <td>{{$property->contact_no}}</td>
                                      <td>{{$property->email}}</td>
                                      <td>{{$property->Area_Sqft}}</td>
                                      
                                      <td>{{$property->Bedroom}}</td>
                                      <td>{{$property->Price}}</td>
                                      @if($property->getAddBy['user_name'])
                                          <td>{{ucfirst($property->getAddBy['user_name'])}}</td>
                                      @else
                                          <td>{{ucfirst($property->Agent['user_name'])}}</td>
                                      @endif
                                      <td>{{date('Y-m-d',strtotime($property->created_at))}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="menu2" class="tab-pane fade">
                          <table id="myTable3" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sno#</th>
                                        <th>Date</th>
                                        <th>Client </th> 
                                        <th>Building </th> 
                                        <th>Agent </th> 
                                        <th>Email </th>
                                        <th>status</th> 
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php  $counter = 1; @endphp
                                @foreach($latestLeads as $lead)
                                    <tr>
                                      <td>{{$counter++}}</td>
                                      <td>{{$lead->submission_date	}}</td>
                                      <td>{{$lead->client_name	}}</td>
                                      <td>{{$lead->building}}</td>
                                      <td>{{$lead->lead_user}}</td>
                                      <td>{{$lead->email}}</td>
                                      <td>{{$lead->status}}</td>
                                      <td>{{date('Y-m-d',strtotime($lead->created_at))}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!--End of cards, For total amout of properties,buildings, etc-->
  <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12 col-xlg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex flex-wrap">
                                            <div>
                                                <h4 >Status</h4>
                                            </div>
                                            <div class="ml-auto">
                                                <ul class="list-inline">
                                                    <li>
                                                        <h6 class="text-muted text-success"><i class="fa fa-circle font-10 m-r-10 "></i>Cold-calling</h6> </li>
                                                    <li>
                                                        <h6 class="text-muted  text-warning"><i class="fa fa-circle font-10 m-r-10"></i>Property</h6> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="earning" style="height: 355px;padding-top: 35px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     <!-- end of graph Column -->   
                    </div>
                    
   
</div>

      
<!--End of conatiner-->
		</div>	
<!--End of page-wrapper-->
	</div>
  <script src="{{url('public/assets/plugins/jquery/jquery.min.js')}}"></script>

@include('inc.footer')
    
    @if(ucfirst(session('role')) == (ucfirst('Admin')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == (ucfirst('SuperAgent')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == ucfirst('Agent'))
      @include('reminder')
    @endif

<script type="text/javascript">
	$(function() {
		var date = new Date();
		var day = date.getDate();
     var month = date.getMonth()+1;
      var year = date.getFullYear();
//Change it so that it is 7 days in the past.

currentDate = year + "-" + month + "-" + day;
first=year + "-" + month + "-" + (date.getDate()- 6);
second=year + "-" + month + "-" + (date.getDate()- 5);
third=year + "-" + month + "-" + (date.getDate()- 4);
four=year + "-" + month + "-" + (date.getDate()- 3);
five=year + "-" + month + "-" + (date.getDate()- 2);
six=year + "-" + month + "-" + (date.getDate()- 1);
//alert(first);
	var weekdays = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];

Morris.Line({
  element: 'earning',
  data: [
    {
      "period": first,
       "cold":'{{$firstCold}}',
      "total": {{$firstDay}}
    },
    {
      "period": second,
       "cold":'{{$secondCold}}',
      "total": {{$secondDay}}

    },
    {
      "period": third,
       "cold":'{{$thirdCold}}',
      "total": {{$thirdDay}}
    },
    {
      "period": four,
       "cold":'{{$fourCold}}',
      "total": {{$fourDay}}
    },
    {
      "period": five,
       "cold":'{{$fiveCold}}',
      "total": {{$fiveDay}}
    }, {
      "period": six,
       "cold":'{{$sixCold}}',
      "total": {{$sixDay}}
    }, {
      "period": currentDate,
      "cold":'{{$currentCold}}',
      "total": {{$currentDay}},


    }
  ],
  lineColors: ['#f5901a', '#26c6da', '#FF6541', '#A4ADD3', '#766B56'],
  xkey: 'period',
  ykeys: ['total','cold'],
  labels: ['Property','cold'],
  xLabels: 'day',
  xLabelFormat: function(d) {
    return weekdays[d.getDay()];
  },
  resize: true
});
});
</script>
 
  <script src="{{url('public/assets/plugins/raphael/raphael-min.js')}}"></script>
    <script src="{{url('public/assets/plugins/morrisjs/morris.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script>
        $(document).ready( function () {
            $('#myTable,#myTable2,#myTable3').DataTable();
        });
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
    </body>

</html>