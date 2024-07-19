<?php
use App\Auth;
use App\Connection;
use App\Table\CategoryTable;

Auth::check();

$id = (int)$params['id'];
$pdo = Connection::getPDO();
$table = new CategoryTable($pdo);
$table->delete($id);
header('Location: ' . $router->url('admin_categories') . '?delete=1');
