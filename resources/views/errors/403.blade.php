<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>403 Error | Edenfort CRM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{url('public/logo.png')}}">

        <!-- Bootstrap Css -->
        <link href="{{url('public/Green/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{url('public/Green/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{url('public/Green/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

    </head>

    <body class="bg-primary bg-pattern">

        <div class="account-pages pt-sm-5">
            <div class="container">
                
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <div class="row justify-content-center">
                                <div class="col-md-4 col-6">
                                    <img src="{{('public/Green/assets/images/error-img.png')}}" alt="" class="img-fluid mx-auto d-block">
                                </div>
                            </div>
    
                            <h1 class="mt-5 text-uppercase text-white font-weight-bold mb-3">FORBIDDON ERROR!</h1>
                            <h5 class="text-white-50">YOU DON'T HAVE PERMISSION TO ACCESS THIS PAGE.</h5>
                            <div class="mt-5">
                                @if(!session("user_id"))
                                <a class="btn btn-success waves-effect waves-light" href="{{url('/')}}">Back to Home</a>
                                @else
                                <a class="btn btn-success waves-effect waves-light" href="{{url('/')}}">Back to Dashboard</a>
                                @endif
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


        <script src="assets/js/app.js"></script>

    </body>
</html>
