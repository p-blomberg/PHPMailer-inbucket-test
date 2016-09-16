<?php
require __DIR__."/includes.php";

$subject = 'HTML email test '.time().'+'.rand(1000000,9999999);

$mail = new Email;
$mail->setFrom('herpaderpa@example.com', 'HerpaDerpa, inc.');
$mail->addAddress('derp@example.com', 'Derpa Derpa');
$mail->Subject = $subject;
$mail->Body = <<<EOF
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>PHPMailer Test</title>
</head>
<body>
<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
  <h1>This is a test of PHPMailer.</h1>
  <div align="center">
    <a href="https://github.com/PHPMailer/PHPMailer/"><img src="images/phpmailer.png" height="90" width="340" alt="PHPMailer rocks"></a>
  </div>
  <p>This example uses <strong>HTML</strong>.</p>
  <p>Chinese text: 郵件內容為空</p>
  <p>Russian text: Пустое тело сообщения</p>
  <p>Armenian text: Հաղորդագրությունը դատարկ է</p>
  <p>Czech text: Prázdné tělo zprávy</p>
</div>
</body>
</html>
EOF;
$mail->AltBody = "This is the text part of a HTML email.
If you are reading this, it sucks to be you.
But please, enjoy some utf8 while you're at it: 😺 😍";

if(!$mail->send()) {
  throw new Exception('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
} else {
  echo "Message has been sent.\n";
}

$mailbox = new InbucketMailbox("derp");
$messages = $mailbox->get_messages($subject);
if(count($messages) == 0) {
	throw new Exception("Message doesn't seem to have arrived. :(");
}
if(count($messages) > 1) {
	throw new Exception("There seems to be more than one message sent the same second and with the same random number... This is strange.");
}
$msg = $messages[0];
echo "Message delivered. Inbucket ID: ".$msg->id."\n";
echo "Text part:\n";
echo $msg->body->text;
echo "HTML part:\n";
echo $msg->body->html;
