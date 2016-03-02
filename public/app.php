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
          if($file->isLink() === false and $file->getFilename() !== 'current') {
            $list[] =  [
              'path' => $file->getRealPath(),
              'name' => $file->getFilename(),
              'date' => date('H:i:s d/m/Y', $file->getMTime()),
              'content' => json_decode($file->open()->readAll(), true)
            ];
          }
      }

      echo json_encode($list);


    })
    ->post('u', '/api/', function () {
      $dir = __DIR__.'/../data';

      $p = function ($key) {
        return (isset($_POST[$key])) ? $_POST[$key] : null;
      };

      $format = function ($name) {
          $name = str_replace([' ', '_'] , '-', $name);
          $ext = strpos($name, '.json')+5;

          if(strlen($name) !== $ext) {
            $name .= '.json';
          }


        return $name;
      };

      $uri = $p('uri');
      $name = $format($p('name'));
      $titre = $p('titre');
      $class = $p('class');
      $duration = $p('duration');
      $object = '{}';
      $change = false;

      if($uri === '') {
        $file = new Hoa\File\ReadWrite($dir.DIRECTORY_SEPARATOR.$name);
      }
      // Regarde si le titre a changé
      if($uri !== '' && $uri !== realpath($dir.DIRECTORY_SEPARATOR.$name)) {
        $path = $dir.'/'.$name;
        $file = new Hoa\File\ReadWrite($path);
        $change = true;
      } else if(file_exists($uri))  {
        $file = new Hoa\File\ReadWrite($uri);
        $object = $file->readAll();
      }

      // Mise a jour de l'objet
      $object = json_decode($object);
      $object->name = $name;
      $object->titre = $titre;
      $object->class = $class;
      $object->duration = $duration;


      $file->truncate(0);
      $file->writeAll(json_encode($object));

      if($change === true)  {
        unlink($uri);
      }
    })
    ->post('define_current', '/api/define', function () {

      $uri = (isset($_POST['uri'])) ? $_POST['uri'] : null;

      if($uri === null){
        throw new Exception("URI not found", 1);
      }

      if(file_exists($uri) === true) {

          $target = realpath(__DIR__.'/../data/').'/current';
          if(is_file($target)) {
            unlink($target);
          }
          if(preg_match("#win#i", PHP_OS) > 0) {
            copy($uri, $target);
          }
          else {
            symlink($uri, $target);
          }
      }
      else {
        throw new Exception("Error 404", 1);
      }

        $client   = new Hoa\Websocket\Client(
            new Hoa\Socket\Client('tcp://127.0.0.1:8889')
        );
        $client->setHost('localhost');
        $client->connect();

        $current = realpath(__DIR__.'/../data/').'/current';
        if(is_file($current) === false) {
              $json = json_encode([
                'path' => '',
                'name' => '',
                'date' => '',
                'content' => ['name' => '','titre' => '','class' => '','duration' => '']
              ]);

              $client->send($json);
      }
      else  {
        $current = new Hoa\File\SplFileInfo($current);
        $json = json_encode([
              'path' => $current->getRealPath(),
              'name' => $current->getFilename(),
              'date' => $current->getMTime(),
              'content' => json_decode($current->open()->readAll(), true)
            ]);

        $client->send($json);
      }

      $client->close();
})
    ->get('api_current', '/api/current', function () {
        $current = __DIR__.'/../data/current';

        if(is_file($current) === false) {
          echo json_encode([
                'path' => '',
                'name' => '',
                'date' => '',
                'content' => ['name' => '','titre' => '','class' => 'geekinc','duration' => '']
              ]);

            return;
        }
        $current = new Hoa\File\SplFileInfo($current);


      echo json_encode([
            'path' => $current->getRealPath(),
            'name' => $current->getFilename(),
            'date' => $current->getMTime(),
            'content' => json_decode($current->open()->readAll(), true)
          ]);


    })
    ->post('d', '/api/delete', function () {
        $uri = (isset($_POST['uri'])) ? $_POST['uri'] : null;

        unlink($uri);
    })
    ->get('t', '/titre', function () use($templates) {

        $current = new Hoa\File\Read(__DIR__.'/../data/current');
        $json = json_decode($current->readAll());

        echo $templates->render('titre',
        [
          'titre' => $json->titre,
          'class' => $json->class,
          'duration' => $json->duration
        ]
      );
    });

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
