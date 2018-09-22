<?php
require("config/config.php");
if(isset($_POST['email']) && !empty($_POST['email'])){
	$email = $_POST['email'];
	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
	if(preg_match($regex, $email)){ 
		$subscription = new Subscription();
		$column = array();
		$where = " Where email ='".$email."'";
		$record = $subscription->select($column,$where);
		
		if(empty($record)){
			$data = array('email'=>$email,'createdAt'=>date("Y-m-d H:i:s"));
			$subscription->insert($data);
		}

				//define the receiver of the email
				$to = $email;
				//define the subject of the email
				$subject = 'Akam: News letter subscription ';
				//define the headers we want passed. Note that they are separated with \r\n
				$headers = "From: support@akam.in\r\nReply-To: support@akam.in";
				//define the body of the message.
				$message="";
				$message .= "Hi,\n\nThank you for subscribing to the India Akam monthly newsletter and welcome to the extravaganza as it unfolds.\n\nThis newsletter will keep you posted about";
				$message .="\n\nExciting new offers\nDesigns & Creations\nNews from India akam.in\nDesign suggestions from Krsna\n\n";
				$message .="Welcome once again to the flamboyant act\n\n";
				$message .="Regards,\n Team Akam";
				//send the email
				$mail_sent = @mail( $to, $subject, $message, $headers );
				if($mail_sent){
					echo "success";
				}else{
					echo "fail";
				}
	}else{
		echo "fail";
	}
}else{
	echo "fail";
}
?>