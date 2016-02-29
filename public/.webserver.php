<?php
/**
 * Autoloader Composer
 */
require_once dirname( __DIR__ )
    . DIRECTORY_SEPARATOR . 'vendor'
    . DIRECTORY_SEPARATOR . 'autoload.php';
$router = new Hoa\Router\Http();
$router
    ->any('a', '.*', function ( Hoa\Dispatcher\Kit $_this ) {
        $uri  = $_this->router->getURI();
        $file = __DIR__ . DS . $uri;

        if(!empty($uri) && true === file_exists($file)) {
            $stream = new Hoa\File\Read($file);
            try {
                $mime  = new Hoa\Mime($stream);
                $_mime = $mime->getMime();
            }
            catch ( \Hoa\Mime\Exception $e ) {
                $_mime = 'text/plain';
            }
            header('Content-Type: ' . $_mime);
            echo $stream->readAll();
            return;
        }
        require 'app.php';
    });
$dispatcher = new Hoa\Dispatcher\Basic();
$dispatcher->dispatch($router);
