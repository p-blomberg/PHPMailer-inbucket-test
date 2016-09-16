<?php
class InbucketMessage {
  private $mailbox, $id, $from, $subject, $date, $size, $body, $header;

  public function __construct($mailbox, $id, $from, $subject, $date, $size) {
    $this->mailbox = $mailbox;
    $this->id      = $id;
    $this->from    = $from;
    $this->subject = $subject;
    $this->date    = $date;
    $this->size    = $size;
  }

  protected function get_body($host='localhost', $proto='http', $path='/api/v1/mailbox/') {
    $url = $proto.'://'.$host.$path.$this->mailbox->name.'/'.$this->id;
    $c = curl_init($url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_HEADER, false);
    curl_setopt($c, CURLOPT_FAILONERROR, true);
    $result = curl_exec($c);
    if($result === false) {
      throw new Exception("Failed to get data from inbucket api. curl error: ".curl_error($c));
    }
    $message = json_decode($result);
    $this->body = $message->body;
    $this->header = $message->header;
  }

  public function __get($property) {
    switch($property) {
      case "mailbox":
      case "id":
      case "from":
      case "subject":
      case "date":
      case "size":
        return $this->$property;
      case "body":
      case "header":
        if(!isset($this->$property)) {
          $this->get_body();
        }
        return $this->$property;
      default:
        throw new Exception("Property does not exist or is not public");
    }
  }
}
