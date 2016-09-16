<?php
class EmailTest extends PHPUnit\Framework\TestCase {
	public function testPlainText() {
		$subject = 'Plaintext email test '.time().'+'.rand(1000000,9999999);
		$mail = new Email;
		$mail->setFrom('unittest@example.com', 'Unit Test');
		$mail->addAddress('unittest@example.com', 'Unit Test');
		$mail->Subject = $subject;
		$mail->Body = 'Bacon ipsum dolor amet esse short ribs t-bone fugiat do beef ribs minim id magna pancetta. Capicola lorem filet mignon exercitation pork belly dolore ullamco pariatur aute adipisicing magna jowl meatloaf officia tempor. Culpa ribeye shankle quis, flank ullamco lorem sausage tongue. Bresaola fugiat chicken qui voluptate beef ribs porchetta meatball ground round filet mignon.

Nön pork loin turkey cupim officia flank ex tongue laborum excepteur nisi boudin consectetur. Irure jerky sed, pariatur tail non ex turkey spare ribs pork ham hock. Leberkas aute officia ut filet mignon do andouille ea enim dolore incididunt corned beef. Nisi duis proident jowl pariatur filet mignon tempor eiusmod chicken kevin nostrud.';

		if(!$mail->send()) {
			throw new Exception('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
		}

		$mailbox = new InbucketMailbox("unittest");
		$messages = $mailbox->get_messages($subject);
		$this->assertEquals(1, count($messages));
		$msg = $messages[0];
		$this->assertNotEmpty($msg->id);
		// phpmailer will replace \n with \r\n and add trailing linebreaks to ensure MIME compatibility
		$this->assertEquals(str_replace("\n", "\r\n", $mail->Body), rtrim($msg->body->text));
	}

	public function testHTML() {
		$subject = 'HTML email test '.time().'+'.rand(1000000,9999999);

		$mail = new Email;
		$mail->setFrom('unittest@example.com', 'Unit Test');
		$mail->addAddress('unittest@example.com', 'Unit Test');
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
		}

		$mailbox = new InbucketMailbox("unittest");
		$messages = $mailbox->get_messages($subject);
		$this->assertEquals(1, count($messages));
		$msg = $messages[0];
		$this->assertNotEmpty($msg->id);
		// phpmailer will replace \n with \r\n and add trailing linebreaks to ensure MIME compatibility
		$this->assertEquals(str_replace("\n", "\r\n", $mail->AltBody), rtrim($msg->body->text));
		$this->assertEquals(str_replace("\n", "\r\n", $mail->Body), rtrim($msg->body->html));
	}

	public function testNoAddress() {
		$this->expectException(phpmailerException::class);
		$this->expectExceptionMessage('You must provide at least one recipient email address.');
		$subject = 'Plaintext email test '.time().'+'.rand(1000000,9999999);
		$mail = new Email;
		$mail->setFrom('unittest@example.com', 'Unit Test');
		$mail->Subject = $subject;
		$mail->Body = 'Bäcon ipsum dolor amet';
		if(!$mail->send()) {
			throw new Exception('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
		}
	}

	public function testNoBody() {
		$this->expectException(phpmailerException::class);
		$this->expectExceptionMessage('Message body empty');
		$subject = 'Plaintext email test '.time().'+'.rand(1000000,9999999);
		$mail = new Email;
		$mail->setFrom('unittest@example.com', 'Unit Test');
		$mail->addAddress('unittest@example.com', 'Unit Test');
		$mail->Subject = $subject;
		if(!$mail->send()) {
			throw new Exception('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
		}
	}
}
