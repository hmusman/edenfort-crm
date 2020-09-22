@include('inc.header')
@if(!session("user_id") && ucfirst(session('role')) != (ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<!-- DataTables -->
<link href="{{url('public/Green/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('public/Green/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     
<style>
    #datatable-buttons_wrapper{
        margin-top: 20px;
    }
    .alert {
        position: relative;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 1.25rem;
    }
    .alert-success {
        color: #ffffff;
        background-color: #46b28a;
        border-color: #46b28a;
    }
    h5{
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
                        <h4 class="page-title mb-1">Clicks Report</h4>
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Edenfort CRM Clicks Reports</li>
                        </ol>
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
                                <div class="card-header" style="background-color: white;">
                                    <h4>Clicks Report</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{url('SearchClicksReport')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label for="agent" class="font-size">Select Agent</label>
                                                <select id="agent" name="agent" class="form-control font-size" required>
                                                    <option value="">Select Agent</option>
                                                    @foreach($agents as $agent)
                                                        <option value="{{$agent->id}}">{{$agent->user_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="font-size">From Date</label>
                                                <input type="date" class="font-size form-control" name="from_date">
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="font-size">To Date</label>
                                                <input type="date" class="font-size form-control" name="to_date">
                                            </div>
                                            <div class="col-sm-3" style="padding-top: 32px;">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light"><b><span><i class="mdi mdi-file-pdf-outline" ></i></span> Filter Report</b></button>
                                            </div>
                                        </div>
                                    </form>
                                    @if(@$search_result_for)
                                    <div class="alert alert-success mt-3">
                                        {!! @$search_result_for !!}
                                    </div>
                                    @endif
                                     <table id="datatable-buttons" class="mt-4 table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Agent_name</th>
                                        <th>Page Name</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if($clicks->count() > 0)
                                        @php $i = 1; @endphp
                                        @foreach($clicks as $key => $click)
                                         <tr>
                                             <td>{{$i}}</td>
                                             <td>{{$click->user_name}}</td>
                                             <td>{{$click->page_name}}</td>
                                             <td>{{$click->description}}</td>
                                             <td>{{$click->created_at}}</td>
                                         </tr>
                                         @php $i += 1; @endphp
                                         @endforeach
                                         @else
                                         <tr>
                                             <td colspan="5" style="text-align: center;">There is no clicks history yet.</td>
                                         </tr>
                                         @endif
                                    </tbody>
                                </table>
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
<!-- Required datatable js -->
<script src="{{url('public/Green/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{url('public/Green/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/jszip/jszip.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{url('public/Green/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

<!-- Datatable init js -->
<script src="{{url('public/Green/assets/js/pages/datatables.init.js')}}"></script>

<!--<script src="{{url('public/assets/plugins/jquery/jquery.min.js')}}"></script>-->
<script src="{{url('public/assets/plugins/raphael/raphael-min.js')}}"></script>
<script src="{{url('public/assets/plugins/morrisjs/morris.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet">
@if ($errors->any())
    @foreach ($errors->all() as $error)
    <script>
        alertify.error(" {{ $error }}");
    </script>       
    @endforeach
@endif

@if(ucfirst(session('role')) == (ucfirst('Admin')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == (ucfirst('SuperAgent')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == ucfirst('Agent'))
      @include('reminder')
    @elseif(ucfirst(session('role')) == ucfirst('SuperDuperAdmin'))
      @include('admin_SuperAgent_reminders')
    @endif
