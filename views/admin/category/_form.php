<form action="" method="POST">
  <?= $form->input('name', 'Titre') ?>
  <?= $form->input('slug', 'URL') ?>
  <button class="btn btn-primary mt-4">
    <?php if ($item->getID() !== null): ?>
      Modifier
    <?php else: ?>
      Enregistrer
    <?php endif ?>
  </button>
</form>
