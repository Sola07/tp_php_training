<?php

use App\Router;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require '../vendor/autoload.php';
// Debug
define('DEBUG_TIME', microtime(true));
$whoops = new Run();
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

// Router
if (isset($_GET['page']) && $_GET['page'] === "1")
 {
  $uri = explode("?", $_SERVER['REQUEST_URI'])[0];
  $get = $_GET;
  unset($get['page']);
  $query = http_build_query($get);
  if (!empty($query)) {
    $uri = $uri . '?' . $query;
  }
  header('Location: ' . $uri);
  http_response_code(301);
  exit();
 }

$router = new Router(dirname(__DIR__) . '/views');
$router
      ->get('/', 'post/index', 'home')
      ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post' )
      ->get('/blog/category', 'category/show', 'category')
      ->run();
