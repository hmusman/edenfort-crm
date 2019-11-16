@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=ucfirst('Admin'))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<style>
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
                                        <div class="col-md-3 ml-5">
                                       <div class="filter_btn_wrapper">
                                           <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter" name="search">
                                       </div>
                                   </div>
                                     </form> 
                               </div>
                             
                                   </div>
                            </div>
                    
                    <table  class="table m-b-0 toggle-arrow-tiny" style="margin-top: 2%" data-page-size="20" >
                        <thead>
                            <tr>
                                <th data-toggle="true">SNO#</th>
                                <th data-toggle="true">Building Name</th>
                                 <th data-toggle="true">Assign Agent</th>                               
                                <th data-toggle="all">Action</th>
                                <!--<th data-toggle="all">Action</th>-->
                            </tr>
                        </thead>     
                        <tbody>
                  <?php if(count($value) > 0){ $counter=1;
                             foreach($value as $values){ ?>
                                    <tr>
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
@include('reminder')
