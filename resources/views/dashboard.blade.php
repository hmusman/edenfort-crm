@include('inc.header')
<style>
   @media only screen and (max-width: 600px) {
    .crd{
      margin-left: 10px;
    }
    .nav.nav-tabs {
      width: 100%;
      margin-left: -4px;
    }
    .btn{
          margin-top: 10px;
    }
   }
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
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperAgent') || ucfirst('SuperDuperAdmin')))

  <script type="text/javascript">

    window.location='{{url("/")}}';

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
                                <div class="col-12 crd">
                                    <h2 class="m-b-0"><i class="mdi mdi-briefcase-check text-info"></i></h2>
                                    <h3 class="">{{$properties}}</h3>
                                    <h6 class="card-subtitle">Properties</h6></div>
                                <div class="col-12 crd">
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                                <div class="col-12 crd">
                                    <h2 class="m-b-0"><i class="mdi mdi-alert-circle text-success"></i></h2>
                                    <h3 class="">{{$contracts}}</h3>
                                    <h6 class="card-subtitle">Supervisions</h6></div>
                                <div class="col-12 crd">
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
                                <div class="col-12 crd">
                                    <h2 class="m-b-0"><i class="mdi mdi-wallet text-purple"></i></h2>
                                    <h3 class="">
                                        
 @if(ucfirst(session('role'))==ucfirst('SuperAgent'))    
                                        {{$coldCallingsSuperAgent}}
                        @else
                         {{$coldCallings}}
                         @endif
                                        </h3>
                                    <h6 class="card-subtitle">Cold Calling</h6></div>
                                <div class="col-12 crd">
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                                <div class="col-12 crd">
                                    <h2 class="m-b-0"><i class="mdi mdi-buffer text-warning"></i></h2>
                                    <h3 class="">{{$leads}}</h3>
                                    <h6 class="card-subtitle">Leads</h6></div>
                                <div class="col-12 crd">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--End of cards, For total amout of properties,buildings, etc-->

<!--Agent monthly report or last 30 days report -->

 <div style="background:white;" class="agent-report mb-3 px-3">
    <div class="tab-pane active p-20 " >
      <h3 align="center">Agent 30 Days Report</h3>
       <div class="form-body">
           <div class="row"> 
                <table id="myTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Agent </th>
                            <th>Total Leads</th>
                            <th>Work On</th>
                            
                        </tr>
                    </thead>
                    <tbody>
            @if(isset($allusers))
               @if(count($allusers) > 0)
                    @foreach($allusers as $user)
                        <tr>
                          <td> {{$user->user_name}}</td>  
                          <td>{{$user->getAgentLeads($user->user_name)}} </td>
                          <td> {{$user->getAgentWorking($user->id)}}</td>
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
<div class="row">
    <div class="col-lg-12 col-xlg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                      <h2>Report Summary</h2>
                      <ul class="nav nav-tabs">
                        <li class="btn btn-primary" aria-expanded="false"><a data-toggle="tab" href="#home" class="active" aria-expanded="true">Upcoming Reminders</a></li>
                        <li class="btn btn-primary"><a data-toggle="tab" href="#menu1">Latest Properties</a></li>
                        <li class="btn btn-primary"><a data-toggle="tab" href="#menu2">Latest Leads</a></li>
                      </ul>
                      <div class="tab-content">
                        <div id="home" class="tab-pane fade in active show table-responsive"" aria-expanded="true">
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php  $counter = 1; @endphp
                                @foreach($reminders as $reminder)
                                    @if(@$reminder->user->status == 1)
                                        <tr>
                                          <td class="text-center;"> {{$counter++}}</td>  
                                          <td class="text-center;">{{$reminder->property_id}} </td>
                                          <td class="text-center;">@if(is_null(@$reminder->user->user_name)) ADMIN @else {{@$reminder->user->user_name}} @endif</td>
                                          <td class="text-center;"> {{$reminder->reminder_of}}</td>  
                                          <td class="text-center;">{{$reminder->reminder_type}} </td>
                                          <td class="text-center;"> {{date("Y-m-d",strtotime($reminder->date_time))}}</td>
                                          <td class="text-center;"> {{$reminder->description}}</td>
                                          <td class="text-center;"> <a target="_blank" href="{{url('get-reminder-record')}}?property_id={{$reminder->property_id}}&ref={{$reminder->reminder_of}}&active={{@$reminder->add_by}}" class="btn btn-success" style="font-size:12px;">visit</a></td>
                                        </tr>
                                    @endif
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
                        <div id="menu2" class="tab-pane fade ">
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

 @if(ucfirst(session('role'))==ucfirst('Admin')) 
