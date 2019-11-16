<?php 
 $connection      = mysqli_connect('localhost','edenfort_crm','D[0zpHn1lEk4','edenfort_crm');

 print_r( $insertQuery);
include_once('lib/class.imap.php');

$email = new Imap();

$inbox = null;

if ($email->connect('{mail.edenfort.ae:143/notls}INBOX','info@edenfort.ae','K3X0Cy0v+0_e')) {
	// $subject = 'You just got a Dubizzle phone lead!';
	$subject = 'Call summary';
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
       $Email_data=explode(' ',$ignoreTags);
         // print_r($Email_data);

    $Name=$Email_data[3607].' '.$Email_data[3608];

$start=$Email_data[4467].' '.$Email_data[4468];
$end= $Email_data[4507].' '.$Email_data[4508];
    
$calWait= $Email_data[4586];
$talkTime= $Email_data[4547];


//echo $start;
$agentname=preg_replace('/[,]/', '', $Name);
 //echo  $agentname;


  $contact= $Email_data[4112];
  $mailId = $row['uid'];
  //abdul code start
  
  echo $start.'<br>'.$end.'<br>'.$agentname.'<br>'.$contact.'<br>'.$calWait.'<br>'.$talkTime;
  echo '<br>'.$subject.'<br>'.'Property finder'.'<br>'.$mailId;
  
  $exist = "SELECT * FROM leads WHERE mail_id='$mailId' ";
   $verified= mysqli_query($connection, $exist);
   
if(mysqli_num_rows( $verified) == 1){
    echo ' Record already exist';
}else{ 
    $insertQuery     = "INSERT into leads (lead_user,contact_no,callStart,callEnd,callTotalTime,subject,lead_source,mail_id) values('$agentname','$contact','$start','$end','$talkTime','$subject','Property finder',$mailId)";
        //  print_r($insertQuery);
 $fireSelectQuery = mysqli_query($connection,$insertQuery);
}
  //check query runs or not
 //  if($fireSelectQuery){echo'ok';}else{echo'not';}
  
   }
}

 ?>