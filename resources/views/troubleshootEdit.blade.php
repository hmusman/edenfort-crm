@include('inc.header')
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
                        <h4 class="page-title mb-1">Update TroubleShooting</h4>
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">CRM TroubleShooting</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
                           <!--  <a class="btn btn-success btn-rounded waves-effect waves-light mr-3 add_trouble" style="cursor: pointer" id="add_toubleShoot" data-toggle="modal" data-target=".bs-example-modal-xl"><span><i class="fa fa-plus"></i></span></a> -->
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
                                <form id="trouble_form" action="{{route('troubleshooting.update', $trouble->id)}}" method="post" accept-charset="utf-8" enctype="multipart/form-date">
                                	{{ method_field('PATCH') }}
		                        	@csrf
		                        	<div class="form-group row">
		                        		<div class="col-md-2" style="text-align: right;">
		                        			<label>Headeing</label>
		                        		</div>
		                        		<div class="col-md-9 t_heading">
		                        			<input class="form-control" type="text" name="t_heading" value="{{@$trouble->heading}}" placeholder="TroubleShooting Heading">
		                        		</div>
		                        	</div>
		                        	<div class="form-group row">
		                        		<div class="col-md-2" style="text-align: right;">
		                        			<label>Description</label>
		                        		</div>
		                        		<div class="col-md-9">
		                                <textarea id="elm1" name="t_description" placeholder="Add Some Description">{{@$trouble->description}}</textarea>
		                        		</div>
		                        	</div>
		                        	<div class="form-group row">
		                        		<div class="col-md-2" style="text-align: right;">
		                        			<label>Video</label>
		                        		</div>
		                        		<div class="col-md-9">
		                        			<div class="custom-file">
		  									  <input type="file" class="custom-file-input t_video" id="customFileLang" value="{{@$trouble->video}}" name="t_video" lang="en" accept="video/*">
		  									  <label class="custom-file-label" for="customFileLang">Select New Video</label>
		  									</div>
		                        		</div>
		                        	</div>
		                        	<div class="form-group row">
		                        		<div class="col-md-2">
		                        		</div>
		                        		<div class="col-md-9">
		                        			<video class="video" width="400" controls>
										       <source src="{{url('public/troubleVideo/', @$trouble->video)}}" id="video_here">
										       Your browser does not support HTML5 video.
										       </video>
		                        		</div>
		                        	</div>
		                        	<div class="form-group">
		                        		<div class="col-md-11" style="text-align: end;">
		                        			<button type="submit" class="btn btn-primary" style="margin-right: -10px;"><i class="fas fa-check mr-1"></i>Update</button>
		                        		</div>
		                        	</div>
		                        </form>
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
<!--tinymce js-->
<script src="{{url('public/Green/assets/libs/tinymce/tinymce.min.js')}}"></script>
<!-- init js -->
<script src="{{url('public/Green/assets/js/pages/form-editor.init.js')}}"></script>
@if(session('msg'))
 <script>alertify.success("{!! session('msg') !!}")</script>
@endif
@if(session('error'))
 <script>alertify.error("{!! session('error') !!}")</script>
@endif
<script>
	$(document).on("change", ".t_video", function(evt) {
		$('.video').css('display','block');
       var $source = $('#video_here');
       $source[0].src = URL.createObjectURL(this.files[0]);
       $source.parent()[0].load();
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