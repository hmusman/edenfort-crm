@if(!session('role'))
    <script type="text/javascript">
        window.location='{{url("/")}}';
    </script>
    <?php redirect('/'); ?>
    @php return; @endphp
@endif
@include('inc.header')
@if(ucfirst(session('role'))!=ucfirst('Admin') && \App\Models\permission::permissions()->loanView == 0)
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<!-- Responsive Table css -->
<link href="{{url('public/Green/assets/libs/RWD-Table-Patterns/css/rwd-table.min.css')}}" rel="stylesheet" type="text/css" />

<style>
    @media (max-width: 550px){
        .btn-toolbar {
            width: 100% !important;
            margin-top: -5px !important;
            margin-left: 0% !important;
            position: unset !important;
            margin-bottom: 10% !important;
        }
    }
    #back_to_owner{
        font-size: 35px;
    }
    #back_to_owner_text{
        font-size: 22px;
        font-weight: bold;
    }
    .table-responsive{
        margin-top: -20px;
    }
    .btn-toolbar{
        width: 67%;
        margin-left: 13%;
        position: absolute;
        margin-top: -5px;
        z-index: 999;
    }
    #tech-companies-1 thead{
        background-color: #2fa97c;
        color: white;
    }
    .owner_information_link{
        display: none;
    }
    .rnd {
        color: white !important;
        padding: 19px 24px 19px 24px;
    }
</style>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{url('add-paid-amount')}}" id="enter-amount-form" method="get"/>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Enter Paid Amount</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <label>Enter Amount</label>
                <input type="text" name="paid_amount" class="form-control paid_amount"/>
                <input type="hidden" class="add-paid-amount-id" name="id" />
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary enter-amount-btn">Submit</button>
          </div>
        </div>
    </form>
  </div>
