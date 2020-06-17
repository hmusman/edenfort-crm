@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<style>
   @media only screen and (max-width: 600px) {
    .filter{
        width: 98%;
        margin-left: 3px !important;
        padding-left: 1px;
        padding-right: 1px;
    }
    
   }
   .modal-body .row .data{
        padding:10px 0px;
        border: 1px solid #ccc;
        border-bottom: 0px;
        }
.filter_input{
        background-color:#1976D2 ;
        color:#fff;
        border-radius:4px;
    }
    .filter_input::placeholder{
        color:#fff;
    }
    .filter_btn{
    height:37px;
}
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
      <!--  <div class="col-sm-5">
        <a href="{{url('buildings')}}" style="padding: 0px 20px;color:white;margin-left: 327px;" class="bt btn-success"> Add building</a>
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
                <div class="card-body">
                   
                   <div class="row">
                                   <div class="col-md-9">
                                   <div class=" mt-2 mb-2">
                                         <form action="{{route('searchAssignAgent') }}" method="GET" class="form-inline">
        
                              
                                        <div class="col-md-3 pl-1 pr-1">
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
                             <div class="col-md-2 pl-1 pr-1">
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
                                        <div class="col-md-3 ml-5 filter">
                                       <div class="filter_btn_wrapper">
                                           <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter" name="search">
                                       </div>
                                   </div>
                                   <div class="col-md-3 filter">
                                       <div class="filter_btn_wrapper">
                                           <input type="button" class="btn btn-success btn-block assign_btn" value="Assign" name="assign" style="padding: 10px 2px 10px 0px;" id="assign-single-property">
                                       </div>
                                   </div>
                                     </form> 
                               </div>
                             
                                   </div>
                            </div>
                    
                    <table  class="table m-b-0 toggle-arrow-tiny" style="margin-top: 2%" data-page-size="20" >
                        <thead>
                            <tr>
                                <th class="checkall" style="cursor:pointer">Select All</th>
                                <th data-toggle="true">SNO#</th>
                                <th data-toggle="true">Building Name</th>
                                <th data-toggle="true">Assign Agent</th>                               
                                <th data-toggle="all">Action</th>
                                <!--<th data-toggle="all">Action</th>-->
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
                                             <input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$values->id}}">
                                             @else
                                             Not Allowed
                                             @endif
                                             @else
                                             <input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$values->id}}">
                                             @endif
                                        </td>
                                        <td>{{$counter++}}</td>
                                        <td>{{ucwords($values->Building)}}  <label class="label label-success">{{count($values->buildingCount)}} </label></td>
                                        <td>{{$values->user->user_name}}</td>
                                        <td><a class="edit_supervision" href='{{url("edit-buildingAssign")}}?action=edit&id={{$values->id}}'><i class="fa fa-edit"></i> Edit</a></td>
                                        <!--<td><a class="edit_supervision" href='{{url("delete-buildingAssign")}}?action=delete&id={{$values->Building}}'><i class="fa fa-edit"></i> Delete</a></td>-->
                                    </tr>
                           <?php  } 
                            } else{ ?>
                                <tr><td colspan="9" align="center">No Record Found</td></tr>
                            <?php }  ?>
                        </tbody>
                        <tfoot style="display:none !important;">
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
                 </form>
                 <div class="ml-auto pr-3">
                            {{$value->appends(Request::only('building','agent'))->links()}}
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
@include('inc.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet">
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
                toastr["error"]("please select Rows!");
            }else{
               $("#assignproperty").modal("show"); 
            }
            
        });
        $("#assign-property-btn").click(function(){
            if(!$('.agents_ids:checkbox:checked').val()){
                toastr["error"]("Please select Agent");
            }else{
               if($('.agents_ids:checkbox:checked').length == 2){
                   toastr["error"]("Please select Only One Agent");
                   // return;
               }
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
  $('.row.owner_main_row').hide();
  $('.row.owner_information_link').show();
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

