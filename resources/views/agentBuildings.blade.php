@include('inc.header')

@if(!session("user_id") || ucfirst(session('role'))!=(ucfirst('Agent') || ucfirst('SuperAgent')))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
@if($permissions->buildingView!=1)
<script type="text/javascript">
    window.location='{{url("404")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<style type="text/css">
    .building-table td, .building-table th{
        text-align: center !important;
    }
</style>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{url('addLandlordEmailPass')}}" method="get">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body add_model_body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
    </form>
  </div>
</div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Set Remider</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class='col-sm-12'>
                            <div class="form-group">
                                <input type="text" class="form-control date-time" placeholder="set min date" id="min-date"> 
                                <span class="date_time_error" style="font-size: 11px;font-weight: 500;color: red;"></span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <textarea class="form-control reminder_description" rows="4" class="" name="reminder_description" placeholder="Description"></textarea>
                            <span class="reminder_description-error" style="font-size: 11px;font-weight: 500;color: red;"></span>
                        </div>
                        <div class="col-sm-12" style="text-align: end">
                            <div class="form-group" style="padding-top: 6%;">
                                <input type="button" value="OK" class="reminder btn btn-success" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
        <div class="page-wrapper">
            <div class="container-fluid">
                @if(session('msg'))
                    {!! session('msg') !!}
                @endif
                <div class="row owner_main_row">
            
                    <h3 class="page_heading">Buildings</h3>
                    <div class="row" style="margin:auto;width: 34%;margin-top: 9px">
                        
                      
                        
                    </div>
                    <form action="{{url('PropertyBulkActions')}}" method="GET" style="width: 100%;">

                        <div class="col-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
       @if($permissions->buildingAdd==1)                                      <a style="cursor: pointer" id="add-new-owne-link"><span><i class="fa fa-plus"></i></span></a>@endif
                                        <div class="form-group ml-auto">
                                        
                                            <input id="demo-input-search2" class="demo-input-search" type="text" placeholder="Search" autocomplete="off">
                                        </div>
                                     </div>
                                     <div class="actions">
                                        <select class="form-control action_select" name="action">
                                            <option value="NULL">Bulk Action</option>
                                            <option value="Update">Update</option>
                                        </select>
                                        <input type="submit" name="apply" value="Apply" class="btn btn-success apply">
                                    </div>
                @if(isset($_GET['action']))
                                    <table id="demo-foo-pagination" class="table">
                                        <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Unit No </th>
                                                <th>Building Name </th>
                                                <th>Area </th>
                                                <th>LandLord </th>
                                                <th>Contact No</th>
                                                <th>Email</th>
                                                <th>Area Sqft</th>
                                                <th>Price</th>
                                                <th>Assign agent</th>
                                                <th>Access</th>
                                            </tr>
                                        </thead>     
                                        <tbody style="font-size: 12px;">
                @if(isset($result_data))
                    @if(count($result_data) > 0)
                        <?php $counter=0; ?>
                            @foreach($result_data as $record)
                                            <tr>
                                                <td><input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$record->id}}"></td>
                                                <td>{{$record->unit_no}}</td>
                                                <td>{{$record->Building}}</td>
                                                <td>{{$record->area}}</td>
                                                <td>{{strtoupper($record->LandLord)}}</td>
                                                <td><?php $temp=explode(',', $record->contact_no);foreach ($temp as $key=>$value) {
                                                    if($key==0){ ?>
                                                   <span>{{$value}}</span>&#160;&#160;<label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer" class="label label-primary add_phone">Add</label>
                                                    <?php }else{ ?>
                                                        <span style="display: block;width: 100%;">{{$value}}</span>
                                                <?php  } } ?></td>
                                                <td><?php $temp=explode(',', $record->email);foreach ($temp as $key=>$value) {
                                                    if($key==0){ ?>
                                                   <span>{{$value}}</span>&#160;&#160;<label data-toggle="modal" data-target="#exampleModal" id="{{$record->id}}" style="cursor: pointer" class="label label-primary add_email">Add</label>
                                                    <?php }else{ ?>
                                                        <span style="display: block;width: 100%;">{{$value}}</span>
                                                <?php  } } ?></td>
                                                <td>{{$record->Area_Sqft}}</td>
                                                <td>{{$record->Price}}</td>
                                                
                                                <td>{{$record->agent}}</td>
                                                <td>
                                                    <select class="form-control access_select" style="font-size: 11px;font-weight: 500;" unit="{{$record->unit_no}}" required="" name="updated_access[{{$counter++}}]">
                                                        <option <?php if(strtoupper($record->access)==strtoupper("For Rent")){echo "selected";}  ?> value="For Rent">For Rent</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("For Sale")){echo "selected";}  ?> value="For Sale">For Sale</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("Upcoming")){echo "selected";}  ?> value="Upcoming">Upcoming</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("Do Not Caller")){echo "selected";}  ?> value="Do Not Caller">Do Not Call</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("Call Back")){echo "selected";}  ?> value="Call Back">Call Back</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("Not answering")){echo "selected";}  ?> value="Not answering">Not answering</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("Not Intrested")){echo "selected";}  ?> value="Not Intrested">Not Intrested</option>
                                                        <option <?php if(strtoupper($record->access)==strtoupper("Intrested")){echo "selected";}  ?> value="Intrested">Intrested</option>
                                                    </select>
                                                </td>
                                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan="11" align="center">No Record Found</td></tr>
                        @endif 
                    @endif                    </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="11">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-split m-t-30"> </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>


            @else
                                    <table id="demo-foo-pagination" class="table building-table">
                                        <thead>
                                            <tr>
                                                <th data-toggle="true">SNO#</th>
                                                <th data-toggle="true">Building Name</th>
