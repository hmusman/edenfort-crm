<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- Favicon icon -->
      <link rel="icon" type="image/png" sizes="16x16" href="{{url('public/logo.png')}}">
      <title>Edenfort Properties</title>
      <!-- Bootstrap Core CSS -->
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="{{url('public/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
      <!-- Footable CSS -->
      <link href="{{url('public/assets/plugins/footable/css/footable.core.css')}}" rel="stylesheet">
      <link href="{{url('public/assets/plugins/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
      <link href="{{url('public/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
      <!-- Custom CSS -->
      <link href="{{url('public/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
      <!-- Page plugins css -->
      <link href="{{url('public/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">
      <!-- Color picker plugins css -->
      <link href="{{url('public/assets/plugins/jquery-asColorPicker-master/css/asColorPicker.css')}}" rel="stylesheet">
      <!-- Date picker plugins css -->
      <link href="{{url('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
      <!-- Daterange picker plugins css -->
      <link href="{{url('public/assets/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
      <link href="{{url('public/assets/css/style.css')}}" rel="stylesheet">
      <link href="{{url('public/assets/css/myStyle.css')}}" rel="stylesheet" >
      <!-- You can change the theme colors from here -->
      <link href="{{url('public/assets/css/colors/blue.css')}}" id="theme" rel="stylesheet">
      <link rel="stylesheet" href="{{url('public/choosen//prism.css')}}">
      <link rel="stylesheet" href="{{url('public/choosen/chosen.css')}}">
      <link href="{{url('public/assets/css/coldCalling.css')}}" rel="stylesheet" >
      <!-- morris CSS -->
      <link href="{{url('public/assets/plugins/morrisjs/morris.css')}}" rel="stylesheet">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

      <!--
         <link href="{{url('public/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
         Custom CSS 
         <link href="{{url('public/assets/css/style.css')}}" rel="stylesheet">
         You can change the theme colors from here 
         <link href="{{url('public/assets/css/colors/blue.css')}}" id="theme" rel="stylesheet">-->
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <style>
         .sidebar-nav #sidebarnav > li{
         text-align:center;
         }
         .sidebar-nav ul li a{
         padding:0px 10px;
         }
         .scroll-sidebar{
         padding:15px;
         }
         .sidebar-nav ul li ul{
         top:45px;
         }
         .sidebar-nav #sidebarnav>li>ul{
         text-align:start;
         }
      </style>
   </head>
   <body class=" card-no-border logo-center">
      <div id="main-wrapper" >
      <header class="topbar"  >
         <nav class="navbar  navbar navbar-fixed-top top-navbar navbar-expand-md navbar-light" style="
            height: 20px !important; ">
            <div class="navbar-header">
               <a class="navbar-brand" href="{{url('/')}}">
                  <img src="{{url('public/logo.png')}}" alt="homepage" class="dark-logo"/>
                  <img src="{{url('public/logo.png')}}" alt="homepage"  height="60px" />
               </a>
            </div>
            <ul class="navbar-nav my-lg-0">
               <li style="position: absolute;right: 0px;top: 5px;">
                  <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{url('public/assets/images/users/dumy.jpg'
                     )}}" alt="user" class="profile-pic" />
                  </a>     
                  <div class="dropdown-menu dropdown-menu-right scale-up">
                     <ul class="dropdown-user">
                        <li>
                           <div class="dw-user-box">
                              <div class="u-img"><img src="{{url('public/assets/images/users/dumy.jpg'
                                 )}}" alt="user" class="profile-pic" /></div>
                              <div class="u-text">
                                 <h4>{{@session('user_name')}}</h4>
                                 <p class="text-muted">
                                    {{@session('email')}}
                                 </p>
                              </div>
                           </div>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#" data-toggle="modal" data-target="#exampleModalPassword" data-whatever="@mdo"><i class="ti-settings"></i> Change Password</a></li>
                        <li><a href="{{url('logout')}}"><i class="fa fa-power-off"></i> Logout</a></li>
                     </ul>
                  </div>
               </li>
            </ul>
         </nav>
      </header>
      @if(ucfirst(session('role'))!=ucfirst('owner'))  
      <div class="scroll-sidebar row" >
         <nav class="sidebar-nav " style="background: white !important; float: none;
            margin: 0 auto; ">
            <ul id="sidebarnav">
               @if(ucfirst(session('role'))==ucfirst('Agent'))        
                    
                        <li> <a class="has-arrow waves-effect waves-dark" href="{{url('/agentdashboard')}}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                       </li>
                    
                    @if(@$permissions->propertyView==1)        
                        <li>
                      <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-book-open-variant"></i><span class="hide-menu">Properties</span></a>
                      <ul aria-expanded="false" class="collapse" style="margin-top:-23px;">
                         <li><a href="{{url('allAddedProperties')}}">
                            Registrations</a>
                         </li>
                         <li><a href="{{url('allAddedProperties')}}?type=For Sale">Sale</a></li>
                         <li><a href="{{url('allAddedProperties')}}?type=For Rent">Rent</a></li>
                         <li><a href="{{url('allAddedProperties')}}?type=upcoming">Upcoming</a></li>
                      </ul>
                    </li>
                    @endif
                   @if(@$permissions->buildingView==1)        
                   <li> <a class="has-arrow waves-effect waves-dark" href="{{url('agent-buildings')}}" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Buildings</span></a>
                   </li>
                   @endif
                   @if(@$permissions->coldcallingView==1) 
                   <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('agentColdCalling')}}" aria-expanded="false"><i class="mdi mdi-widgets"></i><span class="hide-menu">Cold Calling</span></a>
                   </li>
                   @endif
                   @if(@$permissions->leadView==1) 
                   <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('/leads')}}" aria-expanded="false"><i class="mdi mdi-chart-scatterplot-hexbin"></i><span class="hide-menu">Leads</span></a>
                   </li>
                   @endif
                   @if(@$permissions->supervisionView==1)
                   <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('/supervision')}}" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu">Supervisions</span></a>
                   </li>
                   @endif
                   @if(@$permissions->dealView==1) 
                   <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('/dealsInfo')}}" aria-expanded="false"><i class="mdi mdi-chart-scatterplot-hexbin"></i><span class="hide-menu">Deals</span></a>
                   </li>
                   @endif
                   @if(@\App\Models\permission::permissions()->loanView == 1) 
                        <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('/loans')}}" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu"> Loans</span></a>
                        </li>
                    @endif
               @elseif(ucfirst(session('role'))==ucfirst('admin'))          
                   <li> <a class="has-arrow waves-effect waves-dark" href="{{url('/')}}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><br><span class="hide-menu">Dashboard</span></a>
                   </li>
                   <li>
                      <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-home-outline"></i><br><span class="hide-menu">Properties</span></a>
                      <ul aria-expanded="false" class="collapse">
                         <li><a href="{{url('property')}}">
                            Registrations</a>
                         </li>
                         <li><a href="{{url('property')}}?type=For Rent">Rent</a></li>
                         <li><a href="{{url('property')}}?type=For Sale">Sale</a></li>
                         <li><a href="{{url('property')}}?type=upcoming">Upcoming</a></li>
                      </ul>
                   </li>
                   <li>
                      <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-window-open"></i><br><span class="hide-menu">Add & Assign</span></a>
                      <ul aria-expanded="false" class="collapse" style="margin-top:5px;">
                         <li><a href="{{url('assignAgent')}}">Assign Coldcalling</a></li>
                         <li><a href="{{url('buildings')}}">Building</a></li>
                      </ul>
                   </li>
                   <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('coldCalling')}}" aria-expanded="false"><i class="mdi mdi-phone"></i><br><span class="hide-menu">Cold Calling</span></a>
                   </li>
               @endif
               @if(ucfirst(session('role'))==ucfirst('admin'))
                   <li>
                      <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-home-outline"></i><br><span class="hide-menu">Users</span></a>
                      <ul aria-expanded="false" class="collapse">
                         <li><a href="{{url('admins')}}">Users</a></li>
                         <li><a href="{{url('AgentActivity')}}?type=For Rent">Agent Activities</a></li>
                      </ul>
                   </li>
                   <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('/supervision')}}" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><br><span class="hide-menu">Supervisions</span></a>
                   </li>
                   <li>
                      <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-home-outline"></i><br><span class="hide-menu">Deals</span></a>
                      <ul aria-expanded="false" class="collapse">
                         <li><a href="{{url('dealsInfo')}}">Deals</a></li>
                         <li><a href="{{url('get-months-deals')}}?type=For Rent">Recent Deals</a></li>
                      </ul>
                   </li>
                   <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('/agentLead')}}" aria-expanded="false"><i class="mdi mdi-chart-areaspline"></i><br><span class="hide-menu">Leads</span></a>
                   </li>
                   </li>
                   <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('/loans')}}" aria-expanded="false"><i class="mdi mdi-coin"></i><br><span class="hide-menu">Loans</span></a>
                   </li>
                   <li>
                      <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-home-outline"></i><br><span class="hide-menu">Setup</span></a>
                      <ul aria-expanded="false" class="collapse">
                         <li><a href="{{url('submittedProperties')}}">Requests</a></li>
                         <li><a href="{{url('permission')}}?type=For Rent">Permission</a></li>
                         <li><a href="{{url('months')}}?type=For Rent">Months</a></li>
                         <li><a href="{{url('email-templates')}}?type=For Rent">Email Templates</a></li>
                      </ul>
                   </li>
                   <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('/backup')}}" aria-expanded="false"><i class="mdi mdi-disk"></i><br><span class="hide-menu">Backups</span></a>
                   </li>
                   <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('direct-pdf-report')}}" aria-expanded="false"><i style="padding-bottom: 5px;padding-top: 8px;font-size: 15px;font-weight: bold;" class="fa fa-file-pdf-o"></i><br><span class="hide-menu">Direct Report</span></a>
                   </li>
               @endif
               <!--superAgent-->
               @if(ucfirst(session('role'))==ucfirst('SuperAgent'))
                       <li> <a class="has-arrow waves-effect waves-dark" href="{{url('/dashboard')}}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a>
                       </li>
                   @if(@$permissions->propertyView==1)               
                       <li >
                          <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-home-outline"></i><span class="hide-menu">Properties</span></a>
                          <ul aria-expanded="false" class="collapse" style="margin-top:-23px;">
                             <li><a href="{{url('property')}}">
                                Registrations</a>
                             </li>
                             <li><a href="{{url('property')}}?type=For Rent">Rent</a></li>
                             <li><a href="{{url('property')}}?type=For Sale">Sale</a></li>
                             <li><a href="{{url('property')}}?type=upcoming">Upcoming</a></li>
                          </ul>
                       </li>
                   @endif
                   @if(@$permissions->coldcallingView==1) 
                       <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('agentColdCalling')}}" aria-expanded="false"><i class="mdi mdi-phone"></i><span class="hide-menu">Cold Calling</span></a>
                       </li>
                   @endif
                   @if(@$permissions->buildingView==1)        
                       <li> <a class="has-arrow waves-effect waves-dark" href="{{url('agent-buildings')}}" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Buildings</span></a>
                       </li>
                   @endif
                   @if(@$permissions->supervisionView==1)
                       <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('/supervision')}}" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu">Supervisions</span></a>
                       </li>
                   @endif
                    @if(@$permissions->dealView==1) 
                        <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('/dealsInfo')}}" aria-expanded="false"><i class="mdi mdi-chart-scatterplot-hexbin"></i><span class="hide-menu">Deals</span></a>
                        </li>
                    @endif
                    @if(@$permissions->leadView==1) 
                       <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('/agentLead')}}" aria-expanded="false"><i class="mdi mdi-chart-areaspline"></i><span class="hide-menu">Leads</span></a>
                       </li>
                    @endif
                    @if(@\App\Models\permission::permissions()->loanView == 1)
                        <li class="three-column"> <a class="has-arrow waves-effect waves-dark" href="{{url('/loans')}}" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu"> Loans</span></a>
                        </li>
                    @endif
               @endif
            </ul>
         </nav>
      </div>
      @if(ucwords(session('role'))==ucwords('admin') || ucwords(session('role'))==ucwords('agent')  || ucwords(session('role'))==ucwords('SuperAgent'))
      <div>
         <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><span class="badge notification_counter">0</span><i class="fa fa-bell text-white"></i></button>
      </div>
      @endif
      <div class="modal fade" id="exampleModalPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalLabel1">Change your Password</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <div class="modal-body">
                  <form id="chngepass" method="post" action="{{url('change-password')}}">
                     {{ csrf_field() }}
                     <input type="hidden" name="" id="user_id" value="{{@session('user_id')}}">
                     <div class="form-group">
                        <label for="recipient-name" class="control-label">Current Password</label>
                        <input type="password" name="currentPassword" class="form-control" required="" id="current_Password">
                     </div>
                     <div class="form-group">
                        <label for="message-text" class="control-label">New Password</label>
                        <input type="password"  id="password" name="newPassword" class="form-control" required="">
                     </div>
                     <div class="form-group">
                        <label for="message-text" class="control-label">Confirm Password</label>
                        <input type="password"  name="confirmpassword" id="confirmpassword" class="form-control" required="">
                     </div>
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <input type="submit" value="Update" name="changePassword" class="btn btn-primary" onclick="validatePassword()">
                  </form>
               </div>
               <div class="modal-footer">
               </div>
            </div>
         </div>
      </div>
      @endif