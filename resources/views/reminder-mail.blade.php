<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Edenfort Properties</title>
</head>
<body>
  <div class="container">
    <!-- <div class="card text-white bg-primary mb-3" style="border-radius: 20px; ">
      <div class="card-header" style="background: #1976d2;">
        <div class="row"> -->
          <!-- <img src="{{asset ('public/assets/images/logo.png')}}" alt="Logo" style="height: 40px; margin-top: 16px; margin-left: 20px; position: absolute;"> -->
          <h2 class="mt-2 ml-5 mb-0" style="color: black; margin-top: -8px; padding-top: 24px; padding-bottom: 26px;">Edenfort Real Estate</h2>
        <!-- </div>  
      </div>
    </div> -->
    @if($massage['reminder_of']=='Deals_without_reminder')
    <p><strong>Reminder Of : </strong> {{$massage['reminder_of-1']}}</p>
    <p><strong>Reminder Type : </strong>{{$massage['reminder_type']}}</p>
    <p><strong>Building Name : </strong>{{$massage['building']}}</p> 
    <p><strong>Deal Start Date : </strong>{{$massage['deal_start_date']}}</p>
    <p><strong>Contract Start Date : </strong>{{$massage['contract_start_date']}}</p> 
    <p><strong>Contract End Date : </strong>{{$massage['contract_end_date']}}</p> 
    <p><strong>Reference No : </strong>{{$massage['referenceNo']}}</p> 
    <p><strong>Broker Name : </strong>{{$massage['broker_name']}}</p>
    <p><strong>Unit No : </strong>{{$massage['unit_no']}}</p> 
    <p><strong>Client Name : </strong>{{$massage['client_name']}}</p> 
    <p><strong>Property Type : </strong>{{$massage['property_type']}}</p> 
    <p><strong>Rent Sale Value : </strong>{{$massage['rent_sale_value']}}</p>
    <p><strong>Rental Cheques : </strong>{{$massage['rentalCheques']}}</p> 
    <p><strong>Deal Status : </strong>{{$massage['deal_Status']}}</p> 
    <p><strong>Agent Name : </strong>{{$massage['agent_name']}}</p> 
    <p><strong>Gross Commission : </strong>{{$massage['gross_commission']}}</p>
    <p><strong>gc_vat : </strong>{{$massage['gc_vat']}}</p> 
    <p><strong>Company Commision : </strong>{{$massage['company_commision']}}</p> 
    <p><strong>cc_Vat : </strong>{{$massage['cc_Vat']}}</p> 
    <p><strong>efAgent_Commission : </strong>{{$massage['efAgent_Commission']}}</p>
    <p><strong>efAgent_Vat : </strong>{{$massage['efAgent_Vat']}}</p> 
    <p><strong>Second Agent Name : </strong>{{$massage['secondAgentName']}}</p>
    <p><strong>Second Agent Company : </strong>{{$massage['secondAgentCompany']}}</p> 
    <p><strong>sacPhone : </strong>{{$massage['sacPhone']}}</p> 
    <p><strong>Second Agent Commission : </strong>{{$massage['secondAgent_Commission']}}</p> 
    <p><strong>sacAgent_Vat : </strong>{{$massage['sacAgent_Vat']}}</p>
    <p><strong>thirdAgentName : </strong>{{$massage['thirdAgentName']}}</p> 
    <p><strong>thirdAgentCompany : </strong>{{$massage['thirdAgentCompany']}}</p> 
    <p><strong>tacPhone : </strong>{{$massage['tacPhone']}}</p> 
    <p><strong>thirdAgentCommission : </strong>{{$massage['thirdAgentCommission']}}</p>
    <p><strong>tacVat : </strong>{{$massage['tacVat']}}</p> 
    <p><strong>paymentTerms : </strong>{{$massage['paymentTerms']}}</p> 
    <p><strong>chequeNumber : </strong>{{$massage['chequeNumber']}}</p> 
    <p><strong>ownerCompanyName : </strong>{{$massage['ownerCompanyName']}}</p>
    <p><strong>ownerName : </strong>{{$massage['ownerName']}}</p> 
    <p><strong>ownerPhone : </strong>{{$massage['ownerPhone']}}</p> 
    <p><strong>ownerEmail : </strong>{{$massage['ownerEmail']}}</p> 
    <p><strong>ownerNameSecond : </strong>{{$massage['ownerNameSecond']}}</p>
    <p><strong>ownerPhoneSecond : </strong>{{$massage['ownerPhoneSecond']}}</p> 
    <p><strong>ownerEmailSecond : </strong>{{$massage['ownerEmailSecond']}}</p> 
    <p><strong>chequeAmount : </strong>{{$massage['chequeAmount']}}</p> 
    <p><strong>note : </strong>{{$massage['note']}}</p>
    <p><strong>Email : </strong>{{$massage['email']}}</p> 
    <p><strong>Contact No : </strong><span itemprop="telephone"><a href="tel:+{{$massage['contanct_no']}}">{{$massage['contanct_no']}}</a></span></p>
    @elseif($massage['reminder_of']=='Deals')
    <p><strong>Reminder Of : </strong> {{$massage['reminder_of']}}</p>
    <p><strong>Reminder Type : </strong>{{$massage['reminder_type']}}</p>
    <p><strong>Building Name : </strong>{{$massage['building']}}</p> 
    <p><strong>Deal Start Date : </strong>{{$massage['deal_start_date']}}</p>
    <p><strong>Contract Start Date : </strong>{{$massage['contract_start_date']}}</p> 
    <p><strong>Contract End Date : </strong>{{$massage['contract_end_date']}}</p> 
    <p><strong>Reference No : </strong>{{$massage['referenceNo']}}</p> 
    <p><strong>Broker Name : </strong>{{$massage['broker_name']}}</p>
    <p><strong>Unit No : </strong>{{$massage['unit_no']}}</p> 
    <p><strong>Client Name : </strong>{{$massage['client_name']}}</p> 
    <p><strong>Property Type : </strong>{{$massage['property_type']}}</p> 
    <p><strong>Rent Sale Value : </strong>{{$massage['rent_sale_value']}}</p>
    <p><strong>Rental Cheques : </strong>{{$massage['rentalCheques']}}</p> 
    <p><strong>Deal Status : </strong>{{$massage['deal_Status']}}</p> 
    <p><strong>Agent Name : </strong>{{$massage['agent_name']}}</p> 
    <p><strong>Gross Commission : </strong>{{$massage['gross_commission']}}</p>
    <p><strong>gc_vat : </strong>{{$massage['gc_vat']}}</p> 
    <p><strong>Company Commision : </strong>{{$massage['company_commision']}}</p> 
    <p><strong>cc_Vat : </strong>{{$massage['cc_Vat']}}</p> 
    <p><strong>efAgent_Commission : </strong>{{$massage['efAgent_Commission']}}</p>
    <p><strong>efAgent_Vat : </strong>{{$massage['efAgent_Vat']}}</p> 
    <p><strong>Second Agent Name : </strong>{{$massage['secondAgentName']}}</p>
    <p><strong>Second Agent Company : </strong>{{$massage['secondAgentCompany']}}</p> 
    <p><strong>sacPhone : </strong>{{$massage['sacPhone']}}</p> 
    <p><strong>Second Agent Commission : </strong>{{$massage['secondAgent_Commission']}}</p> 
    <p><strong>sacAgent_Vat : </strong>{{$massage['sacAgent_Vat']}}</p>
    <p><strong>thirdAgentName : </strong>{{$massage['thirdAgentName']}}</p> 
    <p><strong>thirdAgentCompany : </strong>{{$massage['thirdAgentCompany']}}</p> 
    <p><strong>tacPhone : </strong>{{$massage['tacPhone']}}</p> 
    <p><strong>thirdAgentCommission : </strong>{{$massage['thirdAgentCommission']}}</p>
    <p><strong>tacVat : </strong>{{$massage['tacVat']}}</p> 
    <p><strong>paymentTerms : </strong>{{$massage['paymentTerms']}}</p> 
    <p><strong>chequeNumber : </strong>{{$massage['chequeNumber']}}</p> 
    <p><strong>ownerCompanyName : </strong>{{$massage['ownerCompanyName']}}</p>
    <p><strong>ownerName : </strong>{{$massage['ownerName']}}</p> 
    <p><strong>ownerPhone : </strong>{{$massage['ownerPhone']}}</p> 
    <p><strong>ownerEmail : </strong>{{$massage['ownerEmail']}}</p> 
    <p><strong>ownerNameSecond : </strong>{{$massage['ownerNameSecond']}}</p>
    <p><strong>ownerPhoneSecond : </strong>{{$massage['ownerPhoneSecond']}}</p> 
    <p><strong>ownerEmailSecond : </strong>{{$massage['ownerEmailSecond']}}</p> 
    <p><strong>chequeAmount : </strong>{{$massage['chequeAmount']}}</p> 
    <p><strong>note : </strong>{{$massage['note']}}</p>
    <p><strong>Email : </strong>{{$massage['email']}}</p> 
    <p><strong>Contact No : </strong><span itemprop="telephone"><a href="tel:+{{$massage['contanct_no']}}">{{$massage['contanct_no']}}</a></span></p> 
    @else
      <p>Reminder Of : {{$massage['reminder_of']}}</p>
      <p>Reminder Type : {{$massage['reminder_type']}}</p>
      <p>Building : {{$massage['Building']}}</p>
      <p>Area : {{$massage['area']}}</p>
      <p>LandLoard : {{$massage['Landloard']}}</p>
      <p>Email : {{$massage['email']}}</p>
      <p>Contact No : <span itemprop="telephone"><a href="tel:+{{$massage['contanct_no']}}">{{$massage['contanct_no']}}</a></span></p><br>
      <p>Edenfort Real Estate</p>
      
    @endif
</div>
</div>
</div>
</div>
</body>
</html>
