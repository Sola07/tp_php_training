<?php

use App\Auth;
use App\Connection;
use App\Table\PostTable;

Auth::check();

$id = (int)$params['id'];
$pdo = Connection::getPDO();
$table = new PostTable($pdo);
$table->delete($id);
header('Location: ' . $router->url('admin_posts') . '?delete=1');
?>
