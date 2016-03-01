<?php

  require_once __DIR__.'/../vendor/autoload.php';

$websocket = new Hoa\Websocket\Server(
    new Hoa\Socket\Server('tcp://geek.ark.im:8889')
);
$websocket->on('open', function (Hoa\Event\Bucket $bucket) {
    echo 'new connection', "\n";

    return;
});
$websocket->on('message', function (Hoa\Event\Bucket $bucket) {
    $data = $bucket->getData();

    $bucket->getSource()->broadcast($data['message']);
    return;
});
$websocket->on('close', function (Hoa\Event\Bucket $bucket) {
    echo 'connection closed', "\n";

    return;
});



//$group[] = $websocket;
//$group[] = $watcher;
$websocket->run();

 ?>
