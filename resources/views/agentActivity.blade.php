@include('inc.header')
<!-- DataTables -->
<link href="{{url('public/Green/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('public/Green/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />     
<style>
  #datatable-buttons{
    font-size: 11px;
    font-weight: bold;
  }
  #datatable-buttons thead{
    background-color: #2fa97c;
    color: white;
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
                        <h4 class="page-title mb-1">Agents Activity</h4>
                        <ol class="breadcrumb m-0">
                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li> -->
                        <li class="breadcrumb-item active">Edenfort CRM Agents Activity</li>
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

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header" style="background-color: white;">
                                  <form action="{{url('agentActivityProperties')}}" method="get">
                                    <table>
                                      <tbody class="row ml-3 mt-3">
                                        <tr class="mr-4">
                                        <td class="select_agent"><label><b>Select Agent: </b></label></td>
                                        <td><select style="font-size: 12px;" class="form-control" name="agent" required="">
                                          <option disabled selected="" value="">Select Agent</option>
                                          @foreach($agents as $allAgents)
                                          <option <?php if($allAgents->id==@$selectedAgent){ echo "selected"; }   ?> value="{{$allAgents->id}}">{{$allAgents->user_name}}</option>
                                          @endforeach
                                      </select></td>
                                      </tr>
                                      <tr class="mr-4">
                                      <td class="select_from"><label><b>From: </b></label></td>
                                      <td><label><input required="" type="date" name="from_date" class="form-control" value="{{@$from_date}}"></label></td>
                                      </tr>
                                      <tr class="mr-4">
                                      <td class="select_to"><label><b>TO: </b></label></td>
                                      <td><label><input required="" value="{{@$to_date}}" type="date" name="to_date" class="form-control"></label></td>
                                      </tr>
                                      <tr class="mr-4">
                                      <td class="submit_btn"><label>
                                        <input type="submit" name="get_activities" class="btn btn-primary" value="Submit"></label></td>
                                      </tr>
                                      </tbody>
                                    </table>
                                  </form>
                                </div>
                                <div class="card-body">
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                      <tbody>
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
                                  </table>
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
<!-- Required datatable js -->
<script src="{{url('public/Green/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{url('public/Green/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/jszip/jszip.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{url('public/Green/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

<!-- Datatable init js -->
<script src="{{url('public/Green/assets/js/pages/datatables.init.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $(document).delegate('.getNotificationDescription','click',function(){
      var description=$(this).prev('p').text();
      $('.reminder-body').text(description);
    })
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