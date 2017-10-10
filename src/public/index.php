<?php

define('SRC_PATH', __DIR__ . '/..');

spl_autoload_register(function($class) {
  require SRC_PATH . '/app/' . preg_replace('/^App\\\\/', '', $class) . '.php';
});

require SRC_PATH . '/app/app.php';
