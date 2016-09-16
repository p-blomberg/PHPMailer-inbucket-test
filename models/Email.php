<?php
class Email extends PHPMailer {
	// exceptions is NULL by default in PHPMailer, we want them!
  public function __construct($exceptions = true) {
    parent::__construct($exceptions);
    $this->isSMTP();
    $this->CharSet = 'utf-8';
  }
}
