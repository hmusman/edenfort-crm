<?php 
 $connection      = mysqli_connect('localhost','edenfort_crm','D[0zpHn1lEk4','edenfort_crm');

 // print_r( $insertQuery);
include_once('lib/class.imap.php');

$email = new Imap();

$inbox = null;

if ($email->connect('{mail.edenfort.ae:143/notls}INBOX','info@edenfort.ae','K3X0Cy0v+0_e')) {
	// $subject = 'You just got a Dubizzle phone lead!';
	$subject = 'You missed a call';
	$inbox = $email->getMessages('html',$subject);
}

// echo "<pre>";
// print_r($inbox);
// echo "</pre>";
foreach ($inbox as $mainRow) {
		// echo "<pre>";
	//	 print_r($mainRow);
    
	foreach ($mainRow as $row) {
		echo "<pre>";
        
		 echo($row['message']);

      $Email_data=explode(' ',$row['message']);
      // print_r($Email_data);
////NAME/// 
//old template
//  $lead_user = $Email_data[3408].' '.$Email_data[3409];  
//  $lead_phone = $Email_data[3635];    
//  $lead_date = $Email_data[3557].'-'.$Email_data[3558].'-'.$Email_data[3559];
//  $text_user = substr(strip_tags($lead_user), 0, -3) ; 
//  $textPhone = strip_tags($lead_phone);
//  $textDate = strip_tags($lead_date);
 
 //new template
          

$lastName= preg_replace('/\s+/', '', $Email_data[3824]);
$lastNameAgain= preg_replace('/[ ,]+/', '', trim($lastName));

  $lead_user = $Email_data[3823].' '.$lastNameAgain;  
 $lead_phone = $Email_data[4027];    
 $lead_date = $Email_data[3949].'-'.$Email_data[3950].'-'.$Email_data[3951];
$text_user=$lead_user;
// $text_user = substr(strip_tags($lead_user), 0, -3) ; 
 $textPhone = strip_tags($lead_phone);
 $textDate = strip_tags($lead_date);
 
 //end of new template
 $mailId = $row['uid'];
 
 echo'lead User: '.$text_user.'<br>';
///Number///
 echo 'lead Phone:'.$textPhone.'<br>';
///DAte ///
 echo 'lead date:'.$textDate.'<br>';
   echo $mailId;     

// echo $mailId;
$exist = "SELECT * FROM leads WHERE mail_id='$mailId' ";
   $verified= mysqli_query($connection, $exist);
   
if(mysqli_num_rows( $verified) == 1){
    echo ' Record already exist';
      $insertQuery     = "INSERT into leads (lead_user,contact_no,submission_date,subject,lead_source,mail_id) values('$text_user','$textPhone','$textDate','$subject','dubizzle',$mailId)";
  print_r($insertQuery);
}else{ 
    $insertQuery     = "INSERT into leads (lead_user,contact_no,submission_date,subject,lead_source,mail_id) values('$text_user','$textPhone','$textDate','$subject','dubizzle',$mailId)";
//          // print_r($insertQuery);
  $fireSelectQuery = mysqli_query($connection,$insertQuery);
            }
         
    }
}

 ?>