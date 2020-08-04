@include('inc.header')
@if(!session("user_id") && ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
<script type="text/javascript">
   window.location='{{url("/")}}';
</script>
<?php redirect('/'); ?>
@endif

<!-- Responsive Table css -->
<link href="{{url('public/Green/assets/libs/RWD-Table-Patterns/css/rwd-table.min.css')}}" rel="stylesheet" type="text/css" />
<style>
  #tech-companies-1 thead{
      background: #2fa97c;
      color: white;
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
                        <h4 class="page-title mb-1">Months</h4>
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Edenfort CRM Open/Close Months</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
                          
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="tech-companies-1" class="table table-striped">
                                            <thead>
                                            <tr>
                                              <th class="text-center">Month</th>
                                              <th class="text-center">Status</th>
                                              <th class="text-center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                               <tr class="current_com_row">
                                                  <td class="text-center">
                                                     <h6><b>{{date("M-Y",strtotime($month->month))}}</b></h6>
                                                  </td>
                                                  <td class="text-center">
                                                      <span style="font-size: 13px;background-color: #2fa97c;color: white;padding: 2px 6px 2px 6px;" class="label label-primary">
                                                          {{$month->status}}
                                                      </span>
                                                  </td>
                                                  <td class="text-center">
                                                      <a href="{{url('close-month')}}" class="btn btn-danger">Close</a>
                                                  </td>
                                               </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
            <!-- end container-fluid -->
        </div> 
        <!-- end page-content-wrapper -->
    </div>
    <!-- End Page-content -->

      
@include('inc.footer')
@if(session('msg'))
<script>alertify.success("{!! session('msg') !!}")</script>
@endif
 <!-- Responsive Table js -->
<script src="{{url('public/Green/assets/libs/RWD-Table-Patterns/js/rwd-table.min.js')}}"></script>

<!-- Init js -->
<script src="{{url('public/Green/assets/js/pages/table-responsive.init.js')}}"></script>

@if(ucfirst(session('role')) == (ucfirst('Admin')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == (ucfirst('SuperAgent')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == ucfirst('Agent'))
      @include('reminder')
    @elseif(ucfirst(session('role')) == ucfirst('SuperDuperAdmin'))
      @include('admin_SuperAgent_reminders')
    @endif

</body>
</html>