@include('inc.header')
 <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
 <link href="{{url('public/assets/css/style.css')}}" rel="stylesheet">
<link href="{{url('public/assets/css/myStyle.css')}}" rel="stylesheet" >
<style type="text/css">
    .bootstrap-datetimepicker-widget,.dropdown-menu{
        font-size: 13px !important;
        font-weight: 500 !important;
    }
    .bootstrap-datetimepicker-widget{
        width:280px !important;
    }
    .topbar .top-navbar .navbar-header .navbar-brand .light-logo {
        display: inline-block;
    }
    .footable > thead > tr > th {
    padding: 10px 10px !important;
    text-align: start !important;
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Reminder Remarks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body reminder-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
        <div class="page-wrapper" style="margin-top: 2%;">
            <div class="container-fluid">
                
                <!-- owner's main page -->
                <div class="row owner_main_row" style="display: ">
                    <h3 class="page_heading" style="padding-bottom: 0px;"></h3>
                 <!--    <div class="row" style="margin:auto;width: 30%;">
                        <div class="col-sm-12">
                            <h3 style="padding: 1px;width: 167px;" class="bt btn-success">Agent Activities</h3>
                        </div>
                    
                    </div> -->
                        <div class="col-12 col-sm-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <div class="d-flex">
                                        <!-- <a id="add-new-owne-link" style="cursor: pointer;"><span><i class="fa fa-plus"></i></span></a> -->
                                        <div class="form-group ml-auto">
                                            <input id="demo-input-search2" class="demo-input-search" type="text" placeholder="Search" autocomplete="off">
                                        </div>
                                     </div>
                                     <div class="actions">
                                        <form action="{{url('agentActivityProperties')}}" method="get">
                                          <table>
                                            <tr>
                                              <td><label>Select Agent : </label></td>
                                              <td><select style="font-size: 12px;" class="form-control" name="agent" required="">
                                                <option disabled selected="" value="">Select Agent</option>
                                                @foreach($agents as $allAgents)
                                                <option <?php if($allAgents->id==@$selectedAgent){ echo "selected"; }   ?> value="{{$allAgents->id}}">{{$allAgents->user_name}}</option>
                                                @endforeach
                                            </select></td>
                                            <td><label>From : </label></td>
                                            <td><label><input required="" type="date" name="from_date" class="form-control" value="{{@$from_date}}"></label></td>
                                            <td><label>TO : </label></td>
                                            <td><label><input required="" value="{{@$to_date}}" type="date" name="to_date" class="form-control"></label></td>
                                            <td><label><input type="submit" name="get_activities" class="btn btn-primary" value="Submit"></label></td>
                                            </tr>
                                          </table>
                                        </form>
                                    </div>
                                    <table id="demo-foo-pagination" class="table">
                                        <thead>
                                            <tr>
                                                <th>Unit No </th>
                                                <th>Building Name </th>
                                                <th>Area </th>
                                                <th>LandLord </th>
                                                <th>Contact No</th>
                                                <th>Email</th>
                                                <th>Area Sqft</th>
                                                <th>Price</th>
                                                <th>Access</th>
                                                <th>Reminder Date</th>
                                                <th>Reminder Remarks</th>
                                            </tr>
                                        </thead>     
                                        <tbody style="font-size: 12px;">
                              @if(isset($properties))
                                  @if(count($properties) > 0)
                                    @foreach($properties as $property)
                                        <tr>
                                          <td>{{$property->unit_no}}</td>
                                          <td>{{$property->Building}}</td>
                                          <td>{{$property->area}}</td>
                                          <td>{{$property->LandLord}}</td>
                                          <td>{{$property->contact_no}}</td>
                                          <td>{{$property->email}}</td>
                                          <td>{{$property->Area_Sqft}}</td>
                                          <td>{{$property->Price}}</td>
                                          <td>{{$property->access}}</td>
                                          <td>@if(!is_null($property->getReminderRemarks['date_time'])){{$property->getReminderRemarks['date_time']}} @else N/A @endif</td>
                                          <td><p style="display: none;">{{$property->getReminderRemarks['description']}}</p>
                                            @if(!is_null($property->getReminderRemarks['description']))<button type="button" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-danger getNotificationDescription">See Remarks</button>
                                            @else
                                            N/A
                                            @endif
                                          </td>
                                        </tr>
                                    @endforeach
                                  @else
                                    <tr>
                                        <td colspan="12" style="text-align: center;">
                                            No Data Found!
                                        </td>
                                    </tr>
                                  @endif
                                @else
                                    <tr>
                                        <td colspan="12" style="text-align: center;">
                                            No Data Found!
                                        </td>
                                    </tr>
                              @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="12">
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
            </div>
        </div>
@include('inc.footer')
<script type="text/javascript">
  $(document).ready(function(){
    $(document).delegate('.getNotificationDescription','click',function(){
      var description=$(this).prev('p').text();
      $('.reminder-body').text(description);
    })
  })
</script>
<!-- <script type="text/javascript">
    $("select#agent_name").change(function(){

    var agentId  = $(this).children("option:selected").val();
    var token      = $('input[name=_token').val();
        $.ajax({

            headers: {
         'X-CSRF-TOKEN': $('input[name="csrf-token"]').attr('content')
         },

         type:'GET',
         url: "{{url('agentActivityProperties')}}",
         data:{'_token' : token,'agentId':agentId},
         dataType: 'json',
         success: function(data){
            

        if (data.length > 0) {
            $.each(data,function(index,key){
               var unitno     =key['unit_no'];
               var building   =key['Building'];
               var area       =key['area'];
               var landlord   =key['LandLord'];
               var email      =key['email'];
               var contact_no =key['contact_no'];
               var sqft       =key['Area_Sqft'];
               var price      =key['Price'];
               var access     =key['access'];
               $('.unitno').html(unitno);
               $('.building').html(building);
               $('.area').html(area);
               $('.landlord').html(landlord);
               $('.sqft').html(sqft);
               $('.price').html(price);
               $('.number').html(contact_no);
               $('.email').html(email);
               $('.access').html(access);
        

            });
        }
            else{
                $('#table_body').html('<h2>'+'No Property Found'+'</h2>');
            }
      }
      });    
    });
</script> -->
</body>
</html>