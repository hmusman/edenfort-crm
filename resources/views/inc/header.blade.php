<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>CRM Edenfort Properties</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{url('public/logo.png')}}">

        <!-- datepicker -->
        <link href="{{url('public/Green/assets/libs/air-datepicker/css/datepicker.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- jvectormap -->
        <link href="{{url('public/Green/assets/libs/jqvmap/jqvmap.min.css')}}" rel="stylesheet" />

        <!-- Bootstrap Css -->
        <link href="{{url('public/Green/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{url('public/Green/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{url('public/Green/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
         <!-- DataTables -->
        <link href="{{url('public/Green/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/Green/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- alertifyjs Css -->
        <link href="{{url('public/Green/assets/libs/alertifyjs/build/css/alertify.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- alertifyjs default themes  Css -->
        <link href="{{url('public/Green/assets/libs/alertifyjs/build/css/themes/default.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        
        @yield('extra-links')
        <style>
          @media (max-width: 550px){
            .right-bar {
                width: 286px !important;
            }
          }
          @if(isset($ownerDetails))
          .owner-nav-item{
            padding:  0px 92px 0px 92px;
          }
          .owner-nav-link i{
            margin-top: 11px;
            font-size: 24px;
            background: #97d4be;
            padding: 14px 16px;
            border-radius: 50%;
            color: #2fa97c;
          }
          @endif
          @if(ucfirst(session('role')) == ucfirst('SuperDuperAdmin'))
            .nav-link{
              font-size: 13px !important;
            }
          @endif
          .notification_link{
            color: white;
          }
          .close_noti{
            float: right;
            margin-top: -10px;
          }
          .right-bar{
            width: 350px;
            right: -350px;
          }
          .notification{
                background-color: #2fa97c;
                color: white;
                padding: 20px;
                border-radius: 10px;
                margin-bottom: 4px;
          }
          .avatar{
              line-height: 48px;
              color: black;
              width: 52px;
              height: 52px;
              display: inline-block;
              font-weight: 700;
              text-align: center;
              border-radius: 100%;
              /*background: #2fa97c;*/
              font-size: 13px;
          }
          .avatar_name{
                color: white;
          }
          .avatar_count{
            color: white;
            padding-left: 10px;
            font-weight: bold;
          }
          .topnav .navbar-nav .nav-link {
            font-size: 13px;
            position: relative;
            padding: 0 10px;
            color: #7c8a96;
            line-height: 70px;
          }
          body[data-layout=horizontal] .navbar-brand-box {
              float: left;
              background-color: transparent;
              padding-left: 0;
              padding-right: 0px;
              margin-left: -20px;
          }
          .arrow-down {
              display: inline-block;
              margin-left: -6px;
          }
          .right-navPart-setting {
              float: right!important;
              margin-right: -30px;
          }
          .right-bar .rightbar-nav-tab .nav-item .nav-link {
              background-color: #fff;
              border: none;
              text-decoration: none !important;
              text-align: left;
          }
          .reminders{
              height: 2rem;
              width: 2rem;
              line-height: calc(2rem - 2px);
              display: block;
              border: 1px solid #ffffff;
              border-radius: 50%;
              color: #ffffff;
              text-align: center;
              margin-right: -3px;
          }
          @media (min-width: 1900px){
            body[data-layout=horizontal] .container-fluid {
                  margin-left: auto;
            }
          }
        </style>
    </head>

    <body data-topbar="colored" data-layout="horizontal" data-layout-size="boxed">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="container-fluid">
                        <div class="float-right right-navPart-setting">
                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                                  @if(ucwords(session('role'))==ucwords('admin') || ucwords(session('role'))==ucwords('agent')  || ucwords(session('role'))==ucwords('SuperAgent') || ucwords(session('role'))==ucfirst('SuperDuperAdmin'))
                                    <div>
                                        <i class="mdi mdi-bell-outline reminders"></i>
                                        <span class="badge badge-pill badge-success notification_counter">0</span>
                                    </div>
                                    @endif
                                </button>
                            </div>



                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="rounded-circle header-profile-user" src="{{url('public/assets/images/users/dumy.jpg')}}" alt="Header Avatar">
                                    <span class="d-none d-sm-inline-block ml-1">{{@session('user_name')}}</span>
                                    <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <div class="dropdown-item">
                                      <h4>{{strtoupper(@session('user_name'))}}</h4>
                                      <p>{{@session('email')}}</p>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModalPassword" data-whatever="@mdo"><i class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i>Change Password</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{url('logout')}}"><i class="mdi mdi-logout font-size-16 align-middle mr-1"></i> Logout</a>
                                </div>
                            </div>
                        </div>

                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="{{url('/')}}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{url('public/logo.png')}}" alt="" height="20">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{url('public/logo.png')}}" alt="" height="40">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm mr-2 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <div class="topnav">
                            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                                <div class="collapse navbar-collapse" id="topnav-menu-content">
                                    <ul class="navbar-nav">
                                    @if(ucfirst(session('role'))==ucfirst('Agent'))
                                    @if(@$permissions->propertyView==1)
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('/agentdashboard')}}">
                                                Dashboard
                                            </a>
                                        </li>
                                    @endif
                                    @if(@$permissions->propertyView==1)
                                      <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Properties <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu px-2" aria-labelledby="topnav-uielement">
                                          <div class="row">
                                            <div class="col-lg-8">
                                              <a href="{{url('allAddedProperties')}}" class="dropdown-item">Registrations</a>
                                              <a href="{{url('allAddedProperties')}}?type=For Sale" class="dropdown-item">Sale</a>
                                              <a href="{{url('allAddedProperties')}}?type=For Rent" class="dropdown-item">Rent</a>
                                              <a href="{{url('allAddedProperties')}}?type=upcoming" class="dropdown-item">Upcoming</a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                    @endif
                                    @if(@$permissions->buildingView==1)
                                      <li class="nav-item">
                                          <a class="nav-link" href="{{url('agent-buildings')}}">
                                              Buildings
                                          </a>
                                      </li>
                                    @endif
                                    @if(@$permissions->coldcallingView==1)
                                      <li class="nav-item">
                                          <a class="nav-link" href="{{url('agentColdCalling')}}">
                                              Cold Calling
                                          </a>
                                      </li>
                                    @endif
                                    @if(@$permissions->leadView==1)
                                      <li class="nav-item">
                                          <a class="nav-link" href="{{url('/leads')}}">
                                              Leads
                                          </a>
                                      </li>
                                    @endif
                                    @if(@$permissions->supervisionView==1)
                                      <li class="nav-item">
                                          <a class="nav-link" href="{{url('/supervision')}}">
                                              Supervisions
                                          </a>
                                      </li>
                                    @endif
                                    @if(@$permissions->dealView==1)
                                      <li class="nav-item">
                                          <a class="nav-link" href="{{url('/dealsInfo')}}">
                                              Deals
                                          </a>
                                      </li>
                                    @endif
                                    @if(@\App\Models\permission::permissions()->loanView == 1) 
                                      <li class="nav-item">
                                          <a class="nav-link" href="{{url('/loans')}}">
                                              Loans
                                          </a>
                                      </li>
                                    @endif
                                    @elseif(ucfirst(session('role'))==ucfirst('admin') || ucfirst(session('role'))==ucfirst('SuperDuperAdmin'))
                                      <li class="nav-item">
                                            <a class="nav-link" href="{{url('/dashboard')}}">
                                                Dashboard
                                            </a>
                                      </li>
                                      <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Properties <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-mega-menu-xl px-2" aria-labelledby="topnav-uielement" style="width: auto;">
                                          <div class="row">
                                            <div class="col-lg-4">
                                              <a href="{{url('property')}}" class="dropdown-item">Registrations</a>
                                              <a href="{{url('property')}}?type=For Sale" class="dropdown-item">Sale</a>
                                              <a href="{{url('property')}}?type=For Rent" class="dropdown-item">Rent</a>
                                              <a href="{{url('property')}}?type=upcoming" class="dropdown-item">Upcoming</a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Add & Assign <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-mega-menu-xl px-2" aria-labelledby="topnav-uielement" style="width: auto;">
                                          <div class="row">
                                            <div class="col-lg-4">
                                              <a href="{{url('assignAgent')}}" class="dropdown-item">Assign Coldcalling</a>
                                              <a href="{{url('buildings')}}" class="dropdown-item">Building</a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="nav-item">
                                            <a class="nav-link" href="{{url('coldCalling')}}">
                                                Cold Calling
                                            </a>
                                      </li>
                                    @if(ucfirst(session('role'))==ucfirst('SuperDuperAdmin'))
                                      <li class="nav-item">
                                            <a class="nav-link" href="{{url('agent-buildings')}}">
                                                Buildings
                                            </a>
                                      </li>
                                    @endif
                                    @endif
                                    @if(ucfirst(session('role'))==ucfirst('admin') || ucfirst(session('role'))==ucfirst('SuperDuperAdmin'))
                                      <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Users <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-mega-menu-xl px-2" aria-labelledby="topnav-uielement" style="width: auto;">
                                          <div class="row">
                                            <div class="col-lg-4">
                                              <a href="{{url('admins')}}" class="dropdown-item">Users</a>
                                              <a href="{{url('AgentActivity')}}?type=For Rent" class="dropdown-item">Agent Activities</a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="nav-item">
                                            <a class="nav-link" href="{{url('/supervision')}}">
                                                Supervisions
                                            </a>
                                      </li>
                                      <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Deals <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-mega-menu-xl px-2" aria-labelledby="topnav-uielement" style="width: auto;">
                                          <div class="row">
                                            <div class="col-lg-4">
                                              <a href="{{url('dealsInfo')}}" class="dropdown-item">Deals</a>
                                              <a href="{{url('get-months-deals')}}?type=For Rent" class="dropdown-item">Recent Deals</a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="nav-item">
                                            <a class="nav-link" href="{{url('/agentLead')}}">
                                                Leads
                                            </a>
                                      </li>
                                      <li class="nav-item">
                                            <a class="nav-link" href="{{url('/loans')}}">
                                                Loans
                                            </a>
                                      </li>
                                      <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Setup <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-mega-menu-xl px-2" aria-labelledby="topnav-uielement" style="width: auto;">
                                          <div class="row">
                                            <div class="col-lg-4">
                                              <a href="{{url('submittedProperties')}}" class="dropdown-item">Requests</a>
                                              <a href="{{url('permission')}}?type=For Rent" class="dropdown-item">Permission</a>
                                              <a href="{{url('months')}}?type=For Rent" class="dropdown-item">Months</a>
                                              <a href="{{url('email-templates')}}?type=For Rent" class="dropdown-item">Email Templates</a>
                                              <a href="{{route('troubleshooting.index')}}" class="dropdown-item">TroubleShooting</a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="nav-item">
                                            <a class="nav-link" href="{{url('/backup')}}">
                                                Backups
                                            </a>
                                      </li>
                                      <li class="nav-item">
                                            <a class="nav-link" href="{{url('direct-pdf-report')}}">
                                                Direct Report
                                            </a>
                                      </li>
                                    @endif
                                    @if(ucfirst(session('role'))==ucfirst('SuperAgent'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{url('/dashboard')}}">
                                            Dashboard
                                        </a>
                                    </li>
                                    @if(@$permissions->propertyView==1)
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Properties <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-mega-menu-xl px-2" aria-labelledby="topnav-uielement" style="width: auto;">
                                          <div class="row">
                                            <div class="col-lg-4">
                                              <a href="{{url('property')}}" class="dropdown-item">Registrations</a>
                                              <a href="{{url('property')}}?type=For Sale" class="dropdown-item">Sale</a>
                                              <a href="{{url('property')}}?type=For Rent" class="dropdown-item">Rent</a>
                                              <a href="{{url('property')}}?type=upcoming" class="dropdown-item">Upcoming</a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                    @endif
                                    @if(@$permissions->coldcallingView==1)
                                     <li class="nav-item">
                                        <a class="nav-link" href="{{url('coldCalling')}}">
                                            Cold Calling
                                        </a>
                                    </li>
                                    @endif
                                    @if(@$permissions->buildingView==1)
                                     <li class="nav-item">
                                        <a class="nav-link" href="{{url('agent-buildings')}}">
                                            Buildings
                                        </a>
                                    </li>
                                    @endif
                                    @if(@$permissions->supervisionView==1)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{url('/supervision')}}">
                                            Supervisions
                                        </a>
                                    </li>
                                    @endif
                                    @if(@$permissions->dealView==1) 
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{url('/dealsInfo')}}">
                                            Deals
                                        </a>
                                    </li>
                                    @endif
                                    @if(@$permissions->leadView==1) 
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{url('/agentLead')}}">
                                            Leads
                                        </a>
                                    </li>
                                    @endif
                                    @if(@\App\Models\permission::permissions()->loanView == 1)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{url('/loans')}}">
                                            Loans
                                        </a>
                                    </li>
                                    @endif
                                    @endif
                                    @if(isset($ownerDetails))
                                    <li class="nav-item owner-nav-item">
                                      <a class="nav-link owner-nav-link active" href="#">
                                        <i class="fa fa-user details-icons" style="font-size:24px"></i>
                                        <label>&nbsp;{{$ownerDetails->First_name}} {{$ownerDetails->Last_name}}</label>
                                      </a>
                                    </li>
                                    <li class="nav-item owner-nav-item">
                                      <a class="nav-link owner-nav-link active" href="#">
                                        <i class="fa fa-envelope details-icons" style="font-size:24px"></i>
                                        <label>&nbsp;{{$ownerDetails->Email}}</label>
                                      </a>
                                    </li>
                                    <li class="nav-item owner-nav-item">
                                      <a class="nav-link owner-nav-link active" href="#">
                                       <i class="fa fa-phone details-icons" style="font-size:24px"></i>
                                       <label>&nbsp;{{$ownerDetails->Phone}}</label>
                                      </a>
                                    </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{url('/agent_troubleshoot')}}">
                                            TroubleShooting
                                        </a>
                                    </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>

            
            </header>
