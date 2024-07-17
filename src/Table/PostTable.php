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

    public function delete(int $id): void {
      $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
      $ok = $query->execute([$id]);
      if ($ok === false) {
        throw new Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
      }
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
