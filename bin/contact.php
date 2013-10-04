
<?php

	require( '../../../../wp-load.php' );


	//validando los campos
	if ((isset($_POST['name'])) && (strlen(trim($_POST['name'])) > 0)) {
		$name = stripslashes(strip_tags($_POST['name']));
	} else {$name = 'No name entered';}
	
	if ((isset($_POST['email'])) && (strlen(trim($_POST['email'])) > 0)) {
		$email = stripslashes(strip_tags($_POST['email']));
	} else {$email = 'No email entered';}

	if ((isset($_POST['phone'])) && (strlen(trim($_POST['phone'])) > 0)) {
		$phone = stripslashes(strip_tags($_POST['phone']));
	} else {$phone = 'No phone entered';}

	if ((isset($_POST['url'])) && (strlen(trim($_POST['url'])) > 0)) {
		$url = stripslashes(strip_tags($_POST['url']));
	} else {$url = 'No url entered';}
	
	if ((isset($_POST['comments'])) && (strlen(trim($_POST['comments'])) > 0)) {
		$comments = stripslashes(strip_tags($_POST['comments']));
	} else {$comments = 'No comments entered';}
	
	
	//generando el HTML
	ob_start();
		?>
<html>
<head>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; color: #000; font-size: 14px;">

<h2><?php bloginfo('name'); ?> Contact Form</h2>

<table width="750" border="0" cellspacing="2" cellpadding="6" style="font-family: Arial, Helvetica, sans-serif; color: #000; font-size: 14px;">
	<tr bgcolor="#eeffee">
		<td>Name</td>
		<td><?=$name;?></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><?=$email;?></td>
	</tr>
	<tr bgcolor="#eeffee">
		<td>Phone</td>
		<td><?=$phone;?></td>
	</tr>
	<tr>
		<td>URL</td>
		<td><?=$url;?></td>
	</tr>
	<tr bgcolor="#eeffee">
		<td>Comments</td>
		<td><?=$comments;?></td>
	</tr>
</table>
</body>
</html>
<?php
$admin_email = get_option('admin_email');
$body = ob_get_contents();
$to = 'someone@example.com';
$email = 'email@example.com';
$fromaddress = "you@example.com";
$fromname = "Online Contact";

require("class.phpmailer.php");

$mail = new PHPMailer();

$mail->From     = $admin_email;
$mail->FromName = "Contact Website Form";
$mail->AddAddress($admin_email,"Contact");

$mail->WordWrap = 50;
$mail->IsHTML(true);

$mail->Subject  =  "Contact Website Form";
$mail->Body     =  $body;
$mail->AltBody  =  "This is the text-only body";


if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  //header('location: ' . site_url('m/thank-you/'));
}

?>
