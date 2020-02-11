@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=ucfirst('Admin'))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<style>
    .footable>thead>tr>th{
        text-align:start !important;
    }
</style>
<div class="page-wrapper" style="margin-top: 2%;">
    <div class="container-fluid">
    @if(session('msg'))
        {!! session('msg') !!}
    @endif
<?php  if(!isset($_GET['action'])) { ?>
    <div class="row owner_main_row">
        <h3 class="page_heading">Buildings</h3>
    <!--    <div class="col-sm-5">
        <a  href="{{url('buildings')}}" style="padding: 0px 20px;color:white;margin-left: 327px;" class="bt btn-success"> Add building</a>
                        </div>
                        <div class="col-sm-5">
                            <a href="{{url('/assignAgent')}}" style="padding: 0px 20px;" class="bt btn-warning">Assign Agent</a>
                        </div>-->
                        <div class="col-12 col-sm-12">
                                                <ul class="nav nav-tabs ">
    <li class="nav-item">
     @if(basename(url()->current())=='buildings')
       <a href="{{url('buildings')}}"  class="nav-link active py-3">Add Building</a>
       @else
        <a href="{{url('buildings')}}"  class="nav-link py-3">Add Building</a>
       @endif
    </li>
    <li class="nav-item">
    @if(basename(url()->current())=='assignAgent')
      <a href="{{url('assignAgent')}}"  class="nav-link active py-3">Assign Coldcalling</a>
      @else
           <a href="{{url('assignAgent')}}"  class="nav-link py-3">Assign Coldcalling</a>
      @endif
    </li></ul></div>
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <div class="d-flex">
                        <a style="cursor: pointer" id="add-new-owne-link"><span><i class="fa fa-plus"></i></span></a>
                        <div class="form-group ml-auto">
                            <input id="demo-input-search2" class="demo-input-search" type="text" placeholder="Search" autocomplete="off">
                        </div>
                    </div>
                    <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny demo-pagination" style="margin-top: 2%" data-page-size="20" >
                        <thead>
                            <tr>
                                <th data-toggle="true">SNO#</th>
                                <th data-toggle="true">Building Name</th>
                                                               
                                <th data-toggle="all">Action</th>
                                <th data-toggle="all">Action</th>
                            </tr>
                        </thead>     
                        <tbody>
                  <?php if(count($value) > 0){ $counter=1;
                             foreach($value as $values){ ?>
                            <tr>
                                <td>{{$counter++}}</td>
                                <td>{{ucwords($values->building_name)}}</td>
                                
                                <td><a class="edit_supervision" href='{{url("edit-building")}}?action=edit&id={{$values->id}}'><i class="fa fa-edit"></i> Edit</a></td>
                                <td><a class="edit_supervision" href='{{url("delete-building")}}?action=delete&id={{$values->id}}'><i class="fa fa-edit"></i> Delete</a></td>
                            </tr>
                           <?php  } 
                            } else{ ?>
                                <tr><td colspan="9" align="center">No Record Found</td></tr>
                            <?php }  ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10">
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
        <span id="back_to_owner_text">Add building</span>
        </div>
    </div>

    <!--adding new owner's form  -->
 <!-- owners info  -->
 <div class="row owner_information_link">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Building Details</h4>
                </div>
                <div class="card-body">
                    <form action="<?php if(isset($_GET['action'])){echo url("update-building")."?id=".@$record->id;}else{ echo url("insert-building"); }  ?>" id="user_form" class="form-horizontal" method="post">
                    {{csrf_field()}}
                        <div class="form-body">
                            <div class="row">
                                
                                 <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Building Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="" name="building_name" value="{{@$record->building_name}}" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="display:none">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Addbuilding</label>
                                     
                                            
                                       <div class="col-md-9">
                                                        <select class="form-control" required="" style="font-size: 12px;" name="assigned_agent" id="building">
                                                            <option value="">Select option</option>
                                                             @foreach(@$agents as $agent)
                                                  <option value="{{$agent->user_name}}">{{$agent->user_name}}</option>-->
                                               @endforeach                                                       
                                                      </select>
                                                    </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <!--<div class="form-group row">-->
                                    <!--    <label class="control-label text-right col-md-3">Assigned Agent</label>-->
                                    <!--    <div class="col-md-9">-->
                                    <!--        <select class="form-control" required="" style="font-size: 12px;" name="assigned_agent" id="agent">-->
                                    <!--            <option value="">Select option</option>-->
                                    <!--            @foreach(@$agents as $agent)-->
                                    <!--                <option value="{{$agent->user_name}}">{{$agent->user_name}}</option>-->
                                    <!--            @endforeach-->
                                    <!--        </select>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>
                          </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9" style="padding-left: 28%;">
                                            <button type="submit" class="btn btn-success submit"><?php  if(isset($_GET['action'])){echo "Update";}else{echo "Submit";}?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"> </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('inc.footer')
<?php  if(isset($_GET['action'])) { ?>
    <script type="text/javascript">
        $("#agent option").each(function(){
            if($(this).val()=='{{$record->assigned_agent}}'){
                $(this).attr("Selected",true);
            }
        })
    </script>
<?php }  ?>
<script type="text/javascript">
$(document).ready(function(){
    $("#user_form").validate();
    // var counter=0;
    // $("#user_form").submit(function(e){
    //     if($("#user_name").val()==""){
    //         return;
    //     }
    //     $.ajax({
    //         url:"{{url('checkUsername')}}",
    //         type:'get',
    //         data:{"user_name":$("#user_name").val()},
    //         success:function(data,e){
    //             if(data=="true"){
    //                 if(counter==0){
    //                     $("<span class='error'>username already exist</span>").insertAfter("#user_name");
    //                     counter++;
    //                     e.preventDefault();
    //                 }
    //             }else{
    //                 $("#user_name").next().remove();
    //                 counter=0;
    //             }
    //         }
    //     })
    //     if(counter > 0){
    //         e.preventDefault();
    //     }
    // })
     $('#building').click(function(){
  $('.row.owner_main_row').hide();
  $('.row.owner_information_link').show();
  $('.back_btn_row').show();
   });
});
</script>
@include('reminder')
