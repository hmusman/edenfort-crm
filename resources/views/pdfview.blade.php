@if(!session("user_id") || ucfirst(session('role'))!=ucfirst('owner'))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('public/assets/images/favicon.png')}}">
    <title>Edenfort Properties</title>
    <link href="{{url('public/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        .header-right{
            text-align:right;
        }
        .licence{
            font-size:8px !important;
        }
        footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px;
            }
            .footerBar{
                background-color:#1976D2;
                /*padding:5px;*/
            }
    </style>
</head>

<body>
    <table class="table" style="font-size: 13px !important;">
        <tr>
            <td>
                <img src="{{url('public/assets/images/pdflogo.png')}}" height="80" width="100">
            </td>
            <td class="header-right">
                <span class="phone">+971-4-323-0688</span> <br>
                <span class="email">info@edenfort.ae</span> <br>
                <span>www.edenfort.ae</span> <br>
                <span class="licence">Trade License No. 774424 </span>
            </td>
        </tr>
    </table>
    <!--<div class="row">-->
    <!--    <div class="col-md-4">-->
    <!--        <img src="{{url('public/assets/images/edenfort_logo.png')}}" height="200" width="200">-->
    <!--    </div>-->
    <!--    <div class="col-md-4"><span>2nd container</span> </div>-->
    <!--    <div class="col-md-4">-->
    <!--        <span>third container</span>   -->
                <!--<div class="col-sm-3">+971-4-323-0688</div>-->
                <!--<div class="col-sm-3">info@edenfort.ae</div>-->
                <!--<div class="col-sm-3">www.edenfort.ae</div>-->
                <!--<div class="col-sm-3" style="font-size:10px;">Trade License No. 774424</div>-->
            
    <!--    </div>-->
    <!--</div>-->
	<table class="table table-bordered" style="font-size: 13px !important;">
		<tbody>
		 @foreach($supervision as $value)
			<tr>
				<td><strong>Unit No</strong></td>
				<td>{{$value->unit_no}}</td>
			</tr>
			<tr>
				<td><strong>Building</strong></td>
				<td>{{$value->Building}}</td>
			</tr>
			<tr>
				<td><strong>LandLord Name</strong></td>
				<td>{{$value->LandLord}}</td>
			</tr>
			<tr>
				<td><strong>LandLord Account</strong></td>
				<td>{{$value->LandLord_account}}</td>
			</tr>
			<tr>
				<td><strong>Tenant Name</strong></td>
				<td>{{$value->tenant_name}}</td>
			</tr>
			<tr>
				<td><strong>Contract</strong></td>
				<td><strong> From : </strong>{{$value->contract_start_date}}<strong> To : </strong>{{$value->contract_end_date}}</td>
			</tr>
			<?php $contract_start_date=$value->contract_start_date;
				  $maintenance_amount=$value->maintenance_amount;
				  $total_maintenance_amount=$value->maintenance_amount;
			  ?>
		@endforeach
		</tbody>
	</table>
	<table class="table table-bordered" style="font-size: 13px !important;">
		<thead>
			<tr>
				<th>DATE</th>
				<th>DESCRIPTION</th>
				<th>RECEIPT</th>
				<th>PAYMENT</th>
				<th>BALANCE</th>
			</tr>
		</thead>
		<tbody>
			<?php  $counter=0 ?>
			<tr>
				<td>{{$contract_start_date}}</td>
				<td>Balance B/F</td>
				<td>{{number_format($maintenance_amount,2)}}</td>
				<td>0.00</td>
				<td>{{number_format($maintenance_amount,2)}}</td>
			</tr>
		 @foreach($maintenance as $value)
			<tr>
				<td>{{$value->maintenance_date}}</td>
				<td>{{$value->maintenance_description}}</td>
				<td></td>
				<td>{{number_format($value->maintenance_AED,2)}}</td>
				<?php $maintenance_amount=number_format((str_replace(",","",$maintenance_amount)-str_replace(",","",$value->maintenance_AED)),2) ?>
				<td>{{number_format(str_replace(",","",$maintenance_amount),2)}}</td>
			</tr>
		@endforeach
		<tr>
			<td colspan="2"><strong>Net Balance</strong></td>
			<td><strong>{{number_format($total_maintenance_amount,2)}}</strong></td>
			<td><strong>{{number_format($total,2)}}</strong></td>
			<td><strong>{{number_format(str_replace(",","",$maintenance_amount),2)}}</strong></td>
		</tr>
		</tbody>
	</table>
	<footer>
	    <div class="footerBar">Office 411, Churchill Executive Towers, Business Bay, P.o Box 124874, Dubai, UAE.</div>
	</footer>
</body>
</html>