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
<div class="page-wrapper" style="margin-top: 2%;">
<div class="container-fluid">
    @if(session('msg'))
        {!! session('msg') !!}
    @endif
<?php  if(!@$edit) { ?>
    <div class="row owner_main_row">
        <h3 class="page_heading">Loans</h3>
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <div class="d-flex">
                        <a style="cursor: pointer" id="add-new-owne-link"><span><i class="fa fa-plus"></i></span></a>
                        <div class="form-group ml-auto">
                            <input id="demo-input-search2" class="demo-input-search" type="text" placeholder="Search" autocomplete="off">
                        </div>
                    </div>
                    <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny demo-pagination" style="margin-top: 2%" data-page-size="5" >
                        <thead>
                            <tr>
                                <th data-toggle="true"> Sno# </th>
                                <th data-toggle="true"> Agent </th>
                                <th data-toggle="true">Loan Type</th>
                                <th data-toggle="true">Loan Amount</th> 
                                <th data-toggle="true">Paid Loan amount</th>                    
                                <th data-toggle="true"> Remaining amount </th>
                                <th data-toggle="true">Previous Month Paid</th>
                                <th data-toggle="true">Status</th>
                                <th data-toggle="all"> Issued Date </th>
                                <th data-toggle="all">Action</th>
                                <th data-toggle="all">Action</th>
                               
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
                                <td><label class="label label-primary" style="font-size:12px;">{{$values->loan_amount}}</label></td>
                                <td><label class="label label-success" style="font-size:12px;">{{$values->paid_amount}}</label></td>
                                <td><label class="label label-warning" style="font-size:12px;">{{$values->loan_amount - $values->paid_amount}}</label></td>
                                <td>@if(!is_null($values->month)) <?php $data = explode(",",$values->month); ?> <label style="font-size:12px;background-color:#606771;" class="label label-success">Amount : {{number_format(@$data[1]),2}}</label><br> <b>{{@$data[0]}}</b> @endif</td>
                                <td>@if($values->loan_amount == $values->paid_amount) <label style="font-size:12px;" class="label label-success">PAID</label> @else <label class="label label-danger" style="font-size:12px;">CONTINUE</label> @endif </td>
                                <td>{{date('d-m-Y',strtotime($values->created_at))}} </td>
                                <td>@if(ucfirst(session('role'))!=ucfirst('Admin'))@if($permissions->loanEdit == 1) @if($values->loan_amount != $values->paid_amount) <a class="edit_supervision" href='{{url("edit-loan/{$values->id}")}}'><i class="fa fa-edit"></i> Edit</a> @endif @else <i class="fa fa-ban"></i> @endif @else <a class="edit_supervision" href='{{url("edit-loan/{$values->id}")}}'><i class="fa fa-edit"></i> Edit</a> @endif</td>
                                <td>@if(ucfirst(session('role'))!=ucfirst('Admin'))@if($permissions->loanAdd == 1)@if($values->loan_amount != $values->paid_amount) <a class="edit_supervision add-paid-amount" loan-amount="{{$values->loan_amount}}" remaining-loan-amount="{{$values->loan_amount - $values->paid_amount}}" id="{{$values->id}}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add</a>@endif @else <i class="fa fa-ban"></i> @endif @else <a class="edit_supervision add-paid-amount" loan-amount="{{$values->loan_amount}}" remaining-loan-amount="{{$values->loan_amount - $values->paid_amount}}" id="{{$values->id}}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add</a> @endif</td>
                            </tr>
                           <?php  } 
                            } else{ ?>
                                <tr><td colspan="9" align="center">No Record Found</td></tr>
                            <?php }  ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="16">
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
        <div class="col-12 back_wrapper">
        <span ><i class="fas fa-arrow-circle-left" id="back_to_owner"></i></span>
        <span id="back_to_owner_text">Add New Loan</span>
        </div>
    </div>
 <div class="row owner_information_link">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Contact Details</h4>
                </div>
                <div class="card-body">
                    <form action="<?php if(!@$edit){echo url("add-loan",array(@$record->id));}else{ echo url("update-loan"); }  ?>" id="user_form" class="form-horizontal" method="post">
                        {{csrf_field()}}
                        <div class="form-body">
                            <div class="row">
                                
                                 <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Agent</label>
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
                                        <label class="control-label text-right col-md-3">Loan Type</label>
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
                                        <label class="control-label text-right col-md-3">Loan Amount</label>
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

@include('inc.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet">
<script>
    $(document).ready(function(){
        $('.add-paid-amount').click(function(){
            $('.add-paid-amount-id').val($(this).attr('id'));
            $('.enter-amount-btn').attr('loan-amount',$(this).attr('loan-amount'));
            $('.enter-amount-btn').attr('remaining-loan-amount',$(this).attr('remaining-loan-amount'));
        })
        $('.enter-amount-btn').click(function(){
            if(!$('.paid_amount').val() || $('.paid_amount').val() == "" || $('.paid_amount').val() == " "){
                Command: toastr["error"]("Invalid Amount");
            }else{
                if($('.paid_amount').val() > parseInt($('.enter-amount-btn').attr('remaining-loan-amount'))){
                    Command: toastr["error"]("Paid Amount is Greater then Loan Amount!");
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
