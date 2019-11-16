<?php 
$connection      = mysqli_connect('localhost','edenfort_crm','D[0zpHn1lEk4','edenfort_crm');

 print_r( $insertQuery);
include_once('lib/class.imap.php');

$email = new Imap();

$inbox = null;

if ($email->connect('{mail.edenfort.ae:143/notls}INBOX','info@edenfort.ae','K3X0Cy0v+0_e')) {
	// $subject = 'You just got a Dubizzle phone lead!';
	$subject = 'dubizzle - someone is interested in your';
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
     $mailId = $row['uid'];

     $ignoreTags= strip_tags($row['message']); 
	 //echo $ignoreTags;
	 
      $Email_data=explode(' ',$ignoreTags);
	  
	  //print_r($Email_data);
	  
      //Agent Name
	  $agent_name= $Email_data[866];
	  	$agent_name1=explode(',',$agent_name);
	  	$agent_name2=$agent_name1[0];
	  //Ref Name  
	  $ref = array_search("Ref", $Email_data);
    //   $refrence= $Email_data[$ref].' '.$Email_data[$ref+1].' '.$Email_data[$ref+2];
    $refrence= $Email_data[$ref+2];
	  
	  //Owner Name
	  $name = array_search("Name:", $Email_data);
    //   echo $Email_data[$name],' ',$Email_data[$name+1].'<br>';
	 $owner_name=$Email_data[$name+1];
	  
	  //Owner Contact no
	  $phone = array_search("Telephone:", $Email_data);
    //   $contact_no= $Email_data[$phone].' '.$Email_data[$phone+2];
	  $contact_no= $Email_data[$phone+2];
	  
	  //Owner Email
	  $email = array_search("Email:", $Email_data);
    //   $owner_email= $Email_data[$email].' '.$Email_data[$email+1];
	   $owner_email= $Email_data[$email+1];
	  
 //   $number=$Email_data[1239];
  //    $Num = substr($number, 20);
  //  echo $Num;
 
 //echo "<br> Data: <br>";
 
echo $agent_name2.'<br>'.$refrence.'<br>'.$owner_name.'<br>'.$contact_no.'<br>'.$owner_email;



echo "our mail id: ".$mailId;
//insertion
$exist = "SELECT * FROM leads WHERE  mail_id='$mailId' ";
   $verified= mysqli_query($connection, $exist);
   
if(mysqli_num_rows( $verified) == 1){
    echo ' Record already exist';
}else{ 
    
 //get usename by matching refernce
  $cutRefernce=substr($refrence, 0, 7);
    echo $cutRefernce.'<br><br>';
  
    $findUsername = "SELECT user_name FROM users WHERE  reference LIKE '%$cutRefernce%' ";
  $nameFound= mysqli_query($connection, $findUsername);
  
  $arr=mysqli_fetch_array($nameFound);
   echo $arr['user_name'];
   $foundedUser=$arr['user_name'];
  
   if($foundedUser){
      $leadUser=$foundedUser;
   }else{
        $leadUser="$agent_name2";
   }
   //end of get usernae by matching reference
   $insertQuery = "INSERT into leads (lead_user,contact_no,reference,client_name,email,subject,lead_source,mail_id) values('$leadUser','$contact_no','$refrence','$owner_name','$owner_email','$subject','dubizzle',$mailId)";
         // print_r($insertQuery);
 $fireSelectQuery = mysqli_query($connection,$insertQuery);
}//end else

//end loop
    }
}

 ?>