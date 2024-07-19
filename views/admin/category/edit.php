<?php

use App\Auth;
use App\Connection;
use App\HelpObject;
use App\HTML\Form;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;

Auth::check();

$id = $params['id'];
$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$item= $categoryTable->find($id);
$success = false;
$errors = [];
$fields = ['name', 'slug'];

if (!empty($_POST)) {
  $v = new CategoryValidator($_POST, $categoryTable, $item->getID());
  if ($v->validate()) {

    HelpObject::hydrate($item, $_POST, $fields);

    $categoryTable->update([
      'name' => $item->getName(),
      'slug' => $item->getSlug()
    ], $item->getID());
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
    La catégorie n'a pas pu être modifiée. Veuillez corriger vos erreurs.
  </div>
<?php endif ?>


<h1 class="text-center mb-4 text-secondary">Editer la catégorie #<?= e($item->getName()) ?></h1>
<?php require('_form.php') ?>
