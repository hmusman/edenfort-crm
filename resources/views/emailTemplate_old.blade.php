@include('inc.header')
@if(!session("user_id") && ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<style>
    table td,table th{
        text-align:center;
    }
    .alert{
            display: block;
    width: 100%;
    margin-bottom: 20px;
    /* width: 86%; */
    margin-left: 15px;
    margin-top: -15px;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<div class="page-wrapper" style="margin-top: 2%;">
<div class="container-fluid">
<?php  if(!@$edit) { ?>
    <div class="row owner_main_row">
        <h3 class="page_heading">Email Templates</h3>
        @if(session('msg'))
            {!! session('msg') !!}
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-body  table-responsive">
                    <div class="d-flex">
                        <a style="cursor: pointer" id="add-new-owne-link"><span><i class="fa fa-plus"></i></span></a>
                        <div class="form-group ml-auto">
                            <input id="demo-input-search2" class="demo-input-search" type="text" placeholder="Search" autocomplete="off">
                        </div>
                    </div>
                    <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny demo-pagination" style="margin-top: 2%" data-page-size="5" >
                        <thead>
                            <tr>
                                <th data-toggle="true"> Sno# </th>
                                <th data-toggle="true"> Template Name </th>
                                <th data-toggle="true"> Subject</th>
                                <th data-toggle="all">Action</th>
                                <th data-toggle="all">Action</th>
                               
                            </tr>
                        </thead>     
                        <tbody>
                  <?php if(count($templates) > 0){
                             $counter= 1; 
                             foreach($templates as $template){ ?>
                            <tr>
                                <td>{{$counter++}}</td>
                                <td>{{$template->template_name}}</td>
                                <td>{{$template->subject}}</td>
                                <td><a style="font-size:12px;" class="edit_supervision label label-success" href='{{url("edit-template/{$template->id}")}}'><i class="fa fa-edit"></i> Edit</a></td>
                                <td><a style="font-size:12px;" href='{{url("delete-template/{$template->id}")}}' class="edit_supervision label label-danger"><i class="fa fa-trash"></i> Delete</a></td>
                            </tr>
                           <?php  } 
                            } else{ ?>
                                <tr><td colspan="9" align="center">No Record Found</td></tr>
                            <?php }  ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="16">
                                    <div class="text-right">
                                        <ul class="pagination pagination-split m-t-30"> </ul>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
<?php  } else{ ?><style type="text/css">.owner_information_link{display: block;</style> <?php  } ?>
    <!-- back button -->
    <div class="row back_btn_row m-b-40">
        <div class="col-12 back_wrapper">
        <span ><i class="fas fa-arrow-circle-left" id="back_to_owner"></i></span>
        <span id="back_to_owner_text">Add New Template</span>
        </div>
    </div>
 <div class="row owner_information_link">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
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

@include('inc.footer')
<!--<script src="https://cdn.ckeditor.com/4.11.4/basic/ckeditor.js"></script>-->
<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet">
<script>
    $(document).ready(function(){
        CKEDITOR.replace( 'template_date' );
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
