<?php
require dirname(__DIR__)."/includes.php";

// Compose the email
$mail = new Email;
$mail->setFrom('herpaderpa@example.com', 'HerpaDerpa, inc.');
$mail->addAddress('derp@example.com', 'Derpa Derpa');
$mail->Subject = 'The Herp häs been derped';
$mail->Body = 'Bäcon ipsum dolor amet esse short ribs t-bone fugiat do beef ribs minim id magna pancetta. Capicola lorem filet mignon exercitation pork belly dolore ullamco pariatur aute adipisicing magna jowl meatloaf officia tempor. Culpa ribeye shankle quis, flank ullamco lorem sausage tongue. Bresaola fugiat chicken qui voluptate beef ribs porchetta meatball ground round filet mignon.

Non pork loin turkey cupim officia flank ex tongue laborum excepteur nisi boudin consectetur. Irure jerky sed, pariatur tail non ex turkey spare ribs pork ham hock. Leberkas aute officia ut filet mignon do andouille ea enim dolore incididunt corned beef. Nisi duis proident jowl pariatur filet mignon tempor eiusmod chicken kevin nostrud.';

// Send the email
if(!$mail->send()) {
  throw new Exception('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
} else {
  echo "Message has been sent to:\n";
	foreach($mail->getToAddresses() as $a) {
		echo $a[0]."\n";
	}
}
