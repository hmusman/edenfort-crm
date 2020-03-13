<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Invoice</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        .text-right {
            text-align: right;
        }
    </style>

</head>
<body class="login-page" style="background: white">

    <div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table" style="font-size: 13px !important;">
                    <tr>
                        <td>
                            <img src="{{url('public/assets/images/pdflogo.png')}}" height="80" width="100">
                        </td>
                        <td class="header-right" style="text-align:right">
                            <span class="phone">+971-4-323-0688</span> <br>
                            <span class="email">info@edenfort.ae</span> <br>
                            <span>www.edenfort.ae</span> <br>
                            <span class="licence">Trade License No. 774424 </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="margin-bottom: 0px">&nbsp;</div>
        <div class="row">
            <div class="col-xs-2">
                <label>Report type :</label>  
                <p>{{@$reportType}}</p>
            </div>
            <div class="col-xs-2">
                <label>Agent Name :</label>  
                <p>{{@$agentName}}</p>
            </div>
            <div class="col-xs-2">
                <label>From Date :</label>  
                <p>{{@$fromDate}}</p>
            </div>
            <div class="col-xs-2">
                <label>To Date :</label>  
                <p>{{@$toDate}}</p>
            </div>
            <div class="col-xs-4"></div>
        </div><br>
        @if(@$properties)
            <table class="table">
            <thead style="background: #F5F5F5;">
                <tr>
                    <th>Sno#</th>
                    <th>Unit No</th>
                    <th>Building</th>
                    <th>Area</th>
                    <th>Landlord</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Bedrooms</th>
                    <th>Area SqFt</th>
                    <th>Price</th>
                    <th>Agent Name</th>
                    <th>Agent Phone</th>
                </tr>
            </thead>
            <tbody>
                @if(count($properties) > 0)
                    @foreach($properties as $key => $property)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$property->unit_no}}</td>
                            <td>{{$property->Building}}</td>
                            <td>{{$property->area}}</td>
                            <td>{{$property->LandLord}}</td>
                            <td>{{$property->contact_no}}</td>
                            <td>{{$property->email}}</td>
                            <td>{{$property->Bedroom}}</td>
                            <td>{{$property->Area_Sqft}}</td>
                            <td>{{$property->Price}}</td>
                            <td>{{$property->Agent->user_name}}</td>
                            <td>{{$property->Agent->Phone}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                            <td colspan="11" style="text-align:center;">No Data Found!</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @elseif(@$leads)
            <table class="table">
            <thead style="background: #F5F5F5;">
                <tr>
                    <th>Sno#</th>
                    <th>Mail ID</th>
                    <th>Lead User</th>
                    <th>Submission Date</th>
                    <th>Client Name</th>
                    <th>Contact No</th>
                    <th>Subject</th>
                    <th>Feedback</th>
                    <th>Lead Source</th>
                    <th>Call Time</th>
                    <th>Created_at</th>
                </tr>
            </thead>
            <tbody>
                @if(count($leads) > 0)
                    @foreach($leads as $key => $lead)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$lead->mail_id}}</td>
                            <td>{{$lead->lead_user}}</td>
                            <td>{{$lead->submission_date}}</td>
                            <td>{{$lead->client_name}}</td>
                            <td>{{$lead->contact_no}}</td>
                            <td>{{$lead->subject}}</td>
                            <td>{{$lead->feedback}}</td>
                            <td>{{$lead->lead_source}}</td>
                            <td>{{$lead->callTotalTime}}</td>
                            <td>{{date('M d Y',strtotime($lead->created_at))}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                            <td colspan="11" style="text-align:center;">No Data Found!</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @elseif(@$coldcallings)
            <table class="table">
            <thead style="background: #F5F5F5;">
                <tr>
                    <th>Sno#</th>
                    <th>Unit No</th>
                    <th>Building</th>
                    <th>Area</th>
                    <th>Landlord</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Bedrooms</th>
                    <th>Area SqFt</th>
                    <th>Price</th>
                    <th>Agent Name</th>
                    <th>Agent Phone</th>
                </tr>
            </thead>
            <tbody>
                @if(count($coldcallings) > 0)
                    @foreach($coldcallings as $key => $coldcalling)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$coldcalling->unit_no}}</td>
                            <td>{{$coldcalling->Building}}</td>
                            <td>{{$coldcalling->area}}</td>
                            <td>{{$coldcalling->LandLord}}</td>
                            <td>{{$coldcalling->contact_no}}</td>
                            <td>{{$coldcalling->email}}</td>
                            <td>{{$coldcalling->Bedroom}}</td>
                            <td>{{$coldcalling->Area_Sqft}}</td>
                            <td>{{$coldcalling->Price}}</td>
                            <td>{{$coldcalling->user_name}}</td>
                            <td>{{$coldcalling->Phone}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                            <td colspan="11" style="text-align:center;">No Data Found!</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @endif
        
    </div>

    </body>
    </html>