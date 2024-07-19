<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;

Auth::check();


$title = 'Administration';
$pdo = Connection::getPDO();

$link = $router->url('admin_categories');
[$categories, $pagination] = (new CategoryTable($pdo))->findPaginated();
?>
<?php if (isset($_GET['delete'])):  ?>
  <div class="alert alert-success">
    Votre article a bien été supprimé !
  </div>
<?php endif ?>

<a href="<?= $router->url('admin_category_new') ?>" class="btn btn-primary">Nouvelle catégorie</a>

<table class="table">
  <thead>

    <tr>
      <th scope="col">Id</th>
      <th scope="col">Categorie</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($categories as $category): ?>
    <tr>
      <th scope="row"><?= $category->getId()?></th>
      <td><a href="<?= $router->url ('admin_category_edit', ['id' => $category->getID()]) ?>" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"><?= e($category->getName())?></a></td>
      <td></td>
      <td class="d-flex justify-content-end" style="gap: 10px;">
        <a href="<?= $router->url ('admin_category_edit', ['id' => $category->getID()]) ?>" class="btn btn-outline-success">Modifier</a>
        <form action="<?= $router->url ('admin_category_delete', ['id' => $category->getID()]) ?>" method="POST" onsubmit="return confirm('Voulez-vous vraiment effectuer cette action?')">
          <button class="btn btn-outline-danger l-3">Supprimer</button>
        </form>
      </td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>
<div class="d-flex justify-content-between my-4">
  <?= $pagination->previousLink($link) ?>
  <?= $pagination->nextLink($link)?>
</div>
