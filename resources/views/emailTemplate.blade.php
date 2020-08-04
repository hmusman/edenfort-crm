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
    #add-new-owne-link{
      cursor: pointer;
      color: white;
      padding: 16px 20px;
    }
    #tech-companies-1 thead{
      background: #2fa97c;
      color: white;
    }
    #back_to_owner{
        font-size: 38px;
        position: absolute;
        margin-top: -3px;
    }
    #back_to_owner_text{
        font-size: 22px;
        font-weight: bold;
        margin-left: 45px;
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
                        <h4 class="page-title mb-1">Email Templates</h4>
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Edenfort CRM Email Templates</li>
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
                            <?php  if(!@$edit) { ?>
                            <div class="card-body all_template_card">
                                <div class="card-header" style="background-color: white">
                                    <a class="btn btn-success btn-rounded waves-effect waves-light" style="cursor: pointer" id="add-new-owne-link"><span><i class="fa fa-plus"></i></span></a>
                                </div>
                                <div class="card-body">
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                                            <table id="tech-companies-1" class="table table-striped">
                                                <thead>
                                                    <th data-toggle="true"> Sno# </th>
                                                    <th data-toggle="true"> Template Name </th>
                                                    <th data-toggle="true"> Subject</th>
                                                    <th data-toggle="all">Action</th>
                                                    <th data-toggle="all">Action</th>
                                                </thead>
                                                <tbody>
                                                 <?php if(count($templates) > 0){
                                                     $counter= 1; 
                                                     foreach($templates as $template){ ?>
                                                    <tr>
                                                        <td>{{$counter++}}</td>
                                                        <td>{{$template->template_name}}</td>
                                                        <td>{{$template->subject}}</td>
                                                        <td><a style="font-size:12px;" class="edit_supervision badge badge-success" href='{{url("edit-template/{$template->id}")}}'><i class="fa fa-edit"></i> Edit</a></td>
                                                        <td><a style="font-size:12px;" href='{{url("delete-template/{$template->id}")}}' class="edit_supervision badge badge-danger"><i class="fa fa-trash"></i> Delete</a></td>
                                                    </tr>
                                                   <?php  } 
                                                    } else{ ?>
                                                        <tr><td colspan="9" align="center">No Record Found</td></tr>
                                                    <?php }  ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php  } else{ ?><style type="text/css">.add_template_card{display: block;</style> <?php  } ?>
                            <div class="card-body add_template_card" style="@if(@$edit) display: block; @else display: none; @endif">
                                <div class="col-12 back_wrapper">
                                    <a href="{{url('email-templates')}}?type=For Rent"><span ><i class="fas fa-arrow-circle-left" id="back_to_owner"></i></span></a>
                                    <span id="back_to_owner_text">@if(@$edit) Updtae Template @else Add New Template @endif</span>
                                </div>
                                <div class="card-header mt-4" style="background-color: #2fa97c;">
                                    <h4 class="m-b-0 text-white">Email Template</h4>
                                </div>
                                <div class="card-body">
                                    <form action="<?php if(@$edit){echo url("update-email-template",array(@$record->id));}else{ echo url("add-email-template"); }  ?>" id="user_form" class="form-horizontal" method="post">
                                    {{csrf_field()}}
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-10">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-2">Template Name</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="template_name" value="{{@$record->template_name}}" required="">
                                                            <input type="hidden" name="id"  value="{{@$record->id}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                           </div>
                                           <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-10">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-2">Subject</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="subject" value="{{@$record->subject}}" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                           </div>
                                           <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-10">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-2">Template Name</label>
                                                        <div class="col-md-9">
                                                            <textarea name="template_date" class="template_date" id="template_date" required="">{{@$record->template_date}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                           </div>
                                           <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8" style="padding:0px;">
                                                <button type="submit" style="width: 90%;text-align: center;display: block;float: right;" class="btn btn-success submit"><?php  if(@$edit){echo "Update Template";}else{echo "Add";}?></button>
                                            </div>
                                            <div class="col-md-2"></div>
                                       </div>
                                        </div>
                                    </form>
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
@if(session('error'))
<script>alertify.error("{!! session('error') !!}")</script>
@endif
<!-- Responsive Table js -->
<script src="{{url('public/Green/assets/libs/RWD-Table-Patterns/js/rwd-table.min.js')}}"></script>

<!-- Init js -->
<script src="{{url('public/Green/assets/js/pages/table-responsive.init.js')}}"></script>

<!--<script src="https://cdn.ckeditor.com/4.11.4/basic/ckeditor.js"></script>-->
<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
<script>
    $(document).ready(function(){
        CKEDITOR.replace( 'template_date' );
    })
</script>
<script>
    $('#add-new-owne-link').on('click', function(){
        $('.all_template_card').css('display','none');
        $('.add_template_card').css('display','block');
    })
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
