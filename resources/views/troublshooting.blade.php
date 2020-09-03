@include('inc.header')
<!-- Responsive Table css -->
<link href="{{('public/Green/assets/libs/RWD-Table-Patterns/css/rwd-table.min.css')}}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{('public/Green/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{('public/Green/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{('public/Green/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     

<style>
	.add_trouble{
		padding: 15px 19px 15px 19px;
        color: white !important;
	}
	.video{
		display: none;
	}
	$custom-file-text: (
		en: "Browse",
		es: "Elegir"
	);

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
                        <h4 class="page-title mb-1">TroubleShooting</h4>
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">CRM TroubleShooting</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
                            <a class="btn btn-success btn-rounded waves-effect waves-light mr-3 add_trouble" style="cursor: pointer" id="add_toubleShoot" data-toggle="modal" data-target=".bs-example-modal-xl"><span><i class="fa fa-plus"></i></span></a>
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
                                      <h4>TroubleShooting</h4>
                                        <table id="tech-companies-1" class="table table-striped">
                                            <thead style="background-color: #2fa97c;color: white;">
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Heading</th>
                                                <th data-priority="1">Description</th>
                                                <th data-priority="3">Video</th>
                                                <th data-priority="1">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($troublshooting->count() > 0)
                                            @php $count = 1 @endphp
                                              @foreach($troublshooting as $trouble)
                                              <tr>
                                                  <td>{{$count++}}</td>
                                                  <th>{{$trouble->heading}}</th>
                                                  <td>{!! \Illuminate\Support\Str::limit($trouble->description, 100, $end='...') !!}</td>
                                                  <td>
                                                    <video width="250" height="150" controls>
                                                        <source src="{{url('public/troubleVideo/'.$trouble->video)}}" type="video/mp4">
                                                     </video>
                                                  </td>
                                                  <td>
                                                    <div class="row">
                                                      <div class="col-md-6" style="text-align: end;">
                                                          <a id="edit_trouble" data-id="{{$trouble->id}}" href="{{route('troubleshooting.edit', $trouble->id)}}" type="button" class="btn btn-success waves-effect waves-light" style="font-size: 11px;"><i class="fas fa-edit mr-1"></i>Edit</a>
                                                      </div>
                                                      <div class="col-md-6" style="text-align: initial;">
                                                          <form id="delete_trouble" action="{{route('troubleshooting.destroy', $trouble->id)}}" method="post" accept-charset="utf-8">
                                                            {{ method_field('DELETE') }}
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger waves-effect waves-light" style="font-size: 11px;"><i class="fas fa-trash mr-1"></i>Delete</button>
                                                          </form>
                                                      </div>
                                                    </div>
                                                  </td>
                                              </tr>
                                              @endforeach
                                            @endif
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
        <div class="modal fade bs-example-modal-xl show" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-modal="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0 t_title" id="myExtraLargeModalLabel">Add New TroubleShooting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="trouble_form" action="#" method="post" accept-charset="utf-8" enctype="multipart/form-date">
                        	@csrf
                        	<div class="form-group row">
                        		<div class="col-md-2" style="text-align: right;">
                        			<label>Headeing</label>
                        		</div>
                        		<div class="col-md-9 t_heading">
                        			<input class="form-control" type="text" name="t_heading" value="" placeholder="TroubleShooting Heading">
                        		</div>
                        	</div>
                        	<div class="form-group row">
                        		<div class="col-md-2" style="text-align: right;">
                        			<label>Description</label>
                        		</div>
                        		<div class="col-md-9">
                                <textarea id="elm1" name="t_description" placeholder="Add Some Description"></textarea>
                        		</div>
                        	</div>
                        	<div class="form-group row">
                        		<div class="col-md-2" style="text-align: right;">
                        			<label>Video</label>
                        		</div>
                        		<div class="col-md-9">
                        			<div class="custom-file">
          									  <input type="file" class="custom-file-input t_video" id="customFileLang" name="t_video" lang="en" accept="video/*">
          									  <label class="custom-file-label" for="customFileLang">Select Video</label>
          									</div>
                        		</div>
                        	</div>
                        	<div class="form-group row">
                        		<div class="col-md-2">
                        		</div>
                        		<div class="col-md-9">
                        			<video class="video" width="400" controls>
        								       <source src="" id="video_here">
        								       Your browser does not support HTML5 video.
        								       </video>
                        		</div>
                        	</div>
                        	<div class="form-group">
                        		<div class="col-md-11" style="text-align: end;">
                        			<button type="submit" class="btn btn-primary" style="margin-right: -10px;"><i class="fas fa-check mr-1"></i>Save</button>
                        		</div>
                        	</div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>
    <!-- End Page-content -->

@include('inc.footer')
<!--tinymce js-->
<script src="{{('public/Green/assets/libs/tinymce/tinymce.min.js')}}"></script>
<!-- init js -->
<script src="{{('public/Green/assets/js/pages/form-editor.init.js')}}"></script>
<!-- Responsive Table js -->
<script src="{{('public/Green/assets/libs/RWD-Table-Patterns/js/rwd-table.min.js')}}"></script>
<!-- Required datatable js -->
<script src="{{('public/Green/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{('public/Green/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{('public/Green/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{('public/Green/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{('public/Green/assets/libs/jszip/jszip.min.js')}}"></script>
<script src="{{('public/Green/assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{('public/Green/assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="{{('public/Green/assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{('public/Green/assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{('public/Green/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{('public/Green/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{('public/Green/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

<!-- Init js -->
<script src="{{('public/Green/assets/js/pages/table-responsive.init.js')}}"></script>
<!-- Datatable init js -->
<script src="{{('public/Green/assets/js/pages/datatables.init.js')}}"></script>

@if(session('msg'))
 <script>alertify.success("{!! session('msg') !!}")</script>
@endif
@if(session('error'))
 <script>alertify.error("{!! session('error') !!}")</script>
@endif
<script>
  $('#tech-companies-1').DataTable();
	$(document).on("change", ".t_video", function(evt) {
		$('.video').css('display','block');
       var $source = $('#video_here');
       $source[0].src = URL.createObjectURL(this.files[0]);
       $source.parent()[0].load();
   });

	$('#trouble_form').on('submit', function(event){
      tinyMCE.triggerSave();
      event.preventDefault();
      $.ajax({
         url:"{{route('troubleshooting.store')}}",
         method:"POST",
         data:new FormData(this),
         dataType:'JSON',
         contentType: false,
         cache: false,
         processData: false,
         success:function(data){
          if(data.message){
            alertify.success(data.message);

            setTimeout(function(){
              window.location.reload();
            },2000);
          }else{
            alertify.error(data.error);
          }
         },
         error:function(e){
          alertify.error('Something went wrong.');
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