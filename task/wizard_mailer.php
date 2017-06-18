	<?php
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1'); 

	if($_POST['email'] && sendEmailSMTP()){
		header('Location: http://yachtgraphx.com/mail_sent');
	 }
	else{
	  echo "Error in Email sending";
	}


	function sendEmailSMTP(){

		   require_once 'mailer/PHPMailerAutoload.php';

			$mail = new PHPMailer();

			$mail->IsMail();                           // telling the class to use SMTP
			//$mail->SMTPDebug  = 3;                     // enables SMTP debug information (for testing)     
													// 1 = errors and messages
													   // 2 = messages only
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->SMTPSecure = "ssl";                 // sets the prefix to the server
			$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
			$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
			$mail->Username   = "yachtgraphx@gmail.com";   // GMAIL username
			$mail->Password   = "ygpass305";            // GMAIL password

			$mail->AddReplyTo($_POST['email']);
			$mail->SetFrom('yachtgraphx@gmail.com', 'Yachtgraphx');     
			$mail->AddAddress("admin@sisfy.com");
			$mail->AddCC("rajan.bhola@sisfy.com");
		   // $mail->AddCC("mike@isatisfy.com");
			
			$mail->Subject    = "Yacht GraphX: Thank you for your inquiry";
			$message = " Thank you ".  $_POST['name']. " ". $_POST['lname'].",  <br/><br/>

We appreciate your interest in our products and we will be in contact with you shortly. <br/><br/>

The following is the information which we received from you: <br/><br/><br/>";
			
			if ($_POST['sales_force_sent'] && $_POST['sales_force_sent'] == "NO"){
			  $message .= "Data sent to SalesForce: NO (error code = ". $_POST['sales_force_error'].")\n\n";
			}
			
			$message .= "Name: ". $_POST['name']. " ". $_POST['lname']."<br/>"
			."Email: ". $_POST['email']."<br/>"        
			."Phone: ". $_POST['phone']."<br/>"        
			."Yacht name: ". $_POST['yacht_name']."<br/>"
			."Font: ". $_POST['font']."<br/>"
			."Color: ". $_POST['color']."<br/>"
			."Backlight: ". $_POST['backlight']."<br/>"
			."Size: ". $_POST['width']. ' in x '.$_POST['height'].' in'."<br/>"
			."Vessel manufacturer: ". $_POST['manufacturer']."<br/>"        
			."Model: ". $_POST['model']."<br/>"         
			."Length of vessel: ". $_POST['length']."<br/>"
			."Shipping address: ". $_POST['address']."<br/>"            
			."Hailing port name: ". $_POST['port_name']."<br/>"        
			."Positioning: ". join(', ',array_keys($_POST['positioning'] ? $_POST['positioning'] : array()))."<br/>"
			."How did you hear about us: ".$_POST['hear']."<br/>";
			$mail->isHTML(true);
			$mail->Body = $message;
			
		     $data = chunk_split(str_replace('data:image/png;base64,','',$_POST['canvas_day'])); 
			$mail->AddStringAttachment(base64_decode($data),"letters_day.png","base64","image/png");
			
			
			$files = array($_FILES['photo1'], $_FILES['photo2'], $_FILES['photo3'], $_FILES['photo4'], $_FILES['photo5']);        
			
			for($x = 0; $x <count($files); $x++){

				$tmpName = $files[$x]['tmp_name']; 
				$fileType = $files[$x]['type']; 
				$fileName = $files[$x]['name']; 


				if ($tmpName) { 
					$mail->AddAttachment($tmpName, $fileName);
				}   
			} 
			
		
		
		/*  // SALES FORCE
        $url = 'https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8';
        $params = array(
            'oid'=> "00D70000000N1ai",
            'retURL'=> "http://yachtgraphx.com",
            '00N70000003eI0n'=> "Yacht Graphx",
            'email'=> $_POST['email'],
            'phone'=> $_POST['phone'],
            'first_name'=> $_POST['name'],
            'last_name'=> $_POST['lname'],
            'lead_source'=> $_POST['hear']            
        );
        $result = file_get_contents($url, false, stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($params)
            )
        )));
		 */
		 $mail2 = clone $mail;
		// $mail->send();
		$mail2->ClearCCs();
		$mail2->ClearAddresses();

		
		$mail2->AddAddress($_POST['email']);
		$msg = " Thank you ".  $_POST['name']. " ". $_POST['lname'].",  <br/><br/>

We appreciate your interest in our products and we will be in contact with you shortly. <br/><br/>

The following is the information which we received from you: <br/><br/><br/>";
		$msg .= "Name: ". $_POST['name']. " ". $_POST['lname']."<br/>"
			."Email: ". $_POST['email']."<br/>"        
			."Phone: ". $_POST['phone']."<br/>"        
			."Product Interest: Yacht GraphX <br>"
			."Boat Type: <br>"
			."Notes:<br>";
			
			$mail->isHTML(true);
		$mail2->Body = $msg;
		$mail2->ClearAttachments();
		if(!$mail2->Send()) {
			echo "Mailer Error: " . $mail2->ErrorInfo;
			} else {
			echo "Message sent!<br>";
				}	
			if(!$mail->send()) { 
				echo "Mailer Error: " . $mail->ErrorInfo;
				return false;
			} else {                                                                                                                                                                                                    
			  return true;
		   }
		
		   
				  
	}
	?>

