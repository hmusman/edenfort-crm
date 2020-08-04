<!DOCTYPE html>

<!-- --------------------------------------------------------------------------------------- -->
<!-- --------------------------------------------NEW LOGIN PAGE----------------------------- -->
<!-- --------------------------------------------------------------------------------------- -->
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Edenfort Properties</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{url('public/logo.png')}}">

        <!-- Bootstrap Css -->
        <link href="{{url('public/Green/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{url('public/Green/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{url('public/Green/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        label[for="Email"]{
            margin-left: 56%;
        }
        label[for="Password"]{
            margin-left: 56%;
        }
    </style>
    </head>

    <body class="bg-primary bg-pattern">
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
        <!-- <div class="home-btn d-none d-sm-block">
            <a href="index.html"><i class="mdi mdi-home-variant h2 text-white"></i></a>
        </div> -->

        <div class="account-pages my-5" style="margin-top: 0px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <a href="#" class="logo"><img src="{{url('public/logo.png')}}" height="74" alt="logo"></a>
                            <h5 class="font-size-16 text-white-50 mb-4">CRM Edenfort Real Estate</h5>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-xl-5 col-sm-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="p-2">
                                    <h5 class="mb-5 text-center">Sign in to continue to CRM.</h5>
                                    <form class="form-horizontal" action="{{url('CheckLogin')}}" method="post" id="login_form">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(session('error'))
                                                    {!! session('error') !!}
                                                @endif
                                                <div class="form-group form-group-custom mb-4">
                                                    <input type="email" name="Email" class="form-control" id="Email" required value="{{ old('Email') }}">
                                                    <label for="username" class="ulabel">User Name</label>
                                                </div>

                                                <div class="form-group form-group-custom mb-4">
                                                    <input type="password" class="form-control" name="Password" id="Password" required>
                                                    <label for="userpassword" class="plabel">Password</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <!-- <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                            <label class="custom-control-label" for="customControlInline">Remember me</label>
                                                        </div> -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="text-md-right mt-3 mt-md-0">
                                                            <a href="{{url('forget-password')}}" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <input class="btn btn-success btn-block waves-effect waves-light" type="submit" name="login" class="btn btn-success" value="Login">
                                                </div>
                                                <!-- <div class="mt-4 text-center">
                                                    <a href="auth-register.html" class="text-muted"><i class="mdi mdi-account-circle mr-1"></i> Create an account</a>
                                                </div> -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end Account pages -->

        <!-- JAVASCRIPT -->
        <script src="{{url('public/Green/assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/node-waves/waves.min.js')}}"></script>

        <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

        <script src="{{url('public/Green/assets/js/app.js')}}"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
            <script type="text/javascript">
                    //validate password//
                    function validatePassword() {
                        var validator = $("#chngepass").validate({
                            rules: {
                                password: "required",
                                confirmpassword: {
                                    equalTo: "#password"
                                }
                            },
                            messages: {
                                password: " Enter Password",
                                confirmpassword: " Enter Confirm Password Same as Password"
                            }
                        });
                        if (validator.form()) {

                        }
                    }

            </script>
    </body>
</html>
