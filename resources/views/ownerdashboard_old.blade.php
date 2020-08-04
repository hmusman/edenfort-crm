@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=ucfirst('owner'))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<style type="text/css">
table tbody tr td  {
    border: 1px solid #ccc !important;
    color: black !important;
}
.label-success:hover{
	cursor: pointer;
}
.label-success{
	background-color: green;
    color: white;
    padding: 1px 10px;
}
strong{
	    color: white!important;
    background: #1976d2;
    padding: 0px 10px;
}
.ownerDetails{
	margin-bottom: 2%;
	    padding: 0px 10px;
}
.ownerDetails_back{
	background: white;
	margin-bottom: 2%;
	padding: 25px 0px 10px 20px;
	font-size: 13px;
    font-weight: 500;
}
span.hidden-xs-down {
    font-size: 14px;
}
.nav-link{
    padding: 1rem 2rem;
}
.active{
    display:block !important;
}
.ownerDetails_back{
    padding:0px !important;
    margin-top: -34px !important;
}
.ownerDetails{
    padding: 15px 0px;
    width: 70%;
    margin: auto;
}
.details-cols{
    text-align:center !important;
}
.details-icons{
        font-size: 16px !important;
    background: #1976D2;
    color: white;
    height: 35px;
    width: 35px;
    text-align: center;
    vertical-align: baseline;
    padding-top: 9px;
    border-radius: 100%;
}
span.hidden-xs-down {
    font-size: 13px !important;
    font-weight: 400 !important;
}
span.tab-heading {
    display: block;
    font-size: 12px !important;
    font-weight: 400 !important;
}
.tabcontent-border {
    background: white !important;
    min-height: 400px;
    padding: 20px 0px !important;
}
</style>
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
 <div class="page-wrapper">
     <div class="col-sm-12 ownerDetails_back">
		@if(isset($ownerDetails))
		<div class="row ownerDetails">
			<div class="col-sm-4 details-cols">
				<i class="fa fa-user details-icons" style="font-size:24px"></i>
				<label>&nbsp;{{$ownerDetails->First_name}} {{$ownerDetails->Last_name}}</label>
			</div>
	        <div class="col-sm-4 details-cols">
				<i class="fa fa-envelope details-icons" style="font-size:24px"></i>
				<label>&nbsp;{{$ownerDetails->Email}}</label>
			</div>
			<div class="col-sm-4 details-cols">
				<i class="fa fa-phone details-icons" style="font-size:24px"></i>
				<label>&nbsp;{{$ownerDetails->Phone}}</label>
			</div>
		</div>
            @else
            <tr><td colspan="8" align="center">No Record Found</td></tr>
        @endif 
	</div>
 	<div class="container-fluid">
   
    
    <!-- inner view tabs-->
    
    @if(isset($_GET['contract_id']))
          @if(isset($result))
        @if(count($result) > 0)
            @foreach($result as $record)
    <div style="background:white;" class="mb-3 px-3">
                        <div class="tab-pane active p-20 " >
		  <h3 align="center">Owners Info</h3>
		   <div class="form-body">
		       <div class="row"> <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Unit No</th>
                                        <th>Building</th>
                                        <th>Location</th>
                                        <th>Bedroom</th>
                                        <th>Condition</th>
                                         <th>Washroom</th>
                                          <th>Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                      <td> {{$record['unit_no']}}</td>  
                                      <td>{{$record['Building']}} </td>
                                      <td> {{$record['area']}}</td>
                                      <td>{{$record['Bedroom']}} </td>
                                      <td> {{$record['Conditions']}}</td>
                                      <td>{{$record['Washroom']}} </td>
                                      <td> {{$record['access']}}</td>
                                    </tr>
                                 
                                </tbody>
                            </table></div>
                              
                         
                           </div> </div>
	</div>
    
    
        <div class="row owner_information_link" style="display: block;">
         <div class="col-lg-12">
            <div class="">
               <div>
                  <form action="http://crm.edenfort.ae/AddSupervison" class="form-horizontal" method="post" enctype="multipart/form-data" id="supervision" novalidate="novalidate">
                     <input type="hidden" name="_token" value="OBctm5vnznLbVVaHI7rJCQk9NCqtseKmS2T5jAR4">                     <input type="hidden" name="supervision_id" value="">
                     <ul class="nav nav-tabs nav-justified owner_tabs_list" role="tablist">
                      
                        <li class="nav-item" id="sc_tab"> 
                        <a class="nav-link active" data-toggle="tab" href="#messages8" role="tab"><span><i class="fa fa-file-archive-o"></i></span><span class="tab-heading">Supervision Contract</span></a> </li>
                        <li class="nav-item" id="pc_tab">
                            <a class="nav-link" data-toggle="tab" href="#cheque" role="tab"><span><i class="fa fa-money"></i></span><span class="tab-heading">Payment/Cheque</span></a> </li>
                        <li class="nav-item" id="as_tab">
                             <a class="nav-link" data-toggle="tab" href="#account_statment" role="tab"><span><i class="fa fa-wrench"></i></span><span class="tab-heading">Account Statement</span></a> </li>
                     </ul>
                     <!-- Tab panes -->
                     <div class="tab-content tabcontent-border">
                       
                        <div class="tab-pane p-20 active" id="messages8" role="tabpanel">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Contract attachment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$record['supervision_contract_start_date']}}</td>
                                        <td>{{$record['supervision_contract_end_date']}}</td>
                                     <!--   <td>{{$record['supervision_contract_attachment']}}</td>-->
                                        	<td><a href="{{URL::to('public/contract_attachments/'.$record['supervision_contract_attachment'])}}" target="_blank" class="attachments"><label class="label-success">Download</label></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane p-20" id="cheque" role="tabpanel">
                            	@if(isset($cheaqueRecord))
	        <table class="table table-bordered">
	        	<h2>Cheaque</h2>
	        	<thead>
	        		<tr style="background: #1976d2;color: white !important">
	        			<th>Cheaque Date</th>
	        			<th>clearance Date</th>
	        			<th>Cheaque Number</th>
	        			<th>Cheaque Amount</th>
	        			<th>Cheaque Attachment File</th>
	        		</tr>
	        	</thead>    
	            <tbody style="font-size: 12px;">
		@if(count($cheaqueRecord) > 0)
			@foreach($cheaqueRecord as $record)
	                <tr>
	                	<td>{{$record->cheque_date}}</td>
	                	<td>{{$record->cheque_deposit_date}}</td>
	                	<td>{{$record->cheque_number}}</td>
	                	<td>{{number_format($record->Cheque_amount,2)}}</td>
	                	<td><a href="{{URL::to('public/Cheque_attachment_files/'.$record->cheque_attach_file)}}" target="_blank" class="attachments"><label class="label-success">Download</label></a></td>
	                </tr>
			@endforeach
		@endif 
	@endif  	</tbody>
	        </table>
                            <!--<table class="table table-bordered table-hover">-->
                            <!--    <thead>-->
                            <!--        <tr>-->
                            <!--            <th>Cheque Number</th>-->
                            <!--            <th>Cheque amount</th>-->
                            <!--            <th>Cheque Date</th>-->
                            <!--            <th>Clearance Date</th>-->
                            <!--            <th>Attachments</th>-->
                            <!--        </tr>-->
                            <!--    </thead>-->
                            <!--    <tbody>-->
                            <!--        @foreach($cheaqueRecord as $cheaque)-->
                            <!--        <tr>-->
                            <!--            <td>{{$cheaque['cheque_number']}}</td>-->
                            <!--            <td>{{$cheaque['Cheque_amount']}}</td>	-->
                            <!--            <td>{{$cheaque['cheque_date']}}</td>-->
                            <!--            <td>{{$cheaque['cheque_deposit_date']}}</td>-->
                            <!--            <td>{{$cheaque['cheque_attach_file']}}</td>-->
                            <!--        </tr>-->
                            <!--        @endforeach-->
                            <!--    </tbody>-->
                            <!--</table>-->
                        </div>
                        <div class="tab-pane p-20" id="account_statment" role="tabpanel">
                                 <table class="table table-bordered">    
                <tbody style="font-size: 12px;">
    @if(isset($result))
        @if(count($result) > 0)
            @foreach($result as $record)
                    <tr>
                        <td colspan="2" style="background: #1976d2;color: white !important"><strong style="color: white;background: none !important">Account Statement</strong></td>
                    </tr>
                    <tr>
                        <td><strong style="background: none;color: black !important">Account Statement</strong></td>
                        <td><a href="{{url('generate-pdf')}}?record_id={{$recordID}}" class="attachments"><label class="label-success">Download</label></a></td>
                    </tr>
            @endforeach
        @else
            <tr><td colspan="11" align="center">No Record Found</td></tr>
        @endif
        @else
         <tr><td colspan="11" align="center">No Record Found</td></tr>
    @endif      </tbody>
            </table>
                            <!--<table class="table table-bordered table-hover">-->
                            <!--    <thead>-->
                                    
                            <!--        <tr>-->
                            <!--            <th>Maintenance Date</th>-->
                            <!--            <th>Description</th>-->
                            <!--            <th>AED</th>-->
                            <!--            <th>Maintenance type</th>-->
                            <!--            <th>Attachments</th>-->
                            <!--        </tr>-->
                            <!--    </thead>-->
                            <!--    <tbody>-->
                            <!--        @foreach($maintenances as $maintenance)-->
                            <!--        <tr>-->
                            <!--            <td>{{$maintenance['maintenance_date']}}</td>-->
                            <!--            <td>{{$maintenance['maintenance_description']}}</td>-->
                            <!--            <td>{{$maintenance['maintenance_AED']}}</td>-->
                            <!--            <td>{{$maintenance['maintenance_type']}}</td>-->
                            <!--            <td>{{$maintenance['maintenance_attach_file']}}</td>-->
                            <!--        </tr>-->
                            <!--        @endforeach-->
                            <!--    </tbody>-->
                            <!--</table>-->
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>@endforeach @endif @endif @endif
    <!--end of inner view tabs-->
    
 	<?php  if(isset($_GET['contract_id'])) { ?>
	 <!--	 <div class="row owner_main_row" style="padding: 0px 5%;">
            <h2 style="width: 100%;">Account Statmen</h2>
            <table class="table table-bordered">    
                <tbody style="font-size: 12px;">
    @if(isset($result))
        @if(count($result) > 0)
            @foreach($result as $record)
                    <tr>
                        <td colspan="2" style="background: #1976d2;color: white !important"><strong style="color: white;background: none !important">Account Statement</strong></td>
                    </tr>
                    <tr>
                        <td><strong style="background: none;color: black !important">Account Statement</strong></td>
                        <td><a href="{{url('generate-pdf')}}?record_id={{$recordID}}" class="attachments"><label class="label-success">Download</label></a></td>
                    </tr>
            @endforeach
        @else
            <tr><td colspan="11" align="center">No Record Found</td></tr>
        @endif
        @else
         <tr><td colspan="11" align="center">No Record Found</td></tr>
    @endif      </tbody>
            </table>
	@if(isset($cheaqueRecord))
	        <table class="table table-bordered">
	        	<h2>Cheaque</h2>
	        	<thead>
	        		<tr style="background: #1976d2;color: white !important">
	        			<th>Cheaque Date</th>
	        			<th>clearance Date</th>
	        			<th>Cheaque Number</th>
	        			<th>Cheaque Amount</th>
	        			<th>Cheaque Attachment File</th>
	        		</tr>
	        	</thead>    
	            <tbody style="font-size: 12px;">
		@if(count($cheaqueRecord) > 0)
			@foreach($cheaqueRecord as $record)
	                <tr>
	                	<td>{{$record->cheque_date}}</td>
	                	<td>{{$record->cheque_deposit_date}}</td>
	                	<td>{{$record->cheque_number}}</td>
	                	<td>{{number_format($record->Cheque_amount,2)}}</td>
	                	<td><a href="{{URL::to('public/Cheque_attachment_files/'.$record->cheque_attach_file)}}" target="_blank" class="attachments"><label class="label-success">Download</label></a></td>
	                </tr>
			@endforeach
		@endif 
	@endif  	</tbody>
	        </table>
	@if(isset($complainRecord))
	        <table class="table table-bordered">
	        	<h2>Complain</h2>
	        	<thead>
	        		<tr style="background: #1976d2;color: white !important">
	        			<th>Complain Date</th>
	        			<th>Complain Description</th>
	        			<th>Action Date</th>
	        			<th>Resolve Date</th>
	        			<th>Complain Attachment File</th>
	        		</tr>
	        	</thead>    
	            <tbody style="font-size: 12px;">
		@if(count($complainRecord) > 0)
			@foreach($complainRecord as $record)
	                <tr>
	                	<td>{{$record->complain_date}}</td>
	                	<td>{{$record->complain_description}}</td>
	                	<td>{{$record->action_date}}</td>
	                	<td>{{$record->resolve_date}}</td>
	                	<td><a href="{{URL::to('public/complain_attach_files/'.$record->complain_attach_file)}}" target="_blank" class="attachments"><label class="label-success">Download</label></a></td>
	                </tr>
			@endforeach
		@endif
         @else
        <div style="text-align: center;width: 100%;color:black;">No Record Found</div> 
	@endif  	</tbody>
	        </table>
		</div>-->
<?php  } else { ?>
<div class="row owner_main_row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item home"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Supervision</span></a> </li>
                  <!--  <li class="nav-item profile"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Properti</span></a> </li>
                    <li class="nav-item messages"> <a class="nav-link" data-toggle="tab" href="#messages" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Documents</span></a> </li>-->
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabcontent-border">
                    <div class="tab-pane active" id="home" role="tabpanel">
                        <div class="">
                            <div class="card-body">
                        	<!--	<div class="d-flex">
            	                    <div class="form-group ml-auto">
            	                        <input id="demo-input-search2" class="demo-input-search" type="text" placeholder="Search" autocomplete="off">
            	                    </div>
            	                 </div>-->
                                <table id="demo-foo-pagination" class="table">
                                    <thead>
                                        <tr>
                                            <th>Unit No </th>
                                            <th>Building Name </th>
                                            <th>Area</th>
                                            <th>Tenant Name</th>
                                            <th>Bedroom</th>
                                            <th>Contract Start Date</th>
                                            <th>Contract End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>     
                                    <tbody style="font-size: 12px;">
            @if(isset($result_data))
                @if(count($result_data) > 0)
                    <?php $counter=0; ?>
                        @foreach($result_data as $record)
                                <tr>
                                    <td>{{$record->unit_no}}</td>
                                    <td>{{$record->Building}}</td>
                                    <td>{{$record->area}}</td>
                                    <td>{{$record->tenant_name}}</td>
                                    <td>{{$record->Bedroom}}</td>
                                    <td>{{$record->contract_start_date}}</td>
                                    <td>{{$record->contract_end_date}}</td>
                                    <td>
                                        <a href="{{url('owner')}}?contract_id={{$record->id}}" class="edit_supervision"><i class="fa fa-eye"></i>&nbsp;view</a>
                                    </td>
                                </tr>
                        @endforeach
                        @else
                        <tr><td colspan="8" align="center">No Record Found</td></tr>
                    @endif 
                @endif              </tbody>
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
             <!--       <div class="tab-pane  " id="profile" role="tabpanel" style="display:none">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="form-group ml-auto">
                                    <input id="demo-input-search2" class="demo-input-search" type="text" placeholder="Search" autocomplete="off">
                                </div>
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
                                        <th>Comment</th>
                                    </tr>
                                </thead>     
                                <tbody style="font-size: 12px;">
        @if(isset($propertyData))
            @if(count($propertyData) > 0)
                <?php $counter=0; ?>
                    @foreach($propertyData as $record)
                            <tr>
                                <td>{{$record->unit_no}}</td>
                                <td>{{$record->Building}}</td>
                                <td>{{$record->area}}</td>
                                <td>{{ucwords($record->LandLord)}}</td>
                                <td><?php $temp=explode(',', $record->contact_no);foreach ($temp as $key=>$value) { ?>
                                        <span style="display: block;width: 100%;">{{$value}}</span>
                                <?php  }  ?></td>
                                <td><?php $temp=explode(',', $record->email);foreach ($temp as $key=>$value) { ?>
                                        <span style="display: block;width: 100%;">{{$value}}</span>
                                <?php  } ?></td>
                                <td>{{$record->Area_Sqft}}</td>
                                <td>{{$record->Price}}</td>
                                <td>{{$record->comment}}</td>
                            </tr>
                    @endforeach
                    @else
                    <tr><td colspan="9" align="center">No Record Found</td></tr>
                @endif 
            @endif                    </tbody>
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
                        </div>
                    </div>-->
                 <!--   <div class="tab-pane" id="messages" role="tabpanel" style="display:none">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="form-group ml-auto">
                                    <input id="demo-input-search2" class="demo-input-search" type="text" placeholder="Search" autocomplete="off">
                                </div>
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
                                        <th>Comment</th>
                                    </tr>
                                </thead>     
                                <tbody style="font-size: 12px;">
        @if(isset($propertyData))
            @if(count($propertyData) > 0)
                <?php $counter=0; ?>
                    @foreach($propertyData as $record)
                            <tr>
                                <td>{{$record->unit_no}}</td>
                                <td>{{$record->Building}}</td>
                                <td>{{$record->area}}</td>
                                <td>{{ucwords($record->LandLord)}}</td>
                                <td><?php $temp=explode(',', $record->contact_no);foreach ($temp as $key=>$value) { ?>
                                        <span style="display: block;width: 100%;">{{$value}}</span>
                                <?php  }  ?></td>
                                <td><?php $temp=explode(',', $record->email);foreach ($temp as $key=>$value) { ?>
                                        <span style="display: block;width: 100%;">{{$value}}</span>
                                <?php  } ?></td>
                                <td>{{$record->Area_Sqft}}</td>
                                <td>{{$record->Price}}</td>
                                <td>{{$record->comment}}</td>
                            </tr>
                    @endforeach
                    @else
                    <tr><td colspan="9" align="center">No Record Found</td></tr>
                @endif 
            @endif                    </tbody>
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
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
       <?php  } ?>
</div>
 @include('inc.footer')

 