<?php

namespace App\Table;

use App\Model\Post;
use App\PaginatedQuery;
use App\Table\Exception\NotFoundException;
use Exception;
use PDO;

final class PostTable extends Table {

  protected $table = "post";
  protected $class = Post::class;


    public function updatePost (Post $post):void
    {
      $this->update([
        'id' => $post->getID(),
        'name' => $post->getName(),
        'slug' => $post->getSlug(),
        'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
        'content' => $post->getContent()
      ], $post->getID());
    }

    public function createPost (Post $post): void
    {
      $id = $this->create([
        'name' => $post->getName(),
        'slug' => $post->getSlug(),
        'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
        'content' => $post->getContent()
      ]);
      $post->setID($id);

    }

    public function findPaginated (): array
    {
      $paginatedQuery = new PaginatedQuery(
        "SELECT *
          FROM post
          ORDER BY created_at DESC",
        "SELECT COUNT(id) FROM {$this->table}",
        $this->pdo
        );
      $posts = $paginatedQuery->getItems(Post::class);
      (new CategoryTable($this->pdo))->hydratePosts($posts);
      return [$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory(int $categoryID): array
    {
      $paginatedQuery = new PaginatedQuery(
        "SELECT p.*
          FROM {$this->table} p
          JOIN post_category pc ON pc.post_id = p.id
          WHERE pc.category_id = {$categoryID}
          ORDER BY created_at DESC",
        "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$categoryID}",
        );

      $posts = $paginatedQuery->getItems(Post::class);
      (new CategoryTable($this->pdo))->hydratePosts($posts);
      return [$posts, $paginatedQuery];
    }
}
