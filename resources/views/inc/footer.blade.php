            @if(ucwords(session('role'))==ucwords('admin') || ucwords(session('role'))==ucwords('agent') || ucwords(session('role'))==ucwords('SuperAgent'))  
                     <div class="right-sidebar">
                        <div class="slimscrollright">
                            <div class="rpanel-title">Reminders<span><i class="ti-close right-side-toggle"></i></span> </div>
                            <div class="r-panel-body">
                                <div class="row notification_bucket">
                                                                        
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
  <script
  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script>
    <script src="{{url('public/assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{url('public/notify.min.js')}}"></script>
    <script src="{{url('public/notify.js')}}"></script>
    <script src="{{url('public/assets/plugins/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{url('public/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{url('public/assets/js/custom.min.js')}}"></script>
   <script src="{{url('public/assets/plugins/moment/moment.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{url('public/assets/js/jquery.slimscroll.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{url('public/assets/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{url('public/assets/js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{url('public/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <script src="{{url('public/assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <!--Custom JavaScript -->
    <!--  -->    <script src="{{url('public/choosen/chosen.jquery.js')}}" type="text/javascript"></script>
<script src="{{url('public/choosen/prism.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{url('public/choosen/init.js')}}" type="text/javascript" charset="utf-8"></script>
    <!-- Footable -->
    <script src="{{url('public/assets/plugins/footable/js/footable.all.min.js')}}"></script>
    <script src="{{url('public/assets/plugins/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <!--FooTable init-->
    <script src="{{url('public/assets/js/footable-init.js')}}"></script>
    <script src="{{url('public/assets/js/myJQuery.js')}}"></script>
        <script src="{{url('public/assets/plugins/icheck/icheck.min.js')}}"></script>
    <script src="{{url('public/assets/plugins/icheck/icheck.init.js')}}"></script>
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
 <script type="text/javascript" src="{{url('public/reminder.js')}}"></script>
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
