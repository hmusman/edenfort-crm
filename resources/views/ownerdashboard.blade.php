@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=ucfirst('owner'))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<!-- Responsive Table css -->
<link href="{{url('public/Green/assets/libs/RWD-Table-Patterns/css/rwd-table.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    #tech-companies-1 thead{
        background-color: #2fa97c;
        color: white;
    }
    .nav-tabs {
        border-bottom: 1px solid #2fa97c;
    }
    .nav-tabs .nav-link.active {
        color: #ffffff;
        background-color: #2fa97c;
        border-color: #2fa97c #2fa97c #2fa97c;
    }
    .pagination{
        float: right;
        margin-top: 20px;
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
                        <h4 class="page-title mb-1">Dashboard</h4>
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Welcome to Edenfort CRM Dashboard</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <?php  if(isset($_GET['contract_id'])) { ?>
                    <div class="col-xl-12">
                        @if(isset($_GET['contract_id']))
                                @if(isset($result))
                                    @if(count($result) > 0)
                                        @foreach($result as $record)
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-header" style="background-color: white;">
                                                    <h3 align="center">Owners Info</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-rep-plugin" style="    margin-top: -73px;">
                                                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                                                            <table id="tech-companies-1" class="table table-striped">
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
                                                                      <td>{{$record['unit_no']}}</td>  
                                                                      <td>{{$record['Building']}} </td>
                                                                      <td>{{$record['area']}}</td>
                                                                      <td>{{$record['Bedroom']}} </td>
                                                                      <td>{{$record['Conditions']}}</td>
                                                                      <td>{{$record['Washroom']}} </td>
                                                                      <td>{{$record['access']}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header mt-4" style="background-color: white;">
                                                <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                                        <i class="far fa-file-archive mr-1"></i> <span class="d-none d-md-inline-block">Supervision Contract</span> 
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                                        <i class="fas fa-money-bill-alt mr-1"></i> <span class="d-none d-md-inline-block">Payment/Cheque</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                                                        <i class="fas fa-wrench mr-1"></i> <span class="d-none d-md-inline-block">Account Statement</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            </div>
                                            <div class="card-body">
                                                <!-- Tab panes -->
                                                <div class="tab-content p-3">
                                                    <div class="tab-pane active" id="home" role="tabpanel">
                                                        <div class="table-rep-plugin">
                                                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                                                <table id="tech-companies-1" class="table table-striped">
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
                                                                            <td><a href="{{URL::to('public/contract_attachments/'.$record['supervision_contract_attachment'])}}" target="_blank" class="attachments"><label class=" badge badge-success" style="cursor: pointer;">Download</label></a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="profile" role="tabpanel">
                                                        @if(isset($cheaqueRecord))
                                                        <h2>Cheaque</h2>
                                                        <div class="table-rep-plugin">
                                                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                                                <table id="tech-companies-1" class="table table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Cheaque Date</th>
                                                                        <th>clearance Date</th>
                                                                        <th>Cheaque Number</th>
                                                                        <th>Cheaque Amount</th>
                                                                        <th>Cheaque Attachment File</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
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
                                                                        @else
                                                                        <tr><td colspan="5" style="text-align: center;">No Record Found</td></tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        @endif  
                                                    </div>
                                                    <div class="tab-pane" id="messages" role="tabpanel">
                                                       <div class="table-rep-plugin">
                                                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                                                <table id="tech-companies-1" class="table table-striped">
                                                                    <tbody>
                                                                    @if(isset($result))
                                                                    @if(count($result) > 0)
                                                                        @foreach($result as $record)
                                                                        <tr>
                                                                            <td colspan="2" style="background: #2fa97c;color: white !important"><strong style="color: white;background: none !important">Account Statement</strong></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong style="background: none;color: black !important">Account Statement</strong></td>
                                                                            <td><a href="{{url('generate-pdf')}}?record_id={{$recordID}}" class="attachments"><label class="badge badge-success" style="cursor: pointer;">Download</label></a></td>
                                                                        </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr><td colspan="11" align="center">No Record Found</td></tr>
                                                                    @endif
                                                                    @else
                                                                     <tr><td colspan="11" align="center">No Record Found</td></tr>
                                                                    @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif 
                            @endif
                        @endif  
                    </div>
                    <?php  } else { ?>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header" style="background-color: white;">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                             <span class="d-none d-md-inline-block">Supervision</span> 
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content p-3">
                                        <div class="tab-pane active" id="home" role="tabpanel">
                                           <div class="table-rep-plugin">
                                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                                    <table id="tech-companies-1" class="table table-striped">
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
                                                        <tbody>
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
                                                            @endif
                                                        </tbody>   
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                            {{$result_data->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php  } ?>
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
