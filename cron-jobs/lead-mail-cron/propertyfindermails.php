<?php 
 $connection      = mysqli_connect('localhost','edenfort_crm','D[0zpHn1lEk4','edenfort_crm');

 print_r( $insertQuery);
include_once('lib/class.imap.php');

$email = new Imap();

$inbox = null;

if ($email->connect('{mail.edenfort.ae:143/notls}INBOX','info@edenfort.ae','K3X0Cy0v+0_e')) {
	// $subject = 'You just got a Dubizzle phone lead!';
	$subject1 = 'propertyfinder.ae - Contact Eden Fort Real Estate';
	$inbox = $email->getMessages('html',$subject1);
}

// echo "<pre>";
// print_r($inbox);
// echo "</pre>";
foreach ($inbox as $mainRow) {
		// echo "<pre>";
		// print_r($mainRow);
    // -agent name,Sender NAme,Reference #,Price,number,Email
	foreach ($mainRow as $row) {
		echo "<pre>";
        
		echo($row['message']);

$Email_for=explode('td',$row['message']);

     $ignore=strip_tags($Email_for[46]); 
     $Email=explode(':',$ignore);

$Email_ref=explode(' ',$Email[5]);

$Email_email=explode(' ',end($Email));

$email=$Email_email[37];
 $email.'<br>';
$subject = $Email_ref[1];
$search = 'Please' ;
$trimmed = str_replace($search, '', $subject);
 $trimmed ;

 $number=$Email_email[74].''.$Email_email[75];
 $number1=preg_replace('/[.]/', '', $number);

          $number1;





     $ignoreTags= strip_tags($row['message']); 
        $Email_data=explode('Dear',$ignoreTags);
        $Email_data1=explode(' ',$Email_data[1]);
      //   print_r($Email_data1);
         $price=$Email_data1[2144].' '.$Email_data1[2145]; 
          $price1=preg_replace('/[-]/', '', $price);
          
          $price2=preg_replace('/[&nbsp;]/', '', $price1);
         // $price1;

     $Agent=$Email_data1[1].' '.$Email_data1[2];
     $Agent=preg_replace('/[.,-]/', '', $Agent);
    //  $Agent1;

    $Name=$Email_data1[74];
         if($Email_data1[75]!='has'){
        echo $Email_data1[75];

    }

echo "email:". $email."</br>";
echo "trimmed:". $trimmed ."</br>";
 echo "number1:". $number1."</br>";

    echo "price:". $price2."</br>";
   echo "agent1:". $Agent."</br>";
    echo "client:". $Name."</br>";
echo "subject:". $subject1."</br>";
 $mailId = $row['uid'];
 
 $exist = "SELECT * FROM leads WHERE mail_id='$mailId' ";
   $verified= mysqli_query($connection, $exist);
   
if(mysqli_num_rows( $verified) == 1){
    echo ' Record already exist';
    // $update = "UPDATE leads set contact_no='$number1',email='$email',lead_user='$Agent' where mail_id='$mailId' ";
    //  $fireSelectQuery = mysqli_query($connection,$update);
}else{ 
$insertQuery     = "INSERT into leads (lead_user,client_name,reference,outcome,contact_no,email,subject,lead_source,mail_id) values('$Agent','$Name','$trimmed','$price2','$number1','$email','$subject1','Property finder',$mailId)";
         //  print_r($insertQuery);
       
 $fireSelectQuery = mysqli_query($connection,$insertQuery);
}
//   if($fireSelectQuery){
//              echo'ok';
//          }else{
//              echo'not';
//          }
         
         
    }
}


 ?>