<?php

use App\Router;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require '../vendor/autoload.php';
define('DEBUG_TIME', microtime(true));

$whoops = new Run();
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$router = new Router(dirname(__DIR__) . '/views');

$router
      ->get('/', 'post/index', 'Home')
      ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post' )
      ->get('/blog/category', 'category/show', 'category')
      ->run();
