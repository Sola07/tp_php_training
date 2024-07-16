<?php

use App\Connection;
use App\Table\PostTable;

$title = 'Mon blog';
$pdo = Connection::getPDO();

$table = new PostTable($pdo);
[$posts, $pagination] = $table->findPaginated();

$link = $router->url('home');

?>

<h1 class="text-center mb-4 text-secondary">Articles</h1>

<div class="row">
  <?php foreach ($posts as $post):?>
     <?php require 'card.php' ?>
  <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
  <?= $pagination->previousLink($link) ?>
  <?=  $pagination->nextLink($link)?>
</div>
