<?php
class InbucketMailbox {
  private $name;

  public function __construct($name) {
    $this->name = $name;
  }

  public function __get($property) {
    switch($property) {
      case "name":
        return $this->$property;
      default:
        throw new Exception("Property does not exist or is not public");
    }
  }

  public function get($host='localhost', $proto='http', $path='/api/v1/mailbox/') {
    $url = $proto.'://'.$host.$path.$this->name;
    $c = curl_init($url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_HEADER, false);
    curl_setopt($c, CURLOPT_FAILONERROR, true);
    $result = curl_exec($c);
    if($result === false) {
      throw new Exception("Failed to get data from inbucket api. curl error: ".curl_error($c));
    }
    $mailbox = json_decode($result);
    return $mailbox;
  }

  public function get_messages($subject=null) {
    $messages = [];
    $mailbox = $this->get();
    foreach($mailbox as $m) {
      if(!is_null($subject) && $m->subject == $subject) {
        $messages[] = new InbucketMessage($this, $m->id, $m->from, $m->subject, $m->date, $m->size);
      }
    }
    return $messages;
  }
}
