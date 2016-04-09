<?php
class Email extends PHPMailer {
  public function __construct() {
    parent::__construct();
    $this->isSMTP();
    $this->CharSet = 'utf-8';
  }
}
