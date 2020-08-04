@include('../inc.header')
<style type="text/css">
    .dashboard-class,.logout-class{
        visibility: hidden;
    }
</style>
<body class="fix-header card-no-border logo-center">
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1>400</h1>
                <h3 class="text-uppercase">FORBIDDON ERROR!</h3>
                <p class="text-muted m-t-30 m-b-30">YOU DON'T HAVE PERMISSION TO ACCESS ON THIS SERVER</p>
                <a href="{{url('/')}}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a> </div>
        </div>
    </section>
    @include('../inc.footer')
</body>
</html>
