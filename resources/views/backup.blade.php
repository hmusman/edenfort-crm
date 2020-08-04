@include('inc.header')
@if(!session("user_id") && ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<style>
    #demo-foo-pagination > thead{
        background-color: #2fa97c;
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
                                    <h4 class="page-title mb-1">Backups</h4>
                                    <ol class="breadcrumb m-0">
                                        <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li> -->
                                    <li class="breadcrumb-item active">Edenfort CRM Generate Backup</li>
                                    </ol>
                                </div>
                                <!-- <div class="col-md-4">
                                    <div class="float-right d-none d-md-block">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-settings-outline mr-1"></i> Settings
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
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
                                            <div class="card-header" style="background-color: #ffffff;">
                                                <div class="d-flex" style="background-color: #ffffff;">
                                                    <button class="btn btn-danger" id="create-new-backup-button"><b><span><i class="fa fa-plus" ></i></span> Create Backup</b></button>
                                                    <span id="loader" style="visibility: hidden;margin-left: 15px !important;"><img src="https://thumbs.gfycat.com/UnitedSmartBinturong-small.gif" style="width: 35px;height: 35px;"></span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny demo-pagination" style="margin-top: 2%" data-page-size="5" >
                                                    <thead>
                                                          <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Date</th>
                                                            <th class="text-right">File Size</th>
                                                            <th class="text-right">Actions</th>
                                                          </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(count($backups) > 0)
                                                          @foreach ($backups as $k => $b)
                                                          <tr>
                                                            <th scope="row">{{ $k+1 }}</th>
                                                            <td>{{ $b['disk'] }}</td>
                                                            <td>{{ \Carbon\Carbon::createFromTimeStamp($b['last_modified'])->formatLocalized('%d %B %Y, %H:%M') }}</td>
                                                            <td class="text-right">{{ round((int)$b['file_size']/1048576, 2).' MB' }}</td>
                                                            <td class="text-right">
                                                                @if ($b['download'])
                                                                <a class="btn btn-xs btn-default" href="{{ url('/backup/download/') }}?disk={{ $b['disk'] }}&path={{ urlencode($b['file_path']) }}&file_name={{ urlencode($b['file_name']) }}"><i class="fa fa-cloud-download"></i>Download</a>
                                                                @endif
                                                                <a class="btn btn-xs btn-danger" data-button-type="delete" href="{{ url('/backup/delete/'.$b['file_name']) }}?disk={{ $b['disk'] }}"><i class="fa fa-trash-o"></i> Delete</a>
                                                            </td>
                                                          </tr>
                                                          @endforeach
                                                          @else
                                                            <tr>
                                                                <td style="text-align: center;" colspan="10">Data not Found!</td>
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
@if(session('msg'))
<script>
    alertify.success("{!! session('msg') !!}");
</script>
    @endif
<script type="text/javascript">
    $("#create-new-backup-button").click(function(e) {
        e.preventDefault();
        $("#loader").css("visibility","visible");
        $(this).attr("disabled",true);
        $.ajax({
                url: '{{url("backup/create")}}',
                type: 'GET',
                success: function(result) {
                    $(this).attr("disabled",false);
                    $("#loader").css("visibility","hidden");
                    // Command: toastr["success"]("Backup Created Successfully!");
                    alertify.success("Backup Created Successfully!");

                    setTimeout(function(){ location.reload(); }, 3000);
                },
                error: function(result) {
                    $(this).attr("disabled",false);
                    $("#loader").css("visibility","hidden");
                    // Command: toastr["error"]("Something Went Wrong");
                    alertify.error("Something Went Wrong!");
                }
            });
    });
</script>
@if(ucfirst(session('role')) == (ucfirst('Admin')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == (ucfirst('SuperAgent')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == ucfirst('Agent'))
      @include('reminder')
    @elseif(ucfirst(session('role')) == ucfirst('SuperDuperAdmin'))
      @include('admin_SuperAgent_reminders')
    @endif