<!--                                             
                                                <th data-toggle="all">Action</th>
                                                <th data-toggle="all">Action</th>-->
                                            </tr>
                                        </thead>     
                                        <tbody style="font-size: 12px;">
                    <?php  if(isset($building)){ ?>
                     <?php $counter=1; ?>
                      @foreach($building as $record)
                                            <tr>
                                                <td>{{$counter++}}</td>
                                                <td>{{ucwords($record->building_name)}}</td>
                                                
                                                <!--<td><a class="edit_supervision" href='{{url("edit-building-agent")}}/<?php echo $record->id; ?>'><i class="fa fa-edit"></i> Edit</a></td>
                                <td><a class="delete_supervision" href='{{url("delete-agent-building")}}?action=delete&id={{$record->id}}'><i class="fa fa-edit"></i> Delete</a></td>-->
                                            </tr>
                           @endforeach
                           <?php }  ?>
                           
                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="9">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-split m-t-30"> </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                          
            <input id="model" data-toggle="modal" data-target=".bs-example-modal-sm" class="btn btn-danger"  style="visibility: hidden;" type="button" value="">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
@endif
<div class="row owner_information_link" style="display: none;">
                       <div class="col-12 back_wrapper" <span=""><i class="fas fa-arrow-circle-left" id="back_to_owner"></i>
        <span id="back_to_owner_text">Add New Building</span>
        </div>
        <div class="col-lg-12">
            <div class="card card-outline-info" style="margin-top: 40px;">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Building Details</h4>
                </div>
                <div class="card-body">
                    <form action="{{url('/insert-building-agent')}}" id="user_form" class="form-horizontal" method="post" novalidate="novalidate">
                    @csrf                      
                     <div class="form-body">
                            <div class="row">
                                
                                 <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Building Name</label>
                                     
                                            
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="" name="building_name" value="" required="">
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
                                    <!--            -->
                                    <!--                <option value="adnan821">adnan821</option>-->
                                    <!--            -->
                                    <!--                <option value="Ali821">Ali821</option>-->
                                    <!--            -->
                                    <!--                <option value="yasirbilal">yasirbilal</option>-->
                                    <!--            -->
                                    <!--                <option value="ejazzabir">ejazzabir</option>-->
                                    <!--            -->
                                    <!--                <option value="aliusman">aliusman</option>-->
                                    <!--            -->
                                    <!--                <option value="quaidjohar">quaidjohar</option>-->
                                    <!--            -->
                                    <!--                <option value="imtiazahmad">imtiazahmad</option>-->
                                    <!--            -->
                                    <!--                <option value="shahzadmehmood">shahzadmehmood</option>-->
                                    <!--            -->
                                    <!--                <option value="wasimjaved">wasimjaved</option>-->
                                    <!--            -->
                                    <!--                <option value="akashahmad">akashahmad</option>-->
                                    <!--            -->
                                    <!--                <option value="sadiausman">sadiausman</option>-->
                                    <!--            -->
                                    <!--                <option value="abdurrehman">abdurrehman</option>-->
                                    <!--            -->
                                    <!--                <option value="samarhassan">samarhassan</option>-->
                                    <!--            -->
                                    <!--                <option value="amirhussain">amirhussain</option>-->
                                    <!--            -->
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
                                            <button type="submit" class="btn btn-success submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"> </div>
                            </div>
                        </div>
                    
                </div></form>
            </div>
        </div>
    </div>
