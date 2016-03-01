<?php

  require_once __DIR__.'/../vendor/autoload.php';

  $client   = new Hoa\Websocket\Client(
      new Hoa\Socket\Client('tcp://127.0.0.1:8889')
  );
  $client->setHost('localhost');
  $client->connect();




$watcher = new Hoa\File\Watcher();
$watcher->in(__DIR__.'/../data');



$watcher->on('modify' , function () use ($client){
    $current = __DIR__.'/../data/current';
    if(is_file($current) === false) {
          $json = json_encode([
            'path' => '',
            'name' => '',
            'date' => '',
            'content' => ['name' => '','titre' => '','bcolor' => '','color' => '','width' => '']
          ]);
          $client->send($json);
        return;
    }
    $current = new Hoa\File\SplFileInfo($current);
    $json = json_encode([
          'path' => $current->getRealPath(),
          'name' => $current->getFilename(),
          'date' => $current->getMTime(),
          'content' => json_decode($current->open()->readAll(), true)
        ]);

  $client->send($json);

});

$watcher->run();
$client->close();
 ?>
