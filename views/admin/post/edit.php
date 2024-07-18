<?php

use App\Connection;
use App\Table\PostTable;
use App\Validator;

$id = $params['id'];
$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($id);
$success = false;

$errors = [];
if (!empty($_POST)) {
  Validator::lang('fr');
  $v = new Validator($_POST);
  $v->labels(array(
    'name' => 'Titre',
    'content' => 'Contenu'
  ));
  $v->rule('required', 'name');
  $v->rule('lengthBetween', 'name', 3, 200);

  if ($v->validate()) {
    $post
      ->setName($_POST['name']);
    $postTable->update($post);
    $success = true;
  } else {
    $errors = $v->errors();
  }

}

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
  <div class="form-group">
    <label for="name" class ="text-secondary">Titre</label>
    <input type="text" class="form-control my-3 <?= isset($errors['name']) ? 'is-invalid' : '' ?>" name="name" value="<?= e($post->getName()) ?>">
    <?php if (isset($errors['name'])): ?>
      <div class="invalid-feedback">
        <?php foreach ($errors['name'] as $error): ?>
          <p class="mb-1 mt-1"><?= $error ?></p>
        <?php endforeach ?>
      </div>
    <?php endif ?>
  </div>
  <button class="btn btn-primary">Modifier</button>
</form>