<div class="row">
    <div class="col-lg-12 col-xlg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                      <h2 align="center">Deals Report</h2>
                      <div class="tab-content">
                        <div id="home" class="tab-pane fade in active show table-responsive" aria-expanded="true">
                          <!-- <div class="row">
                            <li class="mr-2 ml-2" style="color: red">Days Left: 7 or less than 7</li>
                            <li class="mr-2 ml-2" style="color: orange">Days Left: 14 or less than 14</li>
                            <li class="mr-2 ml-2" style="color: green">Days Left: 21 or less than 21</li>
                            <li class="mr-2 ml-2" style="color: black">Days Left: 31 or less than 31</li>
                          </div> -->
                          
                          <table id="myTable3" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sno# </th>
                                        <th>Deal Start Date</th>
                                        <th>Contract Start Date</th>
                                        <th>Contract End Date</th>
                                        <th>Building</th>
                                        <th>Refrence No.</th>
                                        <th>Broker</th>
                                        <th>Unit</th>
                                        <th>Client Name</th>
                                        <th>Contact</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php  $counter = 1; @endphp
                                @foreach($deals as $deal)
                                @php  
                                    $date1 = $currentDate;
                                    $date2 = $deal->cEnd;

                                    $diff = abs(strtotime($date2) - strtotime($date1));

                                    $years = floor($diff / (365*60*60*24));
                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                                @endphp
                                
                                        <tr>
                                          <td class="text-center" style="color: <?php if($days < 7) echo "red"; if($days > 7 && $days <= 14) echo "orange"; if($days > 14 && $days <= 21) echo "green"; if($days > 21 && $days <= 31) echo "black";?>!important"> {{$counter++}}<br> <small style="font-size: 63%;font-weight: 400;background-color:<?php if($days < 7) echo "red"; if($days > 7 && $days <= 14) echo "orange"; if($days > 14 && $days <= 21) echo "green"; if($days > 21 && $days <= 31) echo "black";?>!important;color: white;padding: 3px 2px 3px 1px;border-radius: 50px;">{{$days}} days Left</small></td> 
                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "orange"; if($days > 14 && $days <= 21) echo "green"; if($days > 21 && $days <= 31) echo "black";?>!important">{{date('d-m-Y',strtotime($deal->dStart))}}</td>
                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "orange"; if($days > 14 && $days <= 21) echo "green"; if($days > 21 && $days <= 31) echo "black";?>!important">{{date('d-m-Y',strtotime($deal->cStart))}}</td>  
                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "orange"; if($days > 14 && $days <= 21) echo "green"; if($days > 21 && $days <= 31) echo "black";?>!important">{{date('d-m-Y',strtotime($deal->cEnd))}}</td>
                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "orange"; if($days > 14 && $days <= 21) echo "green"; if($days > 21 && $days <= 31) echo "black";?>!important">{{$deal->build}}</td>
                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "orange"; if($days > 14 && $days <= 21) echo "green"; if($days > 21 && $days <= 31) echo "black";?>!important">{{$deal->refNo}}</td>
                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "orange"; if($days > 14 && $days <= 21) echo "green"; if($days > 21 && $days <= 31) echo "black";?>!important">{{$deal->broker}}</td>
                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "orange"; if($days > 14 && $days <= 21) echo "green"; if($days > 21 && $days <= 31) echo "black";?>!important">{{$deal->unit}}</td>
                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "orange"; if($days > 14 && $days <= 21) echo "green"; if($days > 21 && $days <= 31) echo "black";?>!important">{{$deal->cName}}</td>
                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "orange"; if($days > 14 && $days <= 21) echo "green"; if($days > 21 && $days <= 31) echo "black";?>!important">{{$deal->contact}}</td>
                                          <td class="text-center" style=""> <a target="_blank" href="{{url('get-single-reminder-record')}}?property_id={{$deal->dealId}}&ref=Deals&active=ADMIN" class="btn btn-success" style="font-size:12px;">visit</a></td>
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

@endif


<div class="row">
    <div class="col-lg-12 col-xlg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                      <h2 align="center">Last 30 Days Reminders</h2>
                      <div class="tab-content">
                        <div id="home" class="tab-pane fade in active show table-responsive" aria-expanded="true">
                          <table id="myTable2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sno# </th>
                                        <th>Agent Name</th>
                                        <th>Reminder of</th>
                                        <th>Reminder Type</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Reason</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php  $counter = 1; @endphp
                                @foreach($remSummery as $reminder)
                                        <tr>
                                          <td class="text-center;"> {{$counter++}}</td>  
                                          <!-- <td class="text-center;">{{$reminder->property_id}} </td> -->
                                          <td class="text-center;">@if(is_null(@$reminder->user_name)) ADMIN @else {{@$reminder->user_name}} @endif</td>
                                          <td class="text-center;"> {{$reminder->reminder_of}}</td>  
                                          <td class="text-center;">{{$reminder->reminder_type}} </td>
                                          <td class="text-center;"> {{date("Y-m-d",strtotime($reminder->date_time))}}</td>
                                          <td class="text-center;"> {{$reminder->description}}</td>
                                          <td class="text-center;"> {{$reminder->reason}}</td>
                                          <td class="text-center;"> <a target="_blank" href="{{url('get-reminder-record')}}?property_id={{$reminder->property_id}}&ref={{$reminder->reminder_of}}&active={{$reminder->add_by}}" class="btn btn-success" style="font-size:12px;">visit</a></td>
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


<!--end of agent report-->
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
<!--End of page-wrapper-->
	</div>

@include('inc.footer')



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