@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=ucfirst('Admin'))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
 <div class="page-wrapper" style="margin-top: 2%;">
<div class="container-fluid">
    @if(session('msg'))
        {!! session('msg') !!}
    @endif
<?php  if(!isset($_GET['action'])) { ?>
    <div class="row owner_main_row">
        <h3 class="page_heading">All Users</h3>
        <!--<div class="row" style="margin:auto;">
                        <div class="col-sm-4">
                            <a href="{{url('admins')}}" style="padding: 0px 20px;" class="bt btn-success">Admins</a>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{url('owners')}}?type=sale" style="padding: 0px 20px;" class="bt btn-danger">Owners</a>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{url('agents')}}?type=upcoming" style="padding: 0px 20px;" class="bt btn-primary">Agents</a>
                        </div>
                    </div>-->
                     <div class="col-12 col-sm-12" style="margin-bottom:-5px;">
                    <ul class="nav nav-tabs ">
    <li class="nav-item">
     @if(@$_GET['type']=='')
       <a href="{{url('admins')}}"  class="nav-link active py-3">Admins</a>
       @else
        <a href="{{url('admins')}}" class="nav-link py-3">Admins</a>
       @endif
    </li>
    <li class="nav-item">
    @if(@$_GET['type']=='sale')
      <a href="{{url('owners')}}?type=sale" class="nav-link active py-3">Owners</a>
      @else
      <a href="{{url('owners')}}?type=sale" class="nav-link py-3">Owners</a>
      @endif
    </li>
    <li class="nav-item">
    @if(@$_GET['type']=='upcoming')
    <a href="{{url('agents')}}?type=upcoming"  class="nav-link active py-3">Agents</a>
    @else
     <a href="{{url('agents')}}?type=upcoming"  class="nav-link py-3">Agents</a>
     @endif
    </li>
    
                    </ul>
                    </div>


        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <div class="d-flex">
                        <a style="cursor: pointer" id="add-new-owne-link"><span><i class="fa fa-plus"></i></span></a>
                        <div class="form-group ml-auto">
                            <input id="demo-input-search2" class="demo-input-search" type="text" placeholder="Search" autocomplete="off">
                        </div>
                    </div>
                    <table id="demo-foo-pagination " class="table m-b-0 toggle-arrow-tiny demo-pagination" style="margin-top: 2%" data-page-size="5" >
                        <thead>
                            <tr>
                                <th data-toggle="true"> user Name </th>
                                <th data-toggle="true"> First Name </th>
                                <th data-toggle="true">Last Name</th> 
                                <th data-toggle="true">Gender</th>                    
                                <th data-toggle="true"> Phone </th>
                                <th data-toggle="true"> Email </th>
                                <th data-toggle="true">Role</th>
                                <th data-toggle="all"> DOB </th>
                                <th data-toggle="all">Action</th>
                               
                            </tr>
                        </thead>     
                        <tbody>
                  <?php if(count($value) > 0){
                             foreach($value as $values){ ?>
                            <tr>
                                <td>{{ucwords($values->user_name)}}</td>
                                <td>{{ucwords($values->First_name)}}</td>
                                <td>{{ucwords($values->Last_name )}}</td>
                                <td>{{ucwords($values->Gender )}}</td>
                                <td>{{ucwords($values->Phone)}}</td>
                                <td>{{ucwords($values->Email)}}</td>
                                <td>{{ucwords($values->Rule_type)}} </td>
                                <td>{{ucwords($values->birth_date)}}</td>
                                <td><a class="edit_supervision" href='{{url("EditUser/{$values->id}")}}?action=editUser&user={{@$heading}}'><i class="fa fa-edit"></i> Edit</a></td>
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
        <div class="col-12 back_wrapper"
        <span ><i class="fas fa-arrow-circle-left" id="back_to_owner"></i></span>
        <span id="back_to_owner_text">New User</span>
        </div>
    </div>

    <!--adding new owner's form  -->
 <!-- owners info  -->
 <div class="row owner_information_link">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Contact Details</h4>
                </div>
                <div class="card-body">
                    <form action="<?php if(isset($_GET['action'])){echo url("updateUser",array(@$record->id))."?username=".@$record->user_name."&user_email=".@$record->Email."&user=$user";}else{ echo url("insert")."?&user=".$heading; }  ?>" id="user_form" class="form-horizontal" method="post">
                    {{csrf_field()}}
                        <div class="form-body">
                           <!--  <h3 class="box-title">Owner information</h3> -->
                          <!--   <hr class="m-t-0 m-b-40"> -->
                            <div class="row">
                                
                                 <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">User Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="user Name" name="user_name" value="{{@$record->user_name}}" required="" id="user_name">
                                           <!--  <small class="form-control-feedback"> This is inline help </small> --> </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">First Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="First Name" name="First_name" value="{{@$record->First_name}}" required="">
                                           <!--  <small class="form-control-feedback"> This is inline help </small> --> </div>
                                    </div>
                                </div>
                                
                                <!--/span-->
                          </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-danger row">
                                        <label class="control-label text-right col-md-3">Last Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control form-control-danger" placeholder="Last Name" name="Last_Name" required="" value="{{@$record->Last_name}}">
                                            <!-- <small class="form-control-feedback"> This field has error. </small> --> </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Gender</label>

                                        <div class="col-md-9">
                                              <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="Gender" style="font-size: 12px;" required="">
                                                <option value="">Select Gender</option>
                                                <option <?php  if(@$record->Gender=="Male"){echo "Selected";} ?> value="Male">Male</option>
                                                <option <?php  if(@$record->Gender=="Female"){echo "Selected";} ?> value="Female">Female</option>
                                            </select>
                                            <!-- <small class="form-control-feedback"> Select your gender. </small> --> </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Date of Birth</label>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="birth_date" required="" value="{{@$record->birth_date}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Role</label>
                                        <div class="col-md-9">
                                            <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="role" style="font-size: 12px;" required="" id="role">
                                                <option value="">Select Role</option>
                                                <?php  foreach($Role as $Roles){ ?>
                                                <option value="<?php echo $Roles['Rule_id'] ?>"><?php echo $Roles['Rule_type'] ?></option>
                                                <?php  } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--/row-->
                            <div class="row">
                                   <?php if(!isset($_GET['action'])) { ?>
                                <!--<div class="col-md-6">-->
                                <!--    <div class="form-group row">-->
                                <!--        <label class="control-label text-right col-md-3">Password</label>-->
                                <!--        <div class="col-md-9">-->
                                <!--            <input type="password" class="form-control" name="Password" placeholder="Password" required="">-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <?php } ?>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Email</label>
                                        <div class="col-md-9">
                                            <input type="email" class="form-control" name="Email" placeholder="Email" required="" value="{{@$record->Email}}">
                                        </div>
                                    </div>
                                </div>
                                 <?php if(isset($_GET['action'])) { ?>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Status</label>
                                        <div class="col-md-9">
                                            <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="status" style="font-size: 12px;" required="" id="status">
                                                 <option value="">Select Status</option>
                                                <option <?php  if(@$record->status=="1"){echo "Selected";} ?> value="1">Activate</option>
                                                <option <?php  if(@$record->status=="0"){echo "Selected";} ?> value="0">Deactivate</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                 <?php } ?>
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Phone</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="Phone" placeholder="Phone" required="" value="{{@$record->Phone}}">
                                        </div>
                                    </div>                                
                                </div>
                                <!--/span-->
                               <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Password</label>
                                        <div class="col-md-9">
                                            <input type="Password" class="form-control" name="Password" placeholder="**********" value="{{@$record->Password}}">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9" style="    padding-left: 28%;">
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
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->

@include('inc.footer')
<?php  if(isset($_GET['action'])) { ?>
    <script type="text/javascript">
        $("#role option").each(function(){
            if($(this).val()=={{$record->role}}){
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
})
</script>
@include('reminder')