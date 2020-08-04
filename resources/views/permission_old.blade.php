@include('inc.header')
@if(!session("user_id") && ucfirst(session('role')) != (ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
<script type="text/javascript">
   window.location='{{url("/")}}';
</script>
<?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<style>
   .filter_input {
   background-color: #1976D2;
   color: #fff;
   }
   .filter_btn{
   height:37px;
   }
   .filter_input::placeholder{
   color:#fff;
   }
   .nav-link{
   padding: .5rem 1rem !important;
   text-align:center !important;
   color:black;
   }
   .deals_tabs a {
   padding-top: 8px !important;
   padding-bottom: 8px !important;
   }
   .nav-tabs .nav-link.active{
   color: white !important;
   background-color: #1976D2 !important;
   }
   span.tab-heading{
   display:block;
   font-size:12px !important;
   font-weight:400 !important;
   }
   .tabcontent-border{
   background: white !important;
   min-height: 400px;
   padding:20px 0px !important;
   }
   .nav-tabs {
   border-bottom: 2px dashed #ddd !important;
   /*margin-bottom: 15px !important;*/
   background: white !important;
   }
   hr{
   margin-bottom:3rem;
   }
   label,input,textarea{
   font-size:12px !important;
   }
   .back_btn_row, .prop_back_btn_row, .property_tabs_row, .prop_information_link,.owner_docs_link, .tabs_row, .owner_information_link{
   display:block;
   }
   .hide{
   display: none;
   }
</style>
<style>
    .tab-content>.tab-pane>.row > div > p, .tab-content>.tab-pane>.row > div > input {
        font-size: 14px !important;
        min-height: 15px !important;
    }
</style>
<div class="page-wrapper" style="margin-top: 2%;">
   <div class="container-fluid">
      @if(session('msg'))
      {!! session('msg') !!}
      @endif
      <div class="row owner_main_row_leads" >
         <h3 class="page_heading">Users Access</h3>
         <div class="col-12 col-sm-12 mb-2">
            <div class="dropdown_wrapper ">
            </div>
         </div>
         <div class="col-12 col-sm-12">
            <div class="card">
               <ul class="nav nav-tabs deals_tabs">
                  <li class="nav-item">
                     @if(@$_GET['type']=='')
                     <a href="{{url('permission')}}" class="nav-link active py-3">Users</a>
                     @else
                     <a href="{{url('permission')}}" class="nav-link py-3">Users</a>
                     @endif 
                  </li>
               </ul>
               <div class="card-body table-responsive" >
                  <div class="col-lg-12">
                     <div class="row">
                        <div class="col-md-12">
                           <form action="filterPermissionUser" method="GET" class="">
                              <div class="row mt-2 mb-2">
                                 <div class="col-md-9">
                                    <div class="row">
                                       <div class="col-md-2 pl-1 pr-1">
                                          <div class="dropdown_wrapper ">
                                             <input type="text" class="form-control filter_input" list="userF" placeholder="Select Users" name="filterUser">
                                             <datalist id="userF">
                                                <option value="">Select Users</option>
                                                @foreach($usersall as $user)
                                                <option value="{{$user['user_name']}}"></option>
                                                @endforeach
                                             </datalist>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3 ">
                                    <div class="filter_btn_wrapper">
                                       <input type="submit" class="btn btn-danger btn-block filter_btn" value="Filter" name="search">
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <table  class="table">
                     <thead>
                        <tr>
                           <th>Sno# </th>
                           <th>ID </th>
                           <th>Name </th>
                           <th>Refernce </th>
                           <th>Email </th>
                           <th>Role </th>
                           <th>Phone</th>
                           <th>Updated_at</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <form id="bulkForm" class="form-inline">
                        <input type='hidden' value='' name='status' class='status'>
                        <tbody style="font-size: 12px;">
                            @php  @endphp
                           @if(isset($users))
                               @if(count($users) > 0)
                                   @foreach($users as $user)
                                       <tr class="present_row">
                                          <td  class="permissionEditId hide" >{{$user->permission['id']}}</td>
                                          <td  class="dashboardView hide" >{{$user->permission['dashboardView']}}</td>
                                          <td  class="propertyView hide" >{{$user->permission['propertyView']}}</td>
                                          <td  class="propertyAdd hide" >{{$user->permission['propertyAdd']}}</td>
                                          <td  class="propertyEdit hide" >{{$user->permission['propertyEdit']}}</td>
                                          <td  class="propertyDelete hide" >{{$user->permission['propertyDelete']}}</td>
                                          <td  class="propertyAssign hide" >{{$user->permission['propertyAssign']}}</td>
                                          <td  class="propertyBulk hide" >{{$user->permission['propertyBulk']}}</td>
                                          <td  class="coldcallingView hide" >{{$user->permission['coldcallingView']}}</td>
                                          <td  class="coldcallingAdd hide" >{{$user->permission['coldcallingAdd']}}</td>
                                          <td  class="coldCallingAssign hide" >{{$user->permission['coldCallingAssign']}}</td>
                                          <td  class="coldcallingBulk hide" >{{$user->permission['coldcallingBulk']}}</td>
                                          <td  class="leadView hide" >{{$user->permission['leadView']}}</td>
                                          <td  class="leadAdd hide" >{{$user->permission['leadAdd']}}</td>
                                          <td  class="leadEdit hide" >{{$user->permission['leadEdit']}}</td>
                                          <td  class="leadBulk hide" >{{$user->permission['leadBulk']}}</td>
                                          <td  class="buildingView hide" >{{$user->permission['buildingView']}}</td>
                                          <td  class="buildingAdd hide" >{{$user->permission['buildingAdd']}}</td>
                                          <td  class="supervisionView hide" >{{$user->permission['supervisionView']}}</td>
                                          <td  class="supervisionAdd hide" >{{$user->permission['supervisionAdd']}}</td>
                                          <td  class="supervisionEdit hide" >{{$user->permission['supervisionEdit']}}</td>
                                          <td  class="dealView hide" >{{$user->permission['dealView']}}</td>
                                          <td  class="dealAdd hide" >{{$user->permission['dealAdd']}}</td>
                                          <td  class="dealEdit hide" >{{$user->permission['dealEdit']}}</td>
                                          <td  class="dealBulk hide" >{{$user->permission['dealBulk']}}</td>
                                          <td  class="loanView hide" >{{$user->permission['loanView']}}</td>
                                          <td  class="loanAdd hide" >{{$user->permission['loanAdd']}}</td>
                                          <td  class="loanEdit hide" >{{$user->permission['loanEdit']}}</td>
                                          <!--hidden fields end-->
                                          <td>{{ (($users->currentPage() - 1 ) * $users->perPage() ) + $loop->iteration }}</td>
                                          <td class="uId">{{$user->id}}</td>
                                          <td class="name" >{{$user->user_name}}</td>
                                          <td class="reference">{{$user->reference}}</td>
                                          <td class="email">{{$user->Email}}</td>
                                          <td class="role">@if($user->role == 3)<label class="label label-success">AGENT</label> @else<label class="label label-danger">SUPER AGENT</label>@endif</td>
                                          <td class="phone">{{$user->Phone}}</td>
                                          <td class="updated" >{{date('d M Y',strtotime($user->updated_at))}}</td>
                                          <td><label data-toggle="modal" data-target="#exampleModal" style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="show_content" name="{{$user->id}}"><i class="fa fa-edit"></i> Edit</label>
                                          </td>
                                       </tr>
                                   @endforeach
                               @else
                               <tr>
                                  <td colspan="15" align="center">No Record Found</td>
                               </tr>
                               @endif
                           @endif
                        </tbody>
                     </form>
                  </table>
               </div>
               <div class="ml-auto pr-3">
                  {{$users->appends(Request::only('user'))->links()}}  
               </div>
            </div>
         </div>
      </div>
      <!--end of assign  popup-->
      <!--edit popup-->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title   content_model_title" id="exampleModalLabel1">Edit Permission</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <div class="modal-body">
                  <form action="{{url('permissionUpdateForm')}}" method="post" class="form-horizontal" >
                     @csrf
                     <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#dasboard" role="tab"><span><i class="fa fa-dashboard"></i></span><span class="tab-heading">Dashboard</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#properties" role="tab"><span><i class="ti-home"></i></span><span class="tab-heading"> Properties</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#coldcallings" role="tab"><span><i class="fa fa-phone"></i></span><span class="tab-heading">Coldcallings</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#leads" role="tab"><span><i class="fa fa-line-chart"></i></span><span class="tab-heading"> Leads</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#buildings" role="tab"><span><i class="fa fa-building"></i></span><span class="tab-heading">Buildings</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Supervisions" role="tab"><span><i class="fa fa-users"></i></span><span class="tab-heading">Supervisions</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Deals" role="tab"><span><i class="fa fa-handshake-o"></i></span><span class="tab-heading">Deals</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#loans" role="tab"><span><i class="fa fa-money"></i></span><span class="tab-heading">Loans</span></a> </li>
                     </ul>
                     <div class="tab-content tabcontent-border">
                        <div class="tab-pane active p-20 " id="dasboard" role="tabpanel">
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> View</p>
                                 <!--hidden fields for userid and userPermission Id-->
                                 <input type="hidden" name="permissionEditId" id="permissionEditId">  
                                 <input type="hidden" name="uId" id="uId"> 
                                 <!--end of hidden fields-->
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="dashbordView" id="dashbordView" value="1" >
                              </div>
                           </div>
                        </div>
                        <!--end of 1sttab-->       
                        <div class="tab-pane  p-20" id="properties" role="tabpanel">
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> View</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="propertyView" id="propertyView" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Add</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="propertyAdd" id="propertyAdd" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Edit</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="propertyEdit" id="propertyEdit" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Delete</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="propertyDelete" id="propertyDelete" value="1" >
                              </div>
                           </div>
                            <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Assign</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="propertyAssign" id="propertyAssign" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Bulk</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="propertyBulk" id="propertyBulk" value="1" >
                              </div>
                           </div>
                        </div>
                        <!--end second tab-->
                        <div class="tab-pane  p-20" id="coldcallings" role="tabpanel">
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> View</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="coldcallingView" id="coldcallingView" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Add</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="coldcallingAdd" id="coldcallingAdd" value="1" >
                              </div>
                           </div>
                            <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Assign</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="coldCallingAssign" id="coldCallingAssign" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Bulk</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="coldcallingBulk" id="coldcallingBulk" value="1" >
                              </div>
                           </div>
                        </div>
                        <!--end of 3rd tab-->
                        <div class="tab-pane  p-20" id="leads" role="tabpanel">
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> View</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="leadView" id="leadView" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Add</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="leadAdd" id="leadAdd" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Edit</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="leadEdit" id="leadEdit" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Bulk</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="leadBulk" id="leadBulk" value="1" >
                              </div>
                           </div>
                        </div>
                        <!--end of 4th tab-->
                        <div class="tab-pane  p-20" id="buildings" role="tabpanel">
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> View</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="buildingView" id="buildingView" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Add</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="buildingAdd" id="buildingAdd" value="1" >
                              </div>
                           </div>
                        </div>
                        <!--end of tth tab-->
                        <div class="tab-pane  p-20" id="Supervisions" role="tabpanel">
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> View</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="supervisionView" id="supervisionView" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Add</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="supervisionAdd" id="supervisionAdd" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Edit</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="supervisionEdit" id="supervisionEdit" value="1" >
                              </div>
                           </div>
                        </div>
                        <!-- Supevision End-->
                        <div class="tab-pane  p-20" id="Deals" role="tabpanel">
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> View</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="dealView" id="dealView" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Add</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="dealAdd" id="dealAdd" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Edit</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="dealEdit" id="dealEdit" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Bulk</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="dealBulk" id="dealBulk" value="1" >
                              </div>
                           </div>
                        </div>
                        <!-- Deals End-->
                         <div class="tab-pane  p-20" id="loans" role="tabpanel">
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> View</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="loanView" id="loanView" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Add</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="loanAdd" id="loanAdd" value="1" >
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-sm-2">
                                 <p class="h4" align="center"> Edit</p>
                              </div>
                              <div class="form-group col-sm-1">
                              </div>
                              <div class="form-group col-sm-3">
                                 <input type="checkbox" class="form-control"   name="loanEdit" id="loanEdit" value="1" >
                              </div>
                           </div>
                        </div>
                        <div class="form-group col-sm-12">
                           <input type="submit" value="Submit" class="btn btn-block btn-lg btn-success" name="submitLead"> 
                        </div>
                     </div>
                     <!--end of main div that contains tab-->   
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal-footer">
   </div>
</div>
</div>
</div>
</div>
@include('inc.footer')
<script>
   $(document).delegate('.show_content','click',function(){
     var $row = $(this).closest("tr");    // Find the row
     var permissionEditId=$row.find(".permissionEditId").text();  
     var $uId = $row.find(".uId").text();
   
       var dashboardView=$row.find(".dashboardView").text();
      var propertyView=$row.find(".propertyView").text();
      var propertyAdd=$row.find(".propertyAdd").text();
      var propertyEdit=$row.find(".propertyEdit").text();
      var propertyDelete=$row.find(".propertyDelete").text();
       var propertyAssign=$row.find(".propertyAssign").text();
      var propertyBulk=$row.find(".propertyBulk").text();
      var coldcallingView=$row.find(".coldcallingView").text();
      var coldcallingAdd=$row.find(".coldcallingAdd").text();
      var coldCallingAssign=$row.find(".coldCallingAssign").text();
      var coldcallingBulk=$row.find(".coldcallingBulk").text();
      var leadView=$row.find(".leadView").text();
      var leadAdd=$row.find(".leadAdd").text();
      var leadEdit=$row.find(".leadEdit").text();
      var leadBulk=$row.find(".leadBulk").text();
      var buildingView=$row.find(".buildingView").text();
      var buildingAdd=$row.find(".buildingAdd").text();
      
      var supervisionView=$row.find(".supervisionView").text();
      var supervisionAdd=$row.find(".supervisionAdd").text();
      var supervisionEdit=$row.find(".supervisionEdit").text();
      
       var dealView=$row.find(".dealView").text();
       var dealAdd=$row.find(".dealAdd").text();
       var dealEdit=$row.find(".dealEdit").text();
       var dealBulk=$row.find(".dealBulk").text();
        
    var loanView=$row.find(".loanView").text();
    var loanAdd=$row.find(".loanAdd").text();
    var loanEdit=$row.find(".loanEdit").text();
    
      
     // Find the text
    
    //assigning to to Edit Popup fields
    
   $("#permissionEditId").val(permissionEditId); 
   
    $("#uId").val($uId); 
   
    if( dashboardView=='1'){
      $("#dashbordView").prop('checked', true);
    }else{
      $("#dashbordView").prop('checked', false);
    }
   
    if( propertyView=='1'){
      $("#propertyView").prop('checked', true);
    }else{
      $("#propertyView").prop('checked', false);
    }
   
    if( propertyAdd=='1'){
      $("#propertyAdd").prop('checked', true);
    }else{
      $("#propertyAdd").prop('checked', false);
    }
   
    if( propertyEdit=='1'){
      $("#propertyEdit").prop('checked', true);
    }else{
      $("#propertyEdit").prop('checked', false);
    }
   
    if( propertyDelete=='1'){
      $("#propertyDelete").prop('checked', true);
    }else{
      $("#propertyDelete").prop('checked', false);
    }

    if( propertyAssign=='1'){
      $("#propertyAssign").prop('checked', true);
    }else{
      $("#propertyAssign").prop('checked', false);
    }
   
    if( propertyBulk=='1'){
      $("#propertyBulk").prop('checked', true);
    }else{
      $("#propertyBulk").prop('checked', false);
    }
   
    if( coldcallingView=='1'){
      $("#coldcallingView").prop('checked', true);
    }else{
      $("#coldcallingView").prop('checked', false);
    }
   
    if( coldcallingAdd=='1'){
      $("#coldcallingAdd").prop('checked', true);
    }else{
      $("#coldcallingAdd").prop('checked', false);
    }

    if( coldCallingAssign=='1'){
      $("#coldCallingAssign").prop('checked', true);
    }else{
      $("#coldCallingAssign").prop('checked', false);
    }
   
    if( coldcallingBulk=='1'){
      $("#coldcallingBulk").prop('checked', true);
    }else{
      $("#coldcallingBulk").prop('checked', false);
    }
   
    if( leadView=='1'){
      $("#leadView").prop('checked', true);
    }else{
      $("#leadView").prop('checked', false);
    }
   
    if( dashboardView=='1'){
      $("#dashbordView").prop('checked', true);
    }else{
      $("#dashbordView").prop('checked', false);
    }
   
    if( leadAdd=='1'){
      $("#leadAdd").prop('checked', true);
    }else{
      $("#leadAdd").prop('checked', false);
    }
   
    if( leadEdit=='1'){
      $("#leadEdit").prop('checked', true);
    }else{
      $("#leadEdit").prop('checked', false);
    }
   
    if( leadBulk=='1'){
      $("#leadBulk").prop('checked', true);
    }else{
      $("#leadBulk").prop('checked', false);
    }
   
    if( buildingView=='1'){
      $("#buildingView").prop('checked', true);
    }else{
      $("#buildingView").prop('checked', false);
    }
   
    if( buildingAdd=='1'){
      $("#buildingAdd").prop('checked', true);
    }else{
      $("#buildingAdd").prop('checked', false);
    }
   
   
   
   
   if( supervisionView=='1'){
      $("#supervisionView").prop('checked', true);
    }else{
      $("#supervisionView").prop('checked', false);
    }
   
   if( supervisionAdd=='1'){
      $("#supervisionAdd").prop('checked', true);
    }else{
      $("#supervisionAdd").prop('checked', false);
    }
   
   if( supervisionEdit=='1'){
      $("#supervisionEdit").prop('checked', true);
    }else{
      $("#supervisionEdit").prop('checked', false);
    }
   
   
   if( dealView=='1'){
      $("#dealView").prop('checked', true);
    }else{
      $("#dealView").prop('checked', false);
    }
    
      if( dealAdd=='1'){
      $("#dealAdd").prop('checked', true);
    }else{
      $("#dealAdd").prop('checked', false);
    }
    
      if( dealEdit=='1'){
      $("#dealEdit").prop('checked', true);
    }else{
      $("#dealEdit").prop('checked', false);
    }
    // 
    if( loanView=='1'){
      $("#loanView").prop('checked', true);
    }else{
      $("#loanView").prop('checked', false);
    }
    
      if( loanAdd=='1'){
      $("#loanAdd").prop('checked', true);
    }else{
      $("#loanAdd").prop('checked', false);
    }
    
      if( loanEdit=='1'){
      $("#loanEdit").prop('checked', true);
    }else{
      $("#loanEdit").prop('checked', false);
    }
    // 
    
    
     
      if( dealBulk=='1'){
        
      $("#dealBulk").prop('checked', true);
    }else{
       
      $("#dealBulk").prop('checked', false);
    }
   
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

</body>
</html>