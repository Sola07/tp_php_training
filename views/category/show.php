<?php

use App\Connection;
use App\Model\Category;
use App\Model\Post;
use App\PaginatedQuery;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();
$query = $pdo->prepare('SELECT * from category WHERE id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category|false */
$category =  $query->fetch();
if ($category === false) {
  throw new Exception("Aucune catégorie de correspond à l'id '$id'");
}
if ($category->getSlug() !== $slug) {
  $url = $router->url('post', ['slug' => $category->getSlug(), 'id' => $id]);
  http_response_code(301);
  header('Location: ' . $url);
}
$title =  "Mes catégories : {$category->getName()}";

// Pagination
$paginatedQuery = new PaginatedQuery(
  "SELECT p.*
    FROM post p
    JOIN post_category pc ON pc.post_id = p.id
    WHERE pc.category_id = {$category->getID()}
    ORDER BY created_at DESC",
  "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$category->getID()}",
  );

// Get posts
/** @var Post[]  */
$posts = $paginatedQuery->getItems(Post::class);
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
