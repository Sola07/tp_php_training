<?php

use App\Connection;
use App\Helpers\Text;
use App\Model\Category;
use App\Model\Post;
use App\PaginatedQuery;
use App\URL;

$title = 'Mon blog';
$pdo = Connection::getPDO();

// Pagination

$paginatedQuery = new PaginatedQuery(
  "SELECT *
    FROM post
    ORDER BY created_at DESC",
  "SELECT COUNT(id) FROM post",
  );
  /** @var Post[] */
$posts = $paginatedQuery->getItems(Post::class);
$postsByID = [];
foreach ($posts as $post) {
  $postsByID[$post->getID()] = $post;
}
$categories = $pdo
    ->query('SELECT c.*, pc.post_id
             FROM post_category pc
             JOIN category c ON c.id = pc.category_id
             WHERE pc.post_id IN (' . implode(",", array_keys($postsByID)) . ')'
    )->fetchAll(PDO::FETCH_CLASS, Category::class);

foreach ($categories as $categorie) {
  $postsByID[$categorie->getPostID()]->addCategorie($categorie);
}

$link = $router->url('home');

?>

<h1 class="text-center mb-4 text-secondary">Articles</h1>

<div class="row">
  <?php foreach ($posts as $post):?>
     <?php require 'card.php' ?>
  <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
  <?= $paginatedQuery->previousLink($link) ?>
  <?=  $paginatedQuery->nextLink($link)?>
</div>