</div>
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
                        <h4 class="page-title mb-1">Loans</h4>
                        <ol class="breadcrumb m-0">
                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li> -->
                        <li class="breadcrumb-item active">Edenfort CRM Loans</li>
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
                        <?php  if(!@$edit) { ?>
                        <div class="card">
                            <div class="card-body owner_main_row mt-5">
                                <div class="d-flex">
                                    <a style="cursor: pointer" class="rnd btn btn-success btn-rounded waves-effect waves-light" id="add-new-owne-link"><span><i class="fa fa-plus"></i></span></a>
                                    <!-- <div class="form-group ml-auto">
                                        <input id="demo-input-search2" class="demo-input-search" type="text" placeholder="Search" autocomplete="off">
                                    </div> -->
                                </div>
                                <div class="table-rep-plugin mt-5">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="tech-companies-1" class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Sno#</th>
                                                <th data-priority="1">Agent</th>
                                                <th data-priority="3">Loan Type</th>
                                                <th data-priority="1">Loan Amount</th>
                                                <th data-priority="3">Paid Loan amount</th>
                                                <th data-priority="3">Remaining amount </th>
                                                <th data-priority="6">Previous Month Paid</th>
                                                <th data-priority="6">Status</th>
                                                <th data-priority="6">Issued Date </th>
                                                <th data-priority="6">Action</th>
                                                <th data-priority="6">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(count($loans) > 0){
                                                  $counter= 1; 
                                                 foreach($loans as $values){ ?>
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td>{{$values->getAgent->user_name}}</td>
                                                    <td>{{$values->advance_type}}</td>
                                                    <td><label class="badge badge-success" style="font-size:12px;">{{$values->loan_amount}}</label></td>
                                                    <td><label class="badge badge-primary" style="font-size:12px;">{{$values->paid_amount}}</label></td>
                                                    <td><label class="badge badge-warning" style="font-size:12px;">{{$values->loan_amount - $values->paid_amount}}</label></td>
                                                    <td>@if(!is_null($values->month)) <?php $data = explode(",",$values->month); ?> <label style="font-size:12px;" class="badge badge-dark">Amount : {{number_format(@$data[1]),2}}</label><br> <b>{{@$data[0]}}</b> @endif</td>
                                                    <td>@if($values->loan_amount == $values->paid_amount) <label style="font-size:12px;" class="badge badge-primary">PAID</label> @else <label class="badge badge-danger" style="font-size:12px;">CONTINUE</label> @endif </td>
                                                    <td>{{date('d-m-Y',strtotime($values->created_at))}} </td>
                                                    <td>@if(ucfirst(session('role'))!=ucfirst('Admin'))@if($permissions->loanEdit == 1) @if($values->loan_amount != $values->paid_amount) <a class="edit_supervision" href='{{url("edit-loan/{$values->id}")}}'><i class="fa fa-edit"></i> Edit</a> @endif @else <i class="fa fa-ban"></i> @endif @else <a class="edit_supervision" href='{{url("edit-loan/{$values->id}")}}'><i class="fa fa-edit"></i> Edit</a> @endif</td>
                                                    <td>@if(ucfirst(session('role'))!=ucfirst('Admin'))@if($permissions->loanAdd == 1)@if($values->loan_amount != $values->paid_amount) <a class="edit_supervision add-paid-amount" loan-amount="{{$values->loan_amount}}" remaining-loan-amount="{{$values->loan_amount - $values->paid_amount}}" id="{{$values->id}}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add</a>@endif @else <i class="fa fa-ban"></i> @endif @else <a class="edit_supervision add-paid-amount" loan-amount="{{$values->loan_amount}}" remaining-loan-amount="{{$values->loan_amount - $values->paid_amount}}" id="{{$values->id}}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add</a> @endif</td>
                                                </tr>
                                               <?php  } 
                                                } else{ ?>
                                                    <tr><td colspan="9" align="center">No Record Found</td></tr>
                                                <?php }  ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php  } else{ ?><style type="text/css">.owner_information_link{display: block;</style> <?php  } ?>
                        <div class="card">
                            <div class="card-body owner_information_link">
                                <div class="card-header" style="background-color: white;">
                                    <div class="row back_btn_row m-b-40">
                                        <div class="col-12 back_wrapper">
                                            <a href="{{url('loans')}}"><span ><i class="fas fa-arrow-circle-left" id="back_to_owner"></i></span></a>
                                            @if(!@$edit)
                                            <span id="back_to_owner_text">Add New Loan</span>
                                            @else
                                            <span id="back_to_owner_text">Contact Details</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="<?php if(!@$edit){echo url("add-loan",array(@$record->id));}else{ echo url("update-loan"); }  ?>" id="user_form" class="form-horizontal" method="post">
                                       {{csrf_field()}}
                                        <div class="form-body">
                                            <div class="row">
                                                
                                                 <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label  col-md-3">Agent</label>
                                                        <div class="col-md-9">
                                                            <select class="form-control" name="agent_id" style="font-size: 12px;" required="">
                                                                <option value="">Select Agent</option>
                                                                @foreach($agents as $agent)
                                                                    <option @if(@$edit) @if(@$record->agent_id == $agent->id) selected  @endif  @endif value="{{$agent->id}}">{{$agent->user_name}}</option>
                                                                @endforeach
                                                            </select>
                                                         </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label  col-md-3">Loan Type</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Loan Type" name="advance_type" value="{{@$record->advance_type}}">
                                                            <input type="hidden" name="id"  value="{{@$record->id}}">

                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!--/span-->
                                          </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group has-danger row">
                                                        <label class="control-label  col-md-3">Loan Amount</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control form-control-danger" placeholder="Loan Amount" name="loan_amount" required="" value="{{@$record->loan_amount}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-offset-3 col-md-9" style="    padding-left: 28%;">
                                                            <button type="submit" class="btn btn-success submit"><?php  if(@$edit){echo "Update Loan";}else{echo "Submit";}?></button>
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
<!-- Required datatable js -->
<script src="{{url('public/Green/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
 <!-- Responsive examples -->
<script src="{{url('public/Green/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('public/Green/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

<!-- Datatable init js -->
<script src="{{url('public/Green/assets/js/pages/datatables.init.js')}}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet"> -->
@if(session('msg'))
<script>alertify.success("{!! session('msg') !!}")</script>
@endif
<script>$('#tech-companies-1').DataTable();</script>
<script>
    $('#add-new-owne-link').on('click',function(){
        $('.owner_main_row').css('display', 'none');
        $('.owner_information_link').css('display', 'block');
    })
</script>
<script>
    $(document).ready(function(){
        $('.add-paid-amount').click(function(){
            $('.add-paid-amount-id').val($(this).attr('id'));
            $('.enter-amount-btn').attr('loan-amount',$(this).attr('loan-amount'));
            $('.enter-amount-btn').attr('remaining-loan-amount',$(this).attr('remaining-loan-amount'));
        })
        $('.enter-amount-btn').click(function(){
            if(!$('.paid_amount').val() || $('.paid_amount').val() == "" || $('.paid_amount').val() == " "){
                // Command: toastr["error"]("Invalid Amount");
                alertify.error("Invalid Amount");
            }else{
                if($('.paid_amount').val() > parseInt($('.enter-amount-btn').attr('remaining-loan-amount'))){
                    // Command: toastr["error"]("Paid Amount is Greater then Loan Amount!");
                        alertify.error("Paid Amount is Greater then Loan Amount!");
                }else{
                      $('#enter-amount-form').submit(); 
                }
            }
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
