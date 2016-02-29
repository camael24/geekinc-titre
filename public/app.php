<?php
// run php -S 127.0.0.1:8080 -t public public\app.php
header('Access-Control-Allow-Origin: *');

if ('OPTIONS' === $_SERVER['REQUEST_METHOD'] && isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
    die;
}

/**
 * PHP Settings
 */
date_default_timezone_set('Europe/Paris');

/**
 * Autoloader Composer
 */
require_once dirname( __DIR__ )
    . DIRECTORY_SEPARATOR . 'vendor'
    . DIRECTORY_SEPARATOR . 'autoload.php';

/** ******************************************************************************************************* **/

use  \Hoa\Dispatcher;

$templates = new League\Plates\Engine(__DIR__.'/../views');
$router = new Hoa\Router\Http\Http();
$router
    ->get('css', '/home.css', function () {
        echo file_get_contents(__DIR__.'/home.css');
    })
    ->get('m', '/', function () use($templates){
        echo $templates->render('home');
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
