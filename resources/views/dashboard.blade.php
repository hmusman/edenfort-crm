@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperAgent') || ucfirst('SuperDuperAdmin')))

  <script type="text/javascript">

    window.location='{{url("/")}}';

  </script>

  <?php redirect('/'); ?>

@endif
@section('extra-links')
    

@endsection
<style>
    @media screen and (min-width: 1600px) {
        .right-navPart-setting {
            float: right !important;
            margin-right: -140px !important;
        }
        body[data-layout=horizontal] .navbar-brand-box {
            float: left;
            background-color: transparent;
            padding-left: 0;
            padding-right: 0px;
            margin-left: -80px;
        }
    }
    #datatable{
        font-weight: bold;
    }
    #datatable thead, #datatable-rem thead{
        background-color: #2fa97c;
        color: white;
    }
  .tab1.active, .tab2.active, .tab3.active {
      border-color: #edeff1 #edeff1 #fff;
      background-color: #2fa97c!important;
      color: white !important;
  }
  #mytable_filter{
    margin-left: -42px;
  }
  #datatable_wrapper{
    font-size: 10px;
  }
  #myTable2_wrapper{
    font-size: 13px;
  }
  #tabsdatatable1_wrapper{
    font-size: 12px;
  }
  .dataTable-rem td {
      white-space: break-spaces;
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
                                <div class="col-xl-4">
                                    <div class="card">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-7">
                                                    <h5>Welcome Back !</h5>
                                                    <p class="text-muted"> 
                                                      <b>{{strtoupper(@session('user_name'))}}</b> 
                                                    </p>

                                                    <div class="mt-3">
                                                      <p>{{@session('email')}}</p>
                                                    </div>
                                                </div>

                                                <div class="col-5 ml-auto">
                                                    <div>
                                                        <img src="{{url('public/Green/assets/images/widget-img.png')}}" alt="" class="img-fluid">
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
                                                    <p class="text-muted mb-2"><i class="mdi mdi-briefcase-check" style="font-size: 20px;color: #2fa97c;"></i><b> Properties</b></p>
                                                    <h4>{{$properties}}</h4>
                                                </div>
                                                <div dir="ltr" class="ml-2">
                                                    <input data-plugin="knob" data-width="56" data-height="56" data-linecap=round data-displayInput=false
                                                    data-fgColor="#2fa97c" value="56" data-skin="tron" data-angleOffset="56"
                                                    data-readOnly=true data-thickness=".17" />
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="media">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2"><i class="mdi mdi-alert-circle" style="font-size: 20px;color: #9e7300;"></i><b> Supervisions</b></p>
                                                    <h4>{{$contracts}}</h4>
                                                </div>
                                                <div dir="ltr" class="ml-2">
                                                    <input data-plugin="knob" data-width="56" data-height="56" data-linecap=round data-displayInput=false
                                                    data-fgColor="#9e7300" value="2" data-skin="tron" data-angleOffset="56"
                                                    data-readOnly=true data-thickness=".17" />
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="media">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2"><i class="mdi mdi-wallet text-purple" style="font-size: 20px;color: #e4cc37;"></i><b> Cold Calling</b></p>
                                                    <h4>
                                                        @if(ucfirst(session('role')) == ucfirst('SuperAgent'))    
                                                          {{$coldCallingsSuperAgent}}
                                                        @else
                                                         {{$coldCallings}}
                                                         @endif
                                                    </h4>
                                                </div>
                                                <div dir="ltr" class="ml-2">
                                                    <input data-plugin="knob" data-width="56" data-height="56" data-linecap=round data-displayInput=false
                                                    data-fgColor="#e4cc37" value="56" data-skin="tron" data-angleOffset="56"
                                                    data-readOnly=true data-thickness=".17" />
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="media">
                                                <div class="media-body">
                                                    <p class="text-muted mb-2"><i class="mdi mdi-buffer" style="font-size: 20px;color: #ffb265;"></i><b> Leads</b></p>
                                                    <h4>{{$leads}}</h4>
                                                </div>
                                                <div dir="ltr" class="ml-2">
                                                    <input data-plugin="knob" data-width="56" data-height="56" data-linecap=round data-displayInput=false
                                                    data-fgColor="#ffb265" value="56" data-skin="tron" data-angleOffset="56"
                                                    data-readOnly=true data-thickness=".17" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-xl-8">
                                    <div class="card" style="height: 96%;">
                                        <div class="card-body">
                                            <form class="form-inline float-right">
                                                <div class="input-group mb-3 mr-4">
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
                                        <div class="card-header bg-transparent p-3">
                                            <h5 class="header-title mb-0">Agent 30 Day's Report</h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="media my-2">
                                                    <div class="media-body">
                                                        <table id="mytable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                            <thead>
                                                            <tr>
                                                                <th>Agent</th>
                                                                <th>Total Leads</th>
                                                                <th>Work on</th>         
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
                                                                <td align="center">No Record Found</td>
                                                              </tr>
                                                              @endif 
                                                          @endif    
                                                          </tbody>
                                                      </table>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="header-title">Report Summary</h4><br>
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist" style="border-bottom: 1px solid #2fa97c;">
                                                <li class="nav-item">
                                                    <a class="tab1 nav-link active" data-toggle="tab" href="#home" role="tab">
                                                        <i class="mdi mdi-phone-incoming"></i> <span class="d-none d-md-inline-block">Upcoming Reminders</span> 
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="tab2 nav-link" data-toggle="tab" href="#profile" role="tab">
                                                        <i class="mdi mdi-new-box"></i> <span class="d-none d-md-inline-block">Latest Properties</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="tab3 nav-link" data-toggle="tab" href="#messages" role="tab">
                                                        <i class="mdi mdi-new-box"></i> <span class="d-none d-md-inline-block">Latest Leads</span>
                                                    </a>
                                                </li>
                                            </ul>
            
                                            <!-- Tab panes -->
                                            <div class="tab-content p-3">
                                            <div class="tab-pane active" id="home" role="tabpanel">
                                                <table id="tabsdatatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                                  <td> {{$counter++}}</td>  
                                                                  <td>{{$reminder->property_id}} </td>
                                                                  <td>@if(is_null(@$reminder->user->user_name)) ADMIN @else {{@$reminder->user->user_name}} @endif</td>
                                                                  <td> {{$reminder->reminder_of}}</td>  
                                                                  <td>{{$reminder->reminder_type}} </td>
                                                                  <td> {{date("Y-m-d",strtotime($reminder->date_time))}}</td>
                                                                  <td style="white-space: break-spaces;"> {{$reminder->description}}</td>
                                                                  <td>
                                                                    <a target="_blank" href="{{url('get-reminder-record')}}?property_id={{$reminder->property_id}}&ref={{$reminder->reminder_of}}&active={{@$reminder->add_by}}" type="button" class="btn btn-outline-secondary btn-sm"data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
                                                                    <i class="mdi mdi-eye"></i>
                                                                    </a>
                                                                  </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                            <div class="tab-pane" id="profile" role="tabpanel">
                                               <table id="tabsdatatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                  <table id="tabsdatatable2" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- <div class="float-right ml-2">
                                                <a href="#">View all</a>
                                            </div> -->
                                            <h5 class="header-title mb-4">Deals Report</h5>

                                            <div class="table-responsive">
                                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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

                                                      $days = (strtotime($date2) - strtotime($date1))/60/60/24;

                                                      //print_r($deal->cEnd);

                                                  @endphp
                                                  <tr>
                                                          <td data-order="{{$days}}" class="text-center" style="color: <?php if($days < 7) echo "red"; if($days > 7 && $days <= 14) echo "red"; if($days > 14 && $days <= 21) echo "orange"; if($days > 21 && $days <= 31) echo "green"; if($days > 31) echo "black";?>!important">
                                                            {{$counter++}}<br> 
                                                            <small style="font-size: 63%;font-weight: 400;background-color:<?php if($days < 7) echo "red"; if($days > 7 && $days <= 14) echo "red"; if($days > 14 && $days <= 21) echo "orange"; if($days > 21 && $days <= 31) echo "green"; if($days > 31) echo "black";?>!important;color: white;padding: 3px 2px 3px 1px;border-radius: 50px;">{{$days}} days Left
                                                            </small>
                                                          </td> 
                                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "red"; if($days > 14 && $days <= 21) echo "orange"; if($days > 21 && $days <= 31) echo "green"; if($days > 31) echo "black";?>!important">{{date('d-m-Y',strtotime($deal->dStart))}}</td>
                                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "red"; if($days > 14 && $days <= 21) echo "orange"; if($days > 21 && $days <= 31) echo "green"; if($days > 31) echo "black";?>!important">{{date('d-m-Y',strtotime($deal->cStart))}}</td>  
                                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "red"; if($days > 14 && $days <= 21) echo "orange"; if($days > 21 && $days <= 31) echo "green"; if($days > 31) echo "black";?>!important">{{date('d-m-Y',strtotime($deal->cEnd))}}
                                                          </td>
                                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "red"; if($days > 14 && $days <= 21) echo "orange"; if($days > 21 && $days <= 31) echo "green"; if($days > 31) echo "black";?>!important">{{$deal->build}}
                                                          </td>
                                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "red"; if($days > 14 && $days <= 21) echo "orange"; if($days > 21 && $days <= 31) echo "green"; if($days > 31) echo "black";?>!important">{{$deal->refNo}}
                                                          </td>
                                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "red"; if($days > 14 && $days <= 21) echo "orange"; if($days > 21 && $days <= 31) echo "green"; if($days > 31) echo "black";?>!important">{{$deal->broker}}
                                                          </td>
                                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "red"; if($days > 14 && $days <= 21) echo "orange"; if($days > 21 && $days <= 31) echo "green"; if($days > 31) echo "black";?>!important">{{$deal->unit}}
                                                          </td>
                                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "red"; if($days > 14 && $days <= 21) echo "orange"; if($days > 21 && $days <= 31) echo "green"; if($days > 31) echo "black";?>!important">{{$deal->cName}}
                                                          </td>
                                                          <td class="text-center" style="color: <?php if($days <= 7) echo "red"; if($days > 7 && $days <= 14) echo "red"; if($days > 14 && $days <= 21) echo "orange"; if($days > 21 && $days <= 31) echo "green"; if($days > 31) echo "black";?>!important">{{$deal->contact}}
                                                          </td>
                                                          <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                <a target="_blank" href="{{url('get-single-reminder-record')}}?property_id={{$deal->dealId}}&ref=Deals&active=ADMIN" type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" aria-describedby="tooltip401307">
                                                                    <i class="mdi mdi-eye"></i>
                                                                </a>
                                                            </div>
                                                          </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- <div class="float-right ml-2">
                                                <a href="#">View all</a>
                                            </div> -->
                                            <h5 class="header-title mb-4">Last 30 Days Reminders</h5>

                                            <div class="table-responsive">
                                                <table id="datatable-rem" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                          <td style="white-space: break-spaces;"> {{$reminder->description}}</td>
                                                          <td class="text-center;"> {{$reminder->reason}}</td>
                                                          <td class="text-center;"> <a target="_blank" href="{{url('get-reminder-record')}}?property_id={{$reminder->property_id}}&ref={{$reminder->reminder_of}}&active={{$reminder->add_by}}" type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" aria-describedby="tooltip401307"> <i class="mdi mdi-eye"></i></a></td>
                                                        </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
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
@section('extra-script')
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
@ednsection
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
<script>
  $(document).ready(function(){
    $('#mytable').DataTable();
    $('#myTable2').DataTable();
    $('#tabsdatatable').DataTable();
    $('#tabsdatatable1').DataTable();
    $('#tabsdatatable2').DataTable();
    $('#datatable-rem').DataTable();
  })

  $('.btn-sm').on('click', function(){
    $('.btn-sm').removeClass('active');
    $(this).addClass('active');
  })

$('.Upcoming-Reminders').on('click',function(){
  $('#home').css('display', 'block');
  $('#menu1').css('display', 'none');
  $('#menu2').css('display', 'none');
})
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
