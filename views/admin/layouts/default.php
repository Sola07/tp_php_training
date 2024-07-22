<!DOCTYPE html>
<html lang="fr" class='h-100'>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($title ?? 'Mon site') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="d-flex flex-column h-100">
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <a href="<?= $router->url('home') ?>" class="navbar-brand" style="margin-left: 15px;">Mon site</a>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="<?= $router->url('admin_posts') ?>" class="nav-link">Articles</a>
      </li>
      <li class="nav-item">
        <a href="<?= $router->url('admin_categories') ?>" class="nav-link">Catégories</a>
      </li>
      <li class="nav-item">
        <form action="<?= $router->url('logout') ?>" method="POST" style="display:inline">
          <button type="submit" class ="nav-link">Se déconnecter</button>
        </form>
      </li>
    </ul>
  </nav>
  <div class="container mt-4">
  <?= $content ?>
  </div>

  <footer class="bg-light py-4 footer mt-auto  ">
    <div class="container">
      <?php if (defined('DEBUG_TIME')):  ?>
      <p class="text-muted"><small>Page générée en <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms</small></p>
      <?php endif ?>
    </div>
  </footer>
</body>
</html>
