@include('inc.header')

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
</style>


<!-- Email and Phone Model -->


<!-- Email and Phone Model -->
        <div class="page-wrapper" style="margin-top: 2%;">
            <div class="container-fluid">
          @if(session('msg'))
                    {!! session('msg') !!}
                @endif
                
                <!--bulk editing message-->
                <div class="message"> </div>
                <!--adding new owner's form  -->
                <div class="row owner_main_row_leads" >
                    <h3 class="page_heading">Submitted Properties</h3>
                  
                   <div class="col-12 col-sm-12 mb-2">
                    <div class="dropdown_wrapper ">
                        
                        
                               <!--             <a id="add-new-owne-link" data-toggle="modal" data-target="#addNewLead" style="cursor: pointer;float:left"><span><i class="fa fa-plus"></i></span></a>
                                   -->
                                   
                  <select  class="form-control access_select" name="accessStatus" style="width:180px; float:right; font-size: 11px;font-weight: 500;">
                     <option  value="">Select Option</option>
                     <option  value="Transferred">Pick</option>
                     <option  value="Call Back">Call Back</option>
					 <option  value="Check Availability">Check Availability</option>
					 <option  value="Wrong Number">Wrong Number</option>
					 <option  value="Switch Off">Switch Off</option>
					 <option  value="Not answering">Not answering</option>
                     </select>
                     
             
                                            </div> 
                               
                                            
                                            </div>
                                           
                        <div class="col-12 col-sm-12">
                        
                            <div class="card">
                            
                            
                                <ul class="nav nav-tabs deals_tabs">
   
      <li class="nav-item">
           @if(@$_GET['type']=='')
         <a href="{{url('submittedProperties')}}" class="nav-link active py-3">Properties</a>
            @else 
           <a href="{{url('submittedProperties')}}" class="nav-link py-3">Properties</a> 
            @endif
         </li>  
            
               
           
           <li class="nav-item">
      @if(@$_GET['type']=='Transferred')
            <a href="{{url('submittedProperties')}}?type=Transferred" class="nav-link active py-3">Transferred</a>
              @else
               <a href="{{url('submittedProperties')}}?type=Transferred" class="nav-link py-3">Transferred</a>
               @endif 
           </li>
           
             <li class="nav-item">
      @if(@$_GET['type']=='Call Back')
            <a href="{{url('submittedProperties')}}?type=Call Back" class="nav-link active py-3">Call Back</a>
              @else
               <a href="{{url('submittedProperties')}}?type=Call Back" class="nav-link py-3">Call Back</a>
               @endif 
           </li>
           <li class="nav-item">
      @if(@$_GET['type']=='Check Availability')
            <a href="{{url('submittedProperties')}}?type=Check Availability" class="nav-link active py-3">Check Availability</a>
              @else
               <a href="{{url('submittedProperties')}}?type=Check Availability" class="nav-link py-3">Check Availability</a>
               @endif 
           </li>
           <li class="nav-item">
      @if(@$_GET['type']=='Wrong Number')
            <a href="{{url('submittedProperties')}}?type=Wrong Number" class="nav-link active py-3">Wrong Number</a>
              @else
               <a href="{{url('submittedProperties')}}?type=Wrong Number" class="nav-link py-3">Wrong Number</a>
               @endif 
           </li>
           <li class="nav-item">
      @if(@$_GET['type']=='Switch Off')
            <a href="{{url('submittedProperties')}}?type=Switch Off" class="nav-link active py-3">Switch Off</a>
              @else
               <a href="{{url('submittedProperties')}}?type=Switch Off" class="nav-link py-3">Switch Off</a>
               @endif 
           </li>
           <li class="nav-item">
      @if(@$_GET['type']=='Not answering')
            <a href="{{url('submittedProperties')}}?type=Not answering" class="nav-link active py-3">Not answering</a>
              @else
               <a href="{{url('submittedProperties')}}?type=Not answering" class="nav-link py-3">Not answering</a>
               @endif 
           </li>
           <li class="nav-item">
      @if(@$_GET['type']=='For Rent')
            <a href="{{url('submittedProperties')}}?type=For Rent" class="nav-link active py-3">For Rent</a>
              @else
               <a href="{{url('submittedProperties')}}?type=For Rent" class="nav-link py-3">For Rent</a>
               @endif 
           </li>
            <li class="nav-item">
      @if(@$_GET['type']=='For Sale')
            <a href="{{url('submittedProperties')}}?type=For Sale" class="nav-link active py-3">For Sale</a>
              @else
               <a href="{{url('submittedProperties')}}?type=For Sale" class="nav-link py-3">For Sale</a>
               @endif 
           </li>
           
    
     </ul>
     
      
                                <div class="card-body table-responsive">
								
								 <div class="col-lg-12">
                                 <div class="row">
                                   <div class="col-md-12">
								
								<form action="{{ route('submittedPropertySearch') }}" method="GET" class="">
                          <div class="row mt-2 mb-2">
                          <div class="col-md-9">
                            <div class="row">
             
                             @if(isset($_GET['type'])) <input type="hidden" name="type" value="{{@$_GET['type']}}"/> @endif
                                       
                            
                                   
                                   <div class="col-md-2 pl-1 pr-1">
                                       <div class="dropdown_wrapper "> 
                                           
                                            <input type="text" class="form-control filter_input" list="access" placeholder="Select Access" name="access"  autocomplete="off">
                                          <datalist id="access">
                                               <option value="">Select access</option>
                                          <option value="Transferred"></option>
                                          <option value="Call Back"></option>
										  <option value="Check Availability"></option>
										  <option value="Wrong Number"></option>
										  <option value="Switch Off"></option>
										  <option value="Not answering"></option>
										
                                            
                                           </datalist>
                                             
                                       </div>
                                   </div>
                                       
                                   
                                     <div class="col-md-2 pl-1 pr-1">
                                       <div class="dropdown_wrapper ">
                                           <input type="text" class="form-control filter_input" list="unit_no" placeholder="contact" name="contact">
                                            <datalist id="contact">
                                                <option value="">contact</option>
                                         
                                            </datalist>
                                       </div>
                                   </div>
                                   
                                </div></div>   
                                   
                                   
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
                                                <th>Select</th>
                                               <th>Date</th>
                                               <th>Unit </th> 
                                               <th>Landlord </th> 
                                               <th>Contact </th>
                                              <th>Email </th>
                                               <th>Building </th>
                                                 <th>Condition </th>
                                              <th>Area </th>
                                                <th>Bedroom</th>  
												 <th>Washroom</th>  
												  <th>Type</th>  
                                                 <th>Status </th>
                                                <th>Updated_at</th>
                                              <th>Action</th>
                                             
                                            </tr>
                                        </thead>     
                         <form id="bulkForm" class="form-inline">
                        <input type='hidden' value='' name='status' class='status'>
                        
                                   <tbody style="font-size: 12px;">
                          @if(isset($properties))
                          
                    @if(count($properties) > 0)
                    <?php $counter=0; ?>
                          
                          @foreach($properties as $property)
                          
                                <tr class="present_row">
                                                 <td>
                                                     <input type="checkbox" name="check_boxes[{{$counter}}]" class="ind_chk_box" value="{{$property->id}}">
                                                <input type="hidden" name="pUnit[{{$counter}}]"  value="{{$property->unit_no}}" >  
												<input type="hidden" name="pLandlord[{{$counter}}]"  value="{{$property->LandLord}}" >  
												<input type="hidden" name="pContact[{{$counter}}]"  value="{{$property->contact_no}}" >  
												<input type="hidden" name="pEmail[{{$counter}}]"  value="{{$property->email}}" >  
												<input type="hidden" name="pBuilding[{{$counter}}]"  value="{{$property->Building}}" >  
												<input type="hidden" name="pCondition[{{$counter}}]"  value="{{$property->Conditions}}" >  
												<input type="hidden" name="pArea[{{$counter}}]"  value="{{$property->area}}" >  
												<input type="hidden" name="pBedrooms[{{$counter}}]"  value="{{$property->Bedroom}}" >  
												<input type="hidden" name="pWashrooms[{{$counter}}]"  value="{{$property->Washroom}}" >  
												<input type="hidden" name="pArea_Sqft[{{$counter}}]"  value="{{$property->Area_Sqft}}" >  
												<input type="hidden" name="pPrice[{{$counter}}]"  value="{{$property->Price}}" >  
												<input type="hidden" name="pType[{{$counter}}]"  value="{{$property->type}}" >  
												
                                          <!--   <img style="width: 21px;margin-top: -9px !important;" src="https://img.icons8.com/cotton/24/000000/circled-right.png" class="drop_arrow_icon pulse-effect">
                                            -->
                                          </td>
						  <td class="propertyId" style="display:none;">{{$property->id}}</td >				  
                                               <td class="pCreated">{{$property->created_at}}</td>
                                                  <td class="pUnit" >{{$property->unit_no}}</td>
                                                 <td class="pLandolord">{{$property->LandLord}}</td>
                                               <td class="pContact">{{$property->contact_no}}</td>
                                     
                                                <td class="pEmail">{{$property->email}}</td>
                                                <td class="pBuilding">{{$property->Building}}</td>
                                                <td class="pCondition" >{{$property->Conditions}}</td> 
                                               <td class="pArea" >{{$property->area}}</td> 
                                               <td class="pBedrooms" >{{$property->Bedroom}}</td> 
								               <td class="pWashrooms" >{{$property->Washroom}}</td> 
								              <td class="pType" >{{$property->type}}</td> 
											  <td class="pArea_Sqft" style="display:none;">{{$property->Area_Sqft}}</td> 
								              <td class="pPrice" style="display:none;">{{$property->Price}}</td> 
								              <td class="pAccess" >@if(empty($property->access)) Request Generated @else   {{$property->access}} @endif</td> 
								              <td class="pUpdated" >{{$property->updated_at}}</td> 
                                 
                  <td><label data-toggle="modal" data-target="#exampleModal" style="cursor: pointer;position: relative;right: 5px;display: table-cell;" class="show_content" name="{{$property->id}}"><i class="fa fa-edit"></i> Pick</label>
                                              </td>
                                 
                                        </tr>
                          
                             <!--TOGGLE ROW END HERE-->    
                             <?php $counter++; ?>
                            @endforeach
                            @else
                            <tr>
                                          <td colspan="15" align="center">No Record Found</td>
                                       </tr>
                            @endif
                            @endif
                            <!--<tr><td colspan="11" align="center">No Record Found</td></tr>-->
                                         </tbody>
                                         </form>
                                       
                                    </table>
                                </div>
                                <div class="ml-auto pr-3">
  
     {{$properties->appends(Request::only('type'))->links()}}  
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
                                                <h4 class="modal-title   content_model_title" id="exampleModalLabel1">Edit Property</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                    
                                <form action="{{url('submitPropertyUpdateForm')}}" method="post" class="form-horizontal" id="supervision" >
                                    @csrf
                                   
                                     
                                 <ul class="nav nav-tabs nav-justified" role="tablist">
                                     <!--      <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home8" role="tab"><span><i class="ti-home"></i></span><span class="tab-heading">Lead Basic</span></a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile8" role="tab"><span><i class="far fa-question-circle"></i></span><span class="tab-heading">Lead Detail</span></a> </li>
                                       -->
                                    </ul>
							
                                 <input type="hidden" name="propertyId" id="propertyId">								
									
									
                                    <div class="tab-content tabcontent-border">
                                        <div class="tab-pane active p-20" id="home8" role="tabpanel">
                                            <div class="row">
                                                <div class="form-group col-sm-3">
                                                    <label>Created_at</label>
                                                    <input type="text" class="form-control" name="created_at" id="pCreated" disabled>
                                                </div>
                                              
                                                <div class="form-group col-sm-3">
                                                    <label>Unit</label>
                                                    <input type="text" class="form-control" placeholder="Unit"  name="unit_no" id="pUnit" >
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>LandLord</label>
                                                    <input type="text" class="form-control" placeholder="LandLord" name="LandLord" id="pLandolord" disabled>
                                                </div>
                                               
                                                
                                                <div class="form-group col-sm-3">
                                                    <label>Contact</label>
                                                    <input type="text" class="form-control" placeholder="Contact" name="contact_no" id="pContact" disabled>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" placeholder="Email" name="email" id="pEmail">
                                                </div>
                                                <!--next row-->
                                                  <div class="form-group col-sm-3">
                                                    <label>Building</label>
                                     <input type="text" class="form-control" placeholder="Building" name="Building" id="pBuilding">
                                                </div>
												  <div class="form-group col-sm-3">
                                                    <label>Condition</label>
                                     <input type="text" class="form-control" placeholder="Conditions" name="Conditions" id="pCondition">
                                                </div>
												 <div class="form-group col-sm-3">
                                                    <label>Area</label>
                                     <input type="text" class="form-control" placeholder="AREA" name="area" id="pArea">
                                                </div>
												 <div class="form-group col-sm-3">
                                                    <label>Bedroom</label>
                                     <input type="text" class="form-control" placeholder="Bedroom" name="Bedroom" id="pBedrooms">
                                                </div>
												 <div class="form-group col-sm-3">
                                                    <label>Washroom</label>
                                     <input type="text" class="form-control" placeholder="Washroom" name="Washroom" id="pWashroomsrooms">
                                                </div>
												
                                             
                                                <div class="form-group col-sm-3">
                                                    <label>TYPE</label>
                                                  
                                              <select class="form-control"  name="type" id="ptype">
                                                        <option value="Residential">Residential</option>
                                                        <option value="Commercial">Commercial</option>
                                                    </select> 
                                                </div>
												 <div class="form-group col-sm-3">
                                                    <label>Area_Sqft</label>
                                     <input type="text" class="form-control" placeholder="Area_Sqft" name="Area_Sqft" id="pArea_Sqft">
                                                </div>
												 <div class="form-group col-sm-3">
                                                    <label>Price</label>
                                     <input type="text" class="form-control" placeholder="Price" name="Price" id="pPrice">
                                                </div>
                                                
												<div class="form-group col-sm-3"></div>
											<div class="form-group col-sm-3">
                                                    <input type="submit" value="Submit" class="btn btn-block btn-lg btn-success" name="submitLead"> 
                                                </div>
                                                
                                            </div>
                                        </div>
                            
                    </div>
                </div>
                                            </div>
                                            <div class="modal-footer">
                                              
                                        </div>
                                    </div>
                                </div>
                                <!--end of edit popup-->
                                <!-- /.modal -->
                                
          </div>
              </div>
