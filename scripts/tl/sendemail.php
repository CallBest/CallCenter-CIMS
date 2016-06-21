<?php
require_once('../../includes/class.phpmailer.php');
include("../../includes/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$host = $_POST['host'];
$port = $_POST['port'];
$user = $_POST['user'];
$pass = $_POST['pass'];
$name = $_POST['name'];
$reci = $_POST['reci'];
$subj = $_POST['subj'];
$body = $_POST['body'];
$attach = $_POST['attach'];

//send email with attachment
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

try {
  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
  $mail->Host       = $host;      // sets GMAIL as the SMTP server
  //$mail->Port       = $port;                   // set the SMTP port for the GMAIL server
  $mail->Username   = $user;  // GMAIL username
  $mail->Password   = $pass;            // GMAIL password
  //$mail->AddReplyTo('name@yourdomain.com', 'First Last');
  $mail->AddAddress("$reci", "$reci");
  $mail->SetFrom("$user", "$name");
  //$mail->AddReplyTo('name@yourdomain.com', 'First Last');
  $mail->Subject = "$subj";
  $mail->AltBody = "To view the message, please use an HTML compatible email viewer."; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML('<font size=4><pre>'.$body.'</pre></font>');
  if ($attach!=''){
    $mail->AddAttachment("$attach");      // attachment
  }
  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  echo "Message Sent!\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
    
?>