@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=ucfirst('Admin'))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<div class="page-wrapper" style="margin-top: 2%;">
<div class="container-fluid">
    @if(session('msg'))
        {!! session('msg') !!}
    @endif
    <div class="row owner_main_row">
        <h3 class="page_heading">Backups</h3>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <button class="btn btn-danger" id="create-new-backup-button"><b><span><i class="fa fa-plus" ></i></span> Create Backup</b></button>
                        <span id="loader" style="visibility: hidden;margin-left: 15px !important;"><img src="https://thumbs.gfycat.com/UnitedSmartBinturong-small.gif" style="width: 35px;height: 35px;"></span>
                    </div>
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

@include('inc.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet">
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
                    Command: toastr["success"]("Backup Created Successfully!");
                    setTimeout(function(){ location.reload(); }, 3000);
                },
                error: function(result) {
                    $(this).attr("disabled",false);
                    $("#loader").css("visibility","hidden");
                    Command: toastr["error"]("Something Went Wrong");
                }
            });
    });
</script>
@include('reminder')