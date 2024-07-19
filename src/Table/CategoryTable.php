<?php

namespace App\Table;

use App\Model\Category;
use App\PaginatedQuery;
use App\Table\Exception\NotFoundException;
use Exception;
use PDO;

final class CategoryTable extends Table {

  protected $table = 'category';
  protected $class = Category::class;


  public function find(int $id) : ?Category
  {
    $query = $this->pdo->prepare('SELECT * from category WHERE id = :id');
    $query->execute(['id' => $id]);
    $query->setFetchMode(PDO::FETCH_CLASS, Category::class);
    $category =  $query->fetch();
    if ($category === false) {
      throw new NotFoundException('category', $id);
    }

    return $category;
  }
  /**
   * @param App\Model\Post[] $posts
   */

  public function hydratePosts(array $posts): void
  {
    $postsByID = [];
      foreach ($posts as $post) {
        $postsByID[$post->getID()] = $post;
      }
      $categories = $this->pdo
          ->query('SELECT c.*, pc.post_id
                   FROM post_category pc
                   JOIN category c ON c.id = pc.category_id
                   WHERE pc.post_id IN (' . implode(",", array_keys($postsByID)) . ')'
          )->fetchAll(PDO::FETCH_CLASS, Category::class);

      foreach ($categories as $categorie) {
        $postsByID[$categorie->getPostID()]->addCategorie($categorie);
      }
  }

  public function findPaginated (): array
  {
    $paginatedQuery = new PaginatedQuery(
      "SELECT *
        FROM category
        ORDER BY id DESC",
      "SELECT COUNT(id) FROM {$this->table}",
      $this->pdo
      );
    $categories = $paginatedQuery->getItems(Category::class);
    return [$categories, $paginatedQuery];
  }


}
