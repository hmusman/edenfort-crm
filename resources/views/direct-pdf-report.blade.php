@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=ucfirst('Admin'))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<style>
    .font-size{
        font-size:12px;
    }
</style>
<div class="page-wrapper" style="margin-top: 2%;">
<div class="container-fluid">
    <div class="row owner_main_row">
        <h3 class="page_heading">Direct Report</h3><br>
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-bottom:0px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="agent" class="font-size">Select Agent</label>
                                <select id="agent" name="agent" class="form-control font-size" required>
                                    <option value="">Select Agent</option>
                                    @foreach($agents as $agent)
                                        <option value="{{$agent->id}}">{{$agent->user_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="report_type" class="font-size">Select Report Type</label>
                                <select id="report_type" name="report_type" class="form-control font-size" required>
                                    <option value="property">Agent Property</option>
                                    <option value="lead">Agent Lead</option>
                                    <option value="coldcallings">Agent ColdCallings</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label class="font-size">From Date</label>
                                <input type="date" class="font-size form-control" name="from_date">
                            </div>
                            <div class="col-sm-2">
                                <label class="font-size">TO Date</label>
                                <input type="date" class="font-size form-control" name="to_date">
                            </div>
                            <div class="col-sm-2" style="padding-top: 32px;">
                                <button type="submit" class="font-size btn btn-danger"><b><span><i class="fa fa-file-pdf-o" ></i></span> Generate Report</b></button>
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
@include('reminder')