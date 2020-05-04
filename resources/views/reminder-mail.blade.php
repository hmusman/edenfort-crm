<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Edenfort Properties</title>
      <style type="text/css" media="screen">
        .card {
           box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
           transition: 0.3s;

          }

         .card:hover {
             box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
          }
          .card-header{
              background: #1976d2;
              border-radius: 20px;
          }
          .card-body{
                margin-left: 36px;
                padding-top: 9px;
                margin-right: 31px;
                padding-bottom: 25px;
                border-radius: 10px;
          }
          .card-title{
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    height: 35px;
    padding-top: 11px;
    padding-left: 25px;
    color: white;
          }
          p, span{
                padding-left: 25px;
          }


          #customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
      </style>
</head>
<body>
  <div class="container">
    <div class="card text-white bg-primary mb-3" style="border-radius: 20px; ">
      <div class="card-header" style="background: #1976d2;">
        <div class="row">
          <!-- <img src="{{asset ('public/assets/images/logo.png')}}" alt="Logo" style="height: 40px; margin-top: 16px; margin-left: 20px; position: absolute;"> -->
          <h2 class="mt-2 ml-5 mb-0" style="color: white; margin-left: 41%; margin-top: -8px; padding-top: 24px; padding-bottom: 26px;">Edenfort Real Estate</h2>
        </div>  
      </div>
    </div>
    @if($massage['reminder_of']=='Deals')
    <div class="row">
      <div class="col-sm-12">
        <div class="card" style="border: 1px solid lightgray; border-radius: 37px; width: 95%;margin-left: 29px;  margin: auto; height: 950px;">
          <div class="card-body ">
            <h3 class="card-title card-header">Edenfort CRM Reminder Alert</h3>
            <h3 style="padding-left: 25px;" class="card-text"><strong>Reminder alert of {{$massage['reminder_of']}}</strong></h3>
            <div class="col-sm-6" style="width: 50%; float: left;">
              <table id="customers" style="margin-left: 25px;">
              <tr>
                <td><strong>Reminder Type:</strong></td>
                <td>{{$massage['reminder_type']}}</td>
              </tr>
              <tr>
                <td><strong>Building Name:</strong></td>
                <td>{{$massage['building']}}</td>
              </tr>
              <tr>
                <td><strong>Deal Start Date:</strong></td>
                <td>{{$massage['deal_start_date']}}</td>
              </tr>
              <tr>
                <td><strong>Contract Start Date:</strong></td>
                <td>{{$massage['contract_start_date']}}</td>
              </tr>
              <tr>
                <td><strong>Contract End Date:</strong></td>
                <td>{{$massage['contract_end_date']}}</td>
              </tr>
              <tr>
                <td><strong>Reference No:</strong></td>
                <td>{{$massage['referenceNo']}}</td>
              </tr>
              <tr>
                <td><strong>Broker Name:</strong></td>
                <td>{{$massage['broker_name']}}</td>
              </tr>
              <tr>
                <td><strong>Unit No:</strong></td>
                <td>{{$massage['unit_no']}}</td>
              </tr>
              <tr>
                <td><strong>Client Name:</strong></td>
                <td>{{$massage['client_name']}}</td>
              </tr>
              <tr>
                <td><strong>Property Type:</strong></td>
                <td>{{$massage['property_type']}}</td>
              </tr>
              <tr>
                <td><strong>Rent Sale Value:</strong></td>
                <td>{{$massage['rent_sale_value']}}</td>
              </tr>
              <tr>
                <td><strong>Rental Cheques:</strong></td>
                <td>{{$massage['rentalCheques']}}</td>
              </tr>
              <tr>
                <td><strong>Deal Status:</strong></td>
                <td>{{$massage['deal_Status']}}</td>
              </tr>
              <tr>
                <td><strong>Agent Name:</strong></td>
                <td>{{$massage['agent_name']}}</td>
              </tr>
              <tr>
                <td><strong>Gross Commission:</strong></td>
                <td>{{$massage['gross_commission']}}</td>
              </tr>
              <tr>
                <td><strong>gc_vat:</strong></td>
                <td>{{$massage['gc_vat']}}</td>
              </tr>
              <tr>
                <td><strong>Company Commision:</strong></td>
                <td>{{$massage['company_commision']}}</td>
              </tr>
              <tr>
                <td><strong>cc_Vat:</strong></td>
                <td>{{$massage['cc_Vat']}}</td>
              </tr>
              <tr>
                <td><strong>efAgent_Commission:</strong></td>
                <td>{{$massage['efAgent_Commission']}}</td>
              </tr>
              <tr>
                <td><strong>efAgent_Vat:</strong></td>
                <td>{{$massage['efAgent_Vat']}}</td>
              </tr>
              <tr>
                <td><strong>Contact No:</strong></td>
                <td><span itemprop="telephone"><a href="tel:+{{$massage['contanct_no']}}">{{$massage['contanct_no']}}</a></span></td>
              </tr>
              <tr>
                <td><strong>Email:</strong></td>
                <td>{{$massage['email']}}</td>
              </tr>
             
            </table>
            </div>

            <div class="col-sm-6" style="width: 50%; float: left;">
              <table id="customers" style="margin-left: 25px;">
              <tr>
                <td><strong>Second Agent Name:</strong></td>
                <td>{{$massage['secondAgentName']}}</td>
              </tr>
              <tr>
                <td><strong>Second Agent Company:</strong></td>
                <td>{{$massage['secondAgentCompany']}}</td>
              </tr>
              <tr>
                <td><strong>sacPhone:</strong></td>
                <td>{{$massage['sacPhone']}}</td>
              </tr>
              <tr>
                <td><strong>Second Agent Commission</strong></td>
                <td>{{$massage['secondAgent_Commission']}}</td>
              </tr>
              <tr>
                <td><strong>sacAgent_Vat:</strong></td>
                <td>{{$massage['sacAgent_Vat']}}</td>
              </tr>
              <tr>
                <td><strong>thirdAgentName:</strong></td>
                <td>{{$massage['thirdAgentName']}}</td>
              </tr>
              <tr>
                <td><strong>thirdAgentCompany:</strong></td>
                <td>{{$massage['thirdAgentCompany']}}</td>
              </tr>
              <tr>
                <td><strong>tacPhone:</strong></td>
                <td>{{$massage['tacPhone']}}</td>
              </tr>
              <tr>
                <td><strong>thirdAgentCommission:</strong></td>
                <td>{{$massage['thirdAgentCommission']}}</td>
              </tr>
              <tr>
                <td><strong>tacVat:</strong></td>
                <td>{{$massage['tacVat']}}</td>
              </tr>
              <tr>
                <td><strong>paymentTerms:</strong></td>
                <td>{{$massage['paymentTerms']}}</td>
              </tr>
              <tr>
                <td><strong>chequeNumber:</strong></td>
                <td>{{$massage['chequeNumber']}}</td>
              </tr>
              <tr>
                <td><strong>ownerCompanyName:</strong></td>
                <td>{{$massage['ownerCompanyName']}}</td>
              </tr>
              <tr>
                <td><strong>ownerName:</strong></td>
                <td>{{$massage['ownerName']}}</td>
              </tr>
              <tr>
                <td><strong>ownerPhone:</strong></td>
                <td>{{$massage['ownerPhone']}}</td>
              </tr>
              <tr>
                <td><strong>ownerEmail:</strong></td>
                <td>{{$massage['ownerEmail']}}</td>
              </tr>
              <tr>
                <td><strong>ownerNameSecond:</strong></td>
                <td>{{$massage['ownerNameSecond']}}</td>
              </tr>
              <tr>
                <td><strong>ownerPhoneSecond:</strong></td>
                <td>{{$massage['ownerPhoneSecond']}}</td>
              </tr>
              <tr>
                <td><strong>ownerEmailSecond:</strong></td>
                <td>{{$massage['ownerEmailSecond']}}</td>
              </tr>
              <tr>
                <td><strong>chequeAmount:</strong></td>
                <td>{{$massage['chequeAmount']}}</td>
              </tr>
              <tr>
                <td><strong>note:</strong></td>
                <td>{{$massage['note']}}</td>
              </tr>
            </table>
            </div>
             @else
              <div class="row">
              <div class="col-sm-6">
                <div class="card" style="border: 1px solid lightgray; border-radius: 37px; width: 50%;margin-left: 29px;">
                  <div class="card-body ">
                    <h3 class="card-title card-header">Edenfort CRM Reminder Alert</h3>
                    <h3 style="padding-left: 25px;" class="card-text"><strong>Reminder alert of Property</strong></h3>
                    <table id="customers" style="margin-left: 25px;">
                      <tr>
                        <td><strong>Reminder Type:</strong></td>
                        <td>coldcalling</td>
                      </tr>
                      <tr>
                        <td><strong>Building Name:</strong></td>
                        <td>ABC</td>
                      </tr>
                      <tr>
                        <td><strong>Area:</strong></td>
                        <td>abc</td>
                      </tr>
                      <tr>
                        <td><strong>LandLoard:</strong></td>
                        <td>qwerty</td>
                      </tr>
                      <tr>
                        <td><strong>Email:</strong></td>
                        <td>qwertyuiop</td>
                      </tr>
                      <tr>
                        <td><strong>Contact No:</strong></td>
                        <td><span itemprop="telephone"><a href="tel:+0987654321">0987654321</a></span></td>
                      </tr>
                     
                    </table>
                  </div>
                </div>
              </div>
            </div>
            @endif
        </div>
      </div>
    </div>
    </div>
</body>
</html>



