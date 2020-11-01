 
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                2020 © Edenfort Real Estate.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-right d-none d-sm-block">
                                    Crafted with <i class="mdi mdi-heart text-danger"></i> by DevsBeta
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->
<div class="modal fade" id="exampleModalPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="z-index: 1100;">
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
 <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
    
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom rightbar-nav-tab nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link py-3 active" data-toggle="tab" href="#chat-tab" role="tab" style="font-size: 22px;">
                            <i class="mdi mdi-timeline-clock-outline font-size-22 mr-3"></i>
                            Reminders
                        </a>
                    </li>
                </ul>
                @if(ucwords(session('role')) == ucwords('admin') || ucwords(session('role')) == ucwords('SuperAgent') || ucfirst(session('role')) == ucfirst('SuperDuperAdmin'))
                <!-- Tab panes -->
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="chat-tab" role="tabpanel">
                        <div class="p-2 notify">
                        </div>
                    </div>
                </div>
                @endif
                @if(ucwords(session('role')) == ucwords('agent')) 
                <!-- Tab panes -->
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="chat-tab" role="tabpanel">
                        <div class="p-2 notification_bucket">
                        </div>
                    </div>
                </div>
                @endif
            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{url('public/Green/assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
        @yield('extra-script')
        <script src="{{url('public/Green/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/node-waves/waves.min.js')}}"></script>

        <!-- <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script> -->

        <!-- datepicker -->
        <script src="{{url('public/Green/assets/libs/air-datepicker/js/datepicker.min.js')}}"></script>
        <script src="{{url('public/Green/assets/libs/air-datepicker/js/i18n/datepicker.en.js')}}"></script>

        <!-- apexcharts -->
        <script src="{{url('public/Green/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <script src="{{url('public/Green/assets/libs/jquery-knob/jquery.knob.min.js')}}"></script> 

        <!-- Jq vector map -->
        <!-- <script src="{{url('public/Green/assets/libs/jqvmap/jquery.vmap.min.js')}}"></script> -->
        <!-- <script src="{{url('public/Green/assets/libs/jqvmap/maps/jquery.vmap.usa.js')}}"></script> -->
        <!-- alertifyjs js -->
        <script src="{{url('public/Green/assets/libs/alertifyjs/build/alertify.min.js')}}"></script>

        <script src="{{url('public/Green/assets/js/pages/alertifyjs.init.js')}}"></script>
        <!-- <script src="{{url('public/Green/assets/js/pages/dashboard.init.js')}}"></script> -->

        <script src="{{url('public/Green/assets/js/app.js')}}"></script>
        <!-- <div class="alertify-notifier ajs-top ajs-right"></div> -->

        <script>
            function select(n){var e=$("#"+n).text();$("#owneremail").val(e),$("#owneremail").html(e),$("#suggesstion-box").css("display","none"),$.ajax({type:"POST",url:"{{url('/readdata')}}",data:{_token:"{{ csrf_token() }}",email:e},beforeSend:function(){$(".spin").css("display","block")},success:function(n){$("#ownername").val(n.LandLord),$("#ownername").html(n.LandLord),$("#ownerphone").val(n.contact_no),$("#ownerphone").html(n.contact_no),$(".spin").css("display","none")}})}$(document).ready(function(){$("#owneremail").keyup(function(){var n=$(this).val();$(this).val()?$.ajax({type:"POST",url:"{{url('/reademail')}}",data:{_token:"{{ csrf_token() }}",keyword:n},beforeSend:function(){$(".spin").css("display","block")},success:function(n){n.length>0&&($("#suggesstion-box").css("display","block"),$("#suggesstion-box").html(n)),$(".spin").css("display","none")}}):$("#suggesstion-box").css("display","none")})});
        </script>
        <script>
           function selectName(n){var e=$("#"+n).text();$("#ownername").val(e),$("#ownername").html(e),$("#name-suggesstion-box").css("display","none"),$.ajax({type:"POST",url:"{{url('/readnameData')}}",data:{_token:"{{ csrf_token() }}",LandLord:e},beforeSend:function(){$(".spin1").css("display","block")},success:function(n){$("#owneremail").val(n.email),$("#owneremail").html(n.email),$("#ownerphone").val(n.contact_no),$("#ownerphone").html(n.contact_no),$(".spin1").css("display","none")}})}$(document).ready(function(){$("#ownername").keyup(function(){var n=$(this).val();$(this).val()?$.ajax({type:"POST",url:"{{url('/readname')}}",data:{_token:"{{ csrf_token() }}",keyword:n},beforeSend:function(){$(".spin1").css("display","block")},success:function(n){$("#name-suggesstion-box").css("display","block"),$("#name-suggesstion-box").html(n),$(".spin1").css("display","none")}}):$("#name-suggesstion-box").css("display","none")})});
        </script>
        <script>
          $(document).on("click", function(event){
              var $trigger = $("#suggesstion-box");
              if($trigger !== event.target && !$trigger.has(event.target).length){
                  $("#suggesstion-box").slideUp("fast");
              }            
          });
          $(document).on("click", function(event){
              var $trigger = $("#name-suggesstion-box");
              if($trigger !== event.target && !$trigger.has(event.target).length){
                  $("#name-suggesstion-box").slideUp("fast");
              }            
          });
        </script>
    </body>
</html>
