<?php

use App\Connection;
use App\Table\CategoryTable;
use App\Table\PostTable;

$id = (int)$params['id'];

$pdo = Connection::getPDO();
$post = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$post]);

if (isset($_POST['name'], $_POST['content'])){
}
$post = (new PostTable($pdo))->find($id)


?>
<h1 class="text-center mb-4 text-secondary">Modifier l'article #<?= $id ?></h1>


<div class="container mt-4">
    <form action="" method="post">
      <div class="form-group">
        <input type="text" class="form-control" name="name" value="<?= htmlentities($post->getName())?>">
      </div>
      <div class="form-group">
        <textarea class="form-control mt-4" name="content" style="height: 514px;"><?= htmlentities($post->getFormattedContent())?></textarea>
      </div>
      <button class="btn btn-success mt-4">Modifier</button>
    </form>
  </div>
