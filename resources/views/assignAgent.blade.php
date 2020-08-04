@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<!-- Responsive Table css -->
<link href="{{url('public/Green/assets/libs/RWD-Table-Patterns/css/rwd-table.min.css')}}" rel="stylesheet" type="text/css" />

<style>
 .modal-body .row .data{
    padding:10px 0px;
    border: 1px solid #ccc;
    border-bottom: 0px;
    }
  .owner_information_link{
    display: none;
  }
  .pagination{
    float: right;
  }
  #tech-companies-1 thead{
    background-color: #2fa97c;
    color: white;
}
.nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #2fa97c;
    border-color: #2fa97c #2fa97c #2fa97c;
}
.nav-tabs {
    border-bottom: 1px solid #2fa97c;
}
.form-control {
  width: 100% !important;
}
.table-rep-plugin .btn-group.pull-right {
    float: right;
    margin-right: 13px !important;
}
.focus-btn-group{
  margin-left: 3px;
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
                        <h4 class="page-title mb-1">Buildings</h4>
                        <ol class="breadcrumb m-0">
                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li> -->
                        @if(basename(url()->current())=='buildings')
                        <li class="breadcrumb-item active">Add Building</li>
                        @endif
                        @if(basename(url()->current())=='assignAgent')
                        <li class="breadcrumb-item active">Assign Coldcalling</li>
                        @endif
                        @if(basename(url()->current())=='searchAssignAgent')
                        <li class="breadcrumb-item active">Search Assign Agent</li>
                        @endif
                        @if(basename(url()->current())=='edit-buildingAssign')
                        <li class="breadcrumb-item active">Update Building</li>
                        @endif
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
        <?php  if(!isset($_GET['action'])) { ?>
        <div class="page-content-wrapper owner_main_row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                              <div class="card-header" style="background-color: white;">
                                <ul class="nav nav-tabs" role="tablist">
                                  @if(basename(url()->current())=='buildings')
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{url('buildings')}}">
                                          <span class="d-none d-md-inline-block">Add Building</span> 
                                        </a>
                                    </li>
                                  @else
                                  <li class="nav-item">
                                        <a class="nav-link" href="{{url('buildings')}}">
                                          <span class="d-none d-md-inline-block">Add Building</span> 
                                        </a>
                                    </li>
                                  @endif
                                   @if(basename(url()->current())=='assignAgent')
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{url('assignAgent')}}">
                                          <span class="d-none d-md-inline-block">Assign Coldcalling</span>
                                        </a>
                                    </li>
                                  @else
                                  <li class="nav-item">
                                        <a class="nav-link" href="{{url('assignAgent')}}">
                                          <span class="d-none d-md-inline-block">Assign Coldcalling</span>
                                        </a>
                                    </li>
                                  @endif
                                </ul>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-12">
                                   <div class=" mt-2 mb-2">
                                      <form action="{{route('searchAssignAgent') }}" method="GET" class="form-inline">
                                        <div class="col-md-5 pl-1 pr-1">
                                         <div class="dropdown_wrapper ">
                                          <input type="text" class="form-control filter_input" list="building" name="building" placeholder="select Building">
                                          <datalist id="building">
                                           <option value=" ">Select building</option>
                                            @foreach($building as $building)
                                            <option value="{{$building}}"></option>
                                            @endforeach
                                            <option value="2">2</option>
                                          </datalist>
                                         </div>
                                     </div>
                                     <div class="col-md-3 pl-1 pr-1">
                                        <div class="dropdown_wrapper ">
                                          <input id="name" class="form-control filter_input" list="allNames" autocomplete="off" placeholder="select Agent"/>
                                          <datalist id="allNames">
                                            @foreach($agents as $agent)
                                              <option data-value="{{$agent->id}}" value="{{$agent->user_name}}" >{{$agent->user_name}}</option>
                                            @endforeach
                                          </datalist>
                                          <input type="hidden" id="agentId" name="agent" value="">
                                        </div>
                                      </div>
                                      <div class="col-md-2 filter">
                                       <div class="filter_btn_wrapper">
                                           <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter" name="search">
                                       </div>
                                     </div>
                                     <div class="col-md-2 filter">
                                         <div class="filter_btn_wrapper">
                                             <input type="button" class="btn btn-success btn-block assign_btn" value="Assign" name="assign" style="padding: 10px 2px 10px 0px;" id="assign-single-property">
                                         </div>
                                     </div>
                                    </form> 
                                    </div>
                                  </div>
                                </div>
                                <div class="table-rep-plugin">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="tech-companies-1" class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th class="checkall" style="cursor:pointer">Select All</th>
                                                <th>SNO#</th>
                                                <th>Building Name</th>
                                                <th>Assign Agent</th>                               
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                              <form id="bulkForm" class="form-inline">
                                                @csrf
                                               <!-- Assign Property -->
                                                <div class="modal fade" id="assignproperty" tabindex="-1" role="dialog" aria-labelledby="assignproperty" aria-hidden="true">
                                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                                     <div class="modal-content">
                                                        <div class="modal-header">
                                                           <h5 class="modal-title" id="assignproperty">Assign Property</h5>
                                                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                           <span aria-hidden="true">&times;</span>
                                                           </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row" style="font-size:13px;">
                                                                <div class="col-sm-1 text-center"></div>
                                                                <div class="col-sm-3 text-center data"><strong style="font-weight:900;color:black;">Select</strong></div>
                                                                <div class="col-sm-7 text-center data"><strong style="font-weight:900;color:black;">Agent Name</strong></div>
                                                                 <div class="col-sm-1 text-center"></div>
                                                                @foreach($agents as $key => $agent)
                                                                   <div class="col-sm-1 text-center"></div>
                                                                   <div class="col-sm-3 text-center data"><input class="agents_ids" type="checkbox" name="agents_ids[{{$key}}]" value="{{$agent->id}}"></div>
                                                                   <div class="col-sm-7 text-center data">{{$agent->user_name}}</div>
                                                                   <div class="col-sm-1 text-center"></div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                           <button type="button" id="assign-property-btn" class="btn btn-success">Submit</button>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                            <?php if(count($value) > 0){ $counter=1;
                                            foreach($value as $values){ ?>
                                            <tr>
                                              <td>@if(ucfirst(session('role'))==ucfirst('SuperAgent')) 
                                                 @if(@$permissions->propertyBulk==1)
                                                 <input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$values->Building}}">
                                                 @else
                                                 Not Allowed
                                                 @endif
                                                 @else
                                                 <input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$values->Building}}">
                                                 @endif
                                            </td>
                                            <td>{{$counter++}}</td>
                                            <td>{{ucwords($values->Building)}}  <label class="badge badge-info">{{count($values->buildingCount)}} </label></td>
                                            <td>{{$values->user->user_name}}</td>
                                            <td><a class="edit_supervision" href='{{url("edit-buildingAssign")}}?action=edit&id={{$values->id}}'><i class="fa fa-edit"></i> Edit</a></td>
                                            </tr>
                                            <?php  } 
                                            } else{ ?>
                                                <tr><td colspan="9" align="center">No Record Found</td></tr>
                                            <?php }  ?>
                                            </tbody>
                                        </table>
                                    </div>
                                  </form>
                                </div>
                                {{$value->appends(Request::only('building','agent'))->links()}}
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div> 
<?php  } else{ ?>
  <style type="text/css">.owner_information_link{display: block;</style> <?php  } ?>
    <div class="page-content-wrapper owner_information_link">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                         <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-outline-info">
                                    <div class="card-header" style="background-color: white;">
                                        <h4 class="m-b-0">Building Details</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php if(isset($_GET['action'])){echo url("update-buildingAssign")."?name=".@$record->Building;}else{ echo url("insert-buildingAssign"); }  ?>" id="user_form" class="form-horizontal" method="post">
                                        {{csrf_field()}}
                                            <div class="form-body">
                                                <div class="row">
                                                    
                                                     <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Building Name</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" placeholder="" name="building_name" value="{{@$record->Building}}" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Assign Agent</label>
                                                         
                                                                
                                                           <div class="col-md-9">
                                                                            <select class="form-control" required="" style="font-size: 12px;" name="assigned_agent" id="building">
                                                                                <option value="">Select option</option>
                                                                                @if(isset($_GET['action']))
                                                                                 @foreach($agents as $agent)
                                                                      <option value="{{$agent->id}}">{{$agent->user_name}}</option>
                                                                                       @endforeach   
                                                                                       @endif
                                                                          </select>
                                                                        </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                    <div class="col-md-6">
                                                     
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
<!-- Responsive Table js -->
<script src="{{url('public/Green/assets/libs/RWD-Table-Patterns/js/rwd-table.min.js')}}"></script>

<!-- Init js -->
<script src="{{url('public/Green/assets/js/pages/table-responsive.init.js')}}"></script>
@if(session('msg'))
  <script>alertify.success("{!! session('msg') !!}")</script>
@endif
@if(session('error'))
  <script>alertify.error("{!! session('error') !!}")</script>
@endif
<?php  if(isset($_GET['action'])) { ?>
    <script type="text/javascript">
        $("#agent option").each(function(){
            if($(this).val()=='{{$record->assigned_agent}}'){
                $(this).attr("Selected",true);
            }
        })
    </script>
<?php }  ?>
<script>
    $(document).ready(function(){
        $("#assign-single-property").click(function(){
            if(!$('.ind_chk_box:checkbox:checked').val()){
                // toastr["error"]("please select Rows!");
                alertify.error("please select Rows!")
            }else{
               $("#assignproperty").modal("show"); 
            }
            
        });
        $("#assign-property-btn").click(function(){
          if(!$('.agents_ids:checkbox:checked').val()){
                  // toastr["error"]("Please select Agent");
                  alertify.error("Please select Agent!")
          }else if($('.agents_ids:checkbox:checked').length > 1){
                  // toastr["error"]("Please select Only One Agent");
                  alertify.error("Please select Only One Agent!")

          }else{
               // console.log($('.agents_ids:checkbox:checked').length);
                   $("#bulkForm").attr("action","{{url('assign-singlebuilding')}}");
                   $("#bulkForm").attr("method","POST");
                   $("#bulkForm").submit();
                 }
              })
          })
</script>
<script type="text/javascript">
$(document).ready(function(){
  $(document).ready(function(){
           // Select all
    var clicked = false;
    $(".checkall").on("click", function() {
      $(".ind_chk_box").prop("checked", !clicked);
      if(!clicked){
         $(".ind_chk_box").attr("checked",""); 
      }else{
          $(".ind_chk_box").removeAttr("checked"); 
      }
      clicked = !clicked;
    });
  });

        //datalist on click, agents search
$("#name").on('input', function () {
    var val = this.value;
    if($('#allNames option').filter(function(){
        if(this.value === val) {
          var agentId = $(this).attr("data-value");
          console.log(agentId+" if condition");
          $("#agentId").val(agentId);
        }      
    }).length) {
        //send ajax request
        
    }
});
    
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
  $('owner_main_row').hide();
  $('.owner_information_link').show();
  $('.back_btn_row').show();
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

