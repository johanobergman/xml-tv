<?php

define('BASE_PATH', __DIR__ . '/..');

spl_autoload_register(function($class) {
  require BASE_PATH . '/app/' . preg_replace('/^App\\\\/', '', $class) . '.php';
});

require BASE_PATH . '/app/app.php';
