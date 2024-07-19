<form action="" method="POST">
  <?= $form->input('name', 'Titre') ?>
  <?= $form->input('slug', 'URL') ?>
  <?= $form->textarea('content', 'Contenu') ?>
  <?= $form->textarea('created_at', 'Date de publication') ?>
  <button class="btn btn-primary mt-4">
    <?php if ($post->getID() !== null): ?>
      Modifier
    <?php else: ?>
      Enregistrer
    <?php endif ?>
  </button>
</form>
