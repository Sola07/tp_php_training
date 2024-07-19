<?php

use App\Auth;
use App\Connection;
use App\HelpObject;
use App\HTML\Form;
use App\Model\Post;
use App\Table\PostTable;
use App\Validators\PostValidator;

Auth::check();

$errors = [];
$post = new Post;
if (!empty($_POST)) {
  $pdo = Connection::getPDO();
  $postTable = new PostTable($pdo);
  $v = new PostValidator($_POST, $postTable, $post->getID());

  if ($v->validate()) {

    HelpObject::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
    $postTable->createPost($post);
    header('Location: ' . $router->url('admin_post', ['id' => $post->getID()]) . '?created=1');
    exit();
  } else {
    $errors = $v->errors();
  }
}
$form = new Form($post, $errors);
?>


<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    L'article n'a pas pu être enregistré. Veuillez corriger vos erreurs.
  </div>
<?php endif ?>


<h1 class="text-center mb-4 text-secondary">Créer un article</h1>
<?php require('_form.php') ?>
