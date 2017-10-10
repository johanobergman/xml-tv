<?php

namespace App;

class Router {

  protected $handlers = [];

  /**
   * Run a request through a matching handler.
   */
  public function run()
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $url = ltrim(preg_split('/\?/', $_SERVER['REQUEST_URI'])[0], '/');

    if (isset($this->handlers[$method][$url])) {
      echo $this->handlers[$method][$url]();
    } else {
      echo '404 :(';
    }
  }

  /**
   * Register a handler for a GET request.
   */
  public function get($url, callable $handler)
  {
    $this->handlers['GET'][ltrim($url, '/')] = $handler;
  }

}
