<?php

use App\Auth;
use App\Connection;
use App\HelpObject;
use App\HTML\Form;
use App\Model\Category;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;

Auth::check();

$errors = [];
$item = new Category;
if (!empty($_POST)) {
  $pdo = Connection::getPDO();
  $categoryTable = new CategoryTable($pdo);
  $v = new CategoryValidator($_POST, $categoryTable, $item->getID());

  if ($v->validate()) {

    HelpObject::hydrate($item, $_POST, ['name', 'slug']);
    $id = $categoryTable->create([
      'name' => $item->getName(),
      'slug' => $item->getSlug()
    ]);
    $item->setId($id);
    header('Location: ' . $router->url('admin_category_edit', ['id' => $item->getID()]) . '?created=1');

    exit();
  } else {
    $errors = $v->errors();
  }
}
$form = new Form($item, $errors);
?>


<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    L'article n'a pas pu être enregistré. Veuillez corriger vos erreurs.
  </div>
<?php endif ?>


<h1 class="text-center mb-4 text-secondary">Créer une nouvelle catégorie</h1>
<?php require('_form.php') ?>
