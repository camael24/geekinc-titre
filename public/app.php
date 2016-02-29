<?php
date_default_timezone_set('Europe/Paris');

use  \Hoa\Dispatcher;

$templates = new League\Plates\Engine(__DIR__.'/../views');
$router = new Hoa\Router\Http\Http();
$router
    ->get('m', '/', function () use($templates){
        echo $templates->render('admin/titre');
    })

    ->get('api_list', '/api/titres', function () {
        $directory = new Hoa\File\Finder();

        $directory->in(__DIR__.'/../data');

        $list = [];


        foreach ($directory as $file) {
          if($file->isLink() === false) {
            $list[] =  [
              'path' => $file->getRealPath(),
              'name' => $file->getFilename(),
              'date' => $file->getMTime(),
              'content' => json_decode($file->open()->readAll(), true)
            ];
          }
      }

      echo json_encode($list);


    })

    ->get('api_current', '/api/current', function () {
        $current = __DIR__.'/../data/current';
        $current = new Hoa\File\SplFileInfo($current);


      echo json_encode([
            'path' => $current->getRealPath(),
            'name' => $current->getFilename(),
            'date' => $current->getMTime(),
            'content' => json_decode($current->open()->readAll(), true)
          ]);


    })

    ->get('t', '/titre', function () use($templates) {

        $current = new Hoa\File\Read(__DIR__.'/../data/current');
        $json = json_decode($current->readAll());

        echo $templates->render('titre',
        [
          'titre' => $json->titre,
          'bcolor' => $json->bcolor,
          'color' => $json->color,
          'width' => $json->width
        ]
      );
    })
    ;
$dispatcher = new Hoa\Dispatcher\Basic();

try {
    $dispatcher->dispatch($router);
} catch (Hoa\Router\Exception\NotFound $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo json_encode(['errors' => ['code' => 404, 'title' => 'Resource not found']]);
} catch (\Exception $e) {
    throw $e;
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Not Found');
    echo json_encode(['errors' => ['code' => 500, 'title' => 'Internal server error']]);
}
