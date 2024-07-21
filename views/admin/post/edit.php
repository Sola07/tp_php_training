<?php

use App\Auth;
use App\Connection;
use App\HelpObject;
use App\HTML\Form;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\Validators\PostValidator;

Auth::check();


$id = $params['id'];
$pdo = Connection::getPDO();
$table = new PostTable($pdo);
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$item = $table->find($id);
$categoryTable->hydratePosts([$item]);
$success = false;

$errors = [] ;
if (!empty($_POST)) {
  $v = new PostValidator($_POST, $table, $item->getID(), $categories);
  if ($v->validate()) {
    HelpObject::hydrate($item, $_POST, ['name', 'content', 'slug', 'created_at']);
    $pdo->beginTransaction();
    $table->updatePost($item);
    $table->attachCategories($item->getID(), $_POST['categories_ids']);
    $pdo->commit();
    $categoryTable->hydratePosts([$item]);

    $success = true;
  } else {
    $errors = $v->errors();
  }
}
$form = new Form($item, $errors);
?>

<?php if ($success): ?>
  <div class="alert alert-success">
    Votre enregistrement a bien été modifié!
  </div>
<?php endif ?>

<?php if (isset($_GET['created']) && $success === false): ?>
  <div class="alert alert-success">
    Votre enregistrement a bien été créé!
  </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    L'article n'a pas pu être modifié. Veuillez corriger vos erreurs.
  </div>
<?php endif ?>


<h1 class="text-center mb-4 text-secondary">Editer l'article #<?= e($item->getName()) ?></h1>
<?php require('_form.php') ?>
