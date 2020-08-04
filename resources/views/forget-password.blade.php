<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Recover Password | Edenfort CRM</title>
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

    </head>

    <body class="bg-primary bg-pattern" style="overflow-y: hidden;">

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
        <div class="account-pages my-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <a href="index.html" class="logo"><img src="{{url('public/logo.png')}}" height="74" alt="logo"></a>
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
                                    <h5 class="mb-5 text-center">Forget Password</h5>
                                    <form class="form-horizontal" action="{{url('reset-password')}}" method="post" id="reset-password-form">
                                         @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(session('error'))
                                                    {!! session('error') !!}
                                                @endif
                                                <div class="alert alert-warning alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    Enter your <b>Email</b> and instructions will be sent to you!
                                                </div>

                                                <div class="form-group form-group-custom mt-5">
                                                    <input type="email" class="form-control" id="useremail" name="email" required>
                                                    <label for="useremail">Email</label>
                                                </div>
                                                <div class="mt-4">
                                                    <input  class="btn btn-success btn-block waves-effect waves-light" type="submit" name="login" class="btn btn-success" value="Reset Password">
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </form>
                                    <div class="mt-3" style="text-align: center;">
                                        <a href="{{url('/')}}" title="">Return Back to Login</a>
                                    </div>
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
        <script src="{{url('pubic/Green/assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{url('pubic/Green/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url('pubic/Green/assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{url('pubic/Green/assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{url('pubic/Green/assets/libs/node-waves/waves.min.js')}}"></script>

        <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>


        <script src="{{url('pubic/Green/assets/js/app.js')}}"></script>

    </body>
</html>
