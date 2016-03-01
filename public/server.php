<?php

  require_once __DIR__.'/../vendor/autoload.php';


  $server = new Hoa\Eventsource\Server();

  while (true) {
      // “tick” is the event name.
      $server->tick->send(time());
      sleep(1);
  }


 ?>
