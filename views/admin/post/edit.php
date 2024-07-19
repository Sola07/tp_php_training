<?php

use App\Connection;
use App\HelpObject;
use App\HTML\Form;
use App\Table\PostTable;
use App\Validators\PostValidator;

$id = $params['id'];
$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($id);
$success = false;

$errors = [];
if (!empty($_POST)) {
  $v = new PostValidator($_POST, $postTable, $post->getID());
  if ($v->validate()) {

    HelpObject::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);

    $postTable->update($post);
    $success = true;
  } else {
    $errors = $v->errors();
  }
}
$form = new Form($post, $errors);
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


<h1 class="text-center mb-4 text-secondary">Editer l'article #<?= e($post->getName()) ?></h1>
<?php require('_form.php') ?>
