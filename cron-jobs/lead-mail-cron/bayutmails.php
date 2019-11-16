<?php 
 $connection      = mysqli_connect('localhost','edenfort_crm','D[0zpHn1lEk4','edenfort_crm');

 print_r( $insertQuery);
include_once('lib/class.imap.php');

$email = new Imap();

$inbox = null;

if ($email->connect('{mail.edenfort.ae:143/notls}INBOX','info@edenfort.ae','K3X0Cy0v+0_e')) {
	// $subject = 'You just got a Dubizzle phone lead!';
	$subject = 'Bayut Rental Inquiry';
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
	 
      $Email_data=explode('--',$ignoreTags);
	 
	 //print_r($Email_data);
	 
	 $Agent=explode('Hi',$ignoreTags);
	 $Agent2=explode(' ',$Agent[1]);
	$Agent3=explode(',',$Agent2[1]);
	// print_r($Agent2);
	 if($Agent3[1]){
// 		 echo $Agent3[0],'<br>';
		$agent_name=$Agent3[0];
		 
		 }
		 else{
			 $Agent3=explode(',',$Agent2[2]);
			
			 //echo $Agent2[1],' ',$Agent3[0],'<br>';
		$agent_name=$Agent2[1].' '.$Agent3[0];
			 }

	   
	   $further=explode(' ',$Email_data[64]);
	   $g = array_search("Name:", $further);
	
	   $more=$further[$g+2];
	   
	     $a=explode('E',$more);
	
		 if($a[1]){
		    $email=explode('P',$further[$g+3]);
			$phone=explode('IP',$further[$g+4]);
// 			echo $a[0],$email[0],$phone[0];
     $owner_name=$a[0];
     $owner_email=$email[0];
     $owner_phone=$phone[0];
		 }else{
		
			 $name2=explode('E',$further[$g+3]);
			 $email2=explode('IP',$further[$g+5]);
			 $phone2=explode('P',$further[$g+4]);
			 //echo $further[$g+2],' ',$name2[0],$phone2[0],$email2[0];
			 $owner_name=$further[$g+2].' '.$name2[0];
			 $owner_phone=$phone2[0];
			 $owner_email=$email2[0];
			 }
	 
	 //email
//	 $findEmail=explode(' ',$Email_data[64]);
	  //print_r($further);
	   $findEmail = array_search("Name:", $further);

	//echo $further[$findEmail+2];
	$email1=explode('E',$further[$g+2]);
	 $email2=explode('E',$further[$g+3]);
	 $email3=explode('E',$further[$g+4]);
	if($email1[1]){
	     $finalEmail=explode('P',$further[$g+3]);
	     $finalPhone=explode('IP',$further[$g+4]);
	      $contact= $finalPhone[0];
	     $emailFinal= $finalEmail[0];
	}elseif($email2[1]){
	     $finalEmail=explode('P',$further[$g+4]);
	     $finalPhone=explode('IP',$further[$g+5]);
	     $contact= $finalPhone[0];
	     $emailFinal= $finalEmail[0];
	}elseif($email3[1]){
	     $finalEmail=explode('P',$further[$g+5]);
	     $finalPhone=explode('IP',$further[$g+6]);
	     $contact=$finalPhone[0];
	     $emailFinal= $finalEmail[0];
	}
	
   
    
	//end email  
	
		$ref=explode('Reference: ',$Email_data[96]);
		$ref2=explode('Bayut ID',$ref[1]);
		$reference= $ref2[0];
		
	//	echo "<br>Data:<br>";
		echo $agent_name.'<br>'.$owner_name.'<br>'.$contact.'<br>'.$emailFinal.'<br>'.$reference.'<br>'.$mailId;
		
		//insertion
		$exist = "SELECT * FROM leads WHERE mail_id='$mailId' ";
   $verified= mysqli_query($connection, $exist);
   
if(mysqli_num_rows( $verified) == 1){
    echo ' Record already exist';
}else{ 
 $insertQuery = "INSERT into leads (lead_user,contact_no,reference,client_name,email,subject,lead_source,mail_id) values('$agent_name','$contact','$reference','$owner_name','$emailFinal','$subject','Bayut',$mailId)";

      // print_r($insertQuery);
 $fireSelectQuery = mysqli_query($connection,$insertQuery);
}
   
   
    }
}

 ?>