</div>
                <div class="row owner_information_link1" style="display: none;">
                       <div class="col-12 back_wrapper" <span=""><i class="fas fa-arrow-circle-left" id="back_to_owner"></i>
        <span id="back_to_owner_text">Add New Building</span>
        </div>
       
</div>
            </div>
        </div>
        
@include('inc.footer')
<script type="text/javascript">
$("#property").validate();
     $("body").delegate(".apply","click",function(e){
        var action=$(".action_select option:selected").val();
        if(action=="NULL" || action=="Delete"){
            e.preventDefault();
            return;
        }
    })
     $('.access_select').change(function(e){
        if($(this).val().toLowerCase()=='call back' || $(this).val().toLowerCase()=='upcoming' || $(this).val().toLowerCase()=='intrested' || $(this).val().toLowerCase()=='not answering'){
            var unit=$(this).attr("unit");
            var access=$(this).val();
            $('.reminder').attr('unit',unit);
            $('.reminder').attr('access',access);
            $('.reminder').attr('reminder_type',access);
            $("#model").trigger( "click" );
        }
     })
     $('.reminder').click(function(){
        $('.date_time_error,.reminder_description-error').text("");
        if($('.date-time').val()==""){
           $('.date_time_error').text('This field is required!');
           return; 
        }
        else if($('.reminder_description').val()==""){
            $('.reminder_description-error').text('This field is required!');
           return; 
        }
        var time_date=$('.date-time').val();
        var description=$('.reminder_description').val();
        $.ajax({
            url:'<?php echo url('reminder');  ?>',
            type:'get',
            data:{time_date:time_date,description:description,unit:$(this).attr('unit'),access:$(this).attr('access'),reminder_type:$(this).attr('reminder_type')},
            success:function(data){
                if(data=="true"){
                    location.reload();
                }else{
                    $('.reminder_description-error').html(data);
                }
            }
        })
     })
$('body').delegate('.add_phone','click',function(){
    var id=$(this).attr('id');
    $('.add_model_body').html('<label>Phone</label><input type="number" name="phone" class="form-control"><input type="hidden" name="id" class="form-control" value="'+id+'">');
 })
  $('body').delegate('.add_email','click',function(){
    var id=$(this).attr('id');
    $('.add_model_body').html('<label>Email</label><input type="email" name="email" class="form-control"><input type="hidden" name="id" class="form-control" value="'+id+'">');
 });
 $('#building').click(function(){
  $('.row.owner_main_row').hide();
  $('.row.owner_information_link').show();
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

    </body>
</html>