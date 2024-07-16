<?php

use App\Connection;
use App\Table\CategoryTable;
use App\Table\PostTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();
$category = (new CategoryTable($pdo))->find($id);

if ($category->getSlug() !== $slug) {
  $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
  http_response_code(301);
  header('Location: ' . $url);
}
$title =  "Mes catégories : {$category->getName()}";
[$posts, $paginatedQuery] = (new PostTable($pdo))->findPaginatedForCategory($category->getID());

$link = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
?>

<h1 class="mb-4 text-secondary text-center">Catégorie <?= e($category->getName()) ?></h1>

<div class="row">
  <?php foreach ($posts as $post):?>
     <?php require dirname(__DIR__) . '/post/card.php' ?>
  <?php endforeach ?>
</div>

<!-- Liens -->

<div class="d-flex justify-content-between my-4">
  <?= $paginatedQuery->previousLink($link) ?>
  <?=  $paginatedQuery->nextLink($link)?>
</div>