@include('inc.footer')

<script>

//fill the fields when click on edit
   $(document).delegate('.show_content','click',function(){
       
        var $row = $(this).closest("tr");    // Find the row
		
		var $propertyId = $row.find(".propertyId").text();// Find the text

   var $pCreated = $row.find(".pCreated").text();  
    
    var $pUnit = $row.find(".pUnit").text(); 
    
    var $pLandolord = $row.find(".pLandolord").text(); 
    var $pContact = $row.find(".pContact").text(); 
    var $pEmail = $row.find(".pEmail").text(); 
    var $pBuilding = $row.find(".pBuilding").text(); 
    var $pCondition = $row.find(".pCondition").text(); 
    var $pArea = $row.find(".pArea").text(); 
    var $pBedrooms = $row.find(".pBedrooms").text(); 
    var $pWashrooms = $row.find(".pWashrooms").text(); 
    var $pType = $row.find(".pType").text(); 
	 var $pArea_Sqft = $row.find(".pArea_Sqft").text(); 
	  var $pPrice = $row.find(".pPrice").text(); 
    var $pUpdated = $row.find(".pUpdated").text();
    
    // Let's test it out
	
	   $("#propertyId").val($propertyId);
       $("#pCreated").val($pCreated); 
       $("#pUnit").val($pUnit); 
       $("#pLandolord").val($pLandolord); 
       $("#pContact").val($pContact);
       $(".pEmail").val($pEmail); 
       $("#pBuilding").val($pBuilding); 
       $("#pCondition").val($pCondition);
        $("#pArea").val($pArea); 
        $("#pBedrooms").val($pBedrooms); 
        $("#pWashrooms").val($pWashrooms); 
        $("#pType").val($pType); 
		$("#pArea_Sqft").val($pArea_Sqft); 
		$("#pPrice").val($pPrice); 
        $("#pUpdated").val($pUpdated); 
})

//ACCESS DROPDOWN CODE START HERE  
        $('.access_select').change(function(e){
            
           if(!$('.ind_chk_box:checkbox:checked').val()){
             $(this).val('');
             alert('please select Rows!');
            
         }else{
             // alert($('.ind_chk_box').val());
              var access=$(this).val();
                $('.status').val(access);
            
 
       // console.log($("#bulkForm").serialize());
        
          $.ajax({
              url:'<?php echo url('bulkUpdateSubmittedProperty');  ?>',
              type:'get',
              data : $("#bulkForm").serialize(),
              success:function(data){
				 
                  console.log(data);
                  
                
                  
                  if(data=="true"){
                      location.reload();
                  }else{
                       $(".message").html(data);
                  
                   setTimeout(function() {
              window.location.reload();
                   }, 3500);
                  }
              }
          })
         }
        })
        

</script>

@if(ucfirst(session('role')) == (ucfirst('Admin')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == (ucfirst('SuperAgent')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == ucfirst('Agent'))
      @include('reminder')
    @endif

</body>
</html>