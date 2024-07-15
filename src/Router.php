<?php

namespace App;

use AltoRouter;

class Router {

    /**
     * @var string
     */
    private $viewpath;
    /**
     * @var Altorouter
     */

    private $router;

    public function __construct(string $viewpath)
    {
      $this->viewpath = $viewpath;
      $this->router = new AltoRouter();
    }

    public function get(string $url, string $view, ?string $name = null): self
    {
      $this->router->map('GET', $url, $view, $name);
      return $this;
    }

    public function url(string $name, array $params = [])
    {
      return $this->router->generate($name, $params);
    }

    public function run() : self
    {
      $match = $this->router->match();
      $view = $match['target'];
      $router = $this ;
      ob_start();
      require $this->viewpath . DIRECTORY_SEPARATOR . $view . ".php";
      $content = ob_get_clean();
      require $this->viewpath . DIRECTORY_SEPARATOR . 'layouts/default.php';
      return $this;
    }
}
