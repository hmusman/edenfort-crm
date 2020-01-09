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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header card-no-border logo-center">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div> -->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
              <!--  <a class="has-arrow waves-effect waves-dark dashboard-class" href="{{url('/')}}" aria-expanded="false"><i class="fa fa-home" style="width: 20px;"></i><span class="hide-menu">Dashboard</span></a>-->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{url('/')}}">
                        <!-- Logo icon -->
                        <b>
                            <!-- Dark Logo icon -->
                            <img src="{{url('public/logo.png')}}" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{url('public/logo.png')}}" alt="homepage"  height="60px" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <!--<span>-->
                             <!-- dark Logo text -->
                        <!--     <img src="{{url('public/logo.png')}}" alt="homepage" class="dark-logo" />-->
                             <!-- Light Logo text -->    
                        <!--     <img src="{{url('public/logo.png')}}" class="light-logo" alt="homepage" />-->
                        <!--</span> -->
                    </a>
                </div>
             
                
            </nav>
            
            
            
        
    </header>
        @if(ucwords(session('role'))==ucwords('admin') || ucwords(session('role'))==ucwords('agent'))
            <div class="">
                <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><span class="badge notification_counter">0</span><i class="fa fa-bell text-white"></i></button>
            </div>
        @endif
        </header>

@if(session("user_id"))
    @if(ucfirst(session('role'))==ucfirst('Admin'))
        <script type="text/javascript">
            window.location='{{url("/dashboard")}}';
        </script>
        <?php redirect('/dashboard'); ?>
    @endif
    @if(ucfirst(session('role'))==ucfirst('owner'))
        <script type="text/javascript">
            window.location='{{url("/ownerdashboard")}}';
        </script>
        <?php redirect('/ownerdashboard'); ?>
    @endif
     @if(ucfirst(session('role'))==ucfirst('agent'))
        <script type="text/javascript">
            window.location='{{url("/agentdashboard")}}';
        </script>
        <?php redirect('/agentdashboard'); ?>
    @endif
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additionalLogin.css')}}">
            <div class="container-fluid" style="margin-top: 4%;">
                <h3>Login</h3>
                 <form action="{{url('CheckLogin')}}" method="post" id="login_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            @if(session('error'))
                                {!! session('error') !!}
                            @endif
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Email</label>
                                <input type="email" class="form-control" name="Email" placeholder="Email" required="" value="{{ old('Email') }}">
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Password</label>  
                                <input type="password" class="form-control" name="Password" placeholder="Password" required="">
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-2" style="padding:0px;">
                                <input type="submit" name="login" class="btn btn-success" value="Login">
                            </div>
                            <div class="col-md-2" style="text-align:end !Important;"><strong><a href="{{url('forget-password')}}">Forget Password ?</a></strong></div>
                        </div>
                    </div>
                </form>                           
            </div>    
 @include('inc.footer')
<script type="text/javascript">
    $(document).ready(function(){
        $("#login_form").validate();
    })
</script>
    </body>
</html>