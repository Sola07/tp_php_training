<?php

use App\Connection;
use App\HTML\Form;
use App\Table\PostTable;
use App\Validator;
use App\Validators\PostValidator;

$id = $params['id'];
$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($id);
$success = false;

$errors = [];
if (!empty($_POST)) {
  Validator::lang('fr');
  $v = new PostValidator($_POST, $postTable, $post->getID());

  if ($v->validate()) {
    $post
      ->setName($_POST['name'])
      ->setContent($_POST['content'])
      ->setSlug($_POST['slug'])
      ->setCreatedAt($_POST['created_at']);

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

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    L'article n'a pas pu être modifié. Veuillez corriger vos erreurs.
  </div>
<?php endif ?>


<h1 class="text-center mb-4 text-secondary">Editer l'article #<?= e($post->getName()) ?></h1>
<form action="" method="POST">
  <?= $form->input('name', 'Titre') ?>
  <?= $form->input('slug', 'URL') ?>
  <?= $form->textarea('content', 'Contenu') ?>
  <?= $form->textarea('created_at', 'Date de publication') ?>
  <button class="btn btn-primary mt-4">Modifier</button>
</form>
