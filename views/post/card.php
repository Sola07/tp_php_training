<?php
$categories = array_map(function ($category) use ($router){
  $url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
  return <<<HTML
    <a href="{$url}">{$category->getName()}</a>
HTML;
}, $post->getCategories());

?>


<div class="col-sm-6 mb-3">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
      <p class="text-muted">
        <?= $post->getCreatedAt()->format('d F Y') ?>
        <?php if (!empty($categories)): ?>
          ::
          <?= implode(',', $categories) ?>
        <?php endif ?>
      </p>
      <p class="card-text"><?= $post->getExcerpt() ?></p>
      <a href="<?= $router->url ('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>" class="btn btn-secondary">Voir plus</a>
    </div>
  </div>
</div>
