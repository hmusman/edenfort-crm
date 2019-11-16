<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Todays Lead Report</h2>
           
 <table class="table">
  <thead>
    <tr>
      <th >User Name</th>
      <th >Rent</th>
      <th >Sale</th>
     <!-- <th >No Type</th>-->
    </tr>
  </thead>
  <tbody>
  	@foreach($users as $u)
    <tr>
      <th scope="row">{{$u->user_name}}</th>
      <td>{{$u->getAgentsRentLeads($u->user_name)}}</td>
      <td>{{$u->getAgentsSaleLeads($u->user_name)}}</td>
      
    </tr>
    @endforeach
  </tbody>
</table>
</div>

</body>
</html>
