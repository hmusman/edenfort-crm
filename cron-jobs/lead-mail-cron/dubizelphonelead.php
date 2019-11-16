<?php 
 $connection      = mysqli_connect('localhost','edenfort_crm','D[0zpHn1lEk4','edenfort_crm');

 print_r( $insertQuery);
include_once('lib/class.imap.php');

$email = new Imap();

$inbox = null;

if ($email->connect('{mail.edenfort.ae:143/notls}INBOX','info@edenfort.ae','K3X0Cy0v+0_e')) {
	// $subject = 'You just got a Dubizzle phone lead!';
	$subject = 'You just got a Dubizzle phone lead!';
	$inbox = $email->getMessages('html',$subject);
}

// echo "<pre>";
// print_r($inbox);
// echo "</pre>";
foreach ($inbox as $mainRow) {

	 foreach ($mainRow as $row) {
		 echo "<pre>";

		echo($row['message']);

    $ignoreTags= strip_tags($row['message']); 
    $Email_data1=explode(' ',$ignoreTags);

    // $name= $Email_data1[3053].' '.$Email_data1[3054];

    // $Email_data=explode('Date:',$ignoreTags);
    // $Email=explode(' ',$Email_data[1]);
    // //   Date 
    //  $date= $Email[1].'-'.$Email[2].'-'.$Email[3]; 
    // //Time
    //   $time=  $Email[40].' '.$Email[41].'<br>'; #
    // //Number
    //      $contact=  $Email[79]; 
         
//new template
// print_r($Email_data1);

$lastName= preg_replace('/\s+/', '', $Email_data1[3443]);
$lastNameAgain= preg_replace('/[ ,]+/', '', trim($lastName));


 $name= $Email_data1[3442].' '.$lastNameAgain;



    $Email_data=explode('Date',$ignoreTags);
    $Email=explode(' ',$Email_data[1]);
 
    //   Date 
     $date= $Email[1].'-'.$Email[2].'-'.$Email[3]; 
    //Time
       $time=  $Email[40].' '.$Email[41].'<br>'; #
    //Number
     // print_r($Email);
         $contact=  $Email[79]; 
         
//end of new template


$agentname=preg_replace('/[,]/', '', $name);
echo $agentname;
echo $date;
echo $time;
echo $contact;
$mailId = $row['uid'];

$exist = "SELECT * FROM leads WHERE mail_id='$mailId' ";
   $verified= mysqli_query($connection, $exist);
   
if(mysqli_num_rows( $verified) == 1){
    echo ' Record already exist';
    $insertQuery     = "INSERT into leads (lead_user,contact_no,submission_date,subject,lead_source,mail_id) values('$agentname','$contact','$date','$subject','dubizzle',$mailId)";
         print_r($insertQuery);
}else{ 
 $insertQuery     = "INSERT into leads (lead_user,contact_no,submission_date,subject,lead_source,mail_id) values('$agentname','$contact','$date','$subject','dubizzle',$mailId)";
       //  print_r($insertQuery);
 $fireSelectQuery = mysqli_query($connection,$insertQuery);
}
    }
}

 ?>