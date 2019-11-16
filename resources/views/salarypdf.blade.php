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
    body,h6{
        font-family:Sans-serif;
    }
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
    <h6>Agent {{$account->user->user_name}} Salary Sheet for the month of {{date('M',strtotime($open_month->month))}},{{date('Y',strtotime($open_month->month))}}</h6>
    <table class="table table-bordered" style="font-size: 13px !important;">
        <thead>
           <tr>
               <th>Sr.no</th>
               <th>Date</th>
               <th>Deal Ref</th>
               <th>Property</th>
               <th>Total Commission</th>
               <th>Percentage</th>
               <th>Agent Commission</th>
           </tr>
        </thead>
		<tbody>
        <?php  $counter=1; ?>
            @if(count($getAgentsDeals) > 0)
                @foreach($getAgentsDeals as $deal)
                    <tr>
                        <td>{{$counter++}}</td>
                        <td>{{date('Y-m-d',strtotime($deal->created_at))}}</td>
                        <td>{{$deal->referenceNo}}</td>
                        <td>Unit No: {{$deal->unit_no}} {{$deal->building}}</td>
                        <td>{{$deal->company_commision}}</td>
                        <td>{{$account->percentage}}%</td>
                        <td>{{$deal->company_commision * $account->percentage / 100}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
	</table>
	<table class="table table-bordered" style="font-size: 13px !important;">
		<tbody>
		    <tr>
				<td><strong>Total Company Commission</strong></td>
				<td></td>
				<td>{{$account->total_company_commission}}</td>
			</tr>
			<tr>
				<td><strong>Agent Percentage</strong></td>
				<td></td>
				<td>{{$account->percentage}}%</td>
			</tr>
			<tr>
				<td><strong>Agent Relief</strong></td>
				<td></td>
				<td>{{$account->relief}}</td>
			</tr>
			<tr>
				<td><strong>Total Agent Commission</strong></td>
				<td></td>
				<td>{{$account->gross_commission}}</td>
			</tr>
			<tr>
			    <td><strong>Advance</strong></td>
			    <td>@if(!is_null($loan)) {{$loan->advance_type}} @endif</td>
				<td>@if(!is_null($loan)) - {{$loan->paid_amount}} @endif </td>
			</tr>
			<tr>
			    <td><strong>Amount to be paid</strong></td>
			    <td></td>
				<td>@if(!is_null($loan)) {{$account->gross_commission - $loan->paid_amount}} @else {{$account->gross_commission}} @endif </td>
			</tr>
			<tr>
			    <td><strong>Total Paid</strong></td>
			    <td></td>
				<td>@if(!is_null($loan)) {{$account->gross_commission - $loan->paid_amount}} @else {{$account->gross_commission}} @endif</td>
			</tr>
		</tbody>
	</table>
	<footer>
	    <div class="footerBar">Office 411, Churchill Executive Towers, Business Bay, P.o Box 124874, Dubai, UAE.</div>
	</footer>
</body>
</html>