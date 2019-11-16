<?php 
 $connection      = mysqli_connect('localhost','edenfort_crm','D[0zpHn1lEk4','edenfort_crm');

 print_r( $insertQuery);
include_once('lib/class.imap.php');

$email = new Imap();

$inbox = null;

if ($email->connect('{mail.edenfort.ae:143/notls}INBOX','info@edenfort.ae','K3X0Cy0v+0_e')) {
	// $subject = 'You just got a Dubizzle phone lead!';
	$subject = 'Bayut.com Lead Notification: CALL Missed';
	$inbox = $email->getMessages('html',$subject);
}

// echo "<pre>";
// print_r($inbox);
// echo "</pre>";
foreach ($inbox as $mainRow) {
		// echo "<pre>";
		// print_r($mainRow);
    
	foreach ($mainRow as $row) {
		echo "<pre>";
        
		echo($row['message']);

    $ignoreTags= strip_tags($row['message']); 

       $Email_data=explode('up:',$ignoreTags);
      $number=explode(' ',$Email_data[1]);

   $contact= $number[0];

// Name
     $withouttags= explode('td',$row['message']); 
     $forstatus= explode('>',$withouttags[11]); 
     $Name=explode('>',$withouttags[15]);

  //$subject=$forstatus[1];

   $name= strip_tags($Name[1]);
   
  $date=explode('>',$withouttags[19]); 
  $date1= strip_tags($date[1]); 
  
  
  $datetime=$date1;

echo $contact;
echo $subject;

echo $name.'<br>';

echo $datetime;
$mailId = $row['uid'];

$exist = "SELECT * FROM leads WHERE mail_id='$mailId' ";
   $verified= mysqli_query($connection, $exist);
   
if(mysqli_num_rows( $verified) == 1){
    echo ' Record already exist';
}else{ 

         $insertQuery     = "INSERT into leads (lead_user,contact_no,submission_date,subject,lead_source,mail_id) values('$name','$contact','$datetime','$subject','Bayut',$mailId)";
          //print_r($insertQuery);
 $fireSelectQuery = mysqli_query($connection,$insertQuery);
}
     //datetime
       //  $date= $Email_data[192].'-'.$Email_data[193].'-'.$Email_data[194].' '.$Email_data[195].'<br>';
       //   $Date1=substr($date,18);
       //  echo $Date1.'<br>';
       //   //number//
       // $number=$Email_data[159].'<br>';
       //  $num=substr($number,15);
       //  echo $num;
       //  //name//
       //  $name=$Email_data[188].' '.$Email_data[189]; 
       //    $Name=substr($name,1);
       //    echo   $Name; 
    } 
}

 ?>