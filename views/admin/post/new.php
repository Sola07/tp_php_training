<?php

use App\Auth;
use App\Connection;
use App\HelpObject;
use App\HTML\Form;
use App\Model\Post;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\Validators\PostValidator;

Auth::check();

$errors = [];
$item = new Post;
$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
if (!empty($_POST)) {
  $table = new PostTable($pdo);

  $v = new PostValidator($_POST, $table, $item->getID(), $categories);

  if ($v->validate()) {

    HelpObject::hydrate($item, $_POST, ['name', 'content', 'slug', 'created_at']);
    $pdo->beginTransaction();
    $table->createPost($item);
    $table->attachCategories($item->getID(), $_POST['categories_ids']);
    $pdo->commit();
    header('Location: ' . $router->url('admin_post', ['id' => $item->getID()]) . '?created=1');
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


<h1 class="text-center mb-4 text-secondary">Créer un article</h1>
<?php require('_form.php') ?>
