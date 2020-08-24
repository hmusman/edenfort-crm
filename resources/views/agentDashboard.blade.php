@include('inc.header')
@if(!session("user_id") && ucfirst(session('role')) != ucfirst('agent'))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
@if(@$permissions->dashboardView!=1)
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
  .card-header{
    background-color: white;
  }
  .nav-tabs .nav-link.active {
      color: #ffffff;
      background-color: #2fa97c;
      border-color: #2fa97c #2fa97c #2fa97c;
  }
  .nav-tabs {
      border-bottom: 1px solid #2fa97c;
  }
  @media (max-width: 550px){
    .table-responsive {
      display: block !important;
    }
  }
  .table-responsive {
      display: inline-table;
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
                        <h4 class="page-title mb-1">Dashboard</h4>
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Welcome to Edenfort CRM Dashboard</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <!-- <div class="float-right d-md-block">
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
                        </div> -->
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                            <div class="row">
                                    <div class="col-6">
                                        <h5>Welcome Back !</h5>
                                        <p class="text-muted">
                                          <b>{{strtoupper(@session('user_name'))}}</b>
                                        </p>
                                        <div class="mt-3">
                                          <p>{{@session('email')}}</p>
                                        </div>

                                        <!-- <div class="mt-4">
                                            <a href="#" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ml-1"></i></a>
                                        </div> -->
                                    </div>

                                    <div class="col-5 ml-auto">
                                        <div>
                                            <img src="{{('public/Green/assets/images/widget-img.png')}}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <!-- <h5 class="header-title mb-4">Monthy sale Report</h5> -->
                                <div class="media">
                                    <div class="media-body">
                                       <b><p class="text-muted mb-2"><i class="mdi mdi-briefcase-check" style="font-size: 20px;color: #2fa97c;"></i> Properties</p></b>
                                        <h4>{{$properties}}</h4>
                                    </div>
                                    <div dir="ltr" class="ml-2">
                                        <input data-plugin="knob" data-width="56" data-height="56" data-linecap=round data-displayInput=false
                                        data-fgColor="#2fa97c" value="{{$properties}}" data-skin="tron" data-angleOffset="{{$properties}}" data-min="-{{$properties}}" data-max="5000" data-step="50"
                                        data-readOnly=true data-thickness=".17" />
                                    </div>
                                </div>
                                <hr>
                                <div class="media">
                                    <div class="media-body">
                                        <b><p class="text-muted mb-2"><i class="mdi mdi-alert-circle" style="font-size: 20px;color: #9e7300;"></i> Cold Calling</p></b>
                                        <h4>{{$coldCallings}}</h4>
                                    </div>
                                    <div dir="ltr" class="ml-2">
                                        <input data-plugin="knob" data-width="56" data-height="56" data-linecap=round data-displayInput=false
                                        data-fgColor="#e4cc37" value="{{$coldCallings}}" data-skin="tron" data-angleOffset="{{$coldCallings}}" data-min="-{{$coldCallings}}" data-max="5000" data-step="50"
                                        data-readOnly=true data-thickness=".17" />
                                    </div>
                                </div>
                                <hr>
                                <div class="media">
                                    <div class="media-body">
                                       <b><p class="text-muted mb-2"><i class="mdi mdi-buffer" style="font-size: 20px;color: #ffb265;"></i> Leads</p></b>
                                        <h4>{{$leads}}</h4>
                                    </div>
                                    <div dir="ltr" class="ml-2">
                                        <input data-plugin="knob" data-width="56" data-height="56" data-linecap=round data-displayInput=false
                                        data-fgColor="#ffb265" value="{{$leads}}" data-skin="tron" data-angleOffset="{{$leads}}" data-min="-{{$leads}}" data-max="5000" data-step="50"
                                        data-readOnly=true data-thickness=".17" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body" style="position: relative;height: 491px;">
                                <form class="form-inline float-right">
                                    <div class="input-group mb-3">
                                        <div class="row mb-5">
                                            <h6 class="text-muted" style="color:#e4cc37 !important;"><i class="fa fa-circle font-10 m-r-10 " style="color: #e4cc37;"></i> Cold-calling</h6> </li>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <h6 class="text-muted" style="color: #2fa97c !important;"><i class="fa fa-circle font-10 m-r-10" style="color: #2fa97c !important;"></i> Property</h6> </li>
                                        </div>
                                    </div>
                                </form>
                                <h5 class="header-title mb-4">Status</h5>
                                <div id="yearly-sale-chart" class="apex-charts"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                              <h4 class="page_heading mt-3 mb-3">Report Summary : </h4>
                              <ul class="nav nav-tabs mt-3" role="tablist">
                                  <li class="nav-item">
                                      <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                        <span class="d-md-inline-block">Upcoming Reminders</span> 
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                        <span class="d-md-inline-block">Latest Properties</span>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                                        <span class="d-md-inline-block">Latest Leads</span>
                                      </a>
                                  </li>
                              </ul>
                            </div>
                            <div class="card-body">
                              <div class="tab-content p-3">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                  <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                <div class="tab-pane" id="profile" role="tabpanel">
                                    <table id="datatable1" class="table table-bordered dt-responsive nowrap table-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                <div class="tab-pane" id="messages" role="tabpanel">
                                    <table id="datatable2" class="table table-bordered dt-responsive nowrap table-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                              <td>{{$lead->submission_date  }}</td>
                                              <td>{{$lead->client_name  }}</td>
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
                <!-- end row -->

            </div> <!-- container-fluid -->
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
<script>
  $('#datatable2').DataTable();
  $('#datatable1').DataTable();
</script>
<script>
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

    $('[data-plugin="knob"]').knob()
});
var options = {
    chart: {
        height: 350,
        type: "area",
        toolbar: {
            show: !1
        }
    },
    colors: ["#2fa97c", "#e4cc37"],
    dataLabels: {
        enabled: !1
    },
    series: [{
        name: "Property",
        data: [{{$firstDay}}, {{$secondDay}}, {{$thirdDay}} ,{{$fourDay}}, {{$fiveDay}}, {{$sixDay}}, {{$currentDay}}]
    }, {
        name: "ColdCalling",
        data: [{{$firstCold}}, {{$secondCold}}, {{$thirdCold}} ,{{$fourCold}}, {{$fiveCold}}, {{$sixCold}}, {{$currentCold}}]
    }],
    grid: {
        yaxis: {
            lines: {
                show: !1
            }
        }
    },
    stroke: {
        width: 3,
        curve: "stepline"
    },
    markers: {
        size: 0
    },
    xaxis: {
        categories: ["{{$firstDayName}}", "{{$secondDayName}}", "{{$thirdDayName}}", "{{$fourDayName}}", "{{$fiveDayName}}", "{{$sixDayName}}", "{{$currentDayName}}"],
        title: {
            text: "Days"
        }
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            opacityFrom: .7,
            opacityTo: .9,
            stops: [0, 90, 100]
        }
    },
    legend: {
        position: "top",
        horizontalAlign: "right",
        floating: !0,
        offsetY: -25,
        offsetX: -5
    }
};
(chart = new ApexCharts(document.querySelector("#yearly-sale-chart"), options)).render();
options = {
    chart: {
        height: 350,
        type: "rangeBar",
        toolbar: {
            show: !1
        }
    },
    plotOptions: {
        bar: {
            horizontal: !0,
            barHeight: "12%"
        }
    },
    series: [{
        data: [{
            x: "Jack",
            y: [new Date("2020-01-02").getTime(), new Date("2020-01-04").getTime()],
            fillColor: "#2fa97c"
        }, {
            x: "Thomas",
            y: [new Date("2020-01-04").getTime(), new Date("2020-01-08").getTime()],
            fillColor: "#e4cc37"
        }, {
            x: "David",
            y: [new Date("2020-01-08").getTime(), new Date("2020-01-12").getTime()],
            fillColor: "#F06543"
        }, {
            x: "James",
            y: [new Date("2020-01-12").getTime(), new Date("2020-01-18").getTime()],
            fillColor: "#3051d3"
        }]
    }],
    xaxis: {
        type: "datetime",
        axisBorder: {
            show: !1
        }
    }
};
(chart = new ApexCharts(document.querySelector("#activity-chart"), options)).render();
var chart;
options = {
    chart: {
        height: 270,
        type: "radialBar"
    },
    plotOptions: {
        radialBar: {
            hollow: {
                margin: 5,
                size: "38%"
            },
            track: {
                margin: 12
            },
            dataLabels: {
                name: {
                    fontSize: "18px",
                    offsetY: "-10"
                },
                value: {
                    fontSize: "16px",
                    offsetY: "5"
                },
                total: {
                    show: !0,
                    label: "Total",
                    formatter: function(e) {
                        return 166
                    }
                }
            }
        }
    },
    colors: ["#2fa97c", "#e4cc37", "#f06543"],
    series: [44, 55, 67],
    labels: ["Facebook", "Twitter", "Instagram"]
};
(chart = new ApexCharts(document.querySelector("#radial-chart"), options)).render(), $("#usa-map").vectorMap({
    map: "usa_en",
    enableZoom: !0,
    showTooltip: !0,
    selectedColor: null,
    hoverColor: "#eaf0f1",
    backgroundColor: "transparent",
    color: "#f4f8f9",
    borderColor: "#7c8a96",
    colors: {
        ca: "#2fa97c",
        tx: "#2fa97c",
        mt: "#2fa97c",
        ny: "#2fa97c"
    },
    onRegionClick: function(e, t, a) {
        e.preventDefault()
    }
});
</script>
    
@if(ucfirst(session('role')) == (ucfirst('Admin')))
  @include('admin_SuperAgent_reminders')
@elseif(ucfirst(session('role')) == (ucfirst('SuperAgent')))
  @include('admin_SuperAgent_reminders')
@elseif(ucfirst(session('role')) == ucfirst('Agent'))
  @include('reminder')
@elseif(ucfirst(session('role')) == ucfirst('SuperDuperAdmin'))
  @include('reminder')
@elseif(ucfirst(session('role')) == ucfirst('SuperDuperAdmin'))
  @include('admin_SuperAgent_reminders')
@endif