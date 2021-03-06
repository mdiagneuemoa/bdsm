<?php
////////////////////////////////////////////////////
// PHPMailer - PHP email class
//
// Class for sending email using either
// sendmail, PHP mail(), or SMTP.  Methods are
// based upon the standard AspEmail(tm) classes.
//
// Copyright (C) 2001 - 2003  Brent R. Matzelle
//
// License: LGPL, see LICENSE
////////////////////////////////////////////////////

/**
 * PHPMailer - PHP email transport class
 * @package PHPMailer
 * @author Brent R. Matzelle
 * @copyright 2001 - 2003 Brent R. Matzelle
 */


//file modified by richie


require("class.smtp.php");
require("class.phpmailer.php");

function sendmail($to=array(),$from,$subject,$contents,$mail_server,$mail_server_username,$mail_server_password,$filename,$smtp_auth='',$tocc=array())
{
  $mail = new PHPMailer();
  $mail->Subject = $subject;
	$mail->Body    = $contents;//"This is the HTML message body <b>in bold!</b>";

	$initialfrom = $from;

	$mail->IsSMTP();                                      // set mailer to use SMTP
	//$mail->Host = "smtp1.example.com;smtp2.example.com";  // specify main and backup server
	$mail->Host = $mail_server;  // specify main and backup server
	if($smtp_auth == 'true')
		$mail->SMTPAuth = true;
	else
		$mail->SMTPAuth = false;
	$mail->Username = $mail_server_username ;//$smtp_username;  // SMTP username
	$mail->Password = $mail_server_password ;//$smtp_password; // SMTP password
	$mail->From = $from;
	$mail->FromName = $initialfrom;
	               // name is optional
	foreach($to as $to_value)
	{
		$mail->AddAddress($to_value);   
	}
	foreach($tocc as $cc_value)
	{
		$mail->AddCC($cc_value);
	}
	$mail->AddReplyTo($from);
	$mail->WordWrap = 50;                                 // set word wrap to 50 characters
	$mail->IsHTML(true);                                  // set email format to HTML
	// MNGDIOUF ADDING ATTACHMENT
	if($filename != "")
		$mail->AddAttachment($filename);                                

	$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

	if(!$mail->Send()) 
	{
	   echo "Message could not be sent. <p>";
	   echo "Mailer Error: " . $mail->ErrorInfo;
	   exit;
	}

}
?>
