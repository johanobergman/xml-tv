<?php

namespace App;

class Router {

  protected $handlers = [];

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

  public function get($url, $handler)
  {
    $this->handlers['GET'][ltrim($url, '/')] = $handler;
  }

